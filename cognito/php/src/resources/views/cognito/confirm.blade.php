<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Laravel</title>
    </head>
    <body class="">
        <h1>{{$data['email']}} {{$data['phone_number']}}</h1>
        <form action="" method="POST">@csrf
            <input type="number" placeholder="verify code" name="confirm">
            <input type="hidden" name="email" value="{{$data['email']}}">
            <input type="hidden" name="phone_number" value="{{$data['phone_number']}}">
            <input type="submit" value="送信する">
        </form>
    </body>
</html>