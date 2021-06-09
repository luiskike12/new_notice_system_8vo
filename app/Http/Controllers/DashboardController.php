<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $usuario = Auth::user()->id;
        $anio = date('Y');

        $avisosEnviados = DB::table('avisos as a')
        ->select(DB::raw('MONTH(a.fecha_hora) as mes'),
        DB::raw('YEAR(a.fecha_hora) as anio'),
        DB::raw('COUNT(case WHEN a.estado = 1 THEN a.estado END) as avisos_enviados'),
        DB::raw('COUNT(case WHEN a.estado = 0 THEN a.estado END) as avisos_guardados'))
        ->whereYear('a.fecha_hora',$anio)
        ->where('a.id_usuario','=',$usuario)
        ->groupBy(DB::raw('MONTH(a.fecha_hora)'),DB::raw('YEAR(a.fecha_hora)'))->get();

        return ['avisosEnviados' => $avisosEnviados ,'anio' => $anio];

        // $avisosEnviados = DB::select('SELECT MONTH(fecha_hora) as mes, YEAR(fecha_hora) as anio,
        // COUNT(case when estado = :enviado then estado end) as avisos_enviados,
        // COUNT(case when estado = :guardado then estado end) as avisos_guardados
        // FROM avisos WHERE id_usuario = :usuario and YEAR(fecha_hora) = :anio_actual;',
        // ['usuario'=>$usuario, 'enviado'=>1, 'guardado'=>0, 'anio_actual'=>$anio]);

        
    }
}
