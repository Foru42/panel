<template>
  <div class="flex justify-center flex-wrap">
    <div v-for="technology in technologies" :key="technology" class="m-4">
      <canvas :id="'myChart-' + technology" style="max-width: 300px;"></canvas>
    </div>
  </div>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
  data() {
    return {
      technologies: [],
      barColors: [
        "#FF5733", 
        "#33CC57", 
        "#3380FF", 
        "#FF3380",
        "#80FF33",
        "#8033FF", 
        "#FF8033", 
        "#FFD700",
        "#00FFFF",
        "#8A2BE2",
        "#FF1493", 
        "#7FFF00",
        "#00CED1", 
        "#FF00FF" 
      ]
    };
  },
  mounted() {
    this.loadTechnologies();
  },
  methods: {
    loadTechnologies() {
      fetch("/technologies", { // Cambia "/technologies" a la ruta correcta para obtener los nombres de las tecnologías
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
      })
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error("Error fetching technologies");
        }
      })
      .then((data) => {
        const technologyNames = data.map(item => item.izena);
  this.technologies = technologyNames;
        this.allDatos(); 
      })
      .catch((error) => {
        console.error("Error fetching technologies", error);
      });
    },
    allDatos() {
      fetch("/data", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
      })
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error("Error fetching data");
        }
      })
      .then((data) => {
        const chartData = this.technologies.map((technology) => {
          return {
            technology,
            data: data.reduce((acc, item) => {
              const panelIzena = item.panel.izena;
              const teknologiaIzena = item.teknologia.izena;

              const isTechnology = teknologiaIzena.includes(technology);
              acc[panelIzena] = (acc[panelIzena] || 0) + (isTechnology ? 1 : 0);
              return acc;
            }, {})
          };
        });

        chartData.forEach((technologyData) => {
          const xValues = Object.keys(technologyData.data);
          const yValues = Object.values(technologyData.data);

          const ctx = document.getElementById("myChart-" + technologyData.technology);
          if (ctx) {
            new Chart(ctx, {
              type: "pie",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: this.barColors,
                  data: yValues
                }]
              },
              options: {
                plugins: {
                  title: {
                    display: true,
                    text: technologyData.technology + " Teknologiak Panel bakoitzean"
                  }
                }
              }
            });
          } else {
            console.error("Canvas element not found for", technologyData.technology);
          }
        });
      })
      .catch((error) => {
        console.error("Error fetching data", error);
      });
    },
  },
};
</script>

<style scoped>
/* Your styles here */
</style>
