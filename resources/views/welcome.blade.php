<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="/font-awesome-4.7.0/css/font-awesome.min.css">
        {{-- <link rel="stylesheet" type="text/css" href="/iconic/css/material-design-iconic-font.min.css"> --}}

        <!-- Styles -->
        <link rel="icon" type="image/png" href="/favicon.ico"/>
        <link rel="stylesheet" href="/css/login.css">
        <link rel="stylesheet" href="/css/util.css">

    </head>
    <body>
        <div id="app" class="limiter">
            <Login></Login>
        </div>
        <!-- REQUIRED SCRIPTS -->
        <script src="/js/app.js"></script>
    </body>
</html>
