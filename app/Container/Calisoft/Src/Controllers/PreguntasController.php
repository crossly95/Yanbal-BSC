<?php

namespace App\Container\Calisoft\Src\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Container\Calisoft\Src\Indicadores;
use App\Container\Calisoft\Src\Preguntas;

class PreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Indicadores $indicador)
    {
        
        
        return $pregunta;
    }

    public function qShow(Indicadores $indicador)
    {
        
        
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
        $string = "";
        for ($i=0; $i < sizeof($request['respuesta']); $i++) {
            if($i==0){
                $string = '|'.$string.$request['respuesta'][$i]['respuesta']." = ".$request['respuesta'][$i]['valor']. "|";
            }else{
                $string = $string.$request['respuesta'][$i]['respuesta']." = ".$request['respuesta'][$i]['valor']. "|";
            }
        }
        //$request['respuesta'][1]['respuesta'];
        $pregunta = Preguntas::create([
            'pregunta' => $request['pregunta'],
            'valorPregunta' => 5,
            'respuesta' => $string,
            'tipo' => 'cuatitativa',
            'FK_IndicadorId' => $request['FK_IndicadorId'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $preguntas = Preguntas::all()->where('FK_IndicadorId',$id);
        
        return $preguntas;
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
    public function destroy(Preguntas $pregunta)
    {
        $pregunta->delete();
    }
}
