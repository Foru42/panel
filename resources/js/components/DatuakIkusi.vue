<template>
  <div class="">
    <div v-if="groupedInfo && groupedInfo.length">
      <select v-model="selectedPanel" class="text-black">
        <option disabled value="">Aukeratu panel bat</option>
        <option v-for="panel in uniquePanels" :value="panel">{{ panel }}</option>
      </select>
    </div>
    <div v-else>
      <p>Ez dago daturik</p>
    </div>
    <div id="paginador" class="pagination flex justify-center items-center mt-8">
      <button
        @click="previousPage"
        :disabled="!canGoPrevious"
        class="pagination-btn mr-2"
      >
        <i class="fas fa-angle-double-left"></i>
      </button>
      <span class="pagination-info"
        >{{ currentPage }} <i class="fas fa-ellipsis-h"></i> {{ totalPages }}</span
      >
      <button @click="nextPage" :disabled="!canGoNext" class="pagination-btn ml-2">
        <i class="fas fa-angle-double-right"></i>
      </button>
    </div>
    <br />
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="(info, index) in paginatedInfo"
        class="card mb-4 shadow-lg rounded-lg overflow-hidden w-full"
      >
        <div class="flex justify-between items-center mb-2" v-if="this.isAdmin">
          <button
            class="btn-eliminar flex items-center justify-center bg-red-500 text-white font-bold rounded-full h-8 w-8"
            @click="eliminarPanel(info.id)"
          >
            <i class="fas fa-trash"></i>
          </button>
          <!-- Botón de editar -->
          <button
            class="btn-editar flex items-center justify-center bg-blue-500 text-white font-bold rounded-full h-8 w-8"
            @click="toggleEditMode(info)"
          >
            <i class="fas fa-pencil-alt"></i>
          </button>
          <!-- Botón de sumar -->
          <button
            class="btn-sumar flex items-center justify-center bg-blue-600 text-white font-bold rounded-full h-8 w-8 mr-2"
            @click="sumarPanel(info.id)"
          >
            <i class="fas fa-plus"></i>
          </button>
        </div>
        <img :src="info.panel.irudi" class="card-img-top" :alt="info.panel.izena" />
        <div class="card-body" :id="info.id">
          <p class="card-text panel-izena font-bold">{{ info.panel.izena }}</p>
          <p v-if="!info.editing" class="card-text panel-desk">{{ info.panel.desk }}</p>
          <input v-else class="card-text panel-desk-input" v-model="info.panel.desk" />
          <p v-if="!info.editing" class="card-text teknologia">
            {{ info.teknologia.izena }} - {{ info.teknologia.desk }}
          </p>
          <div v-else>
            <input class="card-text teknologia-izena" v-model="info.teknologia.izena" />
            <input class="card-text teknologia-desk" v-model="info.teknologia.desk" />
          </div>
          <p v-if="!info.editing" class="card-text bertsioa">{{ info.bertsioa.izena }}</p>
          <input v-else class="card-text bertsioa-izena" v-model="info.bertsioa.izena" />
          <p v-if="!info.editing" class="card-text sistema-operativo">
            {{ info.panel.sistema_operativo.izena }} -
            {{ info.panel.sistema_operativo.desk }}
          </p>
          <select
            v-if="info.editing"
            v-model="info.selectedSO"
            class="card-text sistema-operativo-select"
          >
            <option v-for="so in sistemasOperativos" :value="so.id">
              {{ so.izena }}
            </option>
          </select>
        </div>

        <button
          :id="'guardar_' + info.id"
          class="btn-guardar bg-green-500 text-white font-bold rounded-full h-8 w-full mt-2"
          @click="guardarCambios(info.id, info.selectedSO)"
          v-show="info.editing"
        >
          Gorde
        </button>
        <!-- Estrella -->
        <!-- Dentro del bucle v-for donde renderizas cada tarjeta -->
        <button
          v-if="!info.editing"
          class="star-icon absolute bottom-2 right-2"
          @click="toggleStar(info, info.id)"
        >
          <i
            :class="{
              'fas fa-star text-yellow-500': info.usuarios_que_lo_favoritan.length > 0,
              'far fa-star text-gray-400': info.usuarios_que_lo_favoritan.length === 0,
            }"
          ></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { debounce } from "lodash";
import CryptoJS from "crypto-js";

