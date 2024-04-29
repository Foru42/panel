<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">
    <div id="sidebar">
        <div class="sidebar-brand">
            Kontrol Panela<br>
            <span class="block">Aupa {{ session('username') }}</span>
        </div>

        <div class="sidebar-menu">
            <a href="#" id="panel1" class="sidebar-menu-item hover:bg-gray-800">Datuak ikusi</a>
            <a href="#" id="panel2" class="sidebar-menu-item hover:bg-gray-800">Teknologiak ikusi</a>
            <a href="#" id="panel6" class="sidebar-menu-item hover:bg-gray-800">Zure Pasahitza aldatu</a>


            <div class="sidebar-menu-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white hover:bg-red-700 transition duration-300">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto mt-16 px-10 main-content mb-8">
        <div id="ControladorGeneral" class="panel-select hidden mb-8">
            <select class="form-select" id="panelSelect">
                <option selected disabled>Aukeratu Panel bat</option>
                @foreach ($grouped_info as $panel_izena => $panel_tek)
                    <option value="{{ $panel_izena }}">{{ $panel_izena }}</option>
                @endforeach
            </select>
        </div>
        <div id="grouped_info" data-info="{{ json_encode($grouped_info) }}"></div>
        <div id="infoPanel" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>

<form id="pass" class="hidden bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_actual">
        Contraseña actual
    </label>
    <input id="password_actual" type="password" name="password_actual" required
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('password_actual')
    <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_nueva">
        Nueva contraseña
    </label>
    <input id="password_nueva" type="password" name="password_nueva" required
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>

<div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_nueva_confirmation">
        Confirmar nueva contraseña
    </label>
    <input id="password_nueva_confirmation" type="password" name="password_nueva_confirmation" required
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>

<button id="cambio" type="button"
    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
    Cambiar contraseña
</button>
</form>

        <div id="extensionSearch" class="mb-4 mx-auto max-w-screen-lg px-4 hidden">
            <input id="extensionInput" type="text" id="extensionInput" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" placeholder="Buscar tecnologías...">
        </div>

        <div id="resultados" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var teknologias = @json($teknologias);
        var bertsioa_izenak = @json($bertsioa_izenak);
        var so_desk = @json($so_desk);
    </script>

    @vite('resources/js/app.js')
</body>
</html>
