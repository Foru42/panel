<template>
  <div id="anadir">
    <!-- Formulario -->
    <div id="grouped_info" :data-info="groupedInfo"></div>
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <div class="form-group">
        <label for="izenapane">Izena Panela:</label>
        <input
          v-model="izenapane"
          type="text"
          name="izenapane"
          id="izenapane"
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
          required
        />
      </div>

      <div class="form-group">
        <label for="desk">Deskripzioa Panela:</label>
        <textarea
          v-model="desk"
          name="desk"
          id="desk"
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
          required
        ></textarea>
      </div>

      <div class="form-group">
        <label for="irudi">Irudia:</label>
        <input
          type="file"
          ref="irudi"
          name="irudi"
          id="irudi"
          accept="image/*"
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
          required
        />
      </div>

      <div class="form-group">
        <label for="izenatek">Izena Teknologia:</label>
        <input
          v-model="izenatek"
          type="text"
          name="izenatek"
          id="izenatek"
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
          required
        />
      </div>

      <div class="form-group">
        <label for="desktek">Deskripzioa Teknologia:</label>
        <textarea
          v-model="desktek"
          name="desktek"
          id="desktek"
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
          required
        ></textarea>
      </div>

      <div class="form-group">
        <label for="vertek">Teknologia Bertsioa:</label>
        <textarea
          v-model="vertek"
          name="vertek"
          id="vertek"
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
          required
        ></textarea>
      </div>

      <div class="form-group">
        <label for="So_id">Sistema operatiboa:</label>
        <select
          v-model="So_id"
          name="So_id"
          id="So_id"
          class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
          required
        >
          <option
            v-for="sisOperativo in sisOperativos"
            :key="sisOperativo.id"
            :value="sisOperativo.id"
          >
            {{ sisOperativo.izena }}
          </option>
        </select>
      </div>

      <button
        type="submit"
        class="w-full px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 transition duration-300 rounded-full"
      >
        Gorde
      </button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      groupedInfo: null,
      izenapane: "",
      desk: "",
      izenatek: "",
      desktek: "",
      vertek: "",
      So_id: null,
      sisOperativos: [],
    };
  },
  mounted() {
    this.cargarSistemasOperativos();
  },
  methods: {
    submitForm() {
      const formData = new FormData();
      formData.append("izenapane", this.izenapane);
      formData.append("desk", this.desk);
      formData.append("izenatek", this.izenatek);
      formData.append("desktek", this.desktek);
      formData.append("vertek", this.vertek);
      formData.append("So_id", this.So_id);
      formData.append("irudi", this.$refs.irudi.files[0]); // Añade el archivo de imagen

      fetch("/panelakGehi", {
        method: "POST",
        body: formData,
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
          //console.log(data);
          window.location.href = "/panel";
        })
        .catch((error) => {
          console.error("Error formulario", error);
        });
    },

    cargarSistemasOperativos() {
      // Realizar la petición para obtener los sistemas operativos
      fetch("/obtener-sistemas-operativos", {
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
            return response.json(); // Asumiendo que la respuesta es un JSON
          } else {
            throw new Error("Error al obtener los sistemas operativos");
          }
        })
        .then((data) => {
          // Asignar los sistemas operativos obtenidos a la variable sisOperativos
          this.sisOperativos = data;
        })
        .catch((error) => {
          console.error("Error al obtener los sistemas operativos", error);
        });
    },
  },
};
</script>

<style scoped>
/* Estilos */
</style>
