document.getElementById('panelSelect').addEventListener('change', function() {
    mostrarInfo(this);
});
document.getElementById('extensionInput').addEventListener('keypress', function(event) {

        buscarExtensiones();
    
});

function mostrarInfo(select) {
    var panelSeleccionado = select.value;
    var infoPanel = JSON.parse(document.getElementById('grouped_info').getAttribute('data-info'));
    var contenidoHTML = '';
    infoPanel[panelSeleccionado].forEach(function (item) {
        contenidoHTML += `
        <div class="card mb-4 shadow-lg rounded-lg overflow-hidden w-full" data-id="${item.pt_id}">
        <button class="btn-eliminar flex items-center justify-center bg-red-500 text-white font-bold rounded-full h-8 w-8">X</button>
         <img src="${item.panel_irudia}" class="card-img-top" alt="${item.panel_izena}">
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

    // Asignar manejadores de eventos a los botones de eliminar
    var botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(function(boton) {
        boton.addEventListener('click', function() {
            var panelId = this.parentElement.getAttribute('data-id');
            eliminarPanel(panelId);
        });
    });
}

function eliminarPanel(panelId) {
    var confirmacion = confirm("¿Estás seguro de que quieres eliminar este panel?");
    if (confirmacion) {
        // Obtener el token CSRF de la meta etiqueta
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        // Realizar la petición AJAX con el token CSRF incluido en la cabecera
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/eliminar-panel', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Incluir el token CSRF en la cabecera
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Si la eliminación fue exitosa, recargar la información
                    alert('Eliminado Correctamente');
                    // Recargar la página
                    window.location.reload();
                } else {
                    // Si hubo un error, mostrar un mensaje de error
                    console.error('Error al eliminar el panel:', xhr.responseText);
                }
            }
        };
        xhr.send(JSON.stringify({ panelTekId: panelId })); // Aquí se envía 'panelTekId' en lugar de 'panelId'
    }
}





// Ocultar elementos al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('extensionSearch').classList.add("hidden");
    document.getElementById('ControladorGeneral').classList.remove("hidden");
    document.getElementById('ControladorGeneral').classList.add("block");
    document.getElementById('infoPanel').classList.add("block");
    document.getElementById('anadir').classList.add("hidden");
});

// Mostrar/ocultar elementos al hacer clic en los enlaces del menú
document.getElementById('panel1').addEventListener('click', function (event) {
    document.getElementById('resultados').classList.add("hidden");
    document.getElementById('extensionSearch').classList.add("hidden");
    document.getElementById('ControladorGeneral').classList.remove("hidden");
    document.getElementById('infoPanel').classList.remove("hidden");
    document.getElementById('anadir').classList.add("hidden");
});

document.getElementById('panel2').addEventListener('click', function (event) {
    document.getElementById('ControladorGeneral').classList.add("hidden");
    document.getElementById('infoPanel').classList.add("hidden");
    document.getElementById('extensionSearch').classList.remove("hidden");
    document.getElementById('resultados').classList.remove("hidden");
    document.getElementById('anadir').classList.add("hidden");
});

document.getElementById('panel3').addEventListener('click', function (event) {
    document.getElementById('ControladorGeneral').classList.add("hidden");
    document.getElementById('infoPanel').classList.add("hidden");
    document.getElementById('extensionSearch').classList.add("hidden");
    document.getElementById('resultados').classList.add("hidden");
    document.getElementById('anadir').classList.remove("hidden");
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