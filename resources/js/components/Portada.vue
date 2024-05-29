<template>
  <div class="carousel-container">
    <div  class="carousel relative">
      <img 
        v-if="cards.length > 0"
        v-lazy="currentCard"
        :key="currentCardIndex"
        :src="currentCard"
        alt="carousel image"
        class="carousel-image"
      />
    </div>
    <div class="controls flex justify-center mt-4">
      <button @click="prevCard" class="text-3xl mr-4">&lt;</button>
      <button @click="nextCard" class="text-3xl">&gt;</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cards: [],
      currentCardIndex: 0,
    };
  },
  computed: {
    currentCard() {
      // Verifica si cards tiene elementos antes de evaluar currentCard
      if (this.cards.length > 0) {
        return `/img/${this.cards[this.currentCardIndex]}`;
      } else {
        return '';
      }
    },
  },
  mounted() {
    this.loadImages();
  },
  methods: {
    loadImages() {
      try {
        // Importa dinámicamente las imágenes en la carpeta public/img
        const images = import.meta.glob("/public/img/*.{png,jpg,jpeg}");
        // Obtiene las rutas de las imágenes y las agrega al array cards
        for (const path in images) {
          if (images.hasOwnProperty(path)) {
            const imageName = path.substring(path.lastIndexOf("/") + 1);
            // Filtra las imágenes que no contienen "_profila" en su nombre
            if (!imageName.includes("_profila")) {
              this.cards.push(imageName);
            }
          }
        }
      } catch (error) {
        console.error("Error loading images:", error);
      }
    },

    prevCard() {
      this.currentCardIndex =
        (this.currentCardIndex - 1 + this.cards.length) % this.cards.length;
    },
    nextCard() {
      this.currentCardIndex = (this.currentCardIndex + 1) % this.cards.length;
    },
  },
};
</script>

<style scoped>
button {
  background: none;
  border: none;
  cursor: pointer;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.carousel {
  position: relative;
  width: 100%; /* Ajusta el ancho al 100% */
  height: 400px; /* Tamaño fijo para el contenedor del carrusel */
  display: flex; /* Utiliza flexbox */
  justify-content: center; /* Centra horizontalmente */
  align-items: center; /* Centra verticalmente */
}
.carousel-image {
  max-width: 100%; /* Asegura que la imagen no sea más grande que su contenedor */
  max-height: 100%; /* Asegura que la imagen no sea más grande que su contenedor */
  object-fit: cover; /* Ajusta la imagen para que cubra todo el contenedor sin distorsión */
}
</style>
