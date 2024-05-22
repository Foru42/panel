<template>
  <div class="flex flex-col items-center">
    <button
      @click="openColorPicker"
      class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline mb-4 transition duration-300 flex items-center"
    >
      <span class="mr-2">Aukeratu Kolorea</span>
      <span class="text-2xl">&#x1F308;</span>
    </button>

    <button
      @click="defaultChanger"
      class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline mb-4 transition duration-300 flex items-center"
    >
      <span class="mr-2">Default</span>
      <span class="text-2xl">&#x1F37F;</span>
    </button>
    <!-- Modal para el selector de color -->
    <div v-if="colorPickerOpen" class="modal">
      <div class="modal-content">
        <button
          @click="closeColor"
          class="top-0 mt-2 mr-2 text-gray-700 focus:outline-none"
        >
          <span class="text-2xl">&#x2716;</span>
        </button>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Opciones de colores -->
          <div class="color-option rounded-lg p-4 border border-gray-200 hover:border-purple-500 transition duration-300">
            <p class="text-black mt-2 font-bold">Sidebar Kolorea</p>
            <div class="input-container flex justify-center items-center">
              <input
                type="color"
                v-model="SidebarColor"
                @change="changeSidebarColor(SidebarColor)"
                @click.stop
                class="cursor-pointer"
              />
            </div>
          </div>
          <div class="color-option rounded-lg p-4 border border-gray-200 hover:border-purple-500 transition duration-300">
            <p class="text-black mt-2 font-bold">Panel printzipal</p>
            <div class="input-container flex justify-center items-center">
              <input
                type="color"
                v-model="PaneColor"
                @change="changePaneColor(PaneColor)"
                @click.stop
                class="cursor-pointer"
              />
            </div>
          </div>
        </div>
        <button @click="closeColorPicker" class=" text-black mt-4 font-bold bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded transition duration-300">
          Gorde Koloreak
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import CryptoJS from "crypto-js";

export default {
  data() {
    return {
      SidebarColor: localStorage.getItem("koloreS"),
      PaneColor: localStorage.getItem("koloreP"),
      colorPickerOpen: false,
    };
  },
  methods: {
    decryptUsername() {
      const secretKey = "LaClaveDelDiosEspacioal1.·¬"; // La misma clave secreta que se utilizó para encriptar
      const encryptedUsername = localStorage.getItem("encryptedUsername");
      if (encryptedUsername) {
        const bytes = CryptoJS.AES.decrypt(encryptedUsername, secretKey);
        const decryptedUsername = bytes.toString(CryptoJS.enc.Utf8);
        return decryptedUsername;
      } else {
        return null;
      }
    },
    openColorPicker() {
      this.colorPickerOpen = true;
      document.body.style.overflow = "hidden";
    },

    closeColorPicker() {
      this.colorPickerOpen = false;
      document.body.style.overflow = "";
      window.location.reload();
    },
    closeColor() {
      this.colorPickerOpen = false;
      document.body.style.overflow = "";
    },
    changePaneColor(color) {
      localStorage.setItem("koloreP", color);
      const tipo = "panel";
      this.fetcheskaera(color, tipo);
    },
    changeSidebarColor(color) {
      localStorage.setItem("koloreS", color);
      const tipo = "sidebar";
      this.fetcheskaera(color, tipo);
    },
    fetcheskaera(color, tipo) {
      const userId = this.decryptUsername();
      fetch("/koloreak", {
        method: "POST",
        body: JSON.stringify({ color: color, login_id: userId, tipo: tipo }),
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      })
        .then((response) => {
          if (response.ok) {
            console.log("bien echo ");
          } else {
            throw new Error("Error al enviar el formulario");
          }
        })
        .catch((error) => {
          console.error("Error formulario", error);
        });
    },
    defaultChanger() {
      let color = "#3584e4";
      let tipo = "sidebar";
      localStorage.setItem("koloreS", color);
      this.fetcheskaera(color, tipo);
      color = "#f6f5f4";
      tipo = "panel";
      localStorage.setItem("koloreP", color);
      this.fetcheskaera(color, tipo);
      setTimeout(function () {
        window.location.reload();
      }, 500);
    },
  },
};
</script>

<style scoped>
.modal {
  display: flex;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.color-option {
  text-align: center;
}

.input-container {
  margin-top: 10px;
}

.color-text {
  font-size: 18px;
  margin-top: 10px;
}
</style>
