<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <!-- Enlace al archivo CSS de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
        rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
@vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">
    <div id="sidebar" class="sidebar bg-blue-800 text-white fixed left-0 top-0 bottom-0 w-60 pt-32 overflow-y-auto md:relative md:static hidden md:block">
        <div class="sidebar-brand text-center mb-8 text-2xl font-bold">
            Kontrol Panela<br>
            <span class="block">Aupa {{ session('username') }}</span>
        </div>

        <div class="sidebar-menu pl-5">
            <a href="#" id="panel1" class="sidebar-menu-item block py-2 hover:bg-blue-700 transition duration-300">Datuak ikusi</a>
            <a href="#" id="panel2" class="sidebar-menu-item block py-2 hover:bg-blue-700 transition duration-300">Teknologiak ikusi</a>
            <a href="#" id="panel3" class="sidebar-menu-item block py-2 hover:bg-blue-700 transition duration-300">Panelak gehitu</a>
           <div class="sidebar-menu-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white hover:bg-red-700 transition duration-300">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto mt-16 px-10 main-content mb-8"> <!-- Agregado mb-8 para agregar un margen inferior -->
    <!-- Panel Select -->
    <div id="ControladorGeneral" class="panel-select hidden mb-8">
        <select class="form-select" id="panelSelect">
            <option selected disabled>Aukeratu Panel bat</option>
            @foreach ($grouped_info as $panel_izena => $panel_tek)
                <option value="{{ $panel_izena }}">{{ $panel_izena }}</option>
            @endforeach
        </select>
    </div>

    <div id="infoPanel" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>

    <div id="extensionSearch" class="mb-4 mx-auto max-w-screen-lg px-4 hidden">
        <input id="extensionInput" type="text" id="extensionInput" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" placeholder="Buscar tecnologías...">
    </div>

    <div id="resultados" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
    <div id="anadir" class="hidden">
    <!-- Formulario -->
    <div id="grouped_info" data-info="{{ json_encode($grouped_info) }}"></div>
    <form action="{{ route('panelak.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="izenapane">Izena Panela:</label>
        <input type="text" name="izenapane" id="izenapane" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" required>
    </div>

    <div class="form-group">
        <label for="desk">Deskripzioa Panela:</label>
        <textarea name="desk" id="desk" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" required></textarea>
    </div>

    <div class="form-group">
    <label for="irudi">Irudia:</label>
    <input type="file" name="irudi" id="irudi" accept="image/*" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" required>
</div>

    <div class="form-group">
        <label for="izenatek">Izena Teknologia:</label>
        <input type="text" name="izenatek" id="izenatek" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" required>
    </div>

    <div class="form-group">
        <label for="desktek">Deskripzioa Teknologia:</label>
        <textarea name="desktek" id="desktek" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" required></textarea>
    </div>

    <div class="form-group">
        <label for="vertek">Teknologia Bertsioa:</label>
        <textarea name="vertek" id="vertek" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" required></textarea>
    </div>

    <div class="form-group">
        <label for="So_id">Sistema operatiboa:</label>
        <select name="So_id" id="So_id" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" required>
            @foreach(\App\Models\SisOperativo::all() as $sisOperativo)
                <option value="{{ $sisOperativo->id }}">{{ $sisOperativo->izena }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 transition duration-300">Gorde</button>
</form>
</div>
</div>


@vite('resources/js/app.js')
</body>

</html>
