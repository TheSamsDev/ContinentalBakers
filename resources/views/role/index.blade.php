@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Button to Open Add Role Modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRoleModal">
            Add Role
        </button>

        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="roleName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="permissions" class="form-label">Assign Permissions</label>
                                <div class="form-check">
                                    @foreach ($permissions as $permission)
                                        <div>
                                            <input class="form-check-input" type="checkbox"
                                                id="permission{{ $permission->id }}" name="permissions[]"
                                                value="{{ $permission->id }}">
                                            <label class="form-check-label" for="permission{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
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
            <h5 class="card-header">Roles</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Roles</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->permissions->pluck('name')->join(', ') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#editRoleModal{{ $role->id }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
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

                            <!-- Edit Role Modal -->
                            <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1"
                                aria-labelledby="editRoleModalLabel{{ $role->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editRoleModalLabel{{ $role->id }}">Edit
                                                    Role</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="editRoleName{{ $role->id }}" class="form-label">Role
                                                        Name</label>
                                                    <input type="text" class="form-control"
                                                        id="editRoleName{{ $role->id }}" name="name"
                                                        value="{{ $role->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editPermissions{{ $role->id }}"
                                                        class="form-label">Assign Permissions</label>
                                                    <div class="form-check">
                                                        @foreach ($permissions as $permission)
                                                            <div>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="editPermission{{ $role->id }}{{ $permission->id }}"
                                                                    name="permissions[]" value="{{ $permission->id }}"
                                                                    {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="editPermission{{ $role->id }}{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
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
        <!--/ Table -->
    </div>
@endsection
