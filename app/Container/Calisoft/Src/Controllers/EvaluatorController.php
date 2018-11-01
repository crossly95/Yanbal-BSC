<?php
namespace App\Container\Calisoft\Src\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container\Calisoft\Src\Proyecto;
use App\Container\Calisoft\Src\Indicadores;
use App\Container\Calisoft\Src\User;
use App\Container\Calisoft\Src\NomenclaturaBd;
use App\Container\Calisoft\Src\Script;
use App\Container\Calisoft\Src\Documento;
use App\Container\Calisoft\Src\CasoPrueba;
use App\Container\Calisoft\Src\CalificacionBD;
use App\Container\Calisoft\Src\Requests\CalificacionBDRequest;
use Illuminate\Support\Facades\DB;


class EvaluatorController extends Controller
{

    public function categorias()
    {
        return view('calisoft.evaluator.evaluator-categoria');
    }

    public function documentacion(Proyecto $proyecto)
    {
        return view('calisoft.evaluator.evaluator-modelacion', compact('proyecto'));
    }

    public function plataforma(Proyecto $proyecto)
    {
        return view('calisoft.evaluator.evaluator-plataforma', compact('proyecto'));
    }

    public function evaluar(Documento $documento)
    {
        return view('calisoft.evaluator.evaluator-docs', compact('documento'));
    }
    public function codificacion(Proyecto $proyecto)
    {
        return view('calisoft.evaluator.evaluator-codificacion', compact('proyecto'));
    }

    public function evaluarScripts(Script $script)
    {
        return view('calisoft.evaluator.evaluator-scripts',compact('script'));
    }
    public function basedatos(Proyecto $proyecto){

        return view('calisoft.evaluator.evaluator-basedatos',compact('proyecto'));
    }
//RRH
    public function rrhh(){

        return view('calisoft.evaluator.usuariosRrhh');
    }
// LLENAR INDICADOR

    public function diligenciar(Indicadores $indicador,User $usuario){

        return view('calisoft.evaluator.evaluator-diligenciar',compact('indicador','usuario'));
    }

// lleva a resultados

    public function resultados(User $usuario){

        return view('calisoft.evaluator.evaluator-resultados',compact('usuario'));
    }


    public function escenario(Proyecto $proyecto, CasoPrueba $casoPrueba)
    {
        $json = json_decode($casoPrueba->formulario);
        $save = json_decode($casoPrueba->formulario);
        $tot =0;
        $matriz[]="";
        $i=0;
        $j=0;
        foreach ($json as $regla){
            if(array_key_exists('pattern', $regla)){
                $matriz[$i]=$regla->pattern;
            }else{
                $matriz[$i]="1";
            }
            $i=$i+1;    
        }
        $matrix= json_encode($matriz);
        //Retorna el Json con la información del tipo de input seleccionado por el desarrollador
        return view('calisoft.evaluator.evaluator-escenario', compact('proyecto','casoPrueba','matrix'));
    }

