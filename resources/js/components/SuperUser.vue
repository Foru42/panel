<template>
  <form v-if="show_registro_ikusi" @submit.prevent="login">
    <div v-if="error" class="text-red-500 mb-4 ">{{ error }}</div>
    <div>
      <label for="username">Nombre de usuario</label>
      <input type="text" class="text-black" v-model="username" required>
    </div>

    <div>
      <label for="password">Contraseña</label>
      <input type="password" class="text-black" v-model="password" required>
    </div>

    <button type="submit">Iniciar sesión</button>
  </form>
  <div v-if="show_Suser_ikusi">
    <ErabiltzaileakIkusi :IdUsu="IdUsu"></ErabiltzaileakIkusi>
  </div>
</template>

<script>
import ErabiltzaileakIkusi from "./ErabiltzaileakIkusi.vue";

export default {
  props: ["IdUsu"],
  data() {
    return {
      username: '',
      password: '',
      error: "",
      show_Suser_ikusi: false,
      show_registro_ikusi: true,
    };
  },
  components: {
    ErabiltzaileakIkusi,
  },
  methods: {
    login() {
      // Almacenar la referencia al contexto de Vue.js
      const self = this;
      fetch('/ldap/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          username: this.username,
          password: this.password
        })
      })
      .then(response => {
        if (response.ok) {
          return response.json();
        } else {
          self.error = "Pasahitza eta Erabiltzailea ez dira zuzenak";
          throw new Error('Credenciales incorrectas');
        }
      })
      .then(data => {
        console.log(data);
        if (data.isAdmin) {
          this.show_Suser_ikusi = true;
          this.show_registro_ikusi = false;
        } else {
          this.error = "Ez zara administradorea mesedez sartu datu egokiak";
        }
      })
      .catch(error => {
        console.error(error.message);
      });
    }
  }
};
</script>
