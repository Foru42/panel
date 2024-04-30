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
    Iruzkinak
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
    };
  },
  mounted() {
    // Recuperar el nombre de usuario del localStorage al cargar el componente
    this.username = localStorage.getItem('username');
    this.checkAdminStatus(); // Verificar si el usuario es administrador al cargar el componente
  },
  methods: {
    showDatuakIkusi() {
      this.show_datuak_ikusi = true;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
      this.show_Grafiko_ikusi= false;
      this.show_Iruzkin_ikusi= false;
    },
    showTeknologiakIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = true;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
      this.show_Grafiko_ikusi= false;
      this.show_Iruzkin_ikusi= false;
    },
    showPanelakGehitu() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = true;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
      this.show_Grafiko_ikusi= false;
      this.show_Iruzkin_ikusi= false;
    },
    showAldaketaIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = true;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
      this.show_Grafiko_ikusi= false;
      this.show_Iruzkin_ikusi= false;
    },
    showErabiltzaileakIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = true;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
      this.show_Grafiko_ikusi= false;
      this.show_Iruzkin_ikusi= false;
    },
    showPasahitzaAldatuIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = true;
      this.show_FavIkusi_ikusi= false;
      this.show_Grafiko_ikusi= false;
      this.show_Iruzkin_ikusi= false;
    },
    showFavIkusiIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= true;
      this.show_Grafiko_ikusi= false;
      this.show_Iruzkin_ikusi= false;
    },
    showGrafikoIkusi(){
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
      this.show_Grafiko_ikusi= true;
      this.show_Iruzkin_ikusi= false;
    }, 
    showIruzkinIkusi(){
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
      this.show_Grafiko_ikusi= false;
      this.show_Iruzkin_ikusi= true;
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
