<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign in | Wealixir</title>
    <link rel="icon" href="{{ asset('home_page/images/favicon.ico') }}">

    <!-- Font (used by Stripe, Notion, Linear, etc.) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('home_page/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_page/css/saas.css') }}">

    </head>

<body class="page-auth-login">

<div class="auth-layout">

    <form method="POST" action="{{ route('login') }}" class="auth-card">
        @csrf

        <!-- Brand -->
        <div class="text-center mb-4">
            <div class="brand">Wealixir</div>
            <div class="subtitle mt-1">
                Sign in to your client management system
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                required
                autofocus
                autocomplete="username"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                required
                autocomplete="current-password"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember / Forgot -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label footer-text" for="remember_me">
                    Remember me
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Login -->
        <button type="submit" class="btn btn-primary w-100 mb-3">
            Sign in
        </button>

        <!-- Register -->
        @if (Route::has('register'))
            <div class="text-center footer-text">
                Need access?
                <a href="{{ route('register') }}" class="link">Request account</a>
            </div>
        @endif
    </form>

</div>

</body>
</html>

