<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // En AuthController.php (El original que subiste)

    public function login(Request $request)
    {
        // ... validación ...

        $usuario = Usuario::where('correo', $request->correo)
            ->where('activo', true)
            ->first();

        // Esta línea es la única que necesitas.
        // Comprueba si el usuario existe Y si el hash de la contraseña coincide.
        if ($usuario && \Hash::check($request->password, $usuario->hash_password)) {

            // Inicia sesión (incluyendo el "Recordarme")
            Auth::login($usuario, $request->boolean('remember'));
            $request->session()->regenerate();

            // Redirige según el rol
            if ($usuario->isAdmin()) {
                return redirect()->route('usuarios.index');
            }

            return redirect()->route('bienes.index');
        }

        // Si el IF de arriba falla, se ejecuta esta línea
        return back()->with('error', 'Las credenciales no coinciden con nuestros registros')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
