<?php

namespace Mod2Nur\Infraestructura\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
require_once __DIR__ . '/../../../env.php';

class TipoAnalisis extends Model
{
    protected $table = 'TipoAnalisis';
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

    public function analisisClinicos()
    {
        return $this->hasMany(AnalisisClinico::class, 'tipoAnalisis_id', 'id');
    }
}
