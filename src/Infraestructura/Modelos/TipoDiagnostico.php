<?php

namespace Mod2Nur\Infraestructura\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
require_once __DIR__ . '/../../../env.php';

class TipoDiagnostico extends Model
{
    protected $table = 'TipoDiagnostico';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'descripcion'];
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
        return $this->hasMany(Diagnostico::class, 'tipoDiagnostico_id', 'id');
    }
}
