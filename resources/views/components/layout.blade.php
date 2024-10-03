<html>
    <head>
        <title>{{ $title ?? 'Example Website' }}</title>
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
