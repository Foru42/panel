<template>
  <div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Zure profila</h2>

    <div class="bg-gray-100 shadow-md rounded-lg px-16 py-6 mb-8">
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
          class="w-32 h-32 rounded-full mb-4 border-4 border-gray-200 shadow-lg"
        />
        <label class="block text-gray-700 text-sm font-bold mb-2">
          <p v-if="usuario" class="text-lg font-semibold">{{ usuario[0].username }}</p>
        </label>
        <file-pond
          ref="irudi"
          name="irudi"
          accepted-file-types="image/jpeg, image/png"
          :server="{
            url: '/ProfilaGorde',
            process: {
              headers: {
                'X-CSRF-TOKEN': csrfToken,
              },
            },
          }"
          label-idle='Arrastratu eta aukeratu irudia edo  <span class="filepond--label-action">topatu</span>'
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500 text-black shadow-md"
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
          class="block w-full py-2 px-3 border border-gray-300 rounded shadow-md appearance-none text-black focus:outline-none focus:border-blue-500"
        />
      </div>

      <!-- Botón de Guardar Cambios -->
      <div class="flex justify-center">
        <button
          @click="saveChanges"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300"
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
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";

// Import FilePond plugins
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

// Create component
const FilePond = vueFilePond(
  FilePondPluginImagePreview,
  FilePondPluginImageExifOrientation,
  FilePondPluginFileValidateSize,
  FilePondPluginFileValidateType
);

export default {
  components: {
    KoloreakAldatu,
    PasahitzaAldatu,
    FilePond,
  },
  data() {
    return {
      usuario: null,
      isModalOpen: false,
      gmail: "",
      csrfToken: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
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
          "X-CSRF-TOKEN": this.csrfToken,
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.usuario = data;
          this.gmail = data[0].mail;
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
      const mail = document.getElementById("gmail").value;

      if (mail) {
        const formData = new FormData();
        formData.append("gmail", mail);

        fetch("/ProfilaGorde", {
          method: "POST",
          body: formData,
          headers: {
            "X-CSRF-TOKEN": this.csrfToken,
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
            window.location.reload();
          })
          .catch((error) => {
            console.error("Error formulario", error);
          });
      } else {
        console.log(
          "El campo de Gmail está vacío. No se guardará nada en la base de datos."
        );
      }
    },
  },
};
</script>