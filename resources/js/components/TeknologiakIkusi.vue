<template>
  <div class="padd" >
    <h1 id="Topatek">Luzapenen topaketa</h1>
    <input
     class="text-black"
      type="text"
      v-model="searchTerm"
      @keyup.enter="realizarBusqueda"
      placeholder="Extensioak topatu..."
    />
    <div
      class="card mb-4 shadow-lg rounded-lg overflow-hidden"
      v-for="resultado in resultados"
      :key="resultado.izena"
    >
      <div class="card-body text-black">
        <h5 class="card-title">{{ resultado.izena }}</h5>
        <p class="card-text"><strong>Panelak:</strong></p>
        <ul>
          <li v-for="panel in resultado.paneles" :key="panel.izena">{{ panel.izena }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchTerm: "",
      resultados: [],
    };
  },
  mounted() {
  },
  methods: {
    realizarBusqueda(event) {
      if (event.key === "Enter") {
        this.buscarExtensiones();
      }
    },
    buscarExtensiones() {
      fetch(`/buscar-extensiones?searchTerm=${this.searchTerm}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json();
        })
        .then((data) => {
          this.resultados = data;
        })
        .catch((error) => {
          console.error("Error al buscar extensiones:", error);
        });
    },

  },
};
</script>

<style scoped>
/* Estilos específicos del componente */
</style>
