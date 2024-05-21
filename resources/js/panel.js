var tarjetaEditandoId = null;
var estadoEstrellas = cargarEstadoEstrellas();

document.addEventListener("DOMContentLoaded", function () {
    // Event listener para la pulsación de tecla en el input
    if (
        window.location.href == "http://panel.eitb.eus/panel#" ||
        window.location.href == "http://panel.eitb.eus/panel"
    ) {
        document
            .getElementById("extensionInput")
            .addEventListener("keypress", function (event) {
                buscarExtensiones();
            });

        // Ocultar el elemento extensionSearch por defecto
        document.getElementById("extensionSearch").classList.add("hidden");

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
            toggleElement("extensionSearch", pane === "panel2");
            toggleElement(
                "ControladorGeneral",
                pane === "panel1" || pane === "panelSelect"
            );
            toggleElement("anadir", pane === "panel3");
            toggleElement(
                "infoPanel",
                pane === "panel1" || pane === "panelSelect"
            );
            toggleElement("resultados", pane === "panel2");
            toggleElement("aldaketak", pane === "panel4");
            toggleElement("pertsonak", pane === "panel5");
            toggleElement("pass", pane === "panel6");
        }

        document
            .getElementById("panel1")
            .addEventListener("click", function (event) {
                handlePanelClick("panel1");
            });

        document
            .getElementById("panel2")
            .addEventListener("click", function (event) {
                handlePanelClick("panel2");
            });

        document
            .getElementById("panel3")
            .addEventListener("click", function (event) {
                handlePanelClick("panel3");
            });
        document
            .getElementById("panel4")
            .addEventListener("click", function (event) {
                handlePanelClick("panel4");
                MostrarActualizados();
            });
        document
            .getElementById("panel5")
            .addEventListener("click", function (event) {
                handlePanelClick("panel5");
                mostrarUsuarios();
            });
        document
            .getElementById("panel6")
            .addEventListener("click", function (event) {
                handlePanelClick("panel6");
                document
                    .getElementById("cambio")
                    .addEventListener("click", function () {
                        cambiarContra();
                    });
            });

        document
            .getElementById("panelSelect")
            .addEventListener("change", function () {
                var selectedPanelId = this.value;
                if (selectedPanelId) {
                    handlePanelClick("panelSelect");
                    mostrarInfo(this);
                }
            });
        document
            .getElementById("cambio")
            .addEventListener("click", function (event) {
                event.preventDefault(); // Evitar el comportamiento predeterminado del formulario (enviar una solicitud GET)
                cambiarContra();
            });
    }
});
function mostrarInfo(select) {
    var tarjetaEditandoId = null;
    var panelSeleccionado = select.value;
    var infoPanel = JSON.parse(
        document.getElementById("grouped_info").getAttribute("data-info")
    );
    var contenidoHTML = "";
    infoPanel[panelSeleccionado].forEach(function (item) {
        contenidoHTML += `
            <div class="card mb-4 shadow-lg rounded-lg overflow-hidden w-full" data-id="${
                item.pt_id
            }">
                <div class="flex justify-between items-center mb-2">
                    <button class="btn-eliminar flex items-center justify-center bg-red-500 text-white font-bold rounded-full h-8 w-8">  <i class="fas fa-trash"></i></button>
                    <button class="btn-editar flex items-center justify-center bg-blue-500 text-white font-bold rounded-full h-8 w-8"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn-sumar flex items-center justify-center bg-blue-600 text-white font-bold rounded-full h-8 w-8 mr-2"><i class="fas fa-plus"></i></button>

                    </div>
                <img src="${item.panel_irudia}" class="card-img-top" alt="${
            item.panel_izena
        }">
                <div class="card-body">
                    <h5 class="card-title">${item.panel_izena}</h5>
                    <p class="card-text" data-editable="panel_deskripzioa" data-id="${
                        item.pt_id
                    }">${item.panel_deskripzioa}</p>
                    <p class="card-text" data-editable="teknologia_desk" data-id="${
                        item.pt_id
                    }">${item.teknologia_izena} - ${item.teknologia_desk}</p>
                    <p class="card-text" data-editable="bertsioa_izena" data-id="${
                        item.pt_id
                    }">${item.bertsioa_izena}</p>
                    <p class="card-text" data-editable="so_desk" data-id="${
                        item.pt_id
                    }">${item.so_izena} - ${item.so_desk}</p>
                </div>
                <button id="estrella_${
                    item.pt_id
                }" class="btn-star star-icon bottom-2 right-2 ${
            estadoEstrellas[item.pt_id] ? "text-yellow-500" : "text-gray-500"
        }" data-panel-id="${item.pt_id}">
                    <i class="${
                        estadoEstrellas[item.pt_id] ? "fas" : "far"
                    } fa-star"></i>
                </button><button id="guardar_${
                    item.pt_id
                }" class="btn-guardar bg-green-500 text-white font-bold rounded-full h-8 w-full mt-2 hidden">GORDE</button>
            </div>
        `;
    });

    document.getElementById("infoPanel").innerHTML = contenidoHTML;
    var botonesEliminar = document.querySelectorAll(".btn-eliminar");
    botonesEliminar.forEach(function (boton) {
        boton.addEventListener("click", function () {
            var panelId =
                this.parentElement.parentElement.getAttribute("data-id");
            eliminarPanel(panelId);
        });
    });

    var botonesEditar = document.querySelectorAll(".btn-editar");
    botonesEditar.forEach(function (boton) {
        boton.addEventListener("click", function () {
            var panelId =
                this.parentElement.parentElement.getAttribute("data-id");
            var camposEditable = document.querySelectorAll(
                `[data-editable][data-id="${panelId}"]`
            );
            if (tarjetaEditandoId !== null && tarjetaEditandoId !== panelId) {
                // Si hay una tarjeta en edición, mostrar un mensaje o realizar una acción adecuada
                alert(
                    "Ya estás editando otra tarjeta. Por favor, guarda o cancela los cambios antes de continuar."
                );
                return;
            }
            tarjetaEditandoId = panelId;

            camposEditable.forEach(function (campo) {
                //console.log(camposEditable);
                var valorActual = campo.textContent.trim();
                campo.dataset.originalValue = valorActual;
                if (campo.getAttribute("data-editable") === "teknologia_desk") {
                    // Crear el select y cargar las opciones de tecnología
                    var select = document.createElement("select");
                    select.classList.add(
                        "w-full",
                        "py-2",
                        "px-4",
                        "rounded",
                        "border",
                        "border-gray-300",
                        "focus:outline-none",
                        "focus:border-blue-500"
                    );
                    var opcionesTecnologia = obtenerOpcionesTecnologia();
                    opcionesTecnologia.forEach(function (opcion) {
                        var option = document.createElement("option");
                        option.value = opcion.id;
                        option.text = opcion.izena + " - " + opcion.desk;
                        if (opcion.izena === valorActual) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                    campo.innerHTML = "";
                    campo.appendChild(select);
                } else if (
                    campo.getAttribute("data-editable") === "bertsioa_izena"
                ) {
                    // Crear select y cargar opciones de versiones
                    var selectB = document.createElement("select");
                    selectB.classList.add(
                        "w-full",
                        "py-2",
                        "px-4",
                        "rounded",
                        "border",
                        "border-gray-300",
                        "focus:outline-none",
                        "focus:border-blue-500"
                    );
                    var opcionesVersiones = obtenerOpcionesVersiones();
                    opcionesVersiones.forEach(function (version) {
                        var optionV = document.createElement("option");
                        optionV.value = version.id;
                        optionV.text = version.izena;
                        // console.log(optionV);
                        if (version.izena === valorActual) {
                            optionV.selected = true;
                        }
                        selectB.appendChild(optionV);
                    });
                    campo.innerHTML = "";
                    campo.appendChild(selectB);
                } else if (campo.getAttribute("data-editable") === "so_desk") {
                    // Crear select y cargar opciones de versiones
                    var selectSO = document.createElement("select");
                    selectSO.classList.add(
                        "w-full",
                        "py-2",
                        "px-4",
                        "rounded",
                        "border",
                        "border-gray-300",
                        "focus:outline-none",
                        "focus:border-blue-500"
                    );

                    var opcionesSO = obtenerOpcionesSO();
                    opcionesSO.forEach(function (versionSO) {
                        var optionSO = document.createElement("option");
                        optionSO.value = versionSO.id;
                        optionSO.text =
                            versionSO.izena + " - " + versionSO.desk;
                        // console.log(optionV);
                        if (versionSO.izena === valorActual) {
                            optionSO.selected = true;
                        }
                        selectSO.appendChild(optionSO);
                    });
                    campo.innerHTML = "";
                    campo.appendChild(selectSO);
                } else {
                    // Crear input para otros campos editables
                    var input = document.createElement("input");
                    input.setAttribute("type", "text");
                    input.setAttribute("value", valorActual);
                    input.classList.add(
                        "w-full",
                        "py-2",
                        "px-4",
                        "rounded",
                        "border",
                        "border-gray-300",
                        "focus:outline-none",
                        "focus:border-blue-500"
                    );
                    campo.innerHTML = "";
                    campo.appendChild(input);
                }
            });

            boton.classList.add("hidden");

            boton.classList.add("hidden");
            var botonCancelar = document.createElement("button"); // Crear el botón de cancelar
            botonCancelar.textContent = "X";
            botonCancelar.classList.add(
                "btn-cancelar",
                "flex",
                "items-center",
                "justify-center",
                "bg-red-500",
                "text-white",
                "font-bold",
                "rounded-full",
                "h-8",
                "w-8"
            );
            botonCancelar.addEventListener("click", function () {
                // Restaurar los datos originales y ocultar el botón de cancelar
                camposEditable.forEach(function (campo) {
                    campo.innerHTML = campo.dataset.originalValue;
                });
                botonCancelar.parentElement
                    .querySelector(".btn-editar")
                    .classList.remove("hidden"); // Mostrar el botón de editar

                // Ocultar el botón de guardar asociado a esta tarjeta
                document
                    .getElementById(`guardar_${panelId}`)
                    .classList.add("hidden");

                botonCancelar.remove(); // Eliminar el botón de cancelar
                tarjetaEditandoId = null; // Reiniciar la variable tarjetaEditandoId
            });
            this.parentElement.appendChild(botonCancelar); // Agregar el botón de cancelar a la tarjeta

            // console.log(panelId);
            document
                .getElementById(`guardar_${panelId}`)
                .classList.remove("hidden");

            // Asignar manejador de evento al botón de guardar
            var botonGuardar = document.getElementById(`guardar_${panelId}`);
            botonGuardar.addEventListener("click", function () {
                var nuevosValores = {};

                // Recopilar los nuevos valores de los campos editables
                var camposEditable = document.querySelectorAll(
                    `[data-editable][data-id="${panelId}"]`
                );
                camposEditable.forEach(function (campo) {
                    var nombreCampo = campo.getAttribute("data-editable");
                    var nuevoValor;
                    if (campo.querySelector("select")) {
                        nuevoValor = campo.querySelector("select").value;
                    } else {
                        nuevoValor = campo.querySelector("input").value;
                    }
                    nuevosValores[nombreCampo] = nuevoValor;
                });

                // Mostrar mensaje de confirmación
                var confirmacion = confirm(
                    "¿Seguru Panela Aldatu nahi duzula?"
                );
                if (confirmacion) {
                    // Guardar los nuevos valores y mostrarlos en la consola
                    console.log(
                        "Nuevos valores para el panel con ID " + panelId + ":",
                        nuevosValores
                    );

                    document
                        .getElementById(`guardar_${panelId}`)
                        .classList.add("hidden");
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

    var botonesSumar = document.querySelectorAll(".btn-sumar");
    console.log(botonesSumar);
    botonesSumar.forEach(function (botones) {
        botones.addEventListener("click", function () {
            var panelId =
                this.parentElement.parentElement.getAttribute("data-id");
            console.log(panelId);
            sumarpanel(panelId);
        });
    });
    var EstrellasFav = document.querySelectorAll(".btn-star");
    EstrellasFav.forEach(function (estrella) {
        estrella.addEventListener("click", function () {
            // Obtener el ID del panel asociado con esta estrella
            var panelId = this.getAttribute("data-panel-id");

            // Alternar el estado de la estrella para esta tarjeta
            estadoEstrellas[panelId] = !estadoEstrellas[panelId];

            // Guardar el estado de las estrellas actualizado en el almacenamiento local del navegador
            guardarEstadoEstrellas(estadoEstrellas);

            // Actualizar la clase y el icono de la estrella
            const iconoEstrella = this.querySelector("i");
            if (estadoEstrellas[panelId]) {
                iconoEstrella.classList.remove("far");
                iconoEstrella.classList.add("fas");
                this.classList.remove("text-gray-500");
                this.classList.add("text-yellow-500");
            } else {
                iconoEstrella.classList.remove("fas");
                iconoEstrella.classList.add("far");
                this.classList.remove("text-yellow-500");
                this.classList.add("text-gray-500");
            }
        });
    });
}
function cargarEstadoEstrellas() {
    var estadoGuardado = localStorage.getItem("estadoEstrellas");
    var csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    var parsedEstadoGuardado = estadoGuardado ? JSON.parse(estadoGuardado) : {};

    // Convertir los datos a un formato asociativo
    var datosAsociativos = {};
    for (var id in parsedEstadoGuardado) {
        datosAsociativos[id] = { estadoEstrella: parsedEstadoGuardado[id] };
    }
    console.log(datosAsociativos);
    // Hacer la solicitud AJAX para enviar los datos al controlador
    $.ajax({
        url: "/anadir-fav",
        type: "POST",
        data: {
            datosAsociativos: datosAsociativos,
            _token: csrfToken, // Incluir el token CSRF en los datos de la solicitud
        },
        success: function (response) {
            console.log("Datos enviados correctamente al controlador");
        },
        error: function (xhr, status, error) {
            console.error("Error al enviar datos al controlador:", error);
        },
    });
    return parsedEstadoGuardado;
}

// Función para guardar el estado de las estrellas en el almacenamiento local del navegador
function guardarEstadoEstrellas(estadoEstrellas) {
    localStorage.setItem("estadoEstrellas", JSON.stringify(estadoEstrellas));
}

function actualizarPanel(panelId, nuevosValores) {
    // Obtener el token CSRF de la meta etiqueta

    var csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    // Realizar la petición AJAX para actualizar el panel en el servidor
    //   console.log(nuevosValores);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/actualizar-panel", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken); // Incluir el token CSRF en la cabecera
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                window.location.reload();
            } else {
                // Si hubo un error, puedes mostrar un mensaje de error o realizar otras acciones necesarias
                console.error(
                    "Error al actualizar el panel:",
                    xhr.responseText
                );
            }
        }
    };
    xhr.send(
        JSON.stringify({ panelId: panelId, nuevosValores: nuevosValores })
    );
}

function eliminarPanel(panelId) {
    var confirmacion = confirm("¿Seguru Panela borratu nahi duzula?");
    if (confirmacion) {
        // Obtener el token CSRF de la meta etiqueta
        var csrfToken = document.head.querySelector(
            'meta[name="csrf-token"]'
        ).content;

        // Realizar la petición AJAX con el token CSRF incluido en la cabecera
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/eliminar-panel", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken); // Incluir el token CSRF en la cabecera
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Si la eliminación fue exitosa, recargar la información
                    alert("Ederto eraginda");
                    // Recargar la página
                    window.location.reload();
                } else {
                    // Si hubo un error, mostrar un mensaje de error
                    console.error(
                        "Error al eliminar el panel:",
                        xhr.responseText
                    );
                }
            }
        };
        xhr.send(JSON.stringify({ panelTekId: panelId })); // Aquí se envía 'panelTekId' en lugar de 'panelId'
    }
}

function buscarExtensiones() {
    var searchTerm = document.getElementById("extensionInput").value;
    // Realizar la petición AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/buscar-extensiones?searchTerm=" + searchTerm, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Manejar la respuesta del servidor aquí
            var resultados = JSON.parse(xhr.responseText);
            mostrarResultados(resultados);
        }
    };
    xhr.send();
}

function mostrarResultados(resultados) {
    var contenidoHTML = "";
    resultados.forEach(function (resultado) {
        contenidoHTML += `
            <div class="card mb-4 shadow-lg rounded-lg overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">${resultado.izena}</h5>
                    <p class="card-text"><strong>Panelak:</strong></p>
                    <ul>
                        ${resultado.paneles
                            .map((panel) => `<li>${panel.izena}</li>`)
                            .join("")}
                    </ul>
                </div>
            </div>
        `;
    });
    document.getElementById("resultados").innerHTML = contenidoHTML;
}

function MostrarActualizados() {
    var csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    // Realizar la petición AJAX con el token CSRF incluido en la cabecera
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/ultimas-modificaciones-panel-tek", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken); // Incluir el token CSRF en la cabecera
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                // Si la solicitud fue exitosa, obtener los datos
                var data = JSON.parse(xhr.responseText);
                generarCards(data); // Generar cards con los datos obtenidos
            } else {
                // Si hubo un error, mostrar un mensaje de error
                console.error("Error al obtener los datos:", xhr.responseText);
            }
        }
    };
    xhr.send();
}
function generarCards(data) {
    var aldatetak = document.getElementById("aldaketak");
    aldatetak.innerHTML = ""; // Limpiar el contenido previo del contenedor

    // Iterar sobre todos los elementos de datos y generar una tarjeta para cada uno
    Object.values(data).forEach(function (panelSeleccionado) {
        panelSeleccionado.forEach(function (item) {
            var contenidoHTML = `
                <div class="md:flex md:justify-center md:items-center mb-8">
                    <div class="card mb-4 shadow-lg rounded-lg overflow-hidden w-full">
                        <img src="${item.panel_irudia}" class="w-full h-64 object-cover" alt="${item.panel_izena}">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">${item.panel_izena}</div>
                            <p class="text-gray-700 text-base mb-2" data-editable="panel_deskripzioa" data-id="${item.pt_id}">${item.panel_deskripzioa}</p>
                            <p class="text-gray-700 text-base mb-2" data-editable="teknologia_desk" data-id="${item.pt_id}">${item.teknologia_izena} - ${item.teknologia_desk}</p>
                            <p class="text-gray-700 text-base mb-2" data-editable="bertsioa_izena" data-id="${item.pt_id}">${item.bertsioa_izena}</p>
                            <p class="text-gray-700 text-base mb-2" data-editable="so_desk" data-id="${item.pt_id}">${item.so_izena} - ${item.so_desk}</p>
                        </div>
                    </div>
                </div>
            `;
            aldatetak.innerHTML += contenidoHTML;
        });
    });
}
function mostrarUsuarios() {
    $(document).ready(function () {
        $.ajax({
            url: "/usuarios",
            type: "GET",
            dataType: "json",
            success: function (response) {
                mostrarTablaUsuarios(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText); // Manejar errores si los hay
            },
        });
    });
}

