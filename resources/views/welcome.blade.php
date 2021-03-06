<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
    <title>BulletinBoard</title>
    <link rel="preload" href="{{ mix('css/app.css') }}" as="style">
    <link rel="preload" href="{{ mix('js/app.js') }}" as="script">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<div id="app"></div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
