<?php

namespace App\Container\Calisoft\Src;

use Illuminate\Database\Eloquent\Model;

class Indicadores extends Model
{
    protected $table = "TBL_Indicadores";
    protected $primaryKey = "PK_id";
    protected $fillable = [
        'nombreIndicador', 'tipo', 'metaIndicador','limite'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    
    public function planes() {
        return $this->hasMany(Planes::class, 'FK_IndicadorId', 'PK_id');
    }

    public function preguntas() {
        return $this->hasMany(Preguntas::class, 'FK_IndicadorId', 'PK_id');
    }

}
