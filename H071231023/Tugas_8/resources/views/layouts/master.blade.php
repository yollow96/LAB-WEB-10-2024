<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'My Website' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            width: 75%;
            margin: 0 auto;
            padding: 0px;
        }

        nav {
            background: #333;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 1rem;
        }

        .content {
            min-height: 400px;
            padding: 2rem;
            background: #f9f9f9;
            border-radius: 8px;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            /* padding: 1rem; */
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
        }
        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background-color: #fff;
            border-bottom: 2px solid #ddd;
        }

        .hero-text {
            max-width: 50%;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            color: #333;
        }

        .subtitle {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #666;
        }

        .hero-image {
            margin-left: 2rem;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 900px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-text,
            .hero-image {
                max-width: 100%;
            }
    </style>
</head>

<body>
    <nav>
        <div class="container">
            <x-button href="{{ route('home') }}" text="Home" />
            <x-button href="{{ route('about') }}" text="About" />
            <x-button href="{{ route('contact') }}" text="Contact" />
        </div>
    </nav>

    <div class="container">
        <div class="content">
            <h1>{{ $pageTitle ?? 'Welcome' }}</h1>
            @yield('content')
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} My Website. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>