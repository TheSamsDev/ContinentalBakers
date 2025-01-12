@extends('layouts.app')
<style>

</style>
@section('content')
@include('inc.test')
@endsection
<!-- Include Leaflet.js -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Map Container -->

<script>
    const storagePath = "{{ asset('storage') }}";

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

        
            

      // ---------------------------------------------------------------brandDetailsModal- ---------------------------------------------------->      
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



          // ---------------------------------------------------------------Chart- ---------------------------------------------------->      
          const revenueAndOrdersData = @json($revenueAndOrders); // Data from Laravel controller

const storeSelect = document.getElementById('storeSelect');
const toggleRevenue = document.getElementById('toggleRevenue');
const toggleOrders = document.getElementById('toggleOrders');
const toggleBoth = document.getElementById('toggleBoth');
const chartCanvas = document.getElementById('totalRevenueChart');

let chart;
let currentDataType = 'both'; // Default to showing both Revenue & Orders

// Function to filter data by store
function filterDataByStore(storeId) {
    return revenueAndOrdersData.filter(item => storeId === 0 || item.store_id == storeId);
}

// Function to update chart based on selected data type (Revenue, Orders, or Both)
function updateChart(storeId) {
    const filteredData = filterDataByStore(storeId);
    
    const months = [...new Set(filteredData.map(item => item.month))];
    const data = {
        labels: months.map(month => new Date(0, month - 1).toLocaleString('en', { month: 'short' })),
        datasets: []
    };

    // Revenue Dataset
    if (currentDataType === 'both' || currentDataType === 'revenue') {
        data.datasets.push({
            label: 'Revenue',
            data: months.map(month => {
                const monthData = filteredData.find(item => item.month == month);
                return monthData.total_revenue;
            }),
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgb(75, 192, 192)',
            borderWidth: 1,
        });
    }

    // Orders Dataset
    if (currentDataType === 'both' || currentDataType === 'orders') {
        data.datasets.push({
            label: 'Orders',
            data: months.map(month => {
                const monthData = filteredData.find(item => item.month == month);
                return monthData.total_orders;
            }),
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1,
        });
    }

    if (chart) {
        chart.destroy();
    }

    chart = new Chart(chartCanvas, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        }
    });
}

// Event listeners for toggling between revenue, orders, or both
toggleRevenue.addEventListener('click', () => {
    currentDataType = 'revenue';
    updateChart(storeSelect.value);
});

toggleOrders.addEventListener('click', () => {
    currentDataType = 'orders';
    updateChart(storeSelect.value);
});

toggleBoth.addEventListener('click', () => {
    currentDataType = 'both';
    updateChart(storeSelect.value);
});

// Event listener for store selection
storeSelect.addEventListener('change', (e) => {
    updateChart(e.target.value);
});

// Initial chart load with all stores and both revenue and orders
updateChart(0);
    });


</script>