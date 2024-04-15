<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col justify-center">
        <h1 class="text-center text-2xl font-bold mb-8">Login</h1>
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-5" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form class="space-y-4" method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="username" class="block text-gray-700 font-bold">Erabiltzailea</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control" required autofocus>
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-bold">Pasahitza</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div>
            <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 transition duration-300">Gorde</button>
            </div>
        </form>
    </div>
</body>
</html>