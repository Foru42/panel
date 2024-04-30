<template>
  <div id="pertsonak" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
    <table
      id="tablaUsuarios"
      class="w-full divide-y divide-gray-200 shadow-md rounded-lg"
    >
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="px-8 py-3 text-left text-lg font-medium text-gray-700 uppercase tracking-wider"
          >
            Erabiltzailea
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-lg font-medium text-gray-700 uppercase tracking-wider"
          >
            Administradorea
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-lg font-medium text-gray-700 uppercase tracking-wider"
          >
            Ekintzak
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="usuario in usuarios" :key="usuario.id">
          <td>
            <template v-if="!usuario.editando">
              {{ usuario.username }}
            </template>
            <template v-else>
              <input type="text" v-model="usuario.username" />
            </template>
          </td>
          <td v-if="!usuario.editando">
            {{
              usuario.administrador === "1" || usuario.administrador === 1 ? "Sí" : "No"
            }}
          </td>
          <td v-else>
            <select v-model="usuario.administrador">
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </td>
          <td class="relative">
            <div class="absolute right-0 top-0 h-full flex items-center">
              <template v-if="usuario.editando">
                <button
                  class="btn-guardarU flex items-center justify-center bg-green-500 text-white font-bold rounded-full h-8 w-8 mr-2"
                  @click="cambiarUsuario(usuario)"
                >
                  <i class="fas fa-save"></i>
                </button>
              </template>
              <button
                class="btn-eliminarU flex items-center justify-center bg-red-500 text-white font-bold rounded-full h-8 w-8 mr-2"
                @click="eliminarUsuario(usuario.id)"
              >
                <i class="fas fa-trash"></i>
              </button>
              <button
                class="btn-editarU flex items-center justify-center bg-blue-500 text-white font-bold rounded-full h-8 w-8"
                @click="toggleEdicion(usuario)"
              >
                <i class="fas fa-pencil-alt"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      usuarios: [],
    };
  },
  mounted() {
    this.mostrarUsuarios();
  },
  methods: {
    mostrarUsuarios() {
      fetch("/usuarios")
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error al obtener los usuarios");
          }
          return response.json();
        })
        .then((data) => {
          this.usuarios = data.map((usuario) => ({
            ...usuario,
            editando: false, // Agregar propiedad editando a cada usuario
          }));
        })
        .catch((error) => {
          console.error(error.message);
        });
    },
    eliminarUsuario(id) {
      // Obtener el token CSRF del meta tag
      var confirmacion = confirm("¿Estás seguro de eliminar este usuario?");
      if (!confirmacion) {
        return; // Si el usuario cancela, salir de la función sin hacer nada
      }

      var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

      // Hacer la solicitud AJAX para eliminar el usuario
      fetch("/eliminar-usuario", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-Token": csrfToken,
        },
        body: JSON.stringify({ id, _token: csrfToken }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error al eliminar el usuario");
          }
          console.log("Usuario eliminado exitosamente");
          // Por ejemplo, podrías recargar la página para mostrar la tabla actualizada
          window.location.reload();
        })
        .catch((error) => {
          // Maneja los errores si ocurren durante la eliminación
          console.error("Error al eliminar el usuario:", error);
        });
    },
    toggleEdicion(usuario) {
      const usuarioEnEdicion = this.usuarios.find((u) => u.editando);

      if (usuarioEnEdicion && usuarioEnEdicion !== usuario) {
        alert("Ya badaukazu beste erabiltzaile bat editatzen");
        return;
      }

      usuario.editando = !usuario.editando; // Alternar el estado de edición
    },
    cambiarUsuario(nuevosValores) {
      var confirmacion = confirm("¿Seguru erabiltzailea aldatu nahi duzula?");
      if (confirmacion) {
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        localStorage.removeItem('username');
        localStorage.setItem('username',nuevosValores.username);
        // Hacer la solicitud fetch para cambiar el usuario
        fetch("/cambiar-usuario", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
          },
          body: JSON.stringify({
            username: nuevosValores.username,
            administrador: nuevosValores.administrador,
            panelId: nuevosValores.id,
            _token: csrfToken, // Incluir el token CSRF en los datos de la solicitud
          }),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Error al actualizar el usuario");
            }
            console.log("Usuario actualizado exitosamente");
            // Por ejemplo, podrías recargar la página para mostrar la tabla actualizada
            window.location.reload(); // Otra opción es actualizar la lista de usuarios sin recargar la página
          })
          .catch((error) => {
            // Maneja los errores si ocurren durante la actualización
            console.error("Error al actualizar el usuario:", error);
          });
      }
    },
  },
};
</script>

<style>
/* Estilos */
</style>
