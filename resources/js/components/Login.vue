<template>
  <div class="flex justify-center items-center h-screen">
    <div class="max-w-md w-full bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 shadow-lg rounded-lg p-8">
      <h1 class="text-3xl font-bold mb-4 text-white">Login!</h1>
      <div v-if="!showRegister">
        <div v-if="error" class="text-white-500 mb-4">{{ error }}</div>
        <form @submit.prevent="login" class="space-y-4">
          <div class="mb-4">
            <label for="username" class="block text-white">Erabiltzailea</label>
            <input
              type="text"
              id="username"
              v-model="username"
              required
              autofocus
              class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-500 ease-in-out"
            />
          </div>
          <div class="mb-4 relative">
            <label for="password" class="block text-white">Pasahitza</label>
            <input
              :type="showPassword ? 'text' : 'password'"
              id="password"
              v-model="password"
              required
              class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-500 ease-in-out"
            />
            <span class="absolute right-3 top-10 cursor-pointer" @click="toggleShowPassword">
              <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </span>
          </div>
          <button
            type="submit"
            class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white hover:bg-purple-700 rounded-lg transition duration-300"
          >
            ¡Sesioa Hasi!
          </button>
        </form>
        <p class="mt-4 text-center text-white text-sm">
          ¿Ez duzu konturik?
          <a
            href=""
            @click.prevent="showRegisterForm"
            class="font-medium text-blue-200 hover:text-blue-300 transition duration-300 ease-in-out"
          >
            ¡Erregistratu hemen!
          </a>
        </p>
      </div>
      <div v-else>
        <Register @show-login="showLoginForm" />
      </div>
    </div>
  </div>
</template>

<script>
import CryptoJS from "crypto-js";
import Register from "./Register.vue";

export default {
  components: {
    Register,
  },
  data() {
    return {
      username: "",
      password: "",
      error: "",
      csrfToken: "",
      showRegister: false,
      showPassword: false,
    };
  },
  mounted() {
    this.logout();
  },
  methods: {
    login() {
      fetch("/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify({
          username: this.username,
          password: this.password,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            this.error = "Datuak ez daude zuzen";
            return;
          }
          return response.json();
        })
        .then((data) => {
          if (data && data.success) {
            this.encryptAndSaveUsername(this.username);
            window.location.href = "/panel"; // Navegar programáticamente a la página de panel
          } else {
            this.error = "Erabiltzailea edo pasahitza ez da zuzena";
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    logout() {
      fetch("/logout", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
      })
        .then((response) => {
          if (response.ok) {
            console.log("Has cerrado sesión correctamente");
          } else {
            console.error("Error al cerrar sesión");
          }
        })
        .catch((error) => {
          console.error("Error al cerrar sesión:", error);
        });
    },
    showRegisterForm() {
      this.showRegister = true;
    },
    showLoginForm() {
      this.showRegister = false;
    },
    toggleShowPassword() {
      this.showPassword = !this.showPassword;
    },
    encryptAndSaveUsername(username) {
      const secretKey = "LaClaveDelDiosEspacioal1.·¬";
      const encryptedUsername = CryptoJS.AES.encrypt(username, secretKey).toString();
      localStorage.setItem("encryptedUsername", encryptedUsername);
    },
  },
};
</script>


<style scoped></style>
