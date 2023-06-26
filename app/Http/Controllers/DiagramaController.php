<?php

namespace App\Http\Controllers;

use App\Events\DiagramaSent;
use App\Models\Diagrama;
use App\Models\User;
use App\Models\User_diagrama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiagramaController extends Controller
{
    public function index()
    {
        $diagramas = Auth::user()->user_diagramas;
        return view('diagramas.index', compact('diagramas'));

    }

    public function misDiagramas()
    {
        $diagramas = Auth::user()->misDiagramas()->paginate(3);
        return view('diagramas.misDiagramas', compact('diagramas'));
    }

    public function diagramar(Diagrama $diagrama)
    {        
        $permiso = Auth::user()->user_diagramas()->where('diagrama_id', $diagrama->id)->first();
        $permiso = $permiso->editar;
        return view('diagramas.diagramar', compact('diagrama','permiso'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required'],
            'descripcion' => ['required']
        ]);
        try {
            $diagrama = new Diagrama();
            $diagrama->nombre = $request->nombre;
            $diagrama->descripcion = $request->descripcion;
            $diagrama->user_id = Auth::user()->id;
            if ($request->diagrama_id != 'nuevo') {
                $newDiagram = Diagrama::find($request->diagrama_id);
                $diagrama->contenido = $newDiagram->contenido;
            } else {
                $diagrama->contenido = '';
            }
            $diagrama->save();
            DB::table('user_diagramas')->insert([
                'user_id' => $diagrama->user_id,
                'diagrama_id' => $diagrama->id
            ]);
            return redirect()->route('diagramas.misDiagramas');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
    }

    public function editor(Request $request)
    {
        $user = User::find($request->input('id'));
        $relacion = $user->user_diagramas()->where('diagrama_id', $request->input('diagrama'))->first();
        $relacionv = User_diagrama::find($relacion->id);
        $relacionv->editar = $relacionv->editar == 0 ? 1 : 0;
        $relacionv->update();
        return response()->json(['mensaje' => 'Usuario desactivado...'], 200);
    }

    public function favorito(Request $request)
    {
        $diagrama = Diagrama::findOrFail($request->input('id'));
        $diagrama->favorito = $diagrama->favorito == 0 ? 1 : 0;
        $diagrama->update();
        return response()->json(['mensaje' => 'Usuario desactivado...'], 200);
        /* return  redirect()->back()->with('message', 'Se reitro de favoritos '); */
    }

    public function terminado(Request $request)
    {
        $diagrama = Diagrama::findOrFail($request->input('id'));
        $diagrama->terminado = $diagrama->terminado == 0 ? 1 : 0;
        $diagrama->update();
        return response()->json(['mensaje' => 'Usuario desactivado...'], 200);
        /* return  redirect()->back()->with('message', 'Se reitro de favoritos '); */
    }

    public function guardar(Request $request)
    {
        $diagrama = Diagrama::findOrFail($request->input('id'));
        $diagrama->contenido = $request->input('contenido');
        $diagrama->update();
        broadcast(new DiagramaSent($diagrama))->toOthers();
        return response()->json(['msm' => 'msmsms'], 200);
    }

    public function edit(Diagrama $diagrama)
    {
        return view('diagramas.edit', compact('diagrama'));
    }

    public function update(Request $request, Diagrama $diagrama)
    {
        try {
            $diagrama->nombre = $request->nombre;
            $diagrama->descripcion = $request->descripcion;
            $diagrama->update();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
        return redirect()->route('diagramas.misDiagramas')->with('message', 'Se edito la inf del diagrama de manera correcta');
    }

    public function usuarios(Diagrama $diagrama)
    {
        $usuarios = $diagrama->usuarios;
        $all = User::paginate(4);
        return view('diagramas.usuarios', compact('diagrama', 'usuarios', 'all'));
    }

    public function agregar(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                DB::table('user_diagramas')->insert([
                    'user_id' => $request->user_id,
                    'diagrama_id' => $request->diagrama_id
                ]);
            });
            DB::commit();
            return redirect()->back()->with('message', 'Se agrego el usuario correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
    }

    public function banear(Request $request, Diagrama $diagrama)
    {
        try {
            $user = User::find($request->user_id);
            $relacion = Auth::user()->user_diagramas()->where('diagrama_id', $diagrama->id)->first();
            $rel = User_diagrama::find($relacion->id);
            $rel->delete();
            return redirect()->back()->with('message', 'Se removio al usuario del diagrama: ' . $diagrama->nombre);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error' . $e->getMessage());
        }
    }

    public function destroy(Diagrama $diagrama) {
        $diagrama->delete();
        return redirect('/diagramas')->with('message', 'Diagrama eliminado');
    }


    public function script(Diagrama $diagrama)
    {
        $nombre = $diagrama->nombre;
        $contenido = json_decode($diagrama->contenido);
       
        $cell = $contenido->cells;                
        //dd($cell);
        $sql = 'create database ' .$nombre. ';'.PHP_EOL.' use ' .$nombre. ';'.PHP_EOL.PHP_EOL;

        
        for ($i = 0; $i < count($cell); $i++) {
            $primary = '';
            $c = 0;
            if ($cell[$i]->type == 'uml.Class' ) {
                if(count($cell[$i]->attributes) != 0){
                    $sql .= 'create table '. $cell[$i]->name. '( '.PHP_EOL;
                    
                    $atri = $cell[$i]->attributes;
                    for ($j = 0; $j < count($atri); $j++) {   

                        if(str_contains($atri[$j], 'Pk')|| str_contains($atri[$j], 'PK')){
                            if($c == 0){
                                $pieces = explode(" ", $atri[$j]);
                                $primary = $pieces[0] ;
                                $c++;
                            }else{
                                $pieces = explode(" ", $atri[$j]);
                                $primary .= ', '.$pieces[0] ;
                            }
                                
                        }   

                        if(str_contains($atri[$j], 'Fk')|| str_contains($atri[$j], 'FK')|| str_contains($atri[$j], 'fk')){
                            if($j == count($atri)-1){
                                $pieces = explode(" ", $atri[$j]);
                                if(str_contains($pieces[0], '_')){
                                    $foranea = explode("_", $pieces[0]);
                                    $sql .= ' '.$pieces[0]. ' ' .$pieces[1].', '.PHP_EOL.'primary key(' .$primary.'), '.PHP_EOL.' FOREIGN KEY ('.$pieces[0].') REFERENCES '.$foranea[1].'('.$foranea[0].') ON DELETE CASCADE  ON UPDATE CASCADE);'.PHP_EOL;
                                }else{
                                    $sql .= 'foranea mal definida'.PHP_EOL;
                                }
                            }else{
                                $pieces = explode(" ", $atri[$j]);
                                if(str_contains($pieces[0], '_')){
                                    $foranea = explode("_", $pieces[0]);
                                    $sql .= ' ' .$pieces[0].' ' .$pieces[1]. ','.PHP_EOL.' FOREIGN KEY ('.$pieces[0].') REFERENCES '.$foranea[1].'('.$foranea[0].') ON DELETE CASCADE ON UPDATE CASCADE);'.PHP_EOL;
                                }else{
                                    $sql .= 'foranea mal definida'.PHP_EOL;
                                }    
                            }

                        }else{
                            if($j == count($atri)-1){
                                $pieces = explode(" ", $atri[$j]);
                                $sql .= ' '.$pieces[0]. ' ' .$pieces[1].', '.PHP_EOL.' primary key(' .$primary.') '.PHP_EOL.' );'.PHP_EOL;
                            }else{
                                $pieces = explode(" ", $atri[$j]);
                                $sql .= ' ' .$pieces[0].' ' .$pieces[1]. ','.PHP_EOL;
                            }
                        }            
                    }
                }
            } 
        }

        $path = 'script.sql';
        $th = fopen("script.sql", "w");
        fclose($th);
        $ar = fopen("script.sql", "a") or die("Error al crear");
        fwrite($ar, $sql);
        fclose($ar);
        return response()->download($path);
    }

 

    public function crud(Diagrama $diagrama)
    {
        $nombre = $diagrama->nombre;
        $contenido = json_decode($diagrama->contenido);
        

        $sql= '';
        $cell = $contenido->cells;                
        //dd($cell);
            
        for ($i = 0; $i < count($cell); $i++) {
           
            if ( $cell[$i]->type == 'uml.Class' && (count($cell[$i]->attributes) != 0) ) {
                $sql .= '           <?php

                namespace App\Http\Controllers;
                
                use App\Models\Listing;
                use Illuminate\Http\Request;
                use Illuminate\Validation\Rule;
                ';

                $name = $cell[$i]->name;

                $sql .= 'class '.$name.'Controller extends Controller{

                public function create(Request $request) {
                $formFields = $request->validate([
                    ';
                
                $atri = $cell[$i]->attributes;    
                for ($j = 0; $j < count($atri)-1; $j++){
                    $pieces = explode(" ", $atri[$j]);
                    $sql .= "'$pieces[0]' => 'required',
                    ";
                }
                $pieces = explode(" ", $atri[count($atri)-1]);
                $sql .= "   '$pieces[0]' => 'required'
                    ]);
                ";

                $sql .= 'Listing::create($formFields);
                '.
                "return redirect('/')};
                
                ";
                
                $sql .= 'public function show( '.$name.' $'.$name.'){
                        '."return view('$name.show', ['$name' => $$name])}; 
                        
                " ;         
                

                $sql .= 'public function update(Request $request, '.$name.' $'.$name.') {
                            $formFields = $request->validate([
                                '   ;

                $atri = $cell[$i]->attributes;    
                for ($j = 0; $j < count($atri)-1; $j++){
                    $pieces = explode(" ", $atri[$j]);
                    $sql .= "'$pieces[0]' => 'required',
                    ";
                }
                $pieces = explode(" ", $atri[count($atri)-1]);
                $sql .= "       '$pieces[0]' => 'required'
                        ]);
                ".'$'.$name.'Listing->update($formFields);
                '.
                "return redirect('/')
                };
                
                ";                

                $sql .= 'public function destroy( '.$name.' $'.$name.'){
                    '.'$'.$name.'Listing->delete();
                    '.
                    "return redirect('/')};
                    
                }
                
    ";
            }   
        }
        $path = 'Controller.php';
        $th = fopen("$path", "w");
        fclose($th);
        $ar = fopen("$path", "a") or die("Error al crear");
        fwrite($ar, $sql);
        fclose($ar);
        return response()->download($path);
    }
}
