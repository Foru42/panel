<template>
  <div id="pertsonak">
    <button
      @click="addErabiltzaile"
      class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
    >
      Erabiltzailea Gehitu
    </button>
    <table
      id="tablaUsuarios"
      class="w-full divide-y divide-gray-200 shadow-md rounded-lg"
    >
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="px-8 py-3 text-left text-lg font-medium text-gray-700 uppercase tracking-wider"
          >
            Erabiltzailea
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-lg font-medium text-gray-700 uppercase tracking-wider"
          >
            Administradorea
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-lg font-medium text-gray-700 uppercase tracking-wider"
          >
            Ekintzak
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200 text-black">
        <tr v-for="usuario in usuarios" :key="usuario.id">
          <td>
            <template v-if="!usuario.editando">
              {{ usuario.username }}
            </template>
            <template v-else>
              <input type="text" v-model="usuario.username" />
            </template>
          </td>
          <td v-if="!usuario.editando">
            {{
              usuario.administrador === "1" || usuario.administrador === 1 ? "Bai" : "Ez"
            }}
          </td>
          <td v-else>
            <select v-model="usuario.administrador">
              <option value="1">Bai</option>
              <option value="0">Ez</option>
            </select>
          </td>
          <td class="relative">
            <div class="absolute right-0 top-0 h-full flex items-center">
              <template v-if="usuario.editando">
                <button
                  class="btn-guardarU flex items-center justify-center bg-green-500 text-white font-bold rounded-full h-8 w-8 mr-2"
                  @click="cambiarUsuario(usuario)"
                >
                  <i class="fas fa-save"></i>
                </button>
              </template>
              <button
                class="btn-eliminarU flex items-center justify-center bg-red-500 text-white font-bold rounded-full h-8 w-8 mr-2"
                @click="eliminarUsuario(usuario.id)"
              >
                <i class="fas fa-trash"></i>
              </button>
              <button
                class="btn-editarU flex items-center justify-center bg-blue-500 text-white font-bold rounded-full h-8 w-8"
                @click="toggleEdicion(usuario)"
              >
                <i class="fas fa-pencil-alt"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Botón para abrir el modal -->

    <transition name="modal-slide">
      <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div
          class="bg-white rounded-lg p-8 max-w-md w-full transform transition-transform ease-out duration-300"
        >
          <label for="UsuErab">Erabiltzailea:</label><br />
          <input type="text" id="UsuErab" v-model="erabil" /><br />
          <label for="UsuPass">Pasahitza:</label><br />
          <input type="text" id="UsuPass" v-model="pass" /><br />

          <!-- Mostrar mensaje de error -->
          <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>

          <!-- Aquí va el formulario para añadir usuario -->
          <div class="flex justify-end mt-4">
            <button
              @click="storeErabiltzaile"
              class="px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-500"
            >
              Gehitu
            </button>
            <button
              @click="closeModal"
              class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 ml-2"
            >
              Sarratu
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import CryptoJS from "crypto-js";

export default {
  data() {
    return {
      usuarios: [],
      erabil: "",
      pass: "",
      showModal: false,
      errorMessage: "",
    };
  },
  mounted() {
    this.mostrarUsuarios();
  },
  methods: {
    mostrarUsuarios() {
      fetch("/usuarios")
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error al obtener los usuarios");
          }
          return response.json();
        })
        .then((data) => {
          this.usuarios = data.map((usuario) => ({
            ...usuario,
            editando: false, // Agregar propiedad editando a cada usuario
          }));
        })
        .catch((error) => {
          console.error(error.message);
        });
    },
    eliminarUsuario(id) {
      // Obtener el token CSRF del meta tag
      var confirmacion = confirm("¿Estás seguro de eliminar este usuario?");
      if (!confirmacion) {
        return; // Si el usuario cancela, salir de la función sin hacer nada
      }

      var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

      // Hacer la solicitud AJAX para eliminar el usuario
      fetch("/eliminar-usuario", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-Token": csrfToken,
        },
        body: JSON.stringify({ id, _token: csrfToken }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error al eliminar el usuario");
          }
          console.log("Usuario eliminado exitosamente");
          // Por ejemplo, podrías recargar la página para mostrar la tabla actualizada
          window.location.reload();
        })
        .catch((error) => {
          // Maneja los errores si ocurren durante la eliminación
          console.error("Error al eliminar el usuario:", error);
        });
    },
    toggleEdicion(usuario) {
      const usuarioEnEdicion = this.usuarios.find((u) => u.editando);

      if (usuarioEnEdicion && usuarioEnEdicion !== usuario) {
        alert("Ya badaukazu beste erabiltzaile bat editatzen");
        return;
      }

      usuario.editando = !usuario.editando; // Alternar el estado de edición
    },
    cambiarUsuario(nuevosValores) {
      var confirmacion = confirm("¿Seguru erabiltzailea aldatu nahi duzula?");
      if (confirmacion) {
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        localStorage.removeItem("encryptedUsername");
        this.encryptAndSaveUsername(nuevosValores.username);
        // Hacer la solicitud fetch para cambiar el usuario
        fetch("/cambiar-usuario", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
          },
          body: JSON.stringify({
            username: nuevosValores.username,
            administrador: nuevosValores.administrador,
            panelId: nuevosValores.id,
            _token: csrfToken, // Incluir el token CSRF en los datos de la solicitud
          }),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Error al actualizar el usuario");
            }
            console.log("Usuario actualizado exitosamente");
            // Por ejemplo, podrías recargar la página para mostrar la tabla actualizada
            window.location.reload(); // Otra opción es actualizar la lista de usuarios sin recargar la página
          })
          .catch((error) => {
            // Maneja los errores si ocurren durante la actualización
            console.error("Error al actualizar el usuario:", error);
          });
      }
    },
    encryptAndSaveUsername(username) {
      const secretKey = "LaClaveDelDiosEspacioal1.·¬"; // Clave secreta para la encriptación (asegúrate de mantenerla segura)
      const encryptedUsername = CryptoJS.AES.encrypt(
        username,
        secretKey
      ).toString();
      localStorage.setItem("encryptedUsername", encryptedUsername);
    },
    addErabiltzaile() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    storeErabiltzaile() {
      var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

      // Preparar los datos del nuevo usuario
      const userData = {
        username: this.erabil,
        password: this.pass,
      };

      // Hacer la solicitud fetch para registrar al nuevo usuario
      fetch("/registrar", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-Token": csrfToken,
        },
        body: JSON.stringify(userData),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error al registrar el usuario");
          }
          return response.json();
        })
        .then((data) => {
          // Si hay un error, mostrar el mensaje de error en el modal
          if (data.error) {
            this.errorMessage = data.error;
          } else {
            this.showModal = false;
            window.location.reload();
          }
        })
        .catch((error) => {
          // Manejar los errores si ocurren durante el registro
          this.errorMessage = "Usuario ya registrado";
          console.error("Error al registrar el usuario:", error);
        });
    },
  },
};
</script>

<style>
.modal-slide-enter-active,
.modal-slide-leave-active {
  transition: transform 0.5s ease-out;
}
.modal-slide-enter,
.modal-slide-leave-to {
  transform: translateY(-100%);
}
</style>
