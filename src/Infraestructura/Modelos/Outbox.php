<?php
namespace Mod2Nur\Infraestructura\Modelos;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    protected $table = 'outbox';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tipo',
        'contenido',
        'fecha_creacion',
        'fue_procesado',
        'fecha_procesamiento',
    ];

    protected $casts = [
        'contenido' => 'array',
        'fecha_creacion' => 'datetime',
        'fue_procesado' => 'boolean',
        'fecha_procesamiento' => 'datetime',
    ];
}
