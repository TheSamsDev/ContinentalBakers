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

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);



        // Fetch and display store markers
        fetch('/api/stores')
            .then(response => response.json())
            .then(stores => {
                stores.forEach(store => {
                    const {
                        latitude,
                        mainaddress,
                        state,
                        longitude,
                        name,
                        orders
                    } = store;

                    // Custom icon for the store
                    var customIcon = L.icon({
                        iconUrl: '{{ asset('app-assets/assets/icon/store.png') }}',
                        iconSize: [65, 72], // Custom size
                        shadowSize: [80, 80], // Custom shadow size
                        iconAnchor: [32.5, 72], // Anchor at the bottom center
                        shadowAnchor: [40, 70], // Shadow anchor
                        popupAnchor: [0, -70], // Popup opens above the icon
                    });

                    // Add a marker for each store with the custom icon
                    const marker = L.marker([latitude, longitude], {
                        icon: customIcon
                    }).addTo(map);

                    // Prepare the order details in a formatted string
                    let ordersInfo = `<b>Orders Information:</b><br>`;
                    // Check if there are any orders
                    if (orders && orders.length > 0) {
                        orders.forEach(orderGroup => {
                            orderGroup.forEach(order => {
                                ordersInfo += `
                            <b>Brand:</b> ${order.brand_name}<br>
                            <b>Quantity:</b> ${order.quantity}<br>
                            <b>Total Price:</b> ${order.total_price}<br>
                            <b>Order Date:</b> ${order.order_date}<br>
                        `;
                            });
                        });
                    } else {
                        // If no orders, show a message
                        ordersInfo += `<i>No order history available</i><br>`;
                    }
                    // Add a popup with the store's name and order information
                    marker.bindPopup(`
                <b>${name}</b><br>
                 <b>State:</b> ${state}<br>
                <b>Main Address:</b> ${mainaddress}<br><br>
                ${ordersInfo}
            `);
                });
            })
            .catch(error => {
                console.error('Error fetching store data:', error);
            });



        // Province-specific colors
        const provinceColors = {
            'Sind': '#B22222',
            'Punjab': '#FAF0E6',
            'Baluchistan': '#FFA07A',
            'K.P.': 'pink',
            'Azad Kashmir': 'purple',
            'Northern Areas': '#FFA07A',
            // 'Islamabad Capital Territory': 'pink',
        };

        // Load the pk.geojson file from the public directory
        fetch('{{ asset('pk.json') }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(geojsonData => {
                // Add GeoJSON layer to the map with province-specific styling
                L.geoJSON(geojsonData, {
                    style: function(feature) {
                        // Get the province name
                        const provinceName = feature.properties.name;

                        // Set the fill color based on the province name
                        const fillColor = provinceColors[provinceName] ||
                            'gray';

                        return {
                            color: '#A9A9A9',
                            weight: 1,
                            fillColor: fillColor,
                            fillOpacity: 0.6,
                        };
                    },
                    // onEachFeature: function(feature, layer) {
                    //     const name = feature.properties.name ||
                    //     'Unknown';
                    //     layer.bindPopup(`<b>${name}</b>`);
                    // }
                }).addTo(map);
            })
            .catch(error => {
                console.error('Error loading GeoJSON:', error);
            });



        // ---------------------------------------------------------------brandDetailsModal- ---------------------------------------------------->      
        const modal = document.getElementById('brandDetailsModal');
        modal.addEventListener('show.bs.modal', function(event) {
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
                    document.getElementById('productsGrid').innerHTML =
                        '<p>Error loading products.</p>';
                });

        });



        // ---------------------------------------------------------------Chart- ---------------------------------------------------->      
        const yearDropdown = document.getElementById('yearDropdown');
        const selectedYearButton = document.getElementById('selectedYearButton');
        const chartElement = document.getElementById('totalRevenueChart');
        const growthChartElement = document.getElementById('growthChart');
        growthChartElement.style.width = '100%';
        growthChartElement.style.height = '100%';

        const growthPercentageElement = document.getElementById('growthPercentage');
        const currentYearSalesElement = document.getElementById('currentYearSales');
        const previousYearSalesElement = document.getElementById('previousYearSales');
        const currentYearSalesLabel = document.getElementById('currentYearSalesLabel');
        const previousYearSalesLabel = document.getElementById('previousYearSalesLabel');

        let lineChart;
        let growthChart;

        // Populate dropdown with available years
        fetch('/available-years')
            .then((response) => response.json())
            .then((years) => {
                // Populate the dropdown menu
                yearDropdown.innerHTML = ''; // Clear existing items
                years.forEach((year) => {
                    const yearItem = document.createElement('li');
                    yearItem.innerHTML = `<a class="dropdown-item" href="#">${year}</a>`;
                    yearItem.addEventListener('click', () => {
                        selectedYearButton.textContent = year; // Update button text
                        updateChart(year); // Update the charts for the selected year
                    });
                    yearDropdown.appendChild(yearItem);
                });

                // Default to the first year in the list
                if (years.length > 0) {
                    const defaultYear = years[0];
                    selectedYearButton.textContent = defaultYear;
                    updateChart(defaultYear);
                }
            });

        // Update charts based on selected year
        function updateChart(year) {
            fetch(`/growth-data?year=${year}`)
                .then((response) => response.json())
                .then((data) => {
                    // Prepare labels and sales data
                    const labels = Array.from({
                            length: 12
                        }, (_, i) =>
                        new Date(0, i).toLocaleString('default', {
                            month: 'short'
                        })
                    );

                    const monthlySales = Array.from({
                            length: 12
                        }, (_, i) =>
                        data.monthlySales && data.monthlySales[i] ? data.monthlySales[i] : 0
                    );

                    // Update line chart
                    updateLineChart(labels, monthlySales, year);

                    // Update growth chart and sales data
                    updateGrowthChart(data);
                });
        }

        // Function to update the line chart
        function updateLineChart(labels, data, year) {
            if (lineChart) {
                lineChart.destroy(); // Destroy the previous chart instance
            }

            lineChart = new Chart(chartElement, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: `${year} Sales`,
                        data: data,
                        borderColor: '#696CFF',
                        backgroundColor: '#C3C4FF',
                        fill: true,
                        tension: 0.3,
                    }, ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month',
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales ($)',
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return `${(value / 1000000).toFixed(1)}M`; // Display in millions
                                    } else if (value >= 1000) {
                                        return `${(value / 1000).toFixed(1)}k`; // Display in thousands
                                    }
                                    return value; // Display as is for smaller numbers
                                },
                            },
                        },
                    },
                },
            });
        }

        function formatSalesAmount(amount) {
            // Convert the amount to number, in case it is a string
            const number = Number(amount);

            if (number >= 1_000_000) {
                // Convert to millions (M)
                return `$${(number / 1_000_000).toFixed(1)}M`;
            } else if (number >= 1_000) {
                // Convert to thousands (K)
                return `$${(number / 1_000).toFixed(1)}K`;
            } else {
                // For amounts less than 1,000, just return the number with a dollar sign
                return `$${number.toLocaleString()}`;
            }
        }
        // Function to update the growth chart
        function updateGrowthChart(data) {
            const growthPercentage = data.growthPercentage;
            const currentYearSales = data.currentYearSales;
            const previousYearSales = data.previousYearSales;

            // Update the growth percentage and sales values
            growthPercentageElement.textContent = `${growthPercentage}%`;
            currentYearSalesElement.textContent = formatSalesAmount(currentYearSales);
            previousYearSalesElement.textContent = formatSalesAmount(previousYearSales);
            currentYearSalesLabel.textContent = data.currentYear;
            previousYearSalesLabel.textContent = data.currentYear - 1;

            // Destroy the old growth chart if it exists
            if (growthChart) {
                growthChart.destroy();
            }

            // Create a new growth chart with updated cutout size and percentage display
            growthChart = new Chart(growthChartElement, {
                type: 'doughnut',
                data: {
                    labels: ['Growth'],
                    datasets: [{
                        data: [growthPercentage, 100 - growthPercentage],
                        backgroundColor: ['#FFB826', '#E0E0E0'],
                        hoverBackgroundColor: ['#FFF2D6', '#E0E0E0'],
                        borderWidth: 0,
                    }, ],
                },
                options: {
                    responsive: true,
                    cutout: '60%', // Adjust the cutout to make the doughnut thicker
                    plugins: {
                        tooltip: {
                            enabled: false,
                        },
                        doughnutlabel: {
                            labels: [{
                                text: `${growthPercentage}%`, // Display the growth percentage in the center
                                font: {
                                    size: 24,
                                    weight: 'bold',
                                },
                                color: '#FFB826',
                            }, ],
                        },
                    },
                },
            });
        }
    });
</script>
