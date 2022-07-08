<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Link preview for Facebook, Skype -->
    <meta property="og:title" content="Guess My Numbers - A Daily Numbers Game" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://guessmynumbers.com" />
    <meta property="og:image" content="https://imgur.com/a/kRPgdkZ" />
    <meta property="og:description" content="Can you guess my three digit number? Updated twice a day." />
    <!-- Link preview for Twitter -->
    <meta property="twitter:title" content="Guess My Numbers - A Daily Numbers Game" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:site" content="https://guessmynumbers.com" />
    <meta property="twitter:image" content="https://imgur.com/a/kRPgdkZ" />
    <meta property="twitter:description" content="Can you guess my three digit number? Updated twice a day." />

    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/all.min.css') }}" rel="stylesheet">
</head>
<body class="antialiased">
<div id="app">
    <Home/>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
