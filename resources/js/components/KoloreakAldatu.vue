<template>
  <div>
    <button
      @click="openColorPicker"
      class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline mb-4 mr-4"
    >
      <span class="mr-2">Aukeratu Kolorea</span>
      <span class="text-2xl">&#x1F308;</span>
      <!-- Icono de paleta de colores -->
    </button>
    <button
      @click="defaultChanger"
      class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline mb-4"
    >
      <span class="mr-2">Default</span>
      <span class="text-2xl">&#x1F37F;</span>
      <!-- Icono de botella de licor -->
    </button>
    <!-- Modal para el selector de color -->
    <div v-if="colorPickerOpen" class="modal">
      <div class="modal-content">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Opciones de colores -->
          <div
            class="color-option rounded-lg p-4 border border-gray-200 hover:border-purple-500"
          >
            <p :style="{ color: textColor(PaneColor) }" class="color-text mt-2 font-bold">
              Sidebar Kolorea
            </p>
            <div class="input-container flex justify-center items-center">
              <input
                type="color"
                v-model="SidebarColor"
                @change="changeSidebarColor(SidebarColor)"
                @click.stop
              />
            </div>
          </div>
          <button @click="closeColorPicker" class="color-text mt-2 font-bold">
            Sarratu
          </button>
          <div
            class="color-option rounded-lg p-4 border border-gray-200 hover:border-purple-500 transition duration-300"
          >
            <p :style="{ color: textColor(PaneColor) }" class="color-text mt-2 font-bold">
              Panel printzipal
            </p>
            <div class="input-container flex justify-center items-center">
              <input
                type="color"
                v-model="PaneColor"
                @change="changePaneColor(PaneColor)"
                @click.stop
                class=""
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      SidebarColor: "",
      PaneColor: "#9C9C9C",
      colorPickerOpen: false, // Estado del modal del selector de color
    };
  },
  methods: {
    // Función para abrir el selector de color y bloquear interacciones con la página
    openColorPicker() {
      this.colorPickerOpen = true;
      // Bloquear la interacción con el resto de la página
      document.body.style.overflow = "hidden";
    },
    // Función para cerrar el selector de color y permitir interacciones con la página
    closeColorPicker() {
      this.colorPickerOpen = false;
      // Permitir la interacción con el resto de la página
      document.body.style.overflow = "";
      window.location.reload();
    },
    changeSidebarColor(color) {
      this.SidebarColor = color;
      this.$emit("change-sidebar-color", color);
      this.$emit("change-sidebar-text-color", this.textColor(color));
      this.closeColorPicker(); // Cerrar el selector de color después de seleccionar un color
    },
    changePaneColor(color) {
      this.PaneColor = color;
      this.$emit("change-panel-color", color);
      this.$emit("change-panel-text-color", this.textColor(color));
      this.$emit("change-tek-text-color", this.textColor(color));
      this.$emit("change-datuakIkusi-text-color", this.textColor(color));
      this.closeColorPicker(); // Cerrar el selector de color después de seleccionar un color
    },
    textColor(color) {
      let r = parseInt(color.substring(1, 3), 16);
      let g = parseInt(color.substring(3, 5), 16);
      let b = parseInt(color.substring(5, 7), 16);

      let luminosity = (0.2126 * r + 0.7152 * g + 0.0722 * b) / 255;

      return luminosity > 0.5 ? "#000" : "#fff";
    },
    defaultChanger() {
      localStorage.removeItem("anadir");
      localStorage.removeItem("main-content");
      localStorage.removeItem("sidebar");
      localStorage.removeItem("sidebar-text");
      localStorage.removeItem("tek");
      localStorage.removeItem("datuakIkusi");
      window.location.reload();
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
  border-radius: 5px;
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
@change-sidebar-text-color="changeTextColor"
