var tarjetaEditandoId = null;

document.addEventListener("DOMContentLoaded", function () {
    // Event listener para la pulsación de tecla en el input
    if (
        window.location.href == "http://panel.eitb.eus/panelNoadmin#" ||
        window.location.href == "http://panel.eitb.eus/panelNoadmin"
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
            toggleElement(
                "infoPanel",
                pane === "panel1" || pane === "panelSelect"
            );
            toggleElement("resultados", pane === "panel2");
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
            .getElementById("panelSelect")
            .addEventListener("change", function () {
                var selectedPanelId = this.value;
                if (selectedPanelId) {
                    handlePanelClick("panelSelect");
                    mostrarInfo(this);
                }
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
