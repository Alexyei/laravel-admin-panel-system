<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Подтведите регистрацию</title>
</head>
<body>
<h2>Welcome to Our Website, {{ $user->name }}</h2>
<p>
    Click <a href="{{ $link }}">here</a> to verify your email.
</p>
</body>
</html>
