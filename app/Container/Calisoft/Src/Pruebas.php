<?php

namespace App\Container\Calisoft\Src;

use Illuminate\Database\Eloquent\Model;

class Pruebas extends Model
{
    protected $table = "TBL_Pruebas";
    protected $primaryKey = "PK_id";
    protected $fillable = [
        'respuestaUsuario','FK_UsuarioId','FK_PreguntaId',
        'calificacion'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function Usuario()
    {
        return $this->belongsTo(User::class, 'FK_UsuarioId', 'PK_id');
    }

    public function pregunta()
    {
        return $this->belongsTo(Preguntas::class, 'FK_PreguntaId', 'PK_id');
    }
}
