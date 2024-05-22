<template>
  <div id="aldaketak" class="container mx-auto px-4 py-8">
    <div v-if="data.length === 0" class="text-red-500 text-center mb-4">
      Aukeratu gustuko panel bat
    </div>
    <div
      v-else
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6"
    >
      <div
        v-for="item in data"
        :key="item.id"
        class="card shadow-lg rounded-lg overflow-hidden"
      >
        <img
          :src="item.panel.irudi"
          class="w-full h-48 object-cover"
          :alt="item.panel.izena"
        />
        <div class="p-6">
          <div class="font-bold text-xl mb-2">{{ item.panel.izena }}</div>
          <p class="text-gray-700 text-base mb-2">{{ item.name }}</p>
          <p class="text-gray-700 text-base mb-2">{{ item.panel.desk }}</p>
          <p class="text-gray-700 text-base mb-2">
            {{ item.teknologia.izena }} - {{ item.teknologia.desk }}
          </p>
          <p class="text-gray-700 text-base mb-2">{{ item.bertsioa.izena }}</p>
          <p class="text-gray-700 text-base mb-2">
            {{ item.panel.sistema_operativo.izena }} -
            {{ item.panel.sistema_operativo.desk }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      data: [],
    };
  },
  mounted() {
    this.obtenerUltimasModificaciones();
  },
  methods: {
    obtenerUltimasModificaciones() {
      const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

      // Configurar las opciones de la solicitud fetch
      const requestOptions = {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken, // Incluir el token CSRF en la cabecera
        },
      };

      // Realizar la solicitud fetch
      fetch("/ultimas-modificaciones-panel-tek", requestOptions)
        .then((response) => {
          if (response.ok) {
            // Si la solicitud fue exitosa, parsear la respuesta como JSON
            return response.json();
          } else {
            // Si hubo un error, lanzar un error con el mensaje de respuesta
            throw new Error("Error al obtener los datos: " + response.statusText);
          }
        })
        .then((data) => {
          // Si se obtuvieron los datos correctamente, asignarlos a la variable data
          this.data = data;
          //console.log(data)
        })
        .catch((error) => {
          // Capturar cualquier error y mostrar un mensaje de error
          console.error("Error al obtener los datos:", error.message);
        });
    },
  },
};
</script>

<style scoped>
.car {
  min-height: 100%; /* Puedes ajustar este valor según tus necesidades */
}
</style>
