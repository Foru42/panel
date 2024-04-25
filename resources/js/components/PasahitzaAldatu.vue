<template>
  <form id="pass" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password_actual">
        Contraseña actual
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
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password_nueva">
        Nueva contraseña
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
        Confirmar nueva contraseña
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
        errors.password_confirmation
      }}</span>
    </div>

    <div v-if="error" class="mb-4">
      <span class="text-red-500 text-xs">{{ error }}</span>
    </div>

    <button
      id="cambio"
      type="button"
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
      @click="cambiarContra"
    >
      Cambiar contraseña
    </button>
  </form>
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
    };
  },
  methods: {
    cambiarContra() {
      if (this.password_nueva !== this.password_nueva_confirmation) {
        this.errors.password_confirmation = "Las contraseñas no coinciden.";
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
