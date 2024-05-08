<template>
  <div class="flex contenedor-a-borrar">
    <Sidebar
      :username="username"
      :isAdmin="isAdmin"
      @logout="handleLogout"
      @show-datuak-ikusi="showDatuakIkusi"
      @show-teknologiak-ikusi="showTeknologiakIkusi"
      @show_panelakGehitu_ikusi="showPanelakGehitu"
      @show_AldaketakIkusi_ikusi="showAldaketaIkusi"
      @show_ErabiltzaileakIkusi_ikusi="showErabiltzaileakIkusi"
      @show_PasahitzaAldatu_ikusi="showPasahitzaAldatuIkusi"
      @show_FavIkusi_ikusi="showFavIkusiIkusi"
      @show_Grafiko_ikusi="showGrafikoIkusi"
      @show_Iruzkin_ikusi="showIruzkinIkusi"
      @show_KoloreAldaketa_ikusi="showKoloreAldaketaIkusi"
    />

    <div id="main-content" class="flex-1 container small-container red-container">
      <DatuakIkusi v-if="show_datuak_ikusi"></DatuakIkusi>
      <TeknologiakIkusi v-if="show_teknologiak_ikusi"></TeknologiakIkusi>
      <PanelakGehitu v-if="show_panelakGehitu_ikusi"></PanelakGehitu>
      <AldaketakIkusi v-if="show_AldaketakIkusi_ikusi"></AldaketakIkusi>
      <ErabiltzaileakIkusi v-if="show_ErabiltzaileakIkusi_ikusi"></ErabiltzaileakIkusi>
      <PasahitzaAldatu v-if="show_PasahitzaAldatu_ikusi"></PasahitzaAldatu>
      <FavIkusi v-if="show_FavIkusi_ikusi"></FavIkusi>
      <GrafikoakIkusi v-if="show_Grafiko_ikusi"></GrafikoakIkusi>
      <Iruzkinak v-if="show_Iruzkin_ikusi"></Iruzkinak>
      <KoloreakAldatu
        v-if="show_KoloreAldaketa_ikusi"
        @change-sidebar-color="changeSidebarColor"
        @change-panel-color="changePanelColor"
        @change-sidebar-text-color="changeTextColor"
        @change-panel-text-color="changePaneTextColor"
        @change-tek-text-color="changeTekTextColor"
        @change-datuakIkusi-text-color="changedatuakIkusiTextColor"
      ></KoloreakAldatu>

      <div
        v-if="show_portada"
        class="h-screen flex flex-col items-center justify-center bg-cover bg-center"
        style="
          background-image: url('https://source.unsplash.com/random/?technology,computer,programming');
        "
      >
        <div class="text-center">
          <h1
            class="text-5xl font-bold text-white mb-8 animate__animated animate__fadeInDown"
          >
            Ongi etorri Kontrol Panelera!
          </h1>
          <p class="text-lg text-gray-300 mb-8 animate__animated animate__fadeInUp">
            Manage your web applications with ease and style.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from "./Sidebar.vue";
import DatuakIkusi from "./DatuakIkusi.vue";
import TeknologiakIkusi from "./TeknologiakIkusi.vue";
import PanelakGehitu from "./PanelakGehitu.vue";
import AldaketakIkusi from "./AldaketakIkusi.vue";
import ErabiltzaileakIkusi from "./ErabiltzaileakIkusi.vue";
import PasahitzaAldatu from "./PasahitzaAldatu.vue";
import FavIkusi from "./FavIkusi.vue";
import GrafikoakIkusi from "./GrafikoakIkusi.vue";
import Iruzkinak from "./Iruzkinak.vue";
import KoloreakAldatu from "./KoloreakAldatu.vue";

export default {
  components: {
    Sidebar,
    DatuakIkusi,
    TeknologiakIkusi,
    PanelakGehitu,
    AldaketakIkusi,
    ErabiltzaileakIkusi,
    PasahitzaAldatu,
    FavIkusi,
    GrafikoakIkusi,
    Iruzkinak,
    KoloreakAldatu,
  },
  data() {
    return {
      username: "",
      show_datuak_ikusi: false, // Inicialmente mostrar DatuakIkusi
      show_teknologiak_ikusi: false,
      show_panelakGehitu_ikusi: false, // Inicialmente no mostrar PanelakGehitu
      show_AldaketakIkusi_ikusi: false,
      show_ErabiltzaileakIkusi_ikusi: false,
      show_PasahitzaAldatu_ikusi: false,
      show_FavIkusi_ikusi: false,
      show_Grafiko_ikusi: false,
      show_Iruzkin_ikusi: false,
      isAdmin: false,
      show_KoloreAldaketa_ikusi: false,
      show_portada: true,
    };
  },
  mounted() {
    // Recuperar el nombre de usuario del localStorage al cargar el componente
    this.username = localStorage.getItem("username");
    this.checkAdminStatus();
    this.KoloreaKargatu();
  },
  methods: {
    showDatuakIkusi() {
      this.show_datuak_ikusi = true;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showTeknologiakIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = true;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showPanelakGehitu() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = true;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showAldaketaIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = true;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showErabiltzaileakIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = true;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showPasahitzaAldatuIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = true;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showFavIkusiIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = true;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showGrafikoIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = true;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showIruzkinIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = true;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
    },
    showKoloreAldaketaIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = true;
      this.show_portada = false;
    },
    checkAdminStatus() {
      // Hacer una llamada al backend para verificar si el usuario es administrador
      fetch("/check-admin-status", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data && data.isAdmin) {
            console.log("El usuario es administrador.");
            this.isAdmin = true;
          } else {
            console.log("El usuario no es administrador.");
            this.isAdmin = false;
          }
        })
        .catch((error) => {
          console.error("Error al verificar el estado de administrador:", error);
        });
    },
    handleLogout() {
      // Método para el logout
    },
    changeSidebarColor(color) {
      localStorage.setItem("sidebar", color);
    },
    changePanelColor(color) {
      localStorage.setItem("main-content", color);
    },
    changeTextColor(color) {
      localStorage.setItem("sidebar-text", color);
    },
    changePaneTextColor(color) {
      localStorage.setItem("anadir", color);
    },
    changeTekTextColor(color) {
      localStorage.setItem("tek", color);
    },
    changedatuakIkusiTextColor(color) {
      localStorage.setItem("datuakIkusi", color);
    },
    KoloreaKargatu() {
      const koloreak = localStorage.getItem("main-content");
      const element = document.getElementById("main-content");
      if (koloreak) {
        element.style.background = koloreak;
      }
    },
  },
};
</script>

<style scoped>
/* Estilos */
.min-w-sidebar {
  min-width: 300px;
}
.small-container {
  margin-left: 300px; /* Ancho del sidebar */
}

@media (max-width: 768px) {
  .small-container {
    margin-left: auto;
  }
}
</style>
