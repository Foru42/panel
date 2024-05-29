<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoginLdapAuto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LdapLoginController extends Controller
{
    public function login(Request $request)
    {
        if (LoginLdapAuto::attempt($request->username, $request->password)) {
            // Obtener el DN del usuario
            $dn = LoginLdapAuto::getDN($request->username);

            // Verificar si el usuario es administrador
            $isAdmin = LoginLdapAuto::isAdmin($request->username);

            // Almacenar el estado de administrador en la sesión
            Session::put('ldap', array_merge($dn, ['isAdmin' => $isAdmin]));

            // Retornar los datos del usuario junto con su estado de administrador
            return ['user' => $dn, 'isAdmin' => $isAdmin];
        } else {
            // Si la autenticación falla, devolver Unauthorized
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

}
