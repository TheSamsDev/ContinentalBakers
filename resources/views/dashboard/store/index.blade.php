@extends('layouts.app')
@section('content')
@include('inc.test')

<!-- Include Leaflet.js -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Map Container -->
{{-- <div id="map" style="height: 500px;"></div> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the map centered on Pakistan
        const map = L.map('map').setView([30.3753, 69.3451], 5);

        // Add tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 29,
        }).addTo(map);

        // Define the GeoJSON data for Pakistan's provinces (you can replace this with a URL to a GeoJSON file)
        const provincesGeoJSON = {/* Your GeoJSON Data for Pakistan's Provinces */};

        // Function to style provinces with different colors
        function styleProvince(feature) {
            console.log("aa");
            // You can define a color for each province based on the feature properties
            const provinceColors = {
                'Punjab': '#FF6347',
                'Sindh': '#3CB371',
                'Khyber Pakhtunkhwa': '#1E90FF',
                'Balochistan': '#FFD700',
                'Gilgit-Baltistan': '#D2691E',
                'Azad Jammu and Kashmir': '#8A2BE2'
            };

            return {
                fillColor: provinceColors[feature.properties.name] || '#FFFFFF',
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.6
            };
        }

        // Add provinces to the map with GeoJSON layer
        L.geoJSON(provincesGeoJSON, { style: styleProvince }).addTo(map);

        // Define a custom icon for the store markers
        const storeIcon = L.divIcon({
            className: 'store-icon',
            html: '<i class="bx bx-store-alt bx-md text-success me-4"></i>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30]
        });

        // Fetch store data from the Laravel API
        fetch('/api/stores') // This is the API route you defined earlier
            .then(response => response.json())
            .then(stores => {
                // Loop through the store data and add markers for each store
                stores.forEach(store => {
                    const { latitude, longitude, name } = store;

                    // Add a marker for each store with the custom icon
                    const marker = L.marker([latitude, longitude], { icon: storeIcon }).addTo(map);

                    // Add a popup with the store's name
                    marker.bindPopup(`<b>${name}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`);
                });
            })
            .catch(error => {
                console.error('Error fetching store data:', error);
            });
    });
</script>
@endsection