function mostrarTablaUsuarios(usuarios) {
    var tablaUsuarios = document.getElementById("tablaUsuarios");
    var tbody = tablaUsuarios.getElementsByTagName("tbody")[0];
    tbody.innerHTML = "";

    usuarios.forEach(function (usuario) {
        //console.log(usuario);
        var esAdministrador =
            usuario.administrador === "1" || usuario.administrador === 1
                ? "Sí"
                : "No";
        var fila =
            '<tr data-id="' +
            usuario.id +
            '">' +
            "<td>" +
            usuario.username +
            "</td>" +
            "<td>" +
            esAdministrador +
            "</td>" +
            '<td class="relative">' +
            '<div class="absolute right-0 top-0 h-full flex items-center">' +
            '<button class="btn-eliminarU flex items-center justify-center bg-red-500 text-white font-bold rounded-full h-8 w-8 mr-2"><i class="fas fa-trash"></i></button>' +
            '<button class="btn-editarU flex items-center justify-center bg-blue-500 text-white font-bold rounded-full h-8 w-8"><i class="fas fa-pencil-alt"></i></button>' +
            "</div>" +
            "</td>" +
            "</tr>";
        tbody.innerHTML += fila;
    });

    tablaUsuarios.parentElement.classList.remove("hidden");

    var botonesEliminar = document.querySelectorAll(".btn-eliminarU");
    botonesEliminar.forEach(function (boton) {
        boton.addEventListener("click", function () {
            var panelId = this.closest("tr").getAttribute("data-id");
            eliminarUsuario(panelId);
        });
    });

    var botonesEditar = document.querySelectorAll(".btn-editarU");
    botonesEditar.forEach(function (boton) {
        boton.addEventListener("click", function () {
            var usuarioId = this.closest("tr").getAttribute("data-id");
            var filaUsuario = this.closest("tr");
            var camposFila = filaUsuario.querySelectorAll("td");

            // Obtener el panelId y convertirlo a entero si es necesario
            var panelId = parseInt(this.closest("tr").getAttribute("data-id"));

            var usuarioEditando = document.querySelector(".usuario-editando");
            if (usuarioEditando && usuarioEditando !== filaUsuario) {
                alert(
                    "Ya estás editando otro usuario. Por favor, guarda o cancela los cambios antes de continuar."
                );
                return;
            }

            filaUsuario.classList.add("usuario-editando");

            // Almacenar el contenido original del nombre de usuario
            var nombreUsuarioOriginal = camposFila[0].textContent.trim();

            camposFila.forEach(function (campo, index) {
                if (index === 2) return;
                var valorActual = campo.textContent.trim();
                var input;

                // Si es la columna de administrador, crea un select en lugar de un input
                if (index === 1) {
                    input = document.createElement("select");
                    input.classList.add(
                        "w-full",
                        "py-2",
                        "px-4",
                        "rounded",
                        "border",
                        "border-gray-300",
                        "focus:outline-none",
                        "focus:border-blue-500",
                        "select-administrador"
                    );

                    var optionSi = document.createElement("option");
                    optionSi.text = "Sí";
                    optionSi.value = "1";

                    var optionNo = document.createElement("option");
                    optionNo.text = "No";
                    optionNo.value = "0";

                    input.add(optionSi);
                    input.add(optionNo);

                    input.value = valorActual === "Sí" ? "1" : "0"; // Establecer el valor seleccionado basado en el valor actual del administrador
                } else {
                    // Para otros campos, crea un input de texto
                    input = document.createElement("input");
                    input.setAttribute("type", "text");
                    input.setAttribute("value", valorActual);
                }

                campo.innerHTML = "";
                campo.appendChild(input);
            });

            this.style.display = "none";
            var botonGuardar = document.createElement("button");
            botonGuardar.textContent = "Guardar";
            botonGuardar.classList.add(
                "btn-guardarU",
                "flex",
                "items-center",
                "justify-center",
                "bg-green-500",
                "text-white",
                "font-bold",
                "rounded-full",
                "h-8",
                "w-16",
                "mx-auto",
                "mt-2"
            );
            botonGuardar.setAttribute("id", "btn-guardarU");
            botonGuardar.addEventListener("click", function () {
                var nuevosValores = {};
                camposFila.forEach(function (campo, index) {
                    if (index === 2) return;
                    var nombreCampo =
                        index === 0 ? "username" : "administrador";
                    var nuevoValor;

                    // Si es la columna de administrador, obtén el valor del select en lugar del valor del input
                    if (index === 1) {
                        nuevoValor = campo.querySelector("select").value;
                        campo.innerHTML = nuevoValor === "1" ? "Sí" : "No"; // Mostrar el valor como texto
                    } else {
                        nuevoValor = campo.querySelector("input").value;
                    }

                    nuevosValores[nombreCampo] = nuevoValor;
                });

                // Guardar el panelId en nuevosValores
                nuevosValores["panelId"] = panelId;

                filaUsuario.classList.remove("usuario-editando");

                // Restaurar el contenido original del nombre de usuario
                camposFila[0].textContent = nombreUsuarioOriginal;

                boton.style.display = "inline-block";
                botonGuardar.remove();

                cambiarUsuario(nuevosValores);
            });
            this.parentElement.appendChild(botonGuardar);
        });
    });
}

