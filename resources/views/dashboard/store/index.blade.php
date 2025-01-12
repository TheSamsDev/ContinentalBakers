@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStoreModal">
            Add Store
        </button>

        <!-- Add Store Modal -->
        <div class="modal fade" id="addStoreModal" tabindex="-1" aria-labelledby="addStoreModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('stores.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStoreModalLabel">Add Store</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Store Name -->
                            <div class="mb-3">
                                <label for="storeName" class="form-label">Store Name</label>
                                <input type="text" class="form-control" id="storeName" name="name"
                                    placeholder="e.g Imtiaz Super Market" required>

                            </div>
                            <!-- Store Address -->
                            <div class="mb-3" style="position: relative;">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="e.g SHOP 1 2..." required>
                                <span id="spinner" class="fa fa-spinner fa-spin"
                                    style="display: none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"></span>

                            </div>
                            <!-- Main Address -->
                            <div class="mb-3">
                                <label for="mainAddress" class="form-label">Main Address</label>
                                <input type="text" class="form-control" id="mainAddress" name="mainaddress"
                                    placeholder="e.g MINI MARKET PH-5" required>
                            </div>

                            <!-- Province Selection -->
                            <div class="mb-3">
                                <label for="province" class="form-label">Select Province</label>
                                <select id="province" class="form-control" name="state" required>
                                    <option value="Sindh">Sindh</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="KPK">KPK</option>
                                    <option value="Balochistan">Balochistan</option>
                                    <option value="Azad Jammu & Kashmir">Azad Jammu & Kashmir</option>
                                </select>
                            </div>

                            <!-- Map for Location Selection -->
                            <div class="mb-3">
                                <label for="map" class="form-label">Select Store Location</label>
                                <div id="map" style="height: 300px;"></div>
                            </div>

                            <!-- Hidden Inputs for Latitude & Longitude -->
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Table -->
        <div class="card">
            <h5 class="card-header">Stores</h5>
            <div class="table-responsive text-nowrap">
                <table id="storesTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Store</th>
                            <th>Address</th>
                            <th>Main Address</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr>
                                <td><i class="bx bx-store-alt bx-md text-success me-4"></i> <span>{{ $store->name }}</span>
                                </td>
                                <td>{{ $store->address }}</td>

                                <td>{{ $store->mainaddress }}</td>
                                <td>
                                    {{ $store->user->name }}
                                </td>
                                <td><span class="badge bg-label-primary me-1">Active</span></td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#editStoreModal{{ $store->id }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('stores.destroy', $store->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item" onclick="return confirm('Are you sure?');">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Store Modal -->
                            <div class="modal fade" id="editStoreModal{{ $store->id }}" tabindex="-1"
                                aria-labelledby="editStoreModalLabel{{ $store->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('stores.update', $store->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStoreModalLabel{{ $store->id }}">Edit
                                                    Store</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col mb-6">
                                                        <label for="editStoreName{{ $store->id }}"
                                                            class="form-label">Store Name</label>
                                                        <input type="text" class="form-control"
                                                            id="editStoreName{{ $store->id }}" name="name"
                                                            value="{{ $store->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="row g-6">
                                                    <div class="col mb-0">
                                                        <label for="editStoreAddress{{ $store->id }}"
                                                            class="form-label">Address</label>
                                                        <input type="text" class="form-control"
                                                            id="editStoreAddress{{ $store->id }}" name="address"
                                                            value="{{ $store->address }}" required>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <label for="editStoreMainAddress{{ $store->id }}"
                                                            class="form-label">Main Address</label>
                                                        <input type="text" class="form-control"
                                                            id="editStoreMainAddress{{ $store->id }}"
                                                            name="mainaddress" value="{{ $store->mainaddress }}"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<!-- Include Leaflet.js -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize Map
    const map = L.map('map').setView([30.3753, 69.3451], 5);

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 29,
    }).addTo(map);

    // Add a draggable marker
    const marker = L.marker([30.3753, 69.3451], {
        draggable: true
    }).addTo(map);

    // Add a Geocoder Search Bar
    L.Control.geocoder({
            geocoder: L.Control.Geocoder.nominatim(), 
            defaultMarkGeocode: false,
        })
        .on('markgeocode', function(e) {
            const {
                center,
                name
            } = e.geocode;

            // Update marker position and map view
            marker.setLatLng(center).update();
            map.setView(center, 15);

            document.getElementById('latitude').value = center.lat;
            document.getElementById('longitude').value = center.lng;

            document.getElementById('address').value = name;
            document.getElementById('mainAddress').value = name; // Or customize this as needed
        })
        .addTo(map);

        function showLoadingSpinner() {
            const spinner = document.getElementById('spinner');
            spinner.style.display = 'inline'; 
        }

        function hideLoadingSpinner() {
            const spinner = document.getElementById('spinner');
            spinner.style.display = 'none'; 
        }

        function reverseGeocode(lat, lng) {
            const url =
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

            showLoadingSpinner();

            console.log("Fetching reverse geocode from URL:", url);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log("Reverse geocode response data:", data);
                    if (data && data.address) {
                        const addressData = data.display_name;
                        document.getElementById('address').value = addressData;
                        console.log("Address updated to:", addressData);
                    } else {
                        document.getElementById('address').value = "Address not found";
                    }
                })
                .catch(error => {
                    console.error("Error during reverse geocode fetch:", error);
                    document.getElementById('address').value = "Error fetching address";
                })
                .finally(() => {
                    hideLoadingSpinner();
                });
        }

        // Handle the province change event to adjust map view if needed
        const provinceSelect = document.getElementById('province');
        provinceSelect.addEventListener('change', function() {
            const selectedProvince = provinceSelect.value;

            if (selectedProvince === 'Sindh') {
                map.setView([24.8607, 67.0011], 10); 
            } else if (selectedProvince === 'Punjab') {
                map.setView([31.5497, 74.3436], 10);
            } else if (selectedProvince === 'KPK') {
                map.setView([34.0151, 71.5249], 10); 
            } else if (selectedProvince === 'Balochistan') {
                map.setView([30.1575, 66.5167], 10); 
            } else if (selectedProvince === 'Azad Jammu & Kashmir') {
                map.setView([33.6844, 73.0479], 10);
            }
        });



        // Handle map click event to place marker and update address
        map.on('click', function(event) {
            const lat = event.latlng.lat;
            const lng = event.latlng.lng;
            console.log(lat, lng);
            // Set the marker position where the user clicked
            marker.setLatLng([lat, lng]);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            reverseGeocode(lat, lng);
        });

        // Handle the marker dragging event
        marker.on('dragend', function() {
            const {
                lat,
                lng
            } = marker.getLatLng();
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            reverseGeocode(lat, lng);
        });
    });
</script>
