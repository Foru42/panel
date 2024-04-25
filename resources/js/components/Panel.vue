<template>
  <div class="flex">
    <Sidebar
      :username="username"
      @logout="handleLogout"
      @show-datuak-ikusi="showDatuakIkusi"
      @show-teknologiak-ikusi="showTeknologiakIkusi"
      @show_panelakGehitu_ikusi="showPanelakGehitu"
      @show_AldaketakIkusi_ikusi="showAldaketaIkusi"
      @show_ErabiltzaileakIkusi_ikusi="showErabiltzaileakIkusi"
      @show_PasahitzaAldatu_ikusi="showPasahitzaAldatuIkusi"
      @show_FavIkusi_ikusi="showFavIkusiIkusi"
    />

    <div id="main-content" class="flex-1 container small-container red-container">
      <DatuakIkusi v-if="show_datuak_ikusi"></DatuakIkusi>
      <TeknologiakIkusi v-if="show_teknologiak_ikusi"></TeknologiakIkusi>
      <PanelakGehitu v-if="show_panelakGehitu_ikusi"></PanelakGehitu>
      <AldaketakIkusi v-if="show_AldaketakIkusi_ikusi"></AldaketakIkusi>
      <ErabiltzaileakIkusi v-if="show_ErabiltzaileakIkusi_ikusi"></ErabiltzaileakIkusi>
      <showPasahitzaAldatuIkusi v-if="show_PasahitzaAldatu_ikusi"></showPasahitzaAldatuIkusi>
      <FavIkusi v-if="show_FavIkusi_ikusi"></FavIkusi>
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
import showPasahitzaAldatuIkusi from "./PasahitzaAldatu.vue";
import FavIkusi from "./FavIkusi.vue";

export default {
  components: {
    Sidebar,
    DatuakIkusi,
    TeknologiakIkusi,
    PanelakGehitu,
    AldaketakIkusi,
    ErabiltzaileakIkusi,
    showPasahitzaAldatuIkusi,
    FavIkusi,
  },
  data() {
    return {
      username: "",
      show_datuak_ikusi: true, // Inicialmente mostrar DatuakIkusi
      show_teknologiak_ikusi: false,
      show_panelakGehitu_ikusi: false, // Inicialmente no mostrar PanelakGehitu
      show_AldaketakIkusi_ikusi: false,
      show_ErabiltzaileakIkusi_ikusi: false,
      show_PasahitzaAldatu_ikusi: false,
      show_FavIkusi_ikusi: false,
    };
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
    },
    showTeknologiakIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = true;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
    },
    showPanelakGehitu() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = true;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
    },
    showAldaketaIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = true;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
    },
    showErabiltzaileakIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = true;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= false;
    },
    showPasahitzaAldatuIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = true;
      this.show_FavIkusi_ikusi= false;
    },
    showFavIkusiIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_ErabiltzaileakIkusi_ikusi = false;
      this.show_PasahitzaAldatu_ikusi = false;
      this.show_FavIkusi_ikusi= true;
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
  max-width: calc(100vw - 300px); /* Restar el ancho del sidebar */
}
</style>
