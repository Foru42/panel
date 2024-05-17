<template>
  <div class="max-w-lg mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Zure profila</h2>

    <div class="bg-white shadow-md rounded-lg px-8 py-6 mb-8">
      <!-- Cambio de colores -->
      <KoloreakAldatu />

      <!-- Foto de Perfil -->
      <div class="mb-6 flex flex-col items-center">
        <label class="block text-gray-700 text-sm font-bold mb-2"
          >Erabiltzaile argazkia</label
        >
        <img
          :src="usuario ? usuario[0].argazki : ''"
          alt="Foto de Perfil"
          class="w-32 h-30 rounded-full mx-auto mb-4 border-4 border-gray-200"
        />
        <label class="block text-gray-700 text-sm font-bold mb-2">
          <p v-if="usuario" class="text-lg font-semibold">
            {{ usuario[0].username }}
          </p></label
        >
        <!-- Mover dentro del mismo div -->
        <input
          ref="irudi"
          name="irudi"
          id="irudi"
          type="file"
          @change="handleFileUpload"
          accept="image/*"
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500 text-black"
        />
      </div>

      <!-- Nombre de Usuario -->
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">Gmail</label>
        <input
          name="gmail"
          id="gmail"
          type="text"
          :value="gmail"
          class="block w-full py-2 px-3 border border-gray-300 rounded shadow appearance-none text-black"
        />
      </div>

      <!-- Botón de Guardar Cambios -->
      <div class="flex justify-center">
        <button
          @click="saveChanges"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        >
          Guardar Cambios
        </button>
      </div>
    </div>

    <!-- Cambiar Contraseña -->
    <PasahitzaAldatu @modal-closed="handleModalClosed" />
  </div>
</template>

<script>
import KoloreakAldatu from "./KoloreakAldatu.vue";
import PasahitzaAldatu from "./PasahitzaAldatu.vue";
import CryptoJS from "crypto-js";

export default {
  components: {
    KoloreakAldatu,
    PasahitzaAldatu,
  },
  data() {
    return {
      usuario: null,
      isModalOpen: false,
      gmail: "",
    };
  },
  mounted() {
    this.mostrarUsuarios();
  },
  methods: {
    mostrarUsuarios() {
      const nombre = this.decryptUsername();

      fetch("/usuario", {
        method: "POST",
        body: JSON.stringify({ userId: nombre }),
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.usuario = data;
          this.gmail = data[0].mail; // Asignar el valor del correo electrónico a la propiedad gmail
        })
        .catch((error) => {
          console.error("Hubo un problema con la operación fetch:", error);
        });
    },

    decryptUsername() {
      const secretKey = "LaClaveDelDiosEspacioal1.·¬";
      const encryptedUsername = localStorage.getItem("encryptedUsername");
      if (encryptedUsername) {
        const bytes = CryptoJS.AES.decrypt(encryptedUsername, secretKey);
        const decryptedUsername = bytes.toString(CryptoJS.enc.Utf8);
        return decryptedUsername;
      } else {
        return null;
      }
    },
    handleModalClosed() {
      this.isModalOpen = false;
    },
    saveChanges() {
      const file = this.$refs.irudi.files[0]; // Obtener el archivo de imagen
      const mail = document.getElementById('gmail').value ; // Obtener el nombre de usuario

      // Verificar si la imagen o el nombre de usuario no están vacíos
      if (file || mail) {
        const formData = new FormData(); // Crear un objeto FormData para enviar datos

        // Agregar la imagen y el nombre de usuario al formData si no están vacíos
        if (file) {
          formData.append("irudi", file);
        }
        if (mail) {
          formData.append("gmail", mail);
        }

        // Realizar la solicitud POST al servidor
        fetch("/ProfilaGorde", {
          method: "POST",
          body: formData, // Enviar formData en lugar de solo el nombre del archivo
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content"),
          },
        })
          .then((response) => {
            if (response.ok) {
              return response.json();
            } else {
              throw new Error("Error al enviar el formulario");
            }
          })
          .then((data) => {
            // Manejar la respuesta del servidor si es necesario
            console.log(data);
           window.location.reload();
          })
          .catch((error) => {
            console.error("Error formulario", error);
          });
      } else {
        console.log(
          "Ambos campos están vacíos. No se guardará nada en la base de datos."
        );
      }
    },
  },
};
</script>

<style scoped>
/* Estilos específicos del componente */
</style>
