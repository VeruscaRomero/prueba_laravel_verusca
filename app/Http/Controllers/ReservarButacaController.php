<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Butacas;
use App\Reservas;
use App\Usuarios;

class ReservarButacaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=Usuarios::all();
        return view('index',compact('usuarios'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservas= new Reservas();
        $usuarios= new Usuarios();
        $butacas= new Butacas();
        $usuarios->nombres=$request->get('nombres');
        $usuarios->apellidos=$request->get('apellidos');
        $fecha=date_create($request->get('date'));
        $format = date_format($fecha,"Y-m-d");
        $reservas->fecha = $format;
        $reservas->nropersonas=$request->get('cantidad_personas');
        $usuarios->save();
        $reservas->idusuarios=Usuarios::first()->idusuarios;
        $reservas->save();
        $str = $request->get('fila_columna');
        $MiButaca[] = explode(",",$str);
        $MisButacas=array_filter($MiButaca[0], "strlen");
        foreach ($MisButacas as $key => $value) {
            DB::table('Butacas')->insert(
                ['idreserva' => Reservas::first()->idreserva, 'fila_columna' =>$value, 'estado' => true , 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]
            );        
        }

    $nombre_archivo = "logs.txt"; 

    if(file_exists($nombre_archivo))
    {
        $mensaje = "El Archivo logs.txt se ha modificado";
    }

    else
    {
        $mensaje = "El Archivo logs.txt se ha creado";
    }

    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo,  date("d m Y H:m:s"). " ". $usuarios. " ". $reservas. " ". $butacas. " ". "\n"))
        {
            echo "Se ha ejecutado correctamente";
        }
        else
        {
            echo "Ha habido un problema al crear el archivo";
        }

        fclose($archivo);
    }

        
        return redirect('reservarbutaca')->with('success', 'Reservación registrada correctamente');

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$butaca = array();
         $usuarios = DB::table('Usuarios')
            ->join('reservas', 'reservas.idusuarios', '=', 'usuarios.idusuarios')
            ->join('butacas', 'butacas.idreserva', '=', 'reservas.idreserva')
            ->where('usuarios.idusuarios','=',$id)
            ->first();
        $idreserva = DB::table('Reservas')->where('idusuarios', $id)->value('idreserva'); 
        //$butacas = DB::table('Butacas')->where('idreserva', '=', $idreserva)->select('fila_columna')->get();
        //$ArrayButacas = json_decode($butacas, true);
        return view('edit',compact('usuarios','id'));
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

        $usuarios= Usuarios::where('idusuarios', $id)->first();
        $usuarios->nombres=$request->get('nombres');        
        $usuarios->apellidos=$request->get('apellidos');
        DB::table('Usuarios')
            ->where('idusuarios', $id)
            ->update(['nombres' => $usuarios->nombres, 'apellidos' => $usuarios->apellidos, 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]);
        $reservas=Reservas::where('idusuarios', $id)->first();
        $fecha=date_create($request->get('date'));
        $format = date_format($fecha,"Y-m-d");
        $reservas->fecha = $format;
        $reservas->nropersonas=$request->get('cantidad_personas');         
        $idreserva = DB::table('Reservas')->where('idusuarios', $id)->value('idreserva');       
        DB::table('Reservas')
            ->where('idreserva', $idreserva)
            ->update(['fecha' => $reservas->fecha, 'nropersonas' => $reservas->nropersonas, 'idusuarios' => $id, 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]);
        $str = $request->get('fila_columna');
        $MiButaca[] = explode(",",$str);
        $MisButacas=array_filter($MiButaca[0], "strlen");
        foreach ($MisButacas as $key => $value) {
            DB::table('Butacas')
            ->where('idreserva','=', $idreserva)
            ->update(
                ['fila_columna' =>$value, 'estado' => true , 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]
            );        
        }
        return redirect('reservarbutaca');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuarios = DB::table('Usuarios')->where('idusuarios', $id)->delete();
        $idreserva = DB::table('Reservas')->where('idusuarios', $id)->value('idreserva');
        $reservas = DB::table('Reservas')->where('idusuarios', $id)->delete();
        $butacas = DB::table('Butacas')->where('idreserva', '$idreserva')->delete();
        return redirect('reservarbutaca')->with('success','Reserva eliminada correctamente');
    }
}
