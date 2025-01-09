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
                        <div class="row">
                            <div class="col mb-6">
                                <label for="roleName" class="form-label">Store Name</label>
                                <input type="text" class="form-control" id="roleName" name="name" placeholder="e.g Imtiaz Super Market" required>
                            </div>
                        </div>
                        <div class="row g-6">
                            <div class="col mb-0">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="e.g SHOP 1 2..." required>
                            </div>
                            <div class="col mb-0">
                                <label for="mainAddress" class="form-label">Main Address</label>
                                <input type="text" class="form-control" id="mainAddress" name="mainaddress" placeholder="e.g MINI MARKET PH-5" required>
                            </div>
                        </div>
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



<script>
    $(document).ready(function() {
        $('#storesTable').DataTable();
    });
</script>
