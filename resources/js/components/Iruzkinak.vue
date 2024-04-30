<template>
  <div>
    <!-- Botón para abrir el modal -->
    <button @click="openModal" class="add-comment-button">Añadir Comentario</button>

    <!-- Modal para agregar comentario -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>Añadir Comentario</h2>
        <form @submit.prevent="addComment">
          <label for="commentTitle">Título:</label><br>
          <input type="text" id="commentTitle" v-model="commentTitle"><br>
          <label for="commentDesk">Descripción:</label><br>
          <textarea id="commentDesk" v-model="commentDesk"></textarea><br>
          <button type="submit">Guardar</button>
        </form>
      </div>
    </div>

    <!-- Contenedor para mostrar las tarjetas de comentarios -->
    <div class="comment-container">
      <div class="comment-card" v-for="comment in comments" :key="comment.id">
        <div class="comment-header">
          <span class="username">{{ comment.username }}</span>
        </div>
        <div v-for="iruzkin in comment.iruzkinak" :key="iruzkin.id" class="comment-body">
          <div>Title: {{ iruzkin.title }}</div>
          <div>Deskripzioa: {{ iruzkin.desk }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showModal: false,
      commentTitle: '',
      commentDesk: '',
      comments: [] 
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
    },
    addComment() {
      const userId = localStorage.getItem('username');
      const commentData = {
        title: this.commentTitle,
        desk: this.commentDesk,
        username: userId
      };

      fetch('/add-iruzkin', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(commentData)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Ocurrió un error al procesar la solicitud.');
        }
        this.closeModal();
        this.fetchComments();
      })
      .catch(error => {
        console.error('Error:', error);
      });
    },
    fetchComments() {
      fetch('/show-iruzkin', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Ocurrió un error al procesar la solicitud.');
        }
        return response.json();
      })
      .then(data => {
        this.comments = data;
      })
      .catch(error => {
        console.error('Error:', error);
      });
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    }
  }
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
  background-color: rgba(0,0,0,0.4);
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

.date {
  color: #666;
}

.comment-body {
  padding: 10px;
}

.comment-body h3 {
  margin-top: 0;
}

.comment-body p {
  margin-bottom: 0;
}
.add-comment-button {
  background-color: #4CAF50;
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
