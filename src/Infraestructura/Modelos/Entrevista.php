<?php

namespace Mod2Nur\Infraestructura\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
require_once __DIR__ . '/../../../env.php';

class Entrevista extends Model
{
    protected $table = 'Entrevista';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'paciente_id', 'fechaRealizacion'];
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

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'id');
    }
}