function cambiarUsuario(nuevosValores) {
    var confirmacion = confirm("¿Seguru erabiltzailea aldatu nahi duzula?");
    if (confirmacion) {
        var csrfToken = document.head.querySelector(
            'meta[name="csrf-token"]'
        ).content;

        // Hacer la solicitud AJAX para cambiar el usuario
        $.ajax({
            url: "/cambiar-usuario",
            type: "POST",
            data: {
                username: nuevosValores.username,
                administrador: nuevosValores.administrador,
                panelId: nuevosValores.panelId,
                _token: csrfToken, // Incluir el token CSRF en los datos de la solicitud
            },
            success: function (response) {
                // Si la actualización fue exitosa, puedes realizar cualquier acción necesaria
                console.log("Usuario actualizado exitosamente");
                window.location.reload();
            },
            error: function (xhr, status, error) {
                // Maneja los errores si ocurren durante la actualización
                console.error("Error al actualizar el usuario:", error);
            },
        });
    }
}

function eliminarUsuario(id) {
    // Obtener el token CSRF del meta tag
    var confirmacion = confirm("¿Estás seguro de eliminar este usuario?");
    if (!confirmacion) {
        return; // Si el usuario cancela, salir de la función sin hacer nada
    }

    var csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    // Hacer la solicitud AJAX para eliminar el usuario
    $.ajax({
        url: "/eliminar-usuario",
        type: "POST",
        data: {
            id: id,
            _token: csrfToken, // Incluir el token CSRF en los datos de la solicitud
        },
        success: function (response) {
            // Si la eliminación fue exitosa, puedes actualizar la tabla de usuarios o realizar cualquier otra acción necesaria
            console.log("Usuario eliminado exitosamente");
            // Por ejemplo, podrías recargar la página para mostrar la tabla actualizada
            window.location.reload();
        },
        error: function (xhr, status, error) {
            // Maneja los errores si ocurren durante la eliminación
            console.error("Error al eliminar el usuario:", error);
        },
    });
}

