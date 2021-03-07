<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pamoika</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/svg.css">
    <link rel="stylesheet" href="/css/normalize.css">
</head>
<body>
<div id="app">
    <app :user="'{{ $user }}'" :errors="{{ $errors }}"></app>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
