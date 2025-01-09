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
                        <input type="text" class="form-control" id="storeName" name="name" placeholder="e.g Imtiaz Super Market" required>
                    </div>
                    <!-- Store Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="e.g SHOP 1 2..." required readonly>
                    </div>
                    <!-- Main Address -->
                    <div class="mb-3">
                        <label for="mainAddress" class="form-label">Main Address</label>
                        <input type="text" class="form-control" id="mainAddress" name="mainaddress" placeholder="e.g MINI MARKET PH-5" required>
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
                    @foreach($stores as $store)
                    <tr>
                        <td><i class="bx bx-store-alt bx-md text-success me-4"></i> <span>{{ $store->name }}</span></td>
                        <td>{{ $store->address }}</td>
                    
                        <td>{{ $store->mainaddress }}</td>
                        <td>
                            {{ $store->user->name }}
                          </td>
                        <td><span class="badge bg-label-primary me-1">Active</span></td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editStoreModal{{ $store->id }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('stores.destroy', $store->id) }}" method="POST" style="display: inline-block;">
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
                    <div class="modal fade" id="editStoreModal{{ $store->id }}" tabindex="-1" aria-labelledby="editStoreModalLabel{{ $store->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('stores.update', $store->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStoreModalLabel{{ $store->id }}">Edit Store</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-6">
                                                <label for="editStoreName{{ $store->id }}" class="form-label">Store Name</label>
                                                <input type="text" class="form-control" id="editStoreName{{ $store->id }}" name="name" value="{{ $store->name }}" required>
                                            </div>
                                        </div>
                                        <div class="row g-6">
                                            <div class="col mb-0">
                                                <label for="editStoreAddress{{ $store->id }}" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="editStoreAddress{{ $store->id }}" name="address" value="{{ $store->address }}" required>
                                            </div>
                                            <div class="col mb-0">
                                                <label for="editStoreMainAddress{{ $store->id }}" class="form-label">Main Address</label>
                                                <input type="text" class="form-control" id="editStoreMainAddress{{ $store->id }}" name="mainaddress" value="{{ $store->mainaddress }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Leaflet.js -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-geocoder/dist/leaflet-geocoder.js"></script>


<script>
     document.addEventListener('DOMContentLoaded', function () {
        // Initialize Map with Pakistan as default
        const map = L.map('map').setView([30.3753, 69.3451], 5); // Center of Pakistan
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Set up province selection
        document.getElementById('province').addEventListener('change', function () {
            const province = this.value;
            let centerCoordinates = [30.3753, 69.3451];  // Default center for Pakistan
            let zoomLevel = 5;  // Default zoom for the whole country

            switch (province) {
                case 'Sindh':
                    centerCoordinates = [25.0961, 67.0099]; // Center of Sindh
                    zoomLevel = 7;
                    break;
                case 'Punjab':
                    centerCoordinates = [31.5204, 74.3587]; // Center of Punjab (Lahore)
                    zoomLevel = 7;
                    break;
                case 'KPK':
                    centerCoordinates = [34.5114, 73.0595]; // Center of KPK
                    zoomLevel = 7;
                    break;
                case 'Balochistan':
                    centerCoordinates = [30.3753, 65.5000]; // Center of Balochistan
                    zoomLevel = 7;
                    break;
                case 'Azad Jammu & Kashmir':
                    centerCoordinates = [33.6844, 73.0479]; // Center of AJK
                    zoomLevel = 7;
                    break;
            }

            map.setView(centerCoordinates, zoomLevel);
        });

        // Add a draggable marker
        const marker = L.marker([30.3753, 69.3451], { draggable: true }).addTo(map);

        // Update latitude and longitude on marker drag
        marker.on('dragend', function (e) {
            const latLng = e.target.getLatLng();
            document.getElementById('latitude').value = latLng.lat;
            document.getElementById('longitude').value = latLng.lng;

            // Get the address based on lat/lng using reverse geocoding
            const geocoder = new L.Control.Geocoder.Nominatim();
            geocoder.reverse(latLng, map.options.crs.scale(map.getZoom()), function(results) {
                const address = results[0] ? results[0].name : 'No address found';
                document.getElementById('address').value = address;
            });
        });

        // Optional: Click to move the marker and autofill the address
        map.on('click', function (e) {
            const latLng = e.latlng;
            marker.setLatLng(latLng);
            document.getElementById('latitude').value = latLng.lat;
            document.getElementById('longitude').value = latLng.lng;

            // Get the address based on lat/lng
            const geocoder = new L.Control.Geocoder.Nominatim();
            geocoder.reverse(latLng, map.options.crs.scale(map.getZoom()), function(results) {
                const address = results[0] ? results[0].name : 'No address found';
                document.getElementById('address').value = address;
            });
        });
    });
    $(document).ready(function() {
        $('#storesTable').DataTable();
    });
</script>
