<?php

namespace Mod2Nur\Infraestructura\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
require_once __DIR__ . '/../../../env.php';

class AnalisisClinico extends Model
{
    protected $table = 'AnalisisClinico';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'diagnostico_id', 'tipoAnalisis_id', 'fechaRealizacion', 'observaciones', 'conclusion', 'estaConcluido'];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function diagnostico()
    {
        return $this->belongsTo(Diagnostico::class, 'diagnostico_id', 'id');
    }

    public function tipoAnalisis()
    {
        return $this->belongsTo(TipoAnalisis::class, 'tipoAnalisis_id', 'id');
    }
}