function cambiarContra() {
    var csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    // Obtener los valores del formulario
    var password_actual = document.getElementById("password_actual").value;
    var password_nueva = document.getElementById("password_nueva").value;
    var password_nueva_confirmation = document.getElementById(
        "password_nueva_confirmation"
    ).value;

    // Realizar la validación de los campos del formulario, por ejemplo, si las contraseñas coinciden
    if (password_nueva !== password_nueva_confirmation) {
        alert(
            "Las nuevas contraseñas no coinciden. Por favor, inténtelo de nuevo."
        );
        return;
    }

    // Realizar la solicitud AJAX para cambiar la contraseña
    $.ajax({
        url: "/cambiar-contrasena", // Reemplaza '/cambiar-contraseña' con la ruta correcta hacia tu controlador
        type: "POST",
        dataType: "json", // Esperar una respuesta JSON del servidor
        data: {
            password_actual: password_actual,
            password_nueva: password_nueva,
            password_nueva_confirmation: password_nueva_confirmation,
            _token: csrfToken, // Esto asume que estás usando Blade para generar el token CSRF
        },
        success: function (response) {
            // Manejar la respuesta del servidor si es necesario
            console.log(response);
            window.location.reload();
        },
        error: function (xhr, status, error) {
            // Manejar los errores si los hay
            var errorMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : "La contraseña actual no coincide con la base de datos.";
            if (errorMessage.includes("La contraseña actual no es válida.")) {
                alert(
                    "La contraseña actual no es válida. Por favor, inténtelo de nuevo."
                );
            } else {
                alert(errorMessage); // Mostrar el mensaje de error en un alert
            }
        },
    });
}

