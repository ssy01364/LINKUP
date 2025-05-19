<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

        <title>Simple Online Store</title>

        @viteReactRefresh
        @vite([
            'resources/css/app.scss',
            'resources/js/app.jsx'
        ])

        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>
