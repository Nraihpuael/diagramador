<?php

namespace App\Http\Controllers;

use App\Models\Diagrama;
use App\Models\Notificacion;
use App\Models\User;
use App\Notifications\Unotificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification as emailNotificacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();
        $notificaciones = $user->invitaciones()->where('leido', 0)->get();
        return view('auth.notifications', compact('notificaciones'));
    }

    public function notificar(Request $request)
    {
        try {
            $name = Str::substr($request->email, 0, strpos($request->email, '@'));
            $pass = Str::random(8);
            $user = User::create([
                'name' => $name,
                'email' => $request->email,
                'password' => Hash::make($pass),
            ]);

            $diagrama = Diagrama::find($request->diagrama_id);
            $notificacion = new Notificacion;
            $notificacion->contenido = auth()->user()->name . ' te esta invitando al diagrama: ' . $diagrama->nombre . ' como colaborador...Tu equipo te necesita\nIngresa con tu correo actual, tu contrasena es: '.$pass;
            $notificacion->user_id = $user->id;
            $notificacion->c = $request->diagrama_id;
            $notificacion->save();

            DB::table('user_diagramas')->insert([
                'diagrama_id' => $notificacion->diagrama_id,
                'user_id' => $notificacion->user_id
            ]);

            $url = asset('/diagramas').'/'. $request->diagrama_id;

            $email = [
                'subject' => 'Inivitacion Diagrama: ' . $diagrama->nombre,
                'saludo' => 'Hola que tal ' . $user->name,
                'contenido' => $notificacion->contenido,
                'botonTexto' => 'Ingresar al diagrama',
                'url' => $url,
                'nota' => 'Al ingresar al diagrama podras participar en todas los distintos diagramas sobre los que tu equipo te permitira trabajar'
            ];

            emailNotificacion::send($user, new Unotificacion($email));

            return redirect()->back()->with('message', 'Se notifico'.$user->id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
    }



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $diagrama = Diagrama::find($request->diagrama_id);
            $notificacion = new Notificacion;
            $notificacion->contenido = auth()->user()->name . ' te esta invitando al diagrama: ' . $diagrama->nombre . ' como colaborador...Tu equipo te necesita';
            $notificacion->user_id = $request->user_id;
            $notificacion->diagrama_id = $request->diagrama_id;
            $notificacion->save();

            DB::table('user_diagramas')->insert([
                'diagrama_id' => $notificacion->diagrama_id,
                'user_id' => $notificacion->user_id
            ]);

            $user = User::find($request->user_id);

            $url = asset('/diagramas').'/'. $request->diagrama_id;

            $email = [
                'subject' => 'Inivitacion Diagrama: ' . $diagrama->nombre,
                'saludo' => 'Hola que tal ' . $user->name,
                'contenido' => $notificacion->contenido,
                'botonTexto' => 'Ingresar al diagrama',
                'url' => $url,
                'nota' => 'Al ingresar al diagrama podras participar en todas los distintos diagramas sobre los que tu equipo te permitira trabajar'
            ];

            emailNotificacion::send($user, new Unotificacion($email));

            return redirect()->route('diagrama.usuarios', $request->diagrama_id)->with('message', 'Se notifico al usuario exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function leer(Request $request, Notificacion $notificacion)
    {
       
        $notificacion->leido = 1;
        $notificacion->update();
        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notificacion = Notificacion::find($id);
        $diagrama_id = $notificacion->diagrama_id;
        $notificacion->delete();
        return redirect()->route('diagrama.usuarios', $diagrama_id);
    }
}
