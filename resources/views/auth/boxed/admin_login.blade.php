<!-- aiz-main-wrapper -->
<div class="bg-white min-vh-100 d-flex align-items-center justify-content-center overflow-hidden">
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-9 col-md-9 col-sm-12 py-lg-2">
                <div class="card shadow-md border-0">
                    <div class="row g-0 align-items-center">
                        {{-- <!-- Left Side Image (Uncomment if needed) -->
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="{{ uploaded_asset(get_setting('admin_login_page_image')) }}" 
                                 alt="{{ translate('Admin Login Page Image') }}" class="img-fluid">
                        </div> --}}

                        <div class="col-lg-12 p-5">
                            <h1 class="text-primary text-center">{{ translate('Admin Login') }}</h1>

                            <!-- Header Logo -->
                            <div class="mb-3 text-center">
                                @if (get_setting('header_logo'))
                                    <img src="{{ uploaded_asset(get_setting('header_logo')) }}" 
                                         alt="{{ translate('Header Logo') }}" class="w-25">
                                @else
                                    <h5 class="fs-14 fw-400 text-dark">{{ env('APP_NAME') }}</h5>
                                @endif
                            </div>

                            <!-- Titles -->
                            <div class="text-center">
                                <h1 class="fs-20 fw-bold text-secondary text-uppercase">{{ translate('Welcome to') }}</h1>
                                <h5 class="fs-14 fw-400 text-muted">{{ translate('Login to your account') }}</h5>
                            </div>

                            <!-- Login Form -->
                            <form class="mt-3" role="form" action="{{ route('login') }}" method="POST">
                                @csrf

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fs-12 fw-bold text-dark">
                                        {{ translate('Email') }}
                                    </label>
                                    <input type="email" class="form-control rounded" 
                                           value="{{ old('email') }}" 
                                           placeholder="{{ translate('Email') }}" 
                                           name="email" id="email" autocomplete="off">
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- password -->
                                <div class="form-group">
                                    <label for="password"
                                        class="fs-12 fw-700 text-soft-dark">{{ translate('Password') }}</label>
                                    <div class="position-relative">
                                        <input type="password"
                                            class="form-control rounded-0 {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            placeholder="{{ translate('Password') }}" name="password"
                                            id="password">
                                        <i class="password-toggle las la-2x la-eye"></i>
                                    </div>
                                </div>

                                <!-- Remember Me & Forgot Password -->
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember" class="fs-12 text-muted">
                                            {{ translate('Remember Me') }}
                                        </label>
                                    </div>
                                    <div>
                                        <a href="{{ route('password.request') }}" class="fs-12 text-muted">
                                            <u>{{ translate('Forgot password?') }}</u>
                                        </a>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary fw-bold fs-14">
                                        {{ translate('Login') }}
                                    </button>
                                </div>
                            </form>

                            <!-- Demo Mode Credentials -->
                            @if (env('DEMO_MODE') == 'On')
                                <div class="mt-4">
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>admin@example.com</td>
                                                <td>123456</td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-sm" onclick="autoFillAdmin()">
                                                        {{ translate('Copy') }}
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <!-- Go Back -->
                            <div class="text-center mt-3">
                                <a href="{{ str_replace('admin', '', url('/')) }}" class="fs-14 text-primary d-inline-flex align-items-center">
                                    <i class="las la-arrow-left fs-20 me-1"></i> {{ translate('Back to Home Page') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Password Toggle Script -->
<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        let passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    });
</script>

