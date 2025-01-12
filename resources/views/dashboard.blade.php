@extends('layouts.app')
<style>

</style>
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
    const storagePath = "{{ asset('storage') }}";

    document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('brandDetailsModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const brandName = button.getAttribute('data-brand');
        const orders = button.getAttribute('data-orders');
        const sales = button.getAttribute('data-sales');
        const logo = button.getAttribute('data-logo');

        // Update modal static content
        document.getElementById('modalBrandName').textContent = brandName;
        document.getElementById('modalSales').textContent = sales;
        document.getElementById('modalOrders').textContent = orders;
        const logoElement = document.getElementById('modalSalesmodalSalesmodalSales');
        logoElement.src = logo || '/storage/brands/default.jpg'; // Fallback to a default image
        // Fetch brand and store details
        fetch(`/api/brand-details?brand=${encodeURIComponent(brandName)}`)
    .then(response => response.json())
    .then(data => {
        const productsGrid = document.getElementById('productsGrid');

        // Create a product cards grid
        const productHtml = data.stores.reduce((acc, store) => {
            const productName = store.product_name;
            const productImage = store.product_image;
            const totalOrders = store.total_orders;

            // Only add the product if it's not already included in the list
            if (!acc[productName]) {
                acc[productName] = {
                    productName: productName,
                    productImage: productImage,
                    totalOrders: totalOrders
                };
            } else {
                // If the product already exists, just add to the total orders
                acc[productName].totalOrders += totalOrders;
            }

            return acc;
        }, {});

        // Create the HTML structure for each product card
        const productCards = Object.values(productHtml).map(product => {
            return `
                <div class="col-md-6 col-lg-6">
                    <div class="card product-card position-relative">
                        <img src="${storagePath}/${product.productImage}" 
                             class="card-img-top" 
                             alt="${product.productName}">
                        <div class="card-body text-center">
                            <h6 class="card-title">${product.productName}</h6>
                            <p>Total Qauntity: ${product.totalOrders}</p>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        // Insert product cards into the modal grid
        productsGrid.innerHTML = productCards;
    })
    .catch(error => {
        console.error('Error fetching brand details:', error);
        document.getElementById('productsGrid').innerHTML = '<p>Error loading products.</p>';
    });

    });
    
    
});


</script>