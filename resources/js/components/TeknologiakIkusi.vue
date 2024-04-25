<template>
  <div>
    <h1>Búsqueda de Extensiones</h1>
    <input
      type="text"
      v-model="searchTerm"
      @input="buscarExtensiones"
      placeholder="Buscar extensiones..."
    />
    <div id="resultados"></div>
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
  methods: {
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
          this.mostrarResultados(data);
        })
        .catch((error) => {
          console.error("Error al buscar extensiones:", error);
        });
    },
    mostrarResultados(resultados) {
      var contenidoHTML = "";
      resultados.forEach(function (resultado) {
        contenidoHTML += `
            <div class="card mb-4 shadow-lg rounded-lg overflow-hidden">
              <div class="card-body">
                <h5 class="card-title">${resultado.izena}</h5>
                <p class="card-text"><strong>Panelak:</strong></p>
                <ul>
                  ${resultado.paneles.map((panel) => `<li>${panel.izena}</li>`).join("")}
                </ul>
              </div>
            </div>
          `;
      });
      document.getElementById("resultados").innerHTML = contenidoHTML;
    },
  },
};
</script>

<style scoped>
/* Estilos específicos del componente */
</style>
