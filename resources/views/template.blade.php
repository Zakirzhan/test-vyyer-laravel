<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') | Test App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
<header>
    <h2>TestApp</h2>
</header>
<div class="content container">
    @yield('content')
</div>

<footer>
    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </div>


</footer>
<style>
    header {
        position:fixed;
        width:100%;
        height:50px;
        top:0;
        padding:10px;
        color: #fff;
        background-color: #212529;
        border-color: #32383e;
        text-align: center;
    }
    .content {

        margin-top: 70px;
    }

    footer {
        position:fixed;
        width:100%;
        height:50px;
        bottom:0;
        padding:10px;
        color: #fff;
        background-color: #212529;
        border-color: #32383e;
    }
</style>
</body>
</html>