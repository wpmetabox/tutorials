$(document).ready(function () {
    if (!window.tourStops || !window.tourStops.length) return;
    const stops = window.tourStops;
    let map, markers = [], polyline, distanceLabels = [];
    const SUBSTEPS = 50;
    const STEP_MS = 50;

    const script = document.createElement('script');
    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
    script.onload = initMap;
    document.head.appendChild(script);
    function initMap() {
        map = L.map('tour-map').setView([stops[0].lat, stops[0].lng], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);
        stops.forEach(function (stop, i) {
            const marker = L.marker([stop.lat, stop.lng], {
                icon: makeIcon(stop.index, false)
            }).addTo(map);
            marker.bindPopup(popupHtml(stop), { maxWidth: 220 });
            marker.on('click', function () { setActiveCard(i); });
            markers.push(marker);
        });

        setTimeout(function () { drawAnimatedPolyline(stops); }, 2000);
        fitBounds(stops);
        setActiveCard(0);
    }

    function makeIcon(index, dimmed) {
        return L.divIcon({
            className: '',
            html: '<div class="map-marker' + (dimmed ? ' dimmed' : '') + '">' + index + '</div>',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -20]
        });
    }

    function popupHtml(stop) {
        const img = stop.image
            ? '<img src="' + stop.image + '" style="width:100%;height:90px;object-fit:cover;border-radius:8px;margin-bottom:8px">'
            : '';
        return '<div style="min-width:170px;font-family:-apple-system,sans-serif">' +
            img +
            '<div style="font-size:11px;font-weight:700;color:#d9450a;text-transform:uppercase;letter-spacing:.5px">Day ' + stop.day + '</div>' +
            '<div style="font-size:14px;font-weight:700;color:#1e293b;margin-top:2px">' + stop.name + '</div>' +
            '</div>';
    }

    function setActiveCard(index) {
        $('.stop-card').removeClass('active');
        const $card = $('.stop-card[data-index="' + index + '"]').addClass('active');
        if ($card.length) {
            const $sidebar = $('.tour-sidebar');
            $sidebar.animate({
                scrollTop: $card.position().top + $sidebar.scrollTop() - 20
            }, 300);
        }
    }

    function fitBounds(list) {
        if (!list.length) return;
        map.fitBounds(
            L.latLngBounds(list.map(function (s) { return [s.lat, s.lng]; })),
            { padding: [40, 40] }
        );
    }

    function getDistanceKm(a, b) {
        const R = 6371;
        const dLat = (b.lat - a.lat) * Math.PI / 180;
        const dLng = (b.lng - a.lng) * Math.PI / 180;
        const x = Math.sin(dLat / 2) ** 2 +
            Math.cos(a.lat * Math.PI / 180) * Math.cos(b.lat * Math.PI / 180) * Math.sin(dLng / 2) ** 2;
        return (R * 2 * Math.atan2(Math.sqrt(x), Math.sqrt(1 - x))).toFixed(1);
    }

    function clearPolyline() {
        if (polyline) map.removeLayer(polyline);
        distanceLabels.forEach(function (l) { map.removeLayer(l); });
        distanceLabels = [];
    }

    function drawAnimatedPolyline(list) {
        clearPolyline();
        if (list.length < 2) return;
        polyline = L.polyline([], {
            color: '#d9450a', weight: 2.5, opacity: 0.7, dashArray: '6, 6'
        }).addTo(map);
        for (let i = 0; i < list.length - 1; i++) {
            const a = list[i], b = list[i + 1];
            const mid = { lat: (a.lat + b.lat) / 2, lng: (a.lng + b.lng) / 2 };
            distanceLabels.push(
                L.marker([mid.lat, mid.lng], {
                    icon: L.divIcon({
                        className: '',
                        html: '<div class="distance-label">' + getDistanceKm(a, b) + ' km</div>',
                        iconSize: [60, 20],
                        iconAnchor: [30, 10]
                    }),
                    interactive: false,
                    opacity: 0
                }).addTo(map)
            );
        }
        const allPoints = [];
        for (let i = 0; i < list.length - 1; i++) {
            for (let j = 0; j <= SUBSTEPS; j++) {
                const t = j / SUBSTEPS;
                allPoints.push({
                    point: [
                        list[i].lat + (list[i + 1].lat - list[i].lat) * t,
                        list[i].lng + (list[i + 1].lng - list[i].lng) * t
                    ],
                    segmentIndex: i
                });
            }
        }
        let pointIndex = 0;
        const path = [];
        function drawStep() {
            if (pointIndex >= allPoints.length) return;
            const current = allPoints[pointIndex];
            path.push(current.point);
            polyline.setLatLngs(path);
            const next = allPoints[pointIndex + 1];
            const segmentDone = next && next.segmentIndex !== current.segmentIndex;
            if (segmentDone && distanceLabels[current.segmentIndex]) {
                distanceLabels[current.segmentIndex].setOpacity(1);
            }
            pointIndex++;
            setTimeout(drawStep, STEP_MS);
        }
        drawStep();
    }

    function filterByDay(day) {
        const isAll = day === 'all';
        const list = isAll ? stops : stops.filter(function (s) { return s.day == day; });

        $('.stop-card').each(function () {
            const match = isAll || $(this).data('day') == day;
            $(this).toggleClass('hidden', !match).toggleClass('show-desc', !isAll);
        });

        stops.forEach(function (s, i) {
            markers[i].setIcon(makeIcon(s.index, !(isAll || s.day == day)));
        });

        setTimeout(function () { drawAnimatedPolyline(list); }, 2000);
        fitBounds(list);

        const first = stops.findIndex(function (s) { return isAll || s.day == day; });
        if (first !== -1) setActiveCard(first);
    }

    $('.stop-card').on('click', function () {
        const index = parseInt($(this).data('index'));
        map.flyTo([stops[index].lat, stops[index].lng], 13, { duration: 0.8 });
        markers[index].openPopup();
        setActiveCard(index);
    });

    $('.day-tab').on('click', function () {
        $('.day-tab').removeClass('active');
        $(this).addClass('active');
        filterByDay($(this).data('day'));
    });
});
