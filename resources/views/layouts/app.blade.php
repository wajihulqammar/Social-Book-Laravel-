<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Facebook Clone</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
</head>
<body>
    <main>
        @yield('content')
    </main>
</body>
</html>
