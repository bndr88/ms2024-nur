<?php

namespace Mod2Nur\Infraestructura\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
require_once __DIR__ . '/../../../env.php';

class Diagnostico extends Model
{
    protected $table = 'diagnostico';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'paciente_id', 'peso', 'altura', 'composicion', 'estadoDiagnostico', 'tipoDiagnostico_id'];
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

    public function tipoDiagnostico()
    {
        return $this->belongsTo(TipoDiagnostico::class, 'tipoDiagnostico_id', 'id');
    }

    public function analisisClinicos()
    {
        return $this->hasMany(AnalisisClinico::class, 'diagnostico_id', 'id');
    }
}
