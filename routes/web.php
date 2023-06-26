<?php

use App\Http\Controllers\DiagramaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ProfileController;
use App\Mail\notificacion;
use App\Models\User;
use App\Models\Notificacion as modelonoti;
use App\Notifications\Unotificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
    
});

Route::get('/usuarios', function () {
    $users = User::all();
    return response(User::all(), 200);
});

Route::middleware('auth')->group(function () {
    Route::get('/diagramas', function(){
        $usuario = User::find(Auth::user()->id);
        $diagramas = $usuario->diagramas()->where('favorito', 1)->paginate(5);
        return view('diagramas.misDiagramas', compact('diagramas'));
    })->name('dashboard');



    Route::get('/notificadoxd', function(){
        
        $user = Auth::user();
        $cadena = substr($user->email, 0, strpos($user->email, '@'));
        //$notificacion = modelonoti::find(1);
        $url = 'http://diagramador.test/diagramar/1';
        $notificacion = [
            'subject' =>'Inivitacion Diagramaa: ',
            'saludo' => 'Hola que tal '.$user->name,
            'contenido' => auth()->user()->name.' le envió esta invitación',
            'botonTexto' => 'Ingresar al Diagrama',
            'url' => $url,
            'nota' => 'linea ultima'
        ];
        
        Notification::send( $user, new Unotificacion( $notificacion));
        return 'correo: '.$cadena;
    
    });


    Route::get('Profile/', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('Profile/{user}/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::put('Leer-Notificacion/{notificacion}', [NotificacionController::class, 'leer'])->name('notificaciones.leer');
  
    /* Diagramas */


    Route::get('diagramas/{diagrama}/script', [DiagramaController::class, 'script'])->name('diagramas.script');

    Route::get('diagramas/{diagrama}/crud', [DiagramaController::class, 'crud'])->name('diagramas.crud');

    Route::put('Banear-Diagrama/{diagrama}', [DiagramaController::class, 'banear'])->name('diagramas.banear');
    Route::get('digramas/{diagrama}/usuarios', [DiagramaController::class, 'usuarios'])->name('diagramas.usuarios');
    Route::post('diagramas/agregar-usuario', [DiagramaController::class, 'agregar'])->name('diagramas.agregarUsuario');
    Route::get('diagramar/{diagrama}',[DiagramaController::class, 'diagramar'])->name('diagramas.diagramar');
    Route::get('diagramas/',[DiagramaController::class, 'misDiagramas'])->name('diagramas.misDiagramas');
    Route::post('diagramas/editor', [DiagramaController::class, 'editor']);
    Route::post('diagramas/guardar', [DiagramaController::class, 'guardar']);
    Route::post('diagramas/favorito', [DiagramaController::class, 'favorito']);
    Route::post('diagramas/terminado', [DiagramaController::class, 'terminado']);
    Route::get('diagramas/{diagrama}/edit', [DiagramaController::class, 'edit'])->name('diagramas.edit');
    Route::put('diagramas/{diagrama}/update', [DiagramaController::class, 'update'])->name('diagramas.update');
    Route::post('diagramas/', [DiagramaController::class, 'store'])->name('diagramas.store');
    Route::delete('diagramas/{diagrama}',[DiagramaController::class, 'destroy'])->name('diagramas.delete');
    /* Notificaciones */
    Route::post('notificar', [NotificacionController::class, 'notificar'])->name('notificar');
    Route::resource('notificaciones', NotificacionController::class);
    
});

require __DIR__.'/auth.php';
