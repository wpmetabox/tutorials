jQuery(function ($) {
    let rawData = $('#restaurants-data').data('items');

    if (typeof rawData === 'string') {
        Locations = JSON.parse(rawData);
    } else {
        Locations = rawData;
    }

    Locations.forEach(it => {
        it.lat = parseFloat(it.lat) || null;
        it.lng = parseFloat(it.lng) || null;
        it.rating_num = parseInt(it.rating_num || (it.rating_num || '').replace(/[^\d]/g, '')) || null;
        it.price = parseInt(it.price) || 0;
        it.cuisine = Array.isArray(it.cuisine) ? it.cuisine.join(', ') : (it.cuisine || '');
        it.title = it.title || '';
        it.address = it.address || '';
    });

    const initialCenter = [21.0285, 105.85];
    const map = L.map('map').setView(initialCenter, 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

    let currentMarkers = [];
    let userMarker = null;
    let userLocation = null;

    function clearMarkers() {
        currentMarkers.forEach(m => map.removeLayer(m));
        currentMarkers = [];
    }

    function renderMarkers(items) {
        clearMarkers();
        let points = [];
        items.forEach(it => {
            if (!it.lat || !it.lng) return;
            let stars = it.rating_num ? '⭐'.repeat(it.rating_num) : '⭐';
            let popup = `
                <div style="font-family:Arial;min-width:180px;">
                    <strong style="font-size:18px;color:#7a1c1c;">${it.title}</strong><br>
                    <span style="color:#f39c12;">${stars}</span><br>
                    <span>🍽 ${it.cuisine}</span><br>
                    <span>💰 ${it.price} $</span><br>
                    ${it.address ? `📍 ${it.address}` : ''}
                </div>`;
            let mk = L.marker([it.lat, it.lng]).addTo(map).bindPopup(popup);
            currentMarkers.push(mk);
            points.push([it.lat, it.lng]);
        });
        if (points.length) {
            let bounds = L.latLngBounds(points);
            if (userMarker) bounds.extend(userMarker.getLatLng());
            map.fitBounds(bounds, { padding: [40, 40] });
        }
    }

    $('#locate-btn').on('click', function () {
        let $btn = $(this);
        if (!navigator.geolocation) return alert('Browser does not support geolocation.');
        $btn.prop('disabled', true).text('Getting location...');
        navigator.geolocation.getCurrentPosition(pos => {
            userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
            if (userMarker) map.removeLayer(userMarker);
            userMarker = L.circleMarker([userLocation.lat, userLocation.lng], { radius: 8 }).addTo(map).bindPopup('Your Location').openPopup();
            map.setView([userLocation.lat, userLocation.lng], 13);
            $btn.prop('disabled', false).text('📍 My Location');
            alert('Your location has been detected.');
        }, () => {
            $btn.prop('disabled', false).text('📍 My Location');
            alert('Unable to get location.');
        });
    });

    function updatePrice() {
        let min = $('#price-min').val();
        let max = $('#price-max').val();
        $('#price-display').text(`${min} - ${max}$`);
    }

    $('#price-min, #price-max').on('input', updatePrice);

    $('#filter-btn').on('click', function () {
        let r = $('#filter-rating').val();
        let c = $('#filter-cuisine').val();
        let minP = parseInt($('#price-min').val());
        let maxP = parseInt($('#price-max').val());
        let rad = parseFloat($('#filter-radius').val());

        if (rad && !userLocation) return alert('Vui lòng lấy vị trí của bạn trước.');

        function getDistance(lat1, lon1, lat2, lon2) {
            let R = 6371;
            let dLat = (lat2 - lat1) * Math.PI / 180;
            let dLon = (lon2 - lon1) * Math.PI / 180;
            let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        let filtered = Locations.filter(it => {
            let basicFilter = (!r || it.rating_num == r) &&
                (!c || it.cuisine.toLowerCase().includes(c.toLowerCase())) &&
                (it.price >= minP && it.price <= maxP);

            if (!basicFilter) return false;
            if (!rad) return true;
            if (!it.lat || !it.lng) return false;

            let dist = getDistance(userLocation.lat, userLocation.lng, it.lat, it.lng);

            return dist <= rad;
        });

        renderMarkers(filtered);
        $('#filter-info').text(`Result: ${filtered.length} Restaurants`);
    });

    renderMarkers(Locations);
    $('#filter-info').text(`Show: ${Locations.length} Restaurants`);
});
