<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Laravel</title>
    </head>
    <body class="">
        <h1>OK!!!</h1>
        <a href="{{ route('cognito.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">logout</a>
        <form id="logout-form" action="{{ route('cognito.logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
    </body>
</html>
