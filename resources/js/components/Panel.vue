<template>
  <div class="flex">
    <Sidebar
      :username="username"
      :isAdmin="isAdmin"
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
        @change-panel-color="changePanelColor"
      ></KoloreakAldatu>

      <div
        v-if="show_portada"
        class="flex flex-col portada items-center justify-center bg-cover bg-center"
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
            Zure web aplikazioak erraztasunez eta estiloz kudeatu.
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
import CryptoJS from "crypto-js";

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
    
    this.username = this.decryptUsername();
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
    KoloreaKargatu() {
      const userId = this.decryptUsername();
      fetch("/koloreakKargatu", {
        method: "POST",
        body: JSON.stringify({ login_id: userId }),
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
            throw new Error("Error al enviar el formulario");
          }
        })
        .then((data) => {
          const elementS = document.getElementById("sidebar");
          const elementP = document.getElementById("main-content");
          const textoSidebar = this.textColor(data.sidebar);
          elementS.style.background = data.sidebar;
          elementS.style.color = textoSidebar;
          document.getElementById("sidebaricon").style.color = textoSidebar;
          const textoPanel = this.textColor(data.panel);
          elementP.style.background = data.panel;
          elementP.style.color = textoPanel;
        })
        .catch((error) => {
          console.error("Error formulario", error);
        });
    },
    textColor(color) {
      let r = parseInt(color.substring(1, 3), 16);
      let g = parseInt(color.substring(3, 5), 16);
      let b = parseInt(color.substring(5, 7), 16);

      let luminosity = (0.2126 * r + 0.7152 * g + 0.0722 * b) / 255;

      return luminosity > 0.5 ? "#000" : "#fff";
    },
  },
};
</script>

<style scoped>
.portada {
  height: 95vh;
}
</style>
