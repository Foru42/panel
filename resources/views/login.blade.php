<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="login-page">
    <h1>Login</h1>
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    <form class="form1" method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="username">Erabiltzailea</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
        </div>

        <div>
            <label for="password">Pasahitza</label>
            <input type="password" id="password" name="password" required>
        </div>

    
        <a href='/kontua-sortu' class="text-blue-500" style="margin-top: 10px; font-weight: bold; text-decoration: underline;">Kontua Sortu</a>

        
        <div>
        <button class="logeo" type="submit" style="margin-top: 20px;">Login</button>

    </form>
</body>
</html>
