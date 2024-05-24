<template>
  <div>
    <!-- Botón para abrir/cerrar el sidebar -->
    <button id="sidebaricon" @click="toggleSidebar" class="open-sidebar-icon">☰</button>

    <!-- Contenido del sidebar -->
    <div id="sidebar" :class="{ 'sidebar-hidden': !showSidebar }">
      <div class="sidebar-brand py-4 px-6">
        Kontrol Panela<br />
        <span class="block">Aupa {{ username }}</span>
      </div>

      <div class="sidebar-menu transition duration-300">
        <a
          href="#"
          id="panel1"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showDatuakIkusi"
          >Datuak ikusi</a
        >
        <a
          href="#"
          id="panel2"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showTeknologiakIkusi"
          >Teknologiak ikusi</a
        >
        <a
          href="#"
          id="panel3"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showPanelakGehitu"
          >Panelak gehitu</a
        >

        <a
          href="#"
          id="panel6"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showAldaketaIkusi"
          >Aldaketak ikusi</a
        >
        <a
          href="#"
          id="panel7"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showFavIkusiIkusi"
          >Gustuko Panela</a
        >
        <a
          href="#"
          id="panel8"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showGrafikoIkusi"
          >Grafikoak Ikusi</a
        >
        <a
          href="#"
          id="panel9"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showIruzkinIkusi"
          >Iruzkinak Ikusi/Egin</a
        >
        <a
          href="#"
          id="panel10"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showKoloreAldaketaIkusi"
          >Profila</a
        >
        <a
          v-if="isAdmin"
          href="#"
          id="panel11"
          class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block"
          @click.prevent="showSuperUserIkusi"
          >Super Erabiltzailea</a
        >
        <div class="logout-container">
          <button
            @click="logout"
            class="w-full rounded-full px-6 py-2 bg-red-400 text-white hover:bg-red-500 transition duration-300 mt-6"
          >
            Logout
          </button>
 
        </div>



        <div v-if="UsuComent" class="notification">
      <i class="fas fa-comment notification-icon"></i> <!-- Icono de comentario -->
      <div class="notification-message">
        {{ notification.username }} Iruzkina gehitu du: "{{ notification.comment.title }}"
      </div>
      <button @click="marcarLeido" class="mark-read-button">
        <i class="fas fa-check"></i> <!-- Icono de tick -->
      </button>
    </div>

      </div>
    </div>
  </div>
</template>
<script>
// Importa el componente PanelSelect desde su ruta
import DatuakIkusi from "./DatuakIkusi.vue";
import CryptoJS from "crypto-js";
export default {
  props: ["username", "isAdmin"],
  components: {
    DatuakIkusi,
  },

  data() {
    return {
      show_datuak_ikusi: false,
      groupedInfo: [],
      showSidebar: true,
      notification: null,
      UsuComent: false,
    };
  },
  mounted() {
    const pusher = new Pusher("67eeb3212bd414c8db30", {
        cluster: "eu",
        encrypted: true,
    });

    const channel = pusher.subscribe("public-channel");
   // console.log(channel);

    channel.bind("App\\Events\\CommentAdded", (data) => {
        //console.log(data);
        // Aquí puedes hacer lo que quieras con los datos recibidos, por ejemplo:
        this.notification=data; 
        if(this.notification.username == this.decryptUsername()){
         this.UsuComent=false;
        }else{
          this.UsuComent=true;
        }
        //alert(`Nuevo comentario: ${data.comment.title}`);
    });


  },
  methods: {
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
    marcarLeido(){
      this.UsuComent=false;
    },
    toggleSidebar() {
      // Cambia el valor de showSidebar para mostrar u ocultar el sidebar
      this.showSidebar = !this.showSidebar;

      if (this.showSidebar) {
        document.getElementById("sidebaricon").style.color = "white";
      } else {
        document.getElementById("sidebaricon").style.color = "black";
      }
    },
    logout() {
      fetch("/logout", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      })
        .then((response) => {
          if (response.ok) {
            console.log("Has cerrado sesion correctamente");
            localStorage.removeItem("encryptedUsername");
            localStorage.removeItem("koloreP");
            localStorage.removeItem("koloreS");
            // Redirige al usuario a la página de inicio de sesión
            window.location.href = "/login";
          } else {
            console.error("Error al cerrar sesión");
          }
        })
        .catch((error) => {
          console.error("Error al cerrar sesión:", error);
        });
    },
    showDatuakIkusi() {
      this.$emit("show-datuak-ikusi");
    },
    showTeknologiakIkusi() {
      this.$emit("show-teknologiak-ikusi");
    },
    showPanelakGehitu() {
      this.$emit("show_panelakGehitu_ikusi");
    },
    showAldaketaIkusi() {
      this.$emit("show_AldaketakIkusi_ikusi");
    },
    showFavIkusiIkusi() {
      this.$emit("show_FavIkusi_ikusi");
    },
    showGrafikoIkusi() {
      this.$emit("show_Grafiko_ikusi");
    },
    showIruzkinIkusi() {
      this.$emit("show_Iruzkin_ikusi");
    },
    showKoloreAldaketaIkusi() {
      this.$emit("show_KoloreAldaketa_ikusi");
    },
    showSuperUserIkusi() {
      this.$emit("show_SuperUser_ikusi");
    },
  },
};
</script>

<style scoped>
.sidebar-hidden {
  width: 0 !important;
  max-width: none !important; /* Elimina el máximo ancho */
}
.open-sidebar-icon {
  position: fixed;
  top: 20px;
  left: 20px;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 24px; /* Tamaño del icono */
}
.notification {
  background-color: #6ce976; /* Color de fondo */
  padding: 10px; /* Espaciado interno */
  border-radius: 5px; /* Bordes redondeados */
  margin-top: 10px; /* Espaciado superior */
  display: flex; /* Para alinear elementos */
  align-items: center; /* Para alinear verticalmente */
}

.notification-icon {
  margin-right: 10px; /* Espacio a la derecha del icono */
}

.notification-message {
  font-weight: bold; /* Texto en negrita */
}
</style>