    public function analizesql(Proyecto $proyecto)
    {
        $nomenclaturabd = NomenclaturaBd::
                    select('TBL_TipoNomenclatura.nomenclatura')
                          ->get();
        
        $valorItem = NomenclaturaBd::
                    select('TBL_TipoNomenclatura.valor')
                    ->get();

        $arrayItem = array();

        foreach($valorItem as $valorItems)
        {
            $arrayItem[] = $valorItems->valor;
        }

        $palabra_info = "";
        $palabra_infos = "";
        $palabra = "";
        $palabras = "";
        $totalImpostantesBD ="";
        $totalEstandarBD ="";
  
        $importantesBD = array('CREATE DATABASE','CREATE SCHEMA', 'CREATE TABLE', 'VIEWS', 'PRIMARY KEY', 'FOREIGN KEY', 'klkkñlk', 'jknkjnkjn', 'jnojhojuoi');
        $estandarBD = array();

        foreach($nomenclaturabd as $nomenbds)
        {
            $estandarBD[] = $nomenbds->nomenclatura;
        }

        $rutaArchivo = storage_path() . "/app/uploads/sql/".$proyecto->sql->url;
        $rutalecturaArchivo = file($rutaArchivo);
        $abrirArchivo=fopen($rutaArchivo, "r+");

        $obtenerArchivo = fgets($abrirArchivo);
        $leerArchivo = fread($abrirArchivo, 350000);

        foreach ($importantesBD as $i) 
        {

            $repeticion = substr_count($leerArchivo, $i); 
            $palabra_infos .= "$repeticion,";
            $array = explode(",", $palabra_infos);
            $palabras .= "$i ($repeticion)<br>";


        }

        foreach ($estandarBD as $k) 
        {
            $repeticiones = substr_count($leerArchivo, $k); 
            $palabra_info .= "$repeticiones,"; 
            $array1 = explode(",", $palabra_info);
            $palabra .= "$k ($repeticiones)<br>"; 
        }

        // array total en la calificacion
        $total = $array[0];
        $total1 = $array[1];
        $total2 = $array[2];
        $total3 = $array[3];
        $total4 = $array[4];
        $total5 = $array[5];
        $total6 = $array[6];
        $total7 = $array[7];
        $total8 = $array[8];

        // array acertadas en la calificacion
        $acertadas  = $array1[0];
        $acertadas1 = $array1[1];
        $acertadas2 = $array1[2];
        $acertadas3 = $array1[3];
        $acertadas4 = $array1[4];
        $acertadas5 = $array1[5];
        $acertadas6 = $array1[6];
        $acertadas7 = $array1[7];
        $acertadas8 = $array1[8];

        // array valor de cada item

        $valor  = $arrayItem[0];
        $valor2 = $arrayItem[1];
        $valor3 = $arrayItem[2];
        $valor4 = $arrayItem[3];
        $valor5 = $arrayItem[4];
        $valor6 = $arrayItem[5];
        $valor7 = $arrayItem[6];
        $valor8 = $arrayItem[7];
        $valor9 = $arrayItem[8];

        $CalificacionBDS = $total  == 0 ? 0 : ((($acertadas/$total)*$valor)*5)/$valor;
        $CalificacionSCH = $total1 == 0 ? 0 : ((($acertadas1/$total1)*$valor2)*5)/$valor2;
        $CalificacionTBL = $total2 == 0 ? 0 : ((($acertadas2/$total2)*$valor3)*5)/$valor3;
        $CalificacionVWS = $total3 == 0 ? 0 : ((($acertadas3/$total3)*$valor4)*5)/$valor4;
        $CalificacionPK  = $total4 == 0 ? 0 : ((($acertadas4/$total4)*$valor5)*5)/$valor5;
        $CalificacionFK  = $total5 == 0 ? 0 : ((($acertadas5/$total5)*$valor6)*5)/$valor6;
        $CalificacionPGS = $total6 == 0 ? 0 : ((($acertadas6/$total6)*$valor7)*5)/$valor7;
        $CalificacionCTB = $total7 == 0 ? 0 : ((($acertadas7/$total7)*$valor8)*5)/$valor8;
        $CalificacionPSN = $total8 == 0 ? 0 : ((($acertadas8/$total8)*$valor9)*5)/$valor9; 


        $DiCalificacionBDS = round($CalificacionBDS, 2);
        $DiCalificacionSCH = round($CalificacionSCH, 2);
        $DiCalificacionTBL = round($CalificacionTBL, 2);
        $DiCalificacionVWS = round($CalificacionVWS, 2);
        $DiCalificacionPK  = round($CalificacionPK,  2);
        $DiCalificacionFK  = round($CalificacionFK,  2);
        $DiCalificacionPGS = round($CalificacionPGS, 2);
        $DiCalificacionCTB = round($CalificacionCTB, 2);
        $DiCalificacionPSN = round($CalificacionPSN, 2);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 1, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total, 'acertadas' => $acertadas, 'calificacion' => $DiCalificacionBDS]);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 2, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total1, 'acertadas' => $acertadas1, 'calificacion' => $DiCalificacionSCH]);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 3, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total2, 'acertadas' => $acertadas2, 'calificacion' => $DiCalificacionTBL]);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 4, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total3, 'acertadas' => $acertadas3, 'calificacion' => $DiCalificacionVWS]);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 5, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total4, 'acertadas' => $acertadas4, 'calificacion' => $DiCalificacionPK]);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 6, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total5, 'acertadas' => $acertadas5, 'calificacion' => $DiCalificacionFK]);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 7, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total6, 'acertadas' => $acertadas6, 'calificacion' => $DiCalificacionPGS]);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 8, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total7, 'acertadas' => $acertadas7, 'calificacion' => $DiCalificacionCTB]);

            $sql = DB::table('TBL_CalificacionBd')
            ->where('FK_TipoNomenclaturaId' , '=', 9, 'and', 'FK_ArchivoBdId', '=', $proyecto->PK_id)
            ->update(['total' => $total8, 'acertadas' => $acertadas8, 'calificacion' => $DiCalificacionPSN]);


        return view('calisoft.evaluator.evaluator-sql',compact('proyecto'),[
            'nomenclaturabd' => $nomenclaturabd,
          ]);
    }

    
}
