<?php
// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use App\Events\CommentAdded;
use App\Models\Iruzkina;
use App\Models\User;
use Illuminate\Http\Request;

class IruzkinController extends Controller
{
    public function addComment(Request $request)
    {
        // Obtener el nombre de usuario del formulario
        $username = $request->input('username');

        // Obtener el usuario asociado al nombre de usuario
        $user = User::where('username', $username)->first();

        // Verificar si el usuario existe
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Crear un nuevo comentario
        $comment = new Iruzkina();
        $comment->title = $request->input('title');
        $comment->desk = $request->input('desk');
        $comment->user_id = $user->id;
        $comment->save(); // Guardar el comentario
        event(new CommentAdded($comment, $username));

        return response()->json(['message' => 'Comentario añadido con éxito']);
    }

    public function infoIruzkinak()
    {
        // Obtener solo los usuarios que tienen comentarios asociados
        $info = User::whereHas('iruzkinak')->with('iruzkinak')->get();

        return $info;
    }

    public function deleteIruzkin(Request $request)
    {
        $IruzkinId = $request->input('id');
        // Buscar el registro de PanelTek por su ID
        $iruzkin = Iruzkina::find($IruzkinId);

        if ($iruzkin) {
            // Si se encuentra el registro, eliminarlo
            $iruzkin->delete();
            return response()->json(['success' => true, 'message' => 'Registro de PanelTek eliminado correctamente']);
        } else {
            // Si no se encuentra el registro, devolver un mensaje de error
            return response()->json(['success' => false, 'message' => 'El registro de PanelTek no existe'], 404);
        }
    }
    public function editarIruzkin(Request $request)
    {
        // Obtener los datos del comentario actualizado del cuerpo de la solicitud
        $updatedCommentData = $request->all();

        // Encontrar el comentario por su ID
        $comment = Iruzkina::find($updatedCommentData['id']);

        // Verificar si se encontró el comentario
        if ($comment) {
            // Actualizar los campos del comentario con los nuevos valores
            $comment->title = $updatedCommentData['title'];
            $comment->desk = $updatedCommentData['desk'];

            // Guardar el comentario actualizado
            $comment->save();

            // Retornar una respuesta de éxito
            return response()->json(['message' => 'Comentario actualizado exitosamente'], 200);
        } else {
            // Si el comentario no se encontró, retornar un error
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }
    }
}
