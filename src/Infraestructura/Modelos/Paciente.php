<?php

namespace Mod2Nur\Infraestructura\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

require_once __DIR__ . '/../../../env.php';

class Paciente extends Model
{
    protected $table = 'paciente';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'nombre', 'fechaNacimiento'];
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

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class, 'paciente_id', 'id');
    }
}
