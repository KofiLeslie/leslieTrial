<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

</head>
<body>
    <div id="app">
        <main class="py-4">
            <h1>Dear {{ ucwords(strtolower($user->name)) }}!</h1>
            <p>Thank you for subscribing to our newsletter. We'll be sending you updates on our latest products and promotions.</p>
            <p>To ensure that you receive our emails, please add our email address to your contact list: <a href="mailto:{{ env('MAIL_USERNAME') }}">{{ env('MAIL_USERNAME') }}</a>.</p>
            <p>If you have any questions or concerns, please feel free to reply to this email.</p>
            <p>Thank you again for subscribing!</p>
          </div>
        </main>
    </div>
</body>
</html>
