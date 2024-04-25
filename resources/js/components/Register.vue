<template>
  <div class="bg-gray-100 flex items-center justify-center h-screen">
    <div
      class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col justify-center"
    >
      <h1 class="text-center text-2xl font-bold mb-8">Erregistroa</h1>

      <!-- Mostrar mensaje de error si existe -->
      <div
        v-if="error"
        class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-5"
        role="alert"
      >
        {{ error }}
      </div>

      <!-- Formulario de registro -->
      <form class="space-y-4" @submit.prevent="register">
        <div>
          <label for="username" class="block text-gray-700 font-bold"
            >Erabiltzailea</label
          >
          <input
            v-model="username"
            type="text"
            id="username"
            name="username"
            class="form-control"
            required
            autofocus
          />
        </div>

        <div>
          <label for="password" class="block text-gray-700 font-bold">Pasahitza</label>
          <input
            v-model="password"
            type="password"
            id="password"
            name="password"
            class="form-control"
            required
          />
        </div>

        <div>
          <button
            type="submit"
            class="w-full px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 transition duration-300"
          >
            Gorde
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: "",
      password: "",
      error: "",
      success: "",
      csrfToken: "",
    };
  },
  methods: {
    register() {
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
            // Redirigir al usuario a otra página, por ejemplo, la página de inicio
            window.location.href = "/login"; // Ajusta esta ruta según sea necesario
          }
        })
        .catch((error) => {
          console.error("Error al registrar:", error);
          this.error = "Error al registrar, por favor intenta de nuevo";
          this.success = "";
        });
    },
  },
};
</script>

<style>
/* Estilos para el contenedor principal */
.login-page {
  font-family: Arial, sans-serif;
  display: flex;
  flex-direction: column; /* Alinea los elementos en columna */
  justify-content: center; /* Centra verticalmente los elementos */
  align-items: center; /* Centra horizontalmente los elementos */
  height: 100vh;
  margin: 0;
  background-color: #f7f7f7;
}

/* Estilos para el contenedor del formulario de login */
.login-container {
  background-color: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Sombra */
  display: flex;
  flex-direction: column;
  align-items: center; /* Centra los elementos horizontalmente */
}

/* Estilos para el título */
h1 {
  text-align: center;
  margin-bottom: 20px;
  margin-top: 20px; /* Añade margen superior al título */
}

/* Estilos para el formulario */
.form1 {
  max-width: 300px;
  margin: 0 auto;
}

.form1 label {
  display: block;
  margin-bottom: 5px;
}

.form1 input {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.form1 button {
  max-width: 200px; /* Máximo ancho del botón para evitar que se extienda demasiado */
  padding: 10px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-top: 20px; /* Añadimos margen superior */
}

.form1 button:hover {
  background-color: #45a049;
}
</style>
