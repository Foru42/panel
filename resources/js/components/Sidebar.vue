
<template>
  <div id="sidebar" class="bg-gray-800 text-white h-screen">
    <div class="sidebar-brand py-4 px-6">
      Kontrol Panela<br>
      <span class="block">Aupa {{ username }}</span>
    </div>
    <div class="sidebar-menu">
      <a v-if="isAdmin" href="#" id="panel1" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showDatuakIkusi">Datuak ikusi</a>
      <a  href="#" id="panel2" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showTeknologiakIkusi">Teknologiak ikusi</a>
       <a href="#" id="panel3" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showPanelakGehitu">Panelak gehitu</a>
      <a v-if="isAdmin" href="#" id="panel4" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showErabiltzaileakIkusi">Erabiltzaileak ikusi/aldatu</a>
      <a  href="#" id="panel5" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showPasahitzaAldatuIkusi">Zure Pasahitza aldatu</a>
      <a href="#" id="panel6" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showAldaketaIkusi">Aldaketak ikusi</a>
      <a v-if="isAdmin" href="#" id="panel7" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showFavIkusiIkusi">Gustuko Panela</a>
      <a href="#" id="panel8" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showGrafikoIkusi">Grafikoak Ikusi</a>
      <a href="#" id="panel9" class="sidebar-menu-item hover:bg-gray-700 py-2 px-6 block" @click.prevent="showIruzkinIkusi">Iruzkinak Ikusi/Egin</a>


      <button @click="logout" class="w-full px-6 py-2 bg-red-600 text-white hover:bg-red-700 transition duration-300 mt-6">Logout</button>
    </div>
  </div>
</template>
<script>
// Importa el componente PanelSelect desde su ruta
import DatuakIkusi from "./DatuakIkusi.vue";

  export default {
    props: ['username', 'isAdmin'],
    components: {
      DatuakIkusi
    },
    
    data() {
      return {
        
        show_datuak_ikusi:false,
        groupedInfo: [] 
      };
    },

    methods: {
    
      logout() {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                console.log('Has cerrado sesion correctamente');
                localStorage.removeItem('username');
                // Redirige al usuario a la página de inicio de sesión
                window.location.href = '/login';
            } else {
                console.error('Error al cerrar sesión');
            }
        })
        .catch(error => {
            console.error('Error al cerrar sesión:', error);
        });
    },
    showDatuakIkusi() {
       this.$emit('show-datuak-ikusi'); 
      },
      showTeknologiakIkusi() {
        this.$emit('show-teknologiak-ikusi');
      },
      showPanelakGehitu() {
        this.$emit('show_panelakGehitu_ikusi');
      },
      showAldaketaIkusi() {
        this.$emit('show_AldaketakIkusi_ikusi'); 
      },
      showErabiltzaileakIkusi() {
        this.$emit('show_ErabiltzaileakIkusi_ikusi'); 
      },
      showPasahitzaAldatuIkusi(){
        this.$emit('show_PasahitzaAldatu_ikusi');
      },
      showFavIkusiIkusi(){
        this.$emit('show_FavIkusi_ikusi');
      },
      showGrafikoIkusi(){
        this.$emit('show_Grafiko_ikusi');
      },   
      showIruzkinIkusi(){
        this.$emit('show_Iruzkin_ikusi');
      },   
       
    }
};
</script>

<style scoped>

</style>
