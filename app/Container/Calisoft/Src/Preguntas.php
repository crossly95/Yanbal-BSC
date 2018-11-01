<?php

namespace App\Container\Calisoft\Src;

use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    protected $table = "TBL_Preguntas";
    protected $primaryKey = "PK_id";
    protected $fillable = [
        'pregunta', 'valorPregunta', 'respuesta','FK_IndicadorId'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function pruebas()
    {
        return $this->hasMany(Pruebas::class, 'FK_PreguntaId', 'PK_id');
    }

    public function Indicador()
    {
        return $this->belongsTo(Indicadores::class, 'FK_IndicadorId', 'PK_id');
    }


}
