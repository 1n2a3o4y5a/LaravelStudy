<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Laravel</title>
    </head>
    <body class="">
        <h1>login!!!</h1>
        <form action="" method="POST">@csrf
            <input type="email" placeholder="email" name="email">
            <input type="password" placeholder="password" name="password">
            <input type="submit" value="送信する">
        </form>
    </body>
</html>
