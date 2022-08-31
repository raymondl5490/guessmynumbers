<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Guess My Numbers is an online numbers game updated twice a day. Crack the code to reveal the featured number. Winners submit their own numbers to be featured!">
    <meta name="keywords" content="guess, number, twice, daily, three, digit, California, kids">
    <meta name="google-site-verification" content="oMhOnoK8MaI4TilGQx8cA9Y2unX8bVP532ketLdhfp8" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=0">

    <!-- Link preview for Facebook, Skype -->
    <meta property="og:title" content="Guess My Numbers - A Daily Numbers Game" />
    <meta property="og:type" content="summary_large_image" />
    <meta property="og:url" content="https://guessmynumbers.com" />
    <meta property="og:image" content="https://i.imgur.com/17p2epe.png" />
    <meta property="og:description" content="Can you guess my three digit number? Updated twice a day." />
    <!-- Link preview for Twitter -->
    <meta property="twitter:title" content="Guess My Numbers - A Daily Numbers Game" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:site" content="https://guessmynumbers.com" />
    <meta property="twitter:image" content="https://i.imgur.com/17p2epe.png" />
    <meta property="twitter:description" content="Can you guess my three digit number? Updated twice a day." />

    <title>GUESS MY NUMBERS - Play fun and addictive guessing numbers game!</title>
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
