var tarjetaEditandoId = null;

document.addEventListener('DOMContentLoaded', function () {
    // Event listener para la pulsación de tecla en el input
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
    toggleElement('anadir', pane === 'panel3'); 
    toggleElement('infoPanel', pane === 'panel1' || pane === 'panelSelect'); 
    toggleElement('resultados', pane === 'panel2'); 
    toggleElement('aldaketak', pane === 'panel4');
}


    document.getElementById('panel1').addEventListener('click', function (event) {
        handlePanelClick('panel1');
    });
    
    document.getElementById('panel2').addEventListener('click', function (event) {
        handlePanelClick('panel2');
    });
    
    document.getElementById('panel3').addEventListener('click', function (event) {
        handlePanelClick('panel3');
    }); 
    document.getElementById('panel4').addEventListener('click', function (event) {
        handlePanelClick('panel4');
    });
    
    document.getElementById('panelSelect').addEventListener('change', function() {
        var selectedPanelId = this.value;
        if (selectedPanelId) {
            handlePanelClick('panelSelect');
            mostrarInfo(this);
        }
    });
});

function mostrarInfo(select) {
    var tarjetaEditandoId = null;
    var panelSeleccionado = select.value;
    var infoPanel = JSON.parse(document.getElementById('grouped_info').getAttribute('data-info'));
    var contenidoHTML = '';
    infoPanel[panelSeleccionado].forEach(function (item) {
        contenidoHTML += `
            <div class="card mb-4 shadow-lg rounded-lg overflow-hidden w-full" data-id="${item.pt_id}">
                <div class="flex justify-between items-center mb-2">
                    <button class="btn-eliminar flex items-center justify-center bg-red-500 text-white font-bold rounded-full h-8 w-8">  <i class="fas fa-trash"></i></button>
                    <button class="btn-editar flex items-center justify-center bg-blue-500 text-white font-bold rounded-full h-8 w-8"><i class="fas fa-pencil-alt"></i></button>
                </div>
                <img src="${item.panel_irudia}" class="card-img-top" alt="${item.panel_izena}">
                <div class="card-body">
                    <h5 class="card-title">${item.panel_izena}</h5>
                    <p class="card-text" data-editable="panel_deskripzioa" data-id="${item.pt_id}">${item.panel_deskripzioa}</p>
                    <p class="card-text" data-editable="teknologia_desk" data-id="${item.pt_id}">${item.teknologia_izena} - ${item.teknologia_desk}</p>
                    <p class="card-text" data-editable="bertsioa_izena" data-id="${item.pt_id}">${item.bertsioa_izena}</p>
                    <p class="card-text" data-editable="so_desk" data-id="${item.pt_id}">${item.so_izena} - ${item.so_desk}</p>
                </div>
                <button id="guardar_${item.pt_id}" class="btn-guardar bg-green-500 text-white font-bold rounded-full h-8 w-full mt-2 hidden">GORDE</button>
            </div>
        `;
    });

    document.getElementById("infoPanel").innerHTML = contenidoHTML;

    // Asignar manejadores de eventos a los botones de eliminar
    var botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(function(boton) {
        boton.addEventListener('click', function() {
            var panelId = this.parentElement.parentElement.getAttribute('data-id');
            eliminarPanel(panelId);
        });
    });

    // Asignar manejadores de eventos a los botones de editar
    var botonesEditar = document.querySelectorAll('.btn-editar');
    botonesEditar.forEach(function(boton) {
        boton.addEventListener('click', function() {
            var panelId = this.parentElement.parentElement.getAttribute('data-id');
            var camposEditable = document.querySelectorAll(`[data-editable][data-id="${panelId}"]`);
            if (tarjetaEditandoId !== null && tarjetaEditandoId !== panelId) {
                // Si hay una tarjeta en edición, mostrar un mensaje o realizar una acción adecuada
                alert('Ya estás editando otra tarjeta. Por favor, guarda o cancela los cambios antes de continuar.');
                return;
            }
    
            tarjetaEditandoId = panelId;
    

            camposEditable.forEach(function(campo) {
                //console.log(camposEditable);
                var valorActual = campo.textContent.trim();
                campo.dataset.originalValue = valorActual;
                if (campo.getAttribute('data-editable') === 'teknologia_desk') {
                    // Crear el select y cargar las opciones de tecnología
                    var select = document.createElement('select');
                    select.classList.add('w-full', 'py-2', 'px-4', 'rounded', 'border', 'border-gray-300', 'focus:outline-none', 'focus:border-blue-500');
                    var opcionesTecnologia = obtenerOpcionesTecnologia();
                    opcionesTecnologia.forEach(function(opcion) {
                        var option = document.createElement('option');
                        option.value = opcion.id;
                        option.text = opcion.izena + ' - ' + opcion.desk;
                        if (opcion.izena === valorActual) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                    campo.innerHTML = '';
                    campo.appendChild(select);
                } else if (campo.getAttribute('data-editable') === 'bertsioa_izena') {
                    // Crear select y cargar opciones de versiones
                    var selectB = document.createElement('select');
                    selectB.classList.add('w-full', 'py-2', 'px-4', 'rounded', 'border', 'border-gray-300', 'focus:outline-none', 'focus:border-blue-500');
                    var opcionesVersiones = obtenerOpcionesVersiones();
                    opcionesVersiones.forEach(function(version) {
                        var optionV = document.createElement('option');
                        optionV.value = version.id;
                        optionV.text = version.izena;
                 // console.log(optionV);
                        if (version.izena === valorActual) {
                            optionV.selected = true;
                        }
                        selectB.appendChild(optionV);
                    });
                    campo.innerHTML = '';
                    campo.appendChild(selectB);
                }else if (campo.getAttribute('data-editable') === 'so_desk') {
                    // Crear select y cargar opciones de versiones
                    var selectSO = document.createElement('select');
                    selectSO.classList.add('w-full', 'py-2', 'px-4', 'rounded', 'border', 'border-gray-300', 'focus:outline-none', 'focus:border-blue-500');
                  
                    var opcionesSO = obtenerOpcionesSO();
                    opcionesSO.forEach(function(versionSO) {
                        var optionSO = document.createElement('option');
                        optionSO.value = versionSO.id;
                        optionSO.text = versionSO.izena + ' - ' + versionSO.desk;;
                 // console.log(optionV);
                        if (versionSO.izena === valorActual) {
                            optionSO.selected = true;
                        }
                        selectSO.appendChild(optionSO);
                    });
                    campo.innerHTML = '';
                    campo.appendChild(selectSO);
                } else {
                    // Crear input para otros campos editables
                    var input = document.createElement('input');
                    input.setAttribute('type', 'text');
                    input.setAttribute('value', valorActual);
                    input.classList.add('w-full', 'py-2', 'px-4', 'rounded', 'border', 'border-gray-300', 'focus:outline-none', 'focus:border-blue-500');
                    campo.innerHTML = '';
                    campo.appendChild(input);
                }
            });
    
            boton.classList.add('hidden');


            boton.classList.add('hidden');
            var botonCancelar = document.createElement('button'); // Crear el botón de cancelar
            botonCancelar.textContent = 'X';
            botonCancelar.classList.add('btn-cancelar', 'flex', 'items-center', 'justify-center', 'bg-red-500', 'text-white', 'font-bold', 'rounded-full', 'h-8', 'w-8');
            botonCancelar.addEventListener('click', function() {
                // Restaurar los datos originales y ocultar el botón de cancelar
                camposEditable.forEach(function(campo) {
                    campo.innerHTML = campo.dataset.originalValue;
                });
                botonCancelar.parentElement.querySelector('.btn-editar').classList.remove('hidden'); // Mostrar el botón de editar
                
                // Ocultar el botón de guardar asociado a esta tarjeta
                document.getElementById(`guardar_${panelId}`).classList.add('hidden');
                
                botonCancelar.remove(); // Eliminar el botón de cancelar
                tarjetaEditandoId = null; // Reiniciar la variable tarjetaEditandoId
            });
            this.parentElement.appendChild(botonCancelar); // Agregar el botón de cancelar a la tarjeta
      

           // console.log(panelId);
            document.getElementById(`guardar_${panelId}`).classList.remove('hidden');
    
            // Asignar manejador de evento al botón de guardar
            var botonGuardar = document.getElementById(`guardar_${panelId}`);
            botonGuardar.addEventListener('click', function() {
                var nuevosValores = {};
    
                // Recopilar los nuevos valores de los campos editables
                var camposEditable = document.querySelectorAll(`[data-editable][data-id="${panelId}"]`);
                camposEditable.forEach(function(campo) {
                    var nombreCampo = campo.getAttribute('data-editable');
                    var nuevoValor;
                    if (campo.querySelector('select')) {
                        nuevoValor = campo.querySelector('select').value;
                    } else {
                        nuevoValor = campo.querySelector('input').value;
                    }
                    nuevosValores[nombreCampo] = nuevoValor;
                });
    
                // Mostrar mensaje de confirmación
                var confirmacion = confirm("¿Seguru Panela Aldatu nahi duzula?");
                if (confirmacion) {
                    // Guardar los nuevos valores y mostrarlos en la consola
                    console.log("Nuevos valores para el panel con ID " + panelId + ":", nuevosValores);

                    
                    document.getElementById(`guardar_${panelId}`).classList.add('hidden');
                //    console.log(panelId,nuevosValores);
                    actualizarPanel(panelId, nuevosValores);
                }
            });
        });
    });
    
    function obtenerOpcionesTecnologia() {
       return teknologias;
    }
    function obtenerOpcionesVersiones() {
        return bertsioa_izenak;
    }
    function obtenerOpcionesSO() {
        return so_desk;
    }
    
}

function actualizarPanel(panelId, nuevosValores) {
    // Obtener el token CSRF de la meta etiqueta

    var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    // Realizar la petición AJAX para actualizar el panel en el servidor
 //   console.log(nuevosValores);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/actualizar-panel', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Incluir el token CSRF en la cabecera
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
             window.location.reload();
            } else {
                // Si hubo un error, puedes mostrar un mensaje de error o realizar otras acciones necesarias
                console.error('Error al actualizar el panel:', xhr.responseText);
            }
        }
    };
    xhr.send(JSON.stringify({ panelId: panelId, nuevosValores: nuevosValores }));
}

function eliminarPanel(panelId) {
    var confirmacion = confirm("¿Seguru Panela borratu nahi duzula?");
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
                    alert('Ederto eraginda');
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
