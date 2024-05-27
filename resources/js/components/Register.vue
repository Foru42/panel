<template>
  <div
    class="bg-white shadow-md rounded-lg p-8 flex flex-col justify-center max-w-md w-full"
  >
    <h1 class="text-center text-3xl font-bold text-gray-800 mb-8">
      ¡Erregistratu orain!
    </h1>
    <div
      v-if="error"
      class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-5"
      role="alert"
    >
      <span class="block font-semibold">¡Ups!.</span>
      <span>{{ error }}</span>
    </div>
    <div
      v-if="success"
      class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-5"
      role="alert"
    >
      <span class="block font-semibold">¡Erregistro ondo!</span>
      <span>{{ success }}</span>
    </div>
    <transition name="fade">
      <form class="space-y-4" v-if="!success" @submit.prevent="register">
        <div>
          <label for="username" class="block text-gray-800 font-semibold"
            >Erabiltzailea</label
          >
          <input
            v-model="username"
            type="text"
            id="username"
            name="username"
            class="form-input"
            required
            autofocus
          />
        </div>
        <div>
          <label for="password" class="block text-gray-800 font-semibold"
            >Pasahitza</label
          >
          <input
            v-model="password"
            type="password"
            id="password"
            name="password"
            class="form-input"
            required
          />
        </div>

        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2">Gmail</label>
          <input
            name="gmail"
            id="gmail"
            type="text"
            v-model="gmail"
            class="block w-full py-2 px-3 border border-gray-300 rounded shadow appearance-none text-black"
            required
          />
        </div>

        <div>
          <button
            type="submit"
            class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white hover:bg-purple-700 rounded-lg transition duration-300"
          >
            Erregistratu!
          </button>
        </div>
        <p class="mt-4 text-center text-white text-sm">
          <a
            href=""
            @click.prevent="showLogin"
            class="font-medium text-blue-400 hover:text-blue-300 transition duration-300 ease-in-out"
            >Bueltatu!</a
          >
        </p>
      </form>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: "",
      password: "",
      gmail: "",
      error: "",
      success: "",
      csrfToken: "",
    };
  },
  methods: {
    showLogin() {
      this.$emit("show-login");
    },
    isValidEmail(email) {
      const re = /^(([^<>()\[\]\.,;:\s@"]+(\.[^<>()\[\]\.,;:\s@"]+)*)|(".+"))@gmail\.com$/;
      return re.test(String(email).toLowerCase());
    },
    register() {
      if (!this.isValidEmail(this.gmail)) {
        this.error = "Gmail no válido. Por favor, ingresa un correo de Gmail válido.";
        this.success = "";
        return;
      }

      fetch("/registrar", {
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
          gmail: this.gmail,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json();
        })
        .then((data) => {
          if (data.error) {
            this.error = data.error;
            this.success = "";
          } else if (data.success) {
            this.error = "";
            this.success = data.success;
            this.$emit("show-login"); // Emitir evento para mostrar el login
          }
        })
        .catch((error) => {
          console.error("Error al registrar:", error);
          this.error = "Errorea erabiltzailea erregistratzen. Badago gure datubasean.";
          this.success = "";
        });
    },
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
