@extends('layouts.app')
@section('content')
@include('inc.test')
@endsection
<!-- Include Leaflet.js -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Map Container -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the map centered on Pakistan
        const map = L.map('map').setView([30.3753, 69.3451], 5);

        // Add tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 29,
        }).addTo(map);

        // Fetch store data from the Laravel API
        fetch('/api/stores') // This is the API route we defined earlier
            .then(response => response.json())
            .then(stores => {
                // Loop through the store data and add markers for each store
                stores.forEach(store => {
                    const { latitude, longitude, name } = store;

                    // Add a marker for each store
                    const marker = L.marker([latitude, longitude]).addTo(map);

                    // Add a popup with the store's name
                    marker.bindPopup(`<b>${name}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`);
                });
            })
            .catch(error => {
                console.error('Error fetching store data:', error);
            });
    });
</script>