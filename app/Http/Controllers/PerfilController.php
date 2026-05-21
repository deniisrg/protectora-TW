<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SolicitudAdopcion;

class PerfilController extends Controller
{
    public function show()
    {
        $solicitudes = SolicitudAdopcion::with('animal')
            ->where('id_usuario', Auth::id())
            ->orderBy('fecha_solicitud', 'desc')
            ->get();

        return view('perfil', compact('solicitudes'));
    }

    public function configuracion()
    {
        return view('configuracion');
    }

    public function actualizarFoto(Request $request)
    {
        $request->validate(['foto_perfil' => 'required|image|max:2048']);
        $user = Auth::user();
        if ($user->foto_perfil) \Storage::disk('public')->delete($user->foto_perfil);
        $user->foto_perfil = $request->file('foto_perfil')->store('fotos_perfil', 'public');
        $user->save();
        return redirect()->route('configuracion')->with('exito', 'Foto actualizada correctamente.');
    }

    public function actualizarNombre(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Auth::user()->update(['name' => $request->name]);
        return redirect()->route('configuracion')->with('exito', 'Nombre actualizado correctamente.');
    }

    public function actualizarEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255|unique:users,email,' . Auth::id()]);
        Auth::user()->update(['email' => $request->email]);
        return redirect()->route('configuracion')->with('exito', 'Correo actualizado correctamente.');
    }

    public function actualizarPassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password'        => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_actual, Auth::user()->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);
        return redirect()->route('configuracion')->with('exito', 'Contraseña actualizada correctamente.');
    }

    public function eliminarCuenta(Request $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password_eliminar' => 'La contraseña no es correcta.']);
        }

        Auth::logout();
        if ($user->foto_perfil) \Storage::disk('public')->delete($user->foto_perfil);
        $user->delete();

        return redirect()->route('home')->with('exito', 'Tu cuenta ha sido eliminada.');
    }
}
