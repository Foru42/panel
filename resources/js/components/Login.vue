<template>
  <div class="flex justify-center items-center h-screen">
    <div
      class="max-w-md w-full bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 shadow-lg rounded-lg p-8"
    >
      <h1 class="text-3xl font-bold mb-4 text-white">Login!</h1>
      <div v-if="!Show">
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
          <div class="mb-4">
            <label for="password" class="block text-white">Pasahitza</label>
            <input
              type="password"
              id="password"
              v-model="password"
              required
              class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-500 ease-in-out"
            />
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
            @click.prevent="showRegister"
            class="font-medium text-blue-200 hover:text-blue-300 transition duration-300 ease-in-out"
            >¡Erregistratu hemen!</a
          >
        </p>
      </div>
      <div v-else>
        <Register @show-login="showLogin" />
      </div>
    </div>
  </div>
</template>
<script>
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
      Show: false,
    };
  },
  computed: {
    // Computed property para verificar si la URL coincide con /kontua-sortu
    isRegisterPage() {
      return this.$route === "/kontua-sortu";
    },
    showLogin() {
      return () => {
        this.Show = false; // Oculta el componente de registro y muestra el formulario de inicio de sesión
      };
    },
  },

  mounted() {
    this.logout();
  },
  methods: {
    login() {
      let self = this;
      // Enviar los datos del formulario al controlador utilizando fetch
      fetch("/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify({
          username: this.username,
          password: this.password,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            self.error = "Datuak ez daude zuzen";
            return;
          }
          // Manejar la respuesta del controlador, por ejemplo, redirigir a una nueva página
          return response.json(); // Convertir la respuesta a JSON
        })
        .then((data) => {
          // Verificar si la respuesta contiene la propiedad 'success'
          if (data && data.success) {
            localStorage.setItem("username", this.username);
            // Redirigir solo si el inicio de sesión es exitoso
            window.location.href = "/panel";
          } else {
            self.error = "Erabiltzailea edo pasahitza ez da zuzena";
          }
        })
        .catch((error) => {
          // Manejar errores, por ejemplo, mostrar un mensaje de error al usuario
          console.error(error);
        });
    },
    logout() {
      localStorage.removeItem("anadir");
      localStorage.removeItem("main-content");
      localStorage.removeItem("sidebar");
      localStorage.removeItem("sidebar-text");
      localStorage.removeItem("tek");
      localStorage.removeItem("datuakIkusi");

      fetch("/logout", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      })
        .then((response) => {
          if (response.ok) {
            console.log("Has cerrado sesión correctamente");
            // Redirige al usuario a la página de inicio de sesión
          } else {
            console.error("Error al cerrar sesión");
          }
        })
        .catch((error) => {
          console.error("Error al cerrar sesión:", error);
        });
    },
    showRegister() {
      this.Show = true; // Modifica el valor de Show en lugar de asignar a una variable no definida
    },
  },
};
</script>

<style scoped></style>
