<?php

namespace App\Container\Calisoft\Src\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Container\Calisoft\Src\Indicadores;
use App\Container\Calisoft\Src\Preguntas;
use App\Container\Calisoft\Src\Pruebas;
use App\Container\Calisoft\Src\Planes;
use App\Container\Calisoft\Src\User;
use DB;


class PruebasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $respuestas = $request['pruebas'];
        $userId = $request['userId'];
        $contador = 0;
        foreach ($respuestas as &$valor) {
            $contador = $contador + 1;
            if ($valor!=null){
                $prueba = Pruebas::create([
                    'respuestaUsuario' => $valor,
                    'FK_UsuarioId' => $userId,
                    'FK_PreguntaId' => $contador-1
                ]);
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($usuario)
    {
        
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

            if($valor->limite == 'mayor'){

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

            }else{

            
                if($rUsuario >= $malo->umbral || $rUsuario > $regular->umbral ){
                    $valor->plan= Planes::where('FK_IndicadorId',$valor->PK_id)->where('umbral', $malo->umbral)->first()->recomendacion;
                    $valor->color = "#a80303";
                };

                if($rUsuario < $malo->umbral and $rUsuario <= $regular->umbral ){
                    $valor->plan= Planes::where('FK_IndicadorId',$valor->PK_id)->where('umbral', $regular->umbral)->first()->recomendacion;
                    $valor->color = "#969601";
                };

                if( $rUsuario < $regular->umbral  ){
                    $valor->plan= Planes::where('FK_IndicadorId',$valor->PK_id)->where('umbral', $excelente->umbral)->first()->recomendacion;
                    $valor->color = "#01960b";
                }
        }
        }
        return $consulta;
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
        //
    }
}
