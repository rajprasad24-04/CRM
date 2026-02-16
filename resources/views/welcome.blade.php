<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wealixir Client Management System</title>
    <link rel="icon" href="{{ asset('home_page/images/favicon.ico') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('home_page/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_page/css/saas.css') }}">

    <!-- Typed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>

    </head>

<body class="page-public-welcome">

<!-- HEADER -->
<header>
    <div class="container py-3 d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="brand">WEALIXIR</a>

        <a href="{{ url('/login') }}" class="btn btn-outline-primary login-btn">
            Login
        </a>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <div class="container">

        <h1 id="text_animation"></h1>

        <p class="mt-4">
            Wealixir opens doors to a new way of managing wealth.
            End the complexity of handling multiple aspects of your financial
            portfolio independently.
        </p>

        <p class="mt-3">
            Insurance, Investments, Taxation, and Real Estate &mdash;
            all brought together under one unified platform.
            Expert-curated solutions help you create wealth, mitigate risks,
            and manage your financial journey with confidence and clarity.
        </p>

        <p class="mt-3">
            Built for professionals. Designed for reliability.
            Focused on long-term financial well-being.
        </p>

    </div>
</section>

<!-- FOOTER -->
<footer class="py-3 text-center">
    &copy; 2026 Wealixir Client Management System. All rights reserved.
</footer>

<!-- JS -->
<script src="{{ asset('home_page/js/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('home_page/js/bootstrap.min.js') }}"></script>

<script>
    new Typed('#text_animation', {
        strings: [
            'Wealixir Client Management System',
            'One Platform. Complete Financial Control.',
            'Simplifying Wealth Management'
        ],
        typeSpeed: 70,
        backSpeed: 40,
        loop: true
    });
</script>

</body>
</html>


