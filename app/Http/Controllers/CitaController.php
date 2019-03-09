<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cita;
use App\MaestroHora;
use DB;

class CitaController extends Controller
{
    public function lista(Request $r)
    {
        $res    = array();
        $Horas  = MaestroHora::all();
        $Citas  = Cita::where('fecha', $r->fecha)
        ->get(DB::raw(
            'hora_inicio
            , contacto
            , fecha'
        ));
        foreach($Horas as $hora){
            foreach($Citas as $cita){
                if($hora->hora == $cita->hora_inicio){
                    $hora['cita'] = $cita;
                }
            }
            array_push($res, $hora);
        }
        return response()->json($res); 
    }

    public function crear(Request $r)
    {
        $Cita               = new Cita();
        $Cita->fecha        = $r->fecha;
        $Cita->hora_inicio  = $r->hora;
        $Cita->contacto     = $r->contacto;
        $Cita->save();

        $Citas = $this->lista($r);
        return $Citas;
    }
}
