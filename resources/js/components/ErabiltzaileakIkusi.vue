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
            {{ usuario.roles.some((role) => role.name === "admin") ? "Bai" : "Ez" }}
          </td>
          <td v-else>
            <select v-model="usuario.isAdmin">
              <option :value="true">Bai</option>
              <option :value="false">Ez</option>
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

    <transition name="modal-slide text-black">
      <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div
          class="bg-white rounded-lg p-8 max-w-md w-full transform transition-transform ease-out duration-300 text-black"
        >
          <label for="UsuErab">Erabiltzailea:</label><br />
          <input type="text" id="UsuErab" v-model="erabil" /><br />
          <label for="UsuPass">Pasahitza:</label><br />
          <input type="text" id="UsuPass" v-model="pass" /><br />

          <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>

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
  props: ["IdUsu"],
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
    //console.log(this.IdUsu);
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
            isAdmin: usuario.roles.some((role) => role.name === "admin"),
          }));
        })
        .catch((error) => {
          console.error(error.message);
        });
    },
    eliminarUsuario(id) {
      var confirmacion = confirm("¿Estás seguro de eliminar este usuario?");
      if (!confirmacion) {
        return;
      }

      var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

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
          this.mostrarUsuarios();
        })
        .catch((error) => {
          console.error("Error al eliminar el usuario:", error);
        });
    },
    toggleEdicion(usuario) {
      const usuarioEnEdicion = this.usuarios.find((u) => u.editando);

      if (usuarioEnEdicion && usuarioEnEdicion !== usuario) {
        alert("Ya badaukazu beste erabiltzaile bat editatzen");
        return;
      }

      usuario.editando = !usuario.editando;
    },
    cambiarUsuario(nuevosValores) {
      var confirmacion = confirm("¿Seguru erabiltzailea aldatu nahi duzula?");
      if (confirmacion) {
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        const newRoles = nuevosValores.isAdmin ? [{ name: "admin" }] : [];
        fetch("/cambiar-usuario", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
          },
          body: JSON.stringify({
            username: nuevosValores.username,
            panelId: nuevosValores.id,
            roles: newRoles,
            _token: csrfToken,
          }),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Error al actualizar el usuario");
            }
            //console.log("Usuario actualizado exitosamente");

            // Actualizar nombre de usuario en el localStorage si el usuario actual cambia su propio nombre

            if (this.IdUsu === nuevosValores.id) {
              this.encryptAndSaveUsername(nuevosValores.username);
            }

            this.mostrarUsuarios();
          })
          .catch((error) => {
            console.error("Error al actualizar el usuario:", error);
          });
      }
    },
    encryptAndSaveUsername(username) {
      const secretKey = "LaClaveDelDiosEspacioal1.·¬";
      const encryptedUsername = CryptoJS.AES.encrypt(username, secretKey).toString();
      localStorage.setItem("encryptedUsername", encryptedUsername);
    },
    decryptUsername() {
      const secretKey = "LaClaveDelDiosEspacioal1.·¬"; // La misma clave secreta que se utilizó para encriptar
      const encryptedUsername = localStorage.getItem("encryptedUsername");
      if (encryptedUsername) {
        const bytes = CryptoJS.AES.decrypt(encryptedUsername, secretKey);
        const decryptedUsername = bytes.toString(CryptoJS.enc.Utf8);
        return decryptedUsername;
      } else {
        return null;
      }
    },
    addErabiltzaile() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    storeErabiltzaile() {
      var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

      const userData = {
        username: this.erabil,
        password: this.pass,
      };

      fetch("/usunuevo", {
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
          if (data.error) {
            this.errorMessage = data.error;
          } else {
            this.showModal = false;
            this.mostrarUsuarios();
          }
        })
        .catch((error) => {
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
