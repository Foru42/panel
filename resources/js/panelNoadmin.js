var tarjetaEditandoId = null;

document.addEventListener('DOMContentLoaded', function () {
    // Event listener para la pulsación de tecla en el input
    if(window.location.href=='http://panel.eitb.eus/panelNoadmin#' || window.location.href=='http://panel.eitb.eus/panelNoadmin'){
    
    document.getElementById('extensionInput').addEventListener('keypress', function(event) {
        buscarExtensiones();
    });

    // Ocultar el elemento extensionSearch por defecto
    document.getElementById('extensionSearch').classList.add("hidden");

    // Mostrar/ocultar elementos al hacer clic en los enlaces del menú
    function toggleElement(elementId, show) {
        var element = document.getElementById(elementId);
        if (show) {
            element.classList.remove("hidden");
        } else {
            element.classList.add("hidden");
        }
    }

    // Función para manejar los clics en los enlaces del menú
// Función para manejar los clics en los enlaces del menú
function handlePanelClick(pane) {
  
    toggleElement('extensionSearch', pane === 'panel2' ); 
    toggleElement('ControladorGeneral', pane === 'panel1' || pane === 'panelSelect'); 
    toggleElement('infoPanel', pane === 'panel1' || pane === 'panelSelect'); 
    toggleElement('resultados', pane === 'panel2'); 

}


    document.getElementById('panel1').addEventListener('click', function (event) {
        handlePanelClick('panel1');
    });
    
    document.getElementById('panel2').addEventListener('click', function (event) {
        handlePanelClick('panel2');
    });
    
    document.getElementById('panelSelect').addEventListener('change', function() {
        var selectedPanelId = this.value;
        if (selectedPanelId) {
            handlePanelClick('panelSelect');
            mostrarInfo(this);
        }
    });
}
});

function mostrarInfo(select) {
    var tarjetaEditandoId = null;
    var panelSeleccionado = select.value;
    var infoPanel = JSON.parse(document.getElementById('grouped_info').getAttribute('data-info'));
    var contenidoHTML = '';
    infoPanel[panelSeleccionado].forEach(function (item) {
        contenidoHTML += `
            <div class="card mb-4 shadow-lg rounded-lg overflow-hidden w-full" data-id="${item.pt_id}">
                <img src="${item.panel_irudia}" class="card-img-top" alt="${item.panel_izena}">
                <div class="card-body">
                    <h5 class="card-title">${item.panel_izena}</h5>
                    <p class="card-text" data-editable="panel_deskripzioa" data-id="${item.pt_id}">${item.panel_deskripzioa}</p>
                    <p class="card-text" data-editable="teknologia_desk" data-id="${item.pt_id}">${item.teknologia_izena} - ${item.teknologia_desk}</p>
                    <p class="card-text" data-editable="bertsioa_izena" data-id="${item.pt_id}">${item.bertsioa_izena}</p>
                    <p class="card-text" data-editable="so_desk" data-id="${item.pt_id}">${item.so_izena} - ${item.so_desk}</p>
                </div>
              </div>
        `;
    });
    document.getElementById("infoPanel").innerHTML = contenidoHTML;

}

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