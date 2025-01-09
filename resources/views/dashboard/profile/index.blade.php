@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">My Profile</h4>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img
                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('app-assets/assets/img/avatars/1.png') }}"
                        alt="user-avatar"
                        class="d-block w-px-100 h-px-100 rounded"
                        id="uploadedAvatar">
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-4">
                            <span>Upload new photo</span>
                            <input type="file" id="upload" name="avatar" hidden accept="image/png, image/jpeg">
                        </label>
                        <div>Allowed JPG, GIF, or PNG. Max size of 800K</div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" name="role" value="{{ $user->getRoleNames()->first() }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" id="state" name="state" value="{{ $user->state }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $user->zip_code }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="language" class="form-label">Language</label>
                        <select id="language" class="form-select" name="language">
                            <option value="">Select Language</option>
                            <option value="en" {{ $user->language == 'en' ? 'selected' : '' }}>English</option>
                            <option value="fr" {{ $user->language == 'fr' ? 'selected' : '' }}>French</option>
                            <option value="de" {{ $user->language == 'de' ? 'selected' : '' }}>German</option>
                            <option value="pt" {{ $user->language == 'pt' ? 'selected' : '' }}>Portuguese</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('profile.show', $user->id) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function resetAvatar() {
        alert('Avatar reset functionality is not enabled. Upload a new image if needed.');
    }
</script>
@endsection
