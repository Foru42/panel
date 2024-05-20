<template>
  <div class="flex flex-col min-h-screen">
    <div class="flex flex-1">
      <div>
        <Sidebar
          class="h-full"
          :username="username"
          :isAdmin="isAdmin"
          @show-datuak-ikusi="showDatuakIkusi"
          @show-teknologiak-ikusi="showTeknologiakIkusi"
          @show_panelakGehitu_ikusi="showPanelakGehitu"
          @show_AldaketakIkusi_ikusi="showAldaketaIkusi"
          @show_FavIkusi_ikusi="showFavIkusiIkusi"
          @show_Grafiko_ikusi="showGrafikoIkusi"
          @show_Iruzkin_ikusi="showIruzkinIkusi"
          @show_KoloreAldaketa_ikusi="showKoloreAldaketaIkusi"
          @show_SuperUser_ikusi="showSuserIkusi"
        />
      </div>
      <div id="main-content" class="flex-1 p-4 flex justify-center items-center">
        <!-- Nuevo contenedor interior -->
        <div id="content-container" class="content-container">
          <!-- Contenido de las diferentes vistas -->
          <DatuakIkusi v-if="show_datuak_ikusi" :isAdmin="isAdmin"></DatuakIkusi>
          <TeknologiakIkusi v-if="show_teknologiak_ikusi"></TeknologiakIkusi>
          <PanelakGehitu v-if="show_panelakGehitu_ikusi"></PanelakGehitu>
          <AldaketakIkusi v-if="show_AldaketakIkusi_ikusi"></AldaketakIkusi>
          <FavIkusi v-if="show_FavIkusi_ikusi"></FavIkusi>
          <GrafikoakIkusi v-if="show_Grafiko_ikusi"></GrafikoakIkusi>
          <Iruzkinak v-if="show_Iruzkin_ikusi" :isAdmin="isAdmin"></Iruzkinak>
          <LoginPanela v-if="show_KoloreAldaketa_ikusi"></LoginPanela>
          <Portada v-if="show_portada"></Portada>
          <SuperUser v-if="show_SuperUser_ikusi" :IdUsu="IdUsu"></SuperUser>
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
import PasahitzaAldatu from "./PasahitzaAldatu.vue";
import FavIkusi from "./FavIkusi.vue";
import GrafikoakIkusi from "./GrafikoakIkusi.vue";
import Iruzkinak from "./Iruzkinak.vue";
import LoginPanela from "./LoginPanela.vue";
import Portada from "./Portada.vue";
import SuperUser from "./SuperUser.vue";
import CryptoJS from "crypto-js";
import tinycolor from "tinycolor2";

export default {
  components: {
    Sidebar,
    DatuakIkusi,
    TeknologiakIkusi,
    PanelakGehitu,
    AldaketakIkusi,
    PasahitzaAldatu,
    FavIkusi,
    GrafikoakIkusi,
    Iruzkinak,
    Portada,
    SuperUser,
    LoginPanela,
  },
  data() {
    return {
      username: "",
      IdUsu: "",
      show_datuak_ikusi: false, // Inicialmente mostrar DatuakIkusi
      show_teknologiak_ikusi: false,
      show_panelakGehitu_ikusi: false, // Inicialmente no mostrar PanelakGehitu
      show_AldaketakIkusi_ikusi: false,
      show_FavIkusi_ikusi: false,
      show_Grafiko_ikusi: false,
      show_Iruzkin_ikusi: false,
      isAdmin: false,
      show_KoloreAldaketa_ikusi: false,
      show_portada: true,
      show_SuperUser_ikusi: false,
    };
  },
  mounted() {
    this.username = this.decryptUsername();
    console.log("Usuario actual:", this.decryptUsername());
    this.checkAdminStatus();
    this.KoloreaKargatu();
  },
  methods: {
    showDatuakIkusi() {
      this.show_datuak_ikusi = true;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },
    showTeknologiakIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = true;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },
    showPanelakGehitu() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = true;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },
    showAldaketaIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = true;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },
    showErabiltzaileakIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },

    showFavIkusiIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = true;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },
    showGrafikoIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = true;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },
    showIruzkinIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = true;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },
    showKoloreAldaketaIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = true;
      this.show_portada = false;
      this.show_SuperUser_ikusi = false;
    },
    showSuserIkusi() {
      this.show_datuak_ikusi = false;
      this.show_teknologiak_ikusi = false;
      this.show_panelakGehitu_ikusi = false;
      this.show_AldaketakIkusi_ikusi = false;
      this.show_FavIkusi_ikusi = false;
      this.show_Grafiko_ikusi = false;
      this.show_Iruzkin_ikusi = false;
      this.show_KoloreAldaketa_ikusi = false;
      this.show_portada = false;
      this.show_SuperUser_ikusi = true;
    },
    decryptUsername() {
      const secretKey = "LaClaveDelDiosEspacioal1.·¬"; // La misma clave secreta que se utilizó para encriptar
      const encryptedUsername = localStorage.getItem("encryptedUsername");
      if (encryptedUsername) {
        const bytes = CryptoJS.AES.decrypt(encryptedUsername, secretKey);
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
          this.isAdmin = data.isAdmin; // Asigna el valor basado en la respuesta del backend
          console.log(this.isAdmin);
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

          const colorReducido = tinycolor(data.panel).lighten(10).toString();
          document.getElementById("content-container").style.background = colorReducido;
          this.IdUsu = data.login_id;
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
.content-container {
  max-width: auto; /* Ancho máximo del contenedor */
  padding: 20px; /* Espacio interno */
  border: 1px solid #ccc; /* Borde */
  border-radius: 8px; /* Bordes redondeados */

}
</style>
