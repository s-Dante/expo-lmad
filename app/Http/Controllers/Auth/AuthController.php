<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|exists:tbl_usuarios,email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            $usuarios =  Auth::user();

            return $this->redireccionPorRol($usuarios);
            
        }
        return back()->withErrors(['clave' => 'Credenciales incorrectas.']);

    }

    public function redireccionPorRol($usuario){
        switch($usuario->rol){
            case 'super_admin':
                return redirect()->route('superadmin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'profesor':
                return redirect()->route('teacher.registro-expositores');
            case 'estudiante':
                return redirect()->route('estudiante.dashboard');
            case 'staff':
                return redirect()->route('staff.dashboard');
            default:
                Auth::logout();
                return redirect('/login')->withErrors('Credenciales inválidas.');
        }
    }
}
