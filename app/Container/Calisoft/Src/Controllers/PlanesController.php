<?php

namespace App\Container\Calisoft\Src\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Container\Calisoft\Src\Indicadores;
use App\Container\Calisoft\Src\Planes;

class PlanesController extends Controller
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
        $planes = Planes::create([
            'recomendacion' => $request['recomendacion'],
            'umbral' => $request['umbral'],
            'FK_IndicadorId' => $request['FK_IndicadorId'],
            'estado' => $request['estado'],
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
        $planes = Planes::all()->where('FK_IndicadorId',$id);
        return $planes;
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
    public function destroy($plan)
    {
        $plan = Planes::all()->where('PK_id',$plan)->first();
        $plan->delete();
    }
}
