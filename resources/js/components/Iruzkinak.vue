<template>
  <div class="coment">
    <!-- Botón para abrir el modal -->
    <button @click="openModal" class="rounded-full add-comment-button">
      Iruzkinak gehitu
    </button>

    <!-- Modal para agregar comentario -->
    <div v-if="showModal" class="modal text-black">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>Iruzkina Sartu</h2>
        <form @submit.prevent="addComment">
          <label for="commentTitle">Izena:</label><br />
          <input type="text" id="commentTitle" v-model="commentTitle" required /><br />
          <label for="commentDesk">Deskripzioa:</label><br />
          <textarea id="commentDesk" v-model="commentDesk" required></textarea><br />
          <button
            type="submit"
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
          >
            Gorde
          </button>
        </form>
      </div>
    </div>

    <!-- Contenedor para mostrar las tarjetas de comentarios -->
    <div class="comment-container text-black">
      <div class="comment-card" v-for="comment in comments" :key="comment.id">
        <div class="comment-header">
          <span class="user-photo">
            <img
              :src="comment.argazki"
              alt="Foto de Perfil"
              class="w-10 h-10 rounded-full mx-auto mb-4 border-4 border-gray-200"
            />
          </span>
          <span class="username">
            {{ comment.username }}
          </span>
          <button v-if="this.isAdmin"
            class="flex items-center justify-center bg-blue-500 text-white font-bold rounded-full h-8 w-8 mr-2"
            @click="MostrarEditar(comment.username)"
          >
            <i class="fas fa-pencil-alt"></i>
          </button>
        </div>
        <div
          v-for="iruzkin in comment.iruzkinak"
          :key="iruzkin.id"
          class="comment-body"
          :id="iruzkin.id"
        >
          <div>Title: {{ iruzkin.title }}</div>
          <div>Deskripzioa: {{ iruzkin.desk }}</div>
          <div v-if="showDeleteIcons && comment.username === selectedUserId">
            <button
              @click="BorrarIruzkin(iruzkin.id)"
              class="items-center justify-center bg-red-500 text-white font-bold rounded-full h-8 w-8 mr-2"
            >
              <i class="fas fa-trash-alt"></i>
            </button>
            <button   
              @click="editComment(iruzkin.id, iruzkin.title, iruzkin.desk)"
              class="items-center justify-center bg-green-500 text-white font-bold rounded-full h-8 w-8"
            >
              <i  class="fas fa-edit"></i>
            </button>
          </div>
        </div>
        <div v-if="showModalEdit" class="modal">
          <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Editatu Iruzkina</h2>
            <form @submit.prevent="updateIruzkina">
              <label for="editCommentTitle">Izenburu:</label><br />
              <input
                type="text"
                id="editCommentTitle"
                v-model="editCommentTitle"
                required
              /><br />
              <label for="editCommentDesk">Deskripzioa:</label><br />
              <textarea id="editCommentDesk" v-model="editCommentDesk" required></textarea
              ><br />
              <button
                type="submit"
                class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
              >
                Gorde
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CryptoJS from "crypto-js";

export default {
  props: ["isAdmin"],
  data() {
    return {
      showModal: false,
      commentTitle: "",
      commentDesk: "",
      comments: [],
      showDeleteIcons: false,
      selectedUserId: null,
      showModalEdit: false,
    };
  },
  mounted() {
   
    this.fetchComments();
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.showModalEdit = false;
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
    addComment() {
      const userId = this.decryptUsername();
      const commentData = {
        title: this.commentTitle,
        desk: this.commentDesk,
        username: userId,
      };

      fetch("/add-iruzkin", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify(commentData),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Ocurrió un error al procesar la solicitud.");
          }
          this.closeModal();
          this.fetchComments();
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
    fetchComments() {
      fetch("/show-iruzkin", {
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
            throw new Error("Ocurrió un error al procesar la solicitud.");
          }
          return response.json();
        })
        .then((data) => {
          this.comments = data;
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
    MostrarEditar(userId) {
      this.selectedUserId = userId; // Establecer el ID del usuario seleccionado
      this.showDeleteIcons = true; // Mostrar iconos de eliminación
    },

    formatDate(dateString) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    BorrarIruzkin(izenburu) {
      var confirmacion = confirm("¿Seguru Panela borratu nahi duzula?");
      if (confirmacion) {
        // Obtener el token CSRF de la meta etiqueta
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        // Realizar la petición AJAX con el token CSRF incluido en la cabecera
        fetch("/eliminar-iruzkin", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
          body: JSON.stringify({ id: izenburu }),
        })
          .then((response) => {
            if (response.ok) {
              this.fetchComments();
            } else {
              // Si hubo un error, mostrar un mensaje de error
              console.error("Error al eliminar el panel:", response.statusText);
            }
          })
          .catch((error) => {
            console.error("Error al eliminar el panel:", error);
          });
      }
    },
    editComment(commentId, title, desk) {
      // Mostrar el modal de edición
      this.showModalEdit = true;
      // Establecer los datos del comentario seleccionado en el modal
      this.editCommentTitle = title;
      this.editCommentDesk = desk;
      // Establecer el ID del comentario seleccionado
      this.selectedCommentId = commentId;
    },
    updateIruzkina() {
      // Crear el objeto de datos del comentario actualizado
      const updatedCommentData = {
        id: this.selectedCommentId,
        title: this.editCommentTitle,
        desk: this.editCommentDesk,
      };

      // Realizar la solicitud para actualizar el comentario
      fetch("/update-comment", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify(updatedCommentData),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Ocurrió un error al actualizar el comentario.");
          }
          // Cerrar el modal de edición después de actualizar el comentario
          this.closeModal();
          // Volver a cargar los comentarios actualizados
          this.fetchComments();
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },
};
</script>

<style>
/* Estilos para el modal */
.modal {
  position: fixed;
  z-index: 2;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 90%;
  max-width: 600px;
  min-width: calc(50vw - 350px);
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.comment-card {
  width: 100vh;
  background-color: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  margin-bottom: 20px;
}

.comment-header {
  padding: 10px;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.username {
  font-weight: bold;
}


.comment-body {
  padding: 10px;
}

.add-comment-button {
  background-color: #4caf50;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-bottom: 20px;
  cursor: pointer;
}

</style>
