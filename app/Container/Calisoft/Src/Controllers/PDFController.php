<?php
namespace App\Container\Calisoft\Src\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container\Calisoft\Src\Proyecto;
use App\Container\Calisoft\Src\User;
use App\Container\Calisoft\Src\Repositories\Calificaciones;
use App\Container\Calisoft\Src\Indicadores;
use App\Container\Calisoft\Src\Preguntas;
use App\Container\Calisoft\Src\Pruebas;
use App\Container\Calisoft\Src\Planes;
use DB;
use PDF;


class PDFController extends Controller
{

    function __construct()
    {
        //$this->middleware('can:see_evaluations,App\Proyecto')->except('total', 'usuarios');
        //$this->middleware('can:see_global,proyecto')->only('total');
    }
    /**
     * Reporte de evluacion de diagramas
     *
     * @param Proyecto $proyecto
     * @return Illuminate\Http\Response
     */
    public function modelacion(Proyecto $proyecto)
    {
        $documentos = $proyecto->documentos()
            ->with('tipo', 'evaluaciones.componente', 'evaluaciones.evaluador')->get();
        $total = (new Calificaciones($proyecto))->modelacion();
        $pdf = PDF::loadView('pdf.modelacion', compact('proyecto', 'documentos', 'total'));
        return $pdf->stream('modelacion.pdf');
    }

    /**
     * Reporte de usuarios registrados en la plataforma
     *
     * @return Illuminate\Http\Response
     */
    public function usuarios()
    {
        $pdf = PDF::loadView('pdf.usuarios', ['usuarios' => User::limit(50)->get()]);
        return $pdf->stream('usuarios.pdf');
    }
    public function scripts(Proyecto $proyecto )
    {
        $scripts = $proyecto->scripts()->with('items')->get();
        $calificacion=new Calificaciones($proyecto);
        $nota=$calificacion->codificacion();
        $pdf = PDF::loadView('pdf.codificacion', compact('proyecto', 'scripts','nota'));
        return $pdf->stream('codificacion.pdf');
        
    }

    public function basedatos(Proyecto $proyecto)
    {
        $sql = $proyecto->sql->load('componentes');
        $promedio = $sql->componentes->filter(function($componente, $index){
            return $componente->pivot->total > 0;
        })->avg("pivot.calificacion");

        $promedio = round($promedio);
        $pdf = PDF::loadView('pdf.basedatos', compact('proyecto', 'sql','promedio'));
        //return view('pdf.basedatos', compact('proyecto', 'sql'));
        return $pdf->stream('basedatos.pdf');
    }

    public function plataforma(Proyecto $proyecto) {
        $casos = $proyecto->casoPruebas()->with('pruebas')->get();
        $total = round($casos->avg('calificacion'));
        $pdf = PDF::loadView('pdf.plataforma', compact('casos', 'total', 'proyecto'));
        return $pdf->stream('plataforma.pdf');
    }

    public function total(Proyecto $proyecto) {
        $calificaciones = new Calificaciones($proyecto);
        $payload = $calificaciones->global();
        $payload['proyecto'] = $proyecto;
        $pdf = PDF::loadView('pdf.global', $payload);
        return $pdf->stream('resultados.pdf');
    } 
    public function resultados($usuario) {

            $consulta = DB::table('TBL_Indicadores')
            ->join('TBL_Preguntas','TBL_Preguntas.FK_IndicadorId', '=', 'TBL_Indicadores.PK_id')
            ->join('TBL_Pruebas','TBL_Pruebas.FK_PreguntaId', '=', 'TBL_Preguntas.PK_id')
            ->join('TBL_Usuarios','TBL_Pruebas.FK_UsuarioId', '=', 'TBL_Usuarios.PK_id')
            ->select('TBL_Indicadores.metaIndicador','TBL_Pruebas.respuestaUsuario','TBL_Indicadores.nombreIndicador', 'TBL_Indicadores.limite', 'TBL_Indicadores.PK_id')
            ->where('TBL_Pruebas.FK_UsuarioId','=',$usuario)->get();
        foreach ($consulta as &$valor) {
            $malo = Planes::all()->where('estado',"malo")->where('FK_IndicadorId',$valor->PK_id)->first();
            $valor->malo= $malo->umbral;
            $regular = Planes::all()->where('estado',"regular")->where('FK_IndicadorId',$valor->PK_id)->first();
            $valor->regular= $regular->umbral;
            $excelente = Planes::all()->where('estado',"excelente")->where('FK_IndicadorId',$valor->PK_id)->first();
            $valor->excelente= $excelente->umbral;

            $rUsuario = $valor->respuestaUsuario;

            
            if($rUsuario <= $malo->umbral ){
                $valor->plan= Planes::where('FK_IndicadorId',$valor->PK_id)->where('umbral', $malo->umbral)->first()->recomendacion;
                $valor->color = "#a80303";
            };

            if($rUsuario > $malo->umbral and $rUsuario <= $regular->umbral ){
                $valor->plan= Planes::where('FK_IndicadorId',$valor->PK_id)->where('umbral', $regular->umbral)->first()->recomendacion;
                $valor->color = "#969601";
            };

            if( $rUsuario > $regular->umbral  ){
                $valor->plan= Planes::where('FK_IndicadorId',$valor->PK_id)->where('umbral', $excelente->umbral)->first()->recomendacion;
                $valor->color = "#01960b";
            }
        }
        $pdf = PDF::loadView('pdf.resultados', ['resultados' => $consulta]);
        
        return $pdf->stream('resultados.pdf');
    }    
}
