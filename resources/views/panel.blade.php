<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <!-- Enlace al archivo CSS de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
        rel="stylesheet">
    <!-- Aquí iría la referencia a tu archivo de estilos personalizado -->
    <link href="@vite('resources/css/app.css')">
</head>

<body class="bg-gray-100 font-sans">

    <div id="sidebar" class="sidebar bg-gray-800 text-white fixed left-0 top-0 bottom-0 w-60 pt-16 overflow-y-auto md:relative md:static hidden md:block">
        <div class="sidebar-brand text-center mb-8 text-2xl font-bold">
            Kontrol Panela<br>
            <span class="block">Aupa {{ session('username') }}</span>
        </div>

        <div class="sidebar-menu pl-5">
            <a href="#" id="pane1" class="sidebar-menu-item block py-2 hover:bg-gray-700 transition duration-300">Datuak ikusi</a>
            <a href="#" id="panel2" class="sidebar-menu-item block py-2 hover:bg-gray-700 transition duration-300">Teknologiak ikusi</a>
            <a href="#" class="sidebar-menu-item block py-2 hover:bg-gray-700 transition duration-300">Panel 3</a>
            <div class="sidebar-menu-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white hover:bg-red-700 transition duration-300">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto mt-16 px-10 main-content mb-8" > <!-- Agregado mb-8 para agregar un margen inferior -->
    <!-- Panel Select -->
    <div id="ControladorGeneral" class="panel-select hidden mb-8">
        <select class="form-select" onchange="mostrarInfo(this)">
            <option selected disabled>Aukeratu Panel bat</option>
            @foreach ($grouped_info as $panel_izena => $panel_tek)
                <option value="{{ $panel_izena }}">{{ $panel_izena }}</option>
            @endforeach
        </select>
    </div>

    <div id="infoPanel" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>

    <div id="extensionSearch" class="mb-4 mx-auto max-w-screen-lg px-4 hidden">
        <input onkeypress="buscarExtensiones()" type="text" id="extensionInput" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500" placeholder="Buscar tecnologías...">
    </div>

    <div id="resultados" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
</div>

    <!-- Script -->
    <script>
      function mostrarInfo(select) {
            var panelSeleccionado = select.value;
            var infoPanel = @json($grouped_info);

            var contenidoHTML = '';
            infoPanel[panelSeleccionado].forEach(function (item) {
                contenidoHTML += `
                    <div class="card mb-4 shadow-lg rounded-lg overflow-hidden w-full ">
                        <img src="{{ asset('') }}/${item.panel_irudia}" class="card-img-top" alt="${item.panel_izena}">
                        <div class="card-body">
                            <h5 class="card-title">${item.panel_izena}</h5>
                            <p class="card-text"><strong>Panel Deskripzioa:</strong> ${item.panel_deskripzioa}</p>
                            <p class="card-text"><strong>Teknologi Deskripzioa:</strong> ${item.teknologia_izena} - ${item.teknologia_desk}</p>
                            <p class="card-text"><strong>Panel Bertsioa:</strong> ${item.bertsioa_izena}</p>
                            <p class="card-text"><strong>Sistema operatiboa:</strong> ${item.so_izena} - ${item.so_desk}</p>
                        </div>
                    </div>
                `;
            });

            document.getElementById("infoPanel").innerHTML = contenidoHTML;
        }
        // Ocultar elementos al cargar la página
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('extensionSearch').classList.add("hidden");
            document.getElementById('ControladorGeneral').classList.remove("hidden");
            document.getElementById('ControladorGeneral').classList.add("block");
            document.getElementById('infoPanel').classList.add("block");
        });

        // Mostrar/ocultar elementos al hacer clic en los enlaces del menú
        document.getElementById('pane1').addEventListener('click', function (event) {
            document.getElementById('resultados').classList.add("hidden");
            document.getElementById('extensionSearch').classList.add("hidden");
            document.getElementById('ControladorGeneral').classList.remove("hidden");
            document.getElementById('infoPanel').classList.remove("hidden");
        });

        document.getElementById('panel2').addEventListener('click', function (event) {
            document.getElementById('ControladorGeneral').classList.add("hidden");
            document.getElementById('infoPanel').classList.add("hidden");
            document.getElementById('extensionSearch').classList.remove("hidden");
            document.getElementById('resultados').classList.remove("hidden");
        });

// Función para buscar extensiones
function buscarExtensiones() {
    var searchTerm = document.getElementById('extensionInput').value;
    // Realizar la petición AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/buscar-extensiones?searchTerm=' + searchTerm, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Manejar la respuesta del servidor aquí
            var resultados = JSON.parse(xhr.responseText);
            mostrarResultados(resultados);
        }
    };
    xhr.send();
}

// Función para mostrar resultados de búsqueda
function mostrarResultados(resultados) {
    var contenidoHTML = '';
    resultados.forEach(function(resultado) {
        contenidoHTML += `
            <div class="card mb-4 shadow-lg rounded-lg overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">${resultado.izena}</h5>
                    <p class="card-text"><strong>Panelak:</strong></p>
                    <ul>
                        ${resultado.paneles.map(panel => `<li>${panel.izena}</li>`).join('')}
                    </ul>
                </div>
            </div>
        `;
    });
    document.getElementById("resultados").innerHTML = contenidoHTML;
}

    </script>
</body>

</html>
