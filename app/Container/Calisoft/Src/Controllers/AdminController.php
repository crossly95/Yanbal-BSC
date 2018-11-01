<?php

namespace App\Container\Calisoft\Src\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container\Calisoft\Src\TiposDocumento;
use App\Container\Calisoft\Src\Categoria;
use App\Container\Calisoft\Src\Indicadores;

class AdminController extends Controller
{

    public function semilleros()
    {
        return view('calisoft.admin.admin-semilleros');
    }

    public function categorias()
    {
        return view('calisoft.admin.admin-categorias');
    }

    public function usuarios()
    {
        return view('calisoft.admin.admin-usuarios');
    }

    public function tipoDocumento()
    {
        return view('calisoft.admin.admin-tipo-documento');
    }

    public function componentes(TiposDocumento $tdocumento)
    {
        return view('calisoft.admin.admin-componentes', compact('tdocumento'));
    }

    public function proyectos()
    {
        return view('calisoft.admin.admin-proyectos', ['categorias' => Categoria::all()]);
    }
    public function baseDatos()
    {
        return view('calisoft.admin.admin-base-datos');
    }
    public function  codificacion()
    {
        return view('calisoft.admin.admin-codificacion');
    }
    public function  indicadores()
    {
        return view('calisoft.admin.admin-indicadores');
    }
    public function  planes(Indicadores $indicador)
    {
        return view('calisoft.admin.admin-planes', compact('indicador'));
    }
}
