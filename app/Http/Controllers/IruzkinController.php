<?php
// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use App\Models\Iruzkina;
use App\Models\UserIruzkinak;
use Illuminate\Http\Request;
use App\Models\User;

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



        return response()->json(['message' => 'Comentario añadido con éxito']);
    }



    public function infoIruzkinak()
    {
        $info = User::with('iruzkinak')->get();

        return $info;
    }



}
