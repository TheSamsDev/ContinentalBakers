<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme="theme-default">
    <head>
        <meta charset="utf-8" />
        <meta
          name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    
        <title>DMS : Savtech Digital</title>
    
        <meta name="description" content="" />
    
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
          href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
          rel="stylesheet" />
    
          <link rel="stylesheet" href="{{ asset('app-assets/assets/vendor/fonts/boxicons.css') }}" />
    
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('app-assets/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('app-assets/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('app-assets/assets/css/demo.css') }}" />
    
        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{asset('app-assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    
        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="{{ asset('app-assets/assets/vendor/css/pages/page-auth.css')}}" />
    
        <!-- Helpers -->
        <script src="{{ asset('app-assets/assets/vendor/js/helpers.js') }}"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('app-assets/assets/js/config.js') }}"></script> <!-- Assuming this defines 'config' -->  
        </head>
<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Login Card -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('dashboard') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <!-- Include the SVG or logo here -->
                                </span>
                                <span class="app-brand-text demo text-heading fw-bold">Savtech Digital</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Welcome to Savtech! 👋</h4>
                        <p class="mb-6">Please sign-in to your account and start the adventure</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="form-label">Email or Username</label>
                                <input
                                    type="text"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter your email or username"
                                    autofocus
                                >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    >
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-8">
                                <div class="d-flex justify-content-between mt-8">
                                    <div class="form-check mb-0 ms-2">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember"> Remember Me </label>
                                    </div>
                                    <a href="{{ route('password.request') }}">
                                        <span>Forgot Password?</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ route('register') }}">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Login Card -->
            </div>
        </div>
    </div>

    @include('inc.js')

</body>
</html>
