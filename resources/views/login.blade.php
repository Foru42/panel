<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

</head>
<body class="login-page">
    <h1>Login</h1>
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>
