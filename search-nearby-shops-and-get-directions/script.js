jQuery(function ($) {
    /* ===== DATA ===== */
    let rawData = $('#garage-data').data('items');
    let Garages = typeof rawData === 'string' ? JSON.parse(rawData) : rawData;

    Garages.forEach(g => {
        g.lat = parseFloat(g.lat) || null;
        g.lng = parseFloat(g.lng) || null;
    });

    /* ===== MAP ===== */
    const map = L.map('map').setView([21.0285, 105.85], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    let markers = [];
    let userMarker = null;
    let userLocation = null;

    function clearMarkers() {
        markers.forEach(m => map.removeLayer(m));
        markers = [];
    }

    /* ===== TIME CHECK ===== */
    function isOpenNow(openTime, closeTime) {
        if (!openTime || !closeTime) {
            return false;
        }

        let now = new Date();
        let [oh, om] = openTime.split(':').map(Number);
        let [ch, cm] = closeTime.split(':').map(Number);

        let open = new Date();
        let close = new Date();

        open.setHours(oh, om, 0);
        close.setHours(ch, cm, 0);

        return now >= open && now <= close;
    }

    /* ===== DISTANCE ===== */
    function distance(lat1, lon1, lat2, lon2) {
        let R = 6371;
        let dLat = (lat2 - lat1) * Math.PI / 180;
        let dLon = (lon2 - lon1) * Math.PI / 180;

        let a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) *
            Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);

        return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
    }

    /* ===== RENDER ===== */
    function render(items) {
        clearMarkers();
        $('#garage-list').empty();

        let points = [];

        items.forEach(g => {
            if (!g.lat || !g.lng) {
                return;
            }

            let open = isOpenNow(g.open_time, g.close_time);
            let statusText = open
                ? '<span class="status-open">🟢 Open now</span>'
                : '<span class="status-close">🔴 Closed</span>';

            /* === LIST ITEM === */
            $('#garage-list').append(`
                <div class="garage-item"
                     data-lat="${g.lat}"
                     data-lng="${g.lng}">
                    <div class="garage-title">${g.title}</div>
                    <div class="garage-meta">📍 ${g.address}</div>
                    <div class="garage-meta">
                        ⏰ ${g.open_time} - ${g.close_time} ${statusText}
                    </div>
                    <div class="garage-meta garage-phone">
                        📞 ${g.phone}
                        <a href="tel:${g.phone}" class="call-now">Call now</a>
                    </div>
                </div>
            `);

            /* === MARKER === */
            let popup = `
                <strong>🏠 ${g.title}</strong><br>
                📍 ${g.address}<br>
                ${open ? '🟢 Open now' : '🔴 Closed'}
            `;

            let marker = L.marker([g.lat, g.lng])
                .addTo(map)
                .bindPopup(popup);

            markers.push(marker);
            points.push([g.lat, g.lng]);
        });

        if (points.length) {
            let bounds = L.latLngBounds(points);

            if (userMarker) {
                bounds.extend(userMarker.getLatLng());
            }

            map.fitBounds(bounds, {
                padding: [40, 40]
            });
        }

        $('#result-info').text(`Found ${items.length} garages`);
    }

    /* ===== STOP BUBBLE: CALL NOW ===== */
    $(document).on('click', '.call-now', function (e) {
        e.stopPropagation();
    });

    /* ===== CLICK GARAGE ITEM ===== */
    $(document).on('click', '.garage-item', function () {
        let lat = $(this).data('lat');
        let lng = $(this).data('lng');

        if (!lat || !lng) {
            return;
        }

        // Zoom map
        map.setView([lat, lng], 16);

        // Open Google Maps directions
        if (userLocation) {
            let url = `https://www.google.com/maps/dir/?api=1&origin=${userLocation.lat},${userLocation.lng}&destination=${lat},${lng}`;
            window.open(url, '_blank');
        }
    });

    /* ===== LOCATE USER ===== */
    $('#locate-btn').on('click', function () {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser');
            return;
        }

        navigator.geolocation.getCurrentPosition(pos => {
            userLocation = {
                lat: pos.coords.latitude,
                lng: pos.coords.longitude
            };

            if (userMarker) {
                map.removeLayer(userMarker);
            }

            userMarker = L.circleMarker(
                [userLocation.lat, userLocation.lng],
                { radius: 8 }
            )
                .addTo(map)
                .bindPopup('📍 Your location')
                .openPopup();

            map.setView([userLocation.lat, userLocation.lng], 13);
        });
    });

    /* ===== FILTER BY RADIUS ===== */
    $('#filter-btn').on('click', function () {
        let rad = parseFloat($('#filter-radius').val());

        if (!userLocation || !rad) {
            alert('Please get your location and enter a radius');
            return;
        }

        let filtered = Garages.filter(g => {
            if (!g.lat || !g.lng) {
                return false;
            }

            return distance(
                userLocation.lat,
                userLocation.lng,
                g.lat,
                g.lng
            ) <= rad;
        });

        render(filtered);
    });

    /* ===== INIT ===== */
    render(Garages);

});
