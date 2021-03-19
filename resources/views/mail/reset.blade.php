<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Подтведите сброс пароля</title>
</head>
<body>
<h2>Добро пожаловать на наш сайт, {{ $user->login }}</h2>
<p>
    Click <a href="{{ $link }}">here</a> to reset your password.
</p>
</body>
</html>