export default {
  props: ["isAdmin"],
  data() {
    return {
      groupedInfo: [],
      sistemasOperativos: [],
      selectedPanel: "",
      currentPage: 1,
      pageSize: 3,
    };
  },
  computed: {
    uniquePanels() {
      return Array.from(new Set(this.groupedInfo.map((info) => info.panel.izena)));
    },
    filteredInfo() {
      if (!this.selectedPanel) return this.groupedInfo;
      return this.groupedInfo.filter((info) => info.panel.izena === this.selectedPanel);
    },
    totalPages() {
      if (!this.selectedPanel) {
        return Math.ceil(this.filteredInfo.length / this.pageSize) + " ";
      } else {
        // Si hay un panel seleccionado, no hay paginación, así que solo hay una página
        return 1;
      }
    },
    paginatedInfo() {
      if (!this.selectedPanel) {
        const startIndex = (this.currentPage - 1) * this.pageSize;
        const endIndex = startIndex + this.pageSize;
        return this.filteredInfo.slice(startIndex, endIndex);
      } else {
        return this.filteredInfo;
      }
    },
  },
  mounted() {
    this.allDatos();
    this.obtenerSistemasOperativos();
  },
  methods: {
    allDatos() {
      fetch("/data", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      })
        .then((response) => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Error al recoger datos");
          }
        })
        .then((data) => {
          this.groupedInfo = data.map((info) => ({
            ...info,
            editing: false,
          }));
        })
        .catch((error) => {
          console.error("Error al recoger datos", error);
        });
    },
    eliminarPanel(panelId) {
      var confirmacion = confirm("¿Seguru Panela borratu nahi duzula?");
      if (confirmacion) {
        // Obtener el token CSRF de la meta etiqueta
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        // Realizar la petición AJAX con el token CSRF incluido en la cabecera
        fetch("/eliminar-panel", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
          body: JSON.stringify({ panelTekId: panelId }),
        })
          .then((response) => {
            if (response.ok) {
              window.location.reload();
            } else {
              // Si hubo un error, mostrar un mensaje de error
              console.error("Error al eliminar el panel:", response.statusText);
            }
          })
          .catch((error) => {
            console.error("Error al eliminar el panel:", error);
          });
      }
    },
    toggleEditMode(info) {
      if (info.editing) {
        info.editing = false;
      } else {
        const editingCards = this.groupedInfo.filter((item) => item.editing);
        // Si hay tarjetas en modo de edición, mostrar alerta y salir
        if (editingCards.length > 0) {
          alert("Ezin dituzu bi tarjeta batera editatu.");
          return;
        }
        // Establecer el valor seleccionado en el valor actual del sistema operativo
        info.selectedSO = info.panel.sistema_operativo.id;
        // Si no hay tarjetas en modo de edición, cambiar el estado de la tarjeta seleccionada
        info.editing = true;
      }
    },

    guardarCambios(panelId, soID) {
      const panelIndex = this.groupedInfo.findIndex((info) => info.id === panelId);
      if (panelIndex !== -1) {
        const panel = this.groupedInfo[panelIndex];
        panel.editing = false;

        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        // Realizar la petición fetch para actualizar el panel en el servidor
        fetch("/actualizar-panel", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
          body: JSON.stringify({ panelId: panelId, soId: soID, nuevosValores: panel ,userID: this.decryptUsername()}),
        })
          .then((response) => {
            if (response.ok) {
              // Si la actualización fue exitosa, recargar la página
              window.location.reload();
            } else {
              // Si hubo un error, puedes mostrar un mensaje de error o realizar otras acciones necesarias
              console.error("Error al actualizar el panel:", response.statusText);
            }
          })
          .catch((error) => {
            console.error("Error al actualizar el panel:", error);
          });
      }
    },

    obtenerSistemasOperativos() {
      fetch("/obtener-sistemas-operativos")
        .then((response) => response.json())
        .then((data) => {
          this.sistemasOperativos = data;
        })
        .catch((error) => {
          console.error("Error al obtener los sistemas operativos:", error);
        });
    },
    sumarPanel(id) {
      console.log(id);
      var tarjeta = document.getElementById(id);

      var ize = tarjeta.querySelector(".panel-izena").textContent;
      var Tek = tarjeta.querySelector(".teknologia").textContent;
      var Ber = tarjeta.querySelector(".bertsioa").textContent;

      var cantidad = prompt("Mesedez jarri zenbat panel nahi dituzun gehitu.");
      // Verificar si el usuario canceló el prompt
      if (cantidad === null) {
        return; // No hacer nada si se cancela el prompt
      }
      if (cantidad < 11) {
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        fetch("/anadir-panel", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
          body: JSON.stringify({
            izenapanela: ize,
            teknologiaIzena: Tek,
            teknologiaBertsioa: Ber,
            cantidad: cantidad,
            userID: this.decryptUsername()
          }),
        })
          .then((response) => {
            if (response.ok) {
              window.location.reload(); // Recargar la página para mostrar los cambios
            } else {
              // Si hubo un error, mostrar un mensaje de error
              console.error("Error al añadir panel:", response.statusText);
            }
          })
          .catch((error) => {
            console.error("Error al añadir panel:", error);
          });
      } else {
        alert("Mesedez 11 baino txikiago");
      }
    },
    toggleStar: debounce(function (info, id) {
      fetch(`/anadir-fav`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify({ id: id, userID: this.decryptUsername() }), // Enviar el nuevo estado de fav al servidor
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error al guardar el estado de la estrella");
          }
          this.allDatos();
        })
        .catch((error) => {
          console.error("Error al guardar el estado de la estrella:", error);
          // Vuelve al estado anterior si hubo un error
        });
    }, 300),

    decryptUsername() {
      const secretKey = "LaClaveDelDiosEspacioal1.·¬"; // La misma clave secreta que se utilizó para encriptar
      const encryptedUsername = localStorage.getItem("encryptedUsername");
      if (encryptedUsername) {
        const bytes  = CryptoJS.AES.decrypt(encryptedUsername, secretKey);
        const decryptedUsername = bytes.toString(CryptoJS.enc.Utf8);
        return decryptedUsername;
      } else {
        return null; 
      }
    },
    canGoNext() {
      return this.currentPage < this.totalPages;
    },

    canGoPrevious() {
      return this.currentPage > 1;
    },
    nextPage() {
      if (this.canGoNext()) {
        this.currentPage++;
      }
    },
    previousPage() {
      if (this.canGoPrevious()) {
        this.currentPage--;
      }
    },

  },
};
</script>
<style>
.star-icon {
  z-index: 1; /* Asegura que la estrella esté sobre el contenido de la tarjeta */
}

.card {
  position: relative; /* Asegura que los elementos absolutamente posicionados dentro de la tarjeta sean relativos a ella */
}
.pagination {
  left: 20%;
}
button{
  box-shadow: 0 0 0px rgba(0, 0, 0, 0);
}
</style>
