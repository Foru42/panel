<template>
  <div>
    <p @click="togglePasswordForm" class="text-blue-600 cursor-pointer underline">
      Pasahitza Aldatu
    </p>

    <transition name="fade">
      <div class="modal" v-if="showPasswordForm">
        <div class="modal-content">
          <span @click="togglePasswordForm" class="close">&times;</span>
          <form id="pass" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
              <label
                class="block text-gray-700 text-sm font-bold mb-2"
                for="password_actual"
              >
                Zure pasahitza
              </label>
              <input
                v-model="password_actual"
                id="password_actual"
                type="password"
                name="password_actual"
                required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              />
              <span v-if="errors.password_actual" class="text-red-500 text-xs">{{
                errors.password_actual
              }}</span>
            </div>

            <div class="mb-4">
              <label
                class="block text-gray-700 text-sm font-bold mb-2"
                for="password_nueva"
              >
                Pasahitza berria
              </label>
              <input
                v-model="password_nueva"
                id="password_nueva"
                type="password"
                name="password_nueva"
                required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              />
            </div>

            <div class="mb-6">
              <label
                class="block text-gray-700 text-sm font-bold mb-2"
                for="password_nueva_confirmation"
              >
                Konfirmatu pasahitz berria
              </label>
              <input
                v-model="password_nueva_confirmation"
                id="password_nueva_confirmation"
                type="password"
                name="password_nueva_confirmation"
                required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              />
              <span v-if="errors.password_confirmation" class="text-red-500 text-xs">{{
                error
              }}</span>
            </div>

            <div v-if="error" class="mb-4">
              <span class="text-red-500 text-xs">{{ error }}</span>
            </div>

            <div class="flex justify-center">
              <button
                type="button"
                @click="changePassword"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300"
              >
                Gorde
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>


<script>
export default {
  data() {
    return {
      password_actual: "",
      password_nueva: "",
      password_nueva_confirmation: "",
      errors: {},
      error: "",
      showPasswordForm: false,
    };
  },
  methods: {
    togglePasswordForm() {
      this.showPasswordForm = !this.showPasswordForm;
    },
    cambiarContra() {
      if (this.password_nueva !== this.password_nueva_confirmation) {
        this.error = "Las contraseñas no coinciden.";
        return;
      }

      fetch("/cambiar-contrasena", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify({
          password_actual: this.password_actual,
          password_nueva: this.password_nueva,
          password_nueva_confirmation: this.password_nueva_confirmation,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            throw Error(response.statusText);
          }
          return response.json();
        })
        .then((data) => {
          console.log(data.message);
          window.location.reload();
        })
        .catch((error) => {
          if (error.response && error.response.status === 403) {
            // Si el error tiene una respuesta y el estado es 403 (Forbidden)
            alert("La contraseña actual no es válida.");
          } else {
            // En caso de cualquier otro error, muestra un mensaje genérico
            this.error = "Errorea, pasahitza ez da erabiltzailearen pasahitza.";
          }
        });
    },
  },
};
</script>
<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}
.modal {
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  animation: modal-fade-in 0.3s ease-out;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

@keyframes modal-fade-in {
  from {
    opacity: 0;
    transform: translateY(-50px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>