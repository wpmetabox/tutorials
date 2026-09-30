document.addEventListener('DOMContentLoaded', () => {
    const widget = document.getElementById('weather-widget');
    if (!widget) return;
    const {
        lat,
        lng,
        location,
        days = 3,
        layout = 'dashboard',
        lang = 'en',
        unit,
        details = ''
    } = widget.dataset;
    const color = '#2abf97';
    const forecastDays = parseInt(days);
    const selectedDetails = details ? details.split(',') : [];
    const temperatureUnit =
        unit === 'fahrenheit' ? 'fahrenheit' : 'celsius';

    const unitSymbol =
        unit === 'fahrenheit' ? '°F' : '°C';
    const labels = {
        humidity: ['Humidity', 'Độ ẩm', 'Humidité', 'Luftfeuchtigkeit', 'Humedad'],
        wind: ['Wind', 'Gió', 'Vent', 'Wind', 'Viento'],
        pressure: ['Pressure', 'Áp suất', 'Pression', 'Luftdruck', 'Presión'],
        uv: ['UV Index', 'Chỉ số UV', 'Indice UV', 'UV-Index', 'Índice UV'],
        sunrise: ['Sunrise', 'Mặt trời mọc', 'Lever du soleil', 'Sonnenaufgang', 'Amanecer'],
        sunset: ['Sunset', 'Mặt trời lặn', 'Coucher du soleil', 'Sonnenuntergang', 'Atardecer'],
        forecast: ['Forecast', 'Dự báo', 'Prévisions', 'Vorhersage', 'Pronóstico'],
        loading: ['Loading weather...', 'Đang tải dữ liệu...', 'Chargement météo...', 'Wetter wird geladen...', 'Cargando clima...'],
        error: ['Unable to load weather data', 'Không thể tải dữ liệu', 'Impossible de charger la météo', 'Wetterdaten konnten nicht geladen werden', 'No se pudo cargar el clima'],
        aqi: ['Air Quality', 'Chất lượng không khí', 'Qualité de l’air', 'Luftqualität', 'Calidad del aire'],
        today: ['Today', 'Hôm nay', 'Aujourd’hui', 'Heute', 'Hoy']
    };

    const langs = ['en', 'vi', 'fr', 'de', 'es'];

    const index = langs.includes(lang)
        ? langs.indexOf(lang)
        : 0;

    const t = Object.fromEntries(
        Object.entries(labels).map(
            ([key, val]) => [key, val[index] || val[0]]
        )
    );
    widget.classList.add('weather-layout-' + layout);
    const weatherMap = {
        0: ['☀️', 'Clear Sky'],
        1: ['🌤️', 'Mainly Clear'],
        2: ['⛅', 'Partly Cloudy'],
        3: ['☁️', 'Cloudy'],
        45: ['🌫️', 'Fog'],
        48: ['🌫️', 'Fog'],
        51: ['🌦️', 'Drizzle'],
        53: ['🌦️', 'Drizzle'],
        55: ['🌦️', 'Heavy Drizzle'],
        61: ['🌧️', 'Rain'],
        63: ['🌧️', 'Rain'],
        65: ['🌧️', 'Heavy Rain'],
        71: ['❄️', 'Snow'],
        73: ['❄️', 'Snow'],
        75: ['❄️', 'Heavy Snow'],
        80: ['🌦️', 'Rain Shower'],
        81: ['🌧️', 'Rain Shower'],
        82: ['🌧️', 'Heavy Shower'],
        95: ['⛈️', 'Thunderstorm'],
        96: ['⛈️', 'Thunderstorm'],
        99: ['⛈️', 'Severe Thunderstorm']
    };
    const getWeatherInfo = code => {
        const [icon, label] = weatherMap[code] || ['🌤️', 'Weather'];
        return { icon, label };
    };

    const weatherApi =
        `https://api.open-meteo.com/v1/forecast` +
        `?latitude=${lat}` +
        `&longitude=${lng}` +
        `&current=temperature_2m,apparent_temperature,relative_humidity_2m,wind_speed_10m,pressure_msl,weather_code` +
        `&daily=weather_code,temperature_2m_max,temperature_2m_min,uv_index_max,sunrise,sunset` +
        `&temperature_unit=${temperatureUnit}` +
        `&timezone=auto`;

    const airApi =
        `https://air-quality-api.open-meteo.com/v1/air-quality` +
        `?latitude=${lat}` +
        `&longitude=${lng}` +
        `&current=us_aqi`;

    widget.innerHTML = `
        <div class="weather-loading">
            ${t.loading}
        </div>
    `;
    const renderDetail = (label, value) => `
        <div class="weather-detail">
            <div class="weather-detail-label">${label}</div>
            <div class="weather-detail-value">${value}</div>
        </div>
    `;
    Promise.all([
        fetch(weatherApi).then(r => r.json()),
        fetch(airApi).then(r => r.json())
    ])
        .then(([weatherData, airData]) => {
            const current = weatherData.current;
            const daily = weatherData.daily;
            const aqi = airData.current?.us_aqi ?? '-';
            const weather = getWeatherInfo(current.weather_code);
            const currentCard = `
            <div class="weather-current">
                <div class="weather-icon">
                    ${weather.icon}
                </div>
                <div class="weather-condition">
                    ${weather.label}
                </div>
                <div class="weather-minmax">
                    H: ${daily.temperature_2m_max[0]}${unitSymbol}
                    /
                    L: ${daily.temperature_2m_min[0]}${unitSymbol}
                </div>
                <div class="weather-aqi-inline">
                    ${t.aqi}: ${aqi}
                </div>
            </div>
        `;
            let detailsHtml = '';
            const detailItems = [
                ['humidity', t.humidity, `${current.relative_humidity_2m}%`],
                ['wind', t.wind, `${current.wind_speed_10m} km/h`],
                ['pressure', t.pressure, `${current.pressure_msl} hPa`],
                ['uv', t.uv, daily.uv_index_max[0]]
            ];

            detailItems.forEach(([key, label, value]) => {
                if (selectedDetails.includes(key)) {
                    detailsHtml += renderDetail(label, value);
                }
            });

            ['sunrise', 'sunset'].forEach(type => {
                if (!selectedDetails.includes(type)) return;
                const date = new Date(daily[type][0]);
                detailsHtml += renderDetail(
                    t[type],
                    date.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    })
                );
            });
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const forecastHtml = daily.time
                .slice(0, forecastDays)
                .map((dateStr, i) => {
                    const currentDate = new Date(dateStr);
                    currentDate.setHours(0, 0, 0, 0);
                    const dayName =
                        i === 0 ||
                            currentDate.getTime() === today.getTime()
                            ? t.today
                            : currentDate.toLocaleDateString(lang, {
                                weekday: 'short'
                            });

                    const forecastWeather =
                        getWeatherInfo(daily.weather_code[i]);

                    return `
                    <div class="weather-day">
                        <div class="weather-day-name">
                            ${dayName}
                        </div>
                        <div class="weather-day-icon">
                            ${forecastWeather.icon}
                        </div>
                        <div class="weather-day-temp">
                            <span class="temp-max">
                                ${daily.temperature_2m_max[i]}${unitSymbol}
                            </span>
                            <span class="temp-min">
                                ${daily.temperature_2m_min[i]}${unitSymbol}
                            </span>
                        </div>
                    </div>
                `;
                })
                .join('');
            widget.innerHTML = `
            <div class="weather-main">
                <div class="weather-header">
                    <div class="weather-location">
                        ${location}
                    </div>
                    <div class="weather-temperature" style="color:${color}">
                        ${current.temperature_2m}${unitSymbol}
                    </div>
                </div>
                ${currentCard}
                <div class="weather-details">
                    ${detailsHtml}
                </div>
            </div>

            <div class="weather-forecast">
                <div class="weather-forecast-title">
                    ${t.forecast}
                </div>
                <div class="weather-days">
                    ${forecastHtml}
                </div>
            </div>
        `;
        })
        .catch(error => {
            console.error(error);
            widget.innerHTML = `
            <div class="weather-error">
                ${t.error}
            </div>
        `;
        });
});
