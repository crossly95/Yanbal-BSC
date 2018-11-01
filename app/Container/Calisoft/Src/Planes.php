<?php

namespace App\Container\Calisoft\Src;

use Illuminate\Database\Eloquent\Model;

class Planes extends Model
{
    protected $table = "TBL_PlanMejoramiento";
    protected $primaryKey = "PK_id";
    protected $fillable = [
        'recomendacion', 'umbral','FK_IndicadorId', 'estado'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function Indicador()
    {
        return $this->belongsTo(Indicadores::class, 'FK_IndicadorId', 'PK_id');
    }

}
