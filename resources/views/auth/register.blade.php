@php
    session()->flash('register_tab', true);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="0;url={{ route('login') }}">
    <title>Redirecting...</title>
</head>
<body>
    <p class="p-8 text-center text-sm text-navy-700">Redirecting to <a href="{{ route('login') }}" class="text-pulse-500 font-semibold">login page</a>...</p>
</body>
</html>