function sumarpanel(id) {
    var panel_izena = document.querySelector(
        `[data-id="${id}"] .card-title`
    ).textContent;
    var tarjeta = document.querySelector(`[data-id="${id}"]`);
    var teknologia_desk = tarjeta.querySelector(
        "[data-editable='teknologia_desk']"
    ).textContent;
    var bets_izen = tarjeta.querySelector(
        "[data-editable='bertsioa_izena']"
    ).textContent;
    var cantidad = prompt(
        "Por favor, introduce la cantidad de paneles a añadir:"
    );
    // Verificar si el usuario canceló el prompt
    if (cantidad === null) {
        return; // No hacer nada si se cancela el prompt
    }
    if (cantidad < 11) {
        var csrfToken = document.head.querySelector(
            'meta[name="csrf-token"]'
        ).content;

        // Hacer la solicitud AJAX para eliminar el usuario
        $.ajax({
            url: "/anadir-panel",
            type: "POST",
            data: {
                teknologia_desk: teknologia_desk,
                id: id,
                panel_izena: panel_izena,
                bets_izen: bets_izen,
                cantidad: cantidad,
                _token: csrfToken, // Incluir el token CSRF en los datos de la solicitud
            },
            success: function (response) {
                // Si la eliminación fue exitosa, puedes actualizar la tabla de usuarios o realizar cualquier otra acción necesaria
                console.log("Usuario eliminado exitosamente");
                window.location.reload();
                // Por ejemplo, podrías recargar la página para mostrar la tabla actualizada
            },
            error: function (xhr, status, error) {
                // Maneja los errores si ocurren durante la eliminación
                console.error("Error al copiar panel:", error);
            },
        });
    } else {
        alert("10 Baino gutxiago mesedez");
        return;
    }
    //console.log("Se añadirán " + cantidad + " paneles al panel con ID: " + id);
}
