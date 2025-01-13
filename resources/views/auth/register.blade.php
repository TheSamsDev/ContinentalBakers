<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme="theme-default">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title>DMS : Savtech Digital</title>
        <meta name="description" content="" />
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('app-assets/assets/vendor/fonts/boxicons.css') }}" />
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('app-assets/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('app-assets/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('app-assets/assets/css/demo.css') }}" />
        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{asset('app-assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <!-- Page CSS -->
        <link rel="stylesheet" href="{{ asset('app-assets/assets/vendor/css/pages/page-auth.css')}}" />
        <!-- Helpers -->
        <script src="{{ asset('app-assets/assets/vendor/js/helpers.js') }}"></script>
        <script src="{{ asset('app-assets/assets/js/config.js') }}"></script> <!-- Assuming this defines 'config' -->
    </head>
    <body>
        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner">
                    <!-- Register Card -->
                    <div class="card px-sm-6 px-0">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center mb-6">
                                <a href="{{ url('dashboard') }}" class="app-brand-link gap-2">
                                    <span class="app-brand-logo demo">
                                        <!-- Insert SVG logo here -->
                                    </span>
                                    <span class="app-brand-text demo text-heading fw-bold">Savtech Digital</span>
                                </a>
                            </div>
                            <!-- /Logo -->
                            <h4 class="mb-1">Adventure starts here 🚀</h4>
                            <p class="mb-6">Make your Distribution management easy and fun!</p>

                            <!-- Registration Form -->
                            <form method="POST" action="{{ route('register') }}" class="mb-6">
                                @csrf

                                <div class="mb-6">
                                    <label for="name" class="form-label">Username</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your username">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password and Confirm Password fields -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter your password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                                </div>

                                <div class="my-8">
                                    <div class="form-check mb-0 ms-2">
                                        <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                                        <label class="form-check-label" for="terms-conditions">
                                            I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label for="role" class="form-label">Become a </label>
                                    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
                            </form>

                            <p class="text-center">
                                <span>Already have an account?</span>
                                <a href="{{ route('login') }}">
                                    <span>Sign in instead</span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Register Card -->
                </div>
            </div>
        </div>

        @include('inc.js')

    </body>
</html>
