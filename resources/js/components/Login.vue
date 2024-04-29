<template>
  <div class="login-page">
    <h1>Login</h1>
    <div v-if="error" class="text-red-500">
      {{ error }}
    </div>
    <form class="form1" @submit.prevent="login">
      <div>
        <label for="username">Erabiltzailea</label>
        <input type="text" id="username" v-model="username" required autofocus />
      </div>
      <div>
        <label for="password">Pasahitza</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <a
        href="/kontua-sortu"
        class="text-blue-500"
        style="margin-top: 10px; font-weight: bold; text-decoration: underline"
        >Kontua Sortu</a
      >
      <button type="submit" class="logeo" style="margin-top: 20px">Login</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: "",
      password: "",
      error: "",
      csrfToken: "",
    };
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
            self.error = "Credenciales incorrectas";
            //throw new Error('Credenciales incorrectas');
            return;
          }
          // Manejar la respuesta del controlador, por ejemplo, redirigir a una nueva página
          console.log(response.data);
          return response.json(); // Convertir la respuesta a JSON
        })
        .then((data) => {
          // Verificar si la respuesta contiene la propiedad 'success'
          if (data && data.success) {
            localStorage.setItem('username', this.username);
            // Redirigir solo si el inicio de sesión es exitoso
             window.location.href = "/panel";
          } else {
            self.error = "Credenciales incorrectas";
          }
        })
        .catch((error) => {
          // Manejar errores, por ejemplo, mostrar un mensaje de error al usuario
          console.error(error);
        });
    },
    logout() {
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
  },
};
</script>

<style scoped></style>
