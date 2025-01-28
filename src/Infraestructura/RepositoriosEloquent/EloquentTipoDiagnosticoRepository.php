<?php

namespace Mod2Nur\Infraestructura\RepositoriosEloquent;

use Mod2Nur\Dominio\Abstracciones\AggregateRoot;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnosticoRepository;
use Mod2Nur\Infraestructura\Modelos\TipoDiagnostico as TipoDiagModel;

class EloquentTipoDiagnosticoRepository implements TipoDiagnosticoRepository {
    
    public function save(TipoDiagnostico $tipoDiagnostico): bool
    {
        $TipoDiagModel = TipoDiagModel::find($tipoDiagnostico->getId()) ?? new TipoDiagModel();

        $TipoDiagModel->id = $tipoDiagnostico->getId();
        $TipoDiagModel->descripcion = $tipoDiagnostico->getDescripcion();

        return $TipoDiagModel->save();
    }

    public function findById(string $id): ?TipoDiagnostico { 
        $tipoDiagModel = TipoDiagModel::find($id);
        if (!$tipoDiagModel) {
            return null;
        }

        return new TipoDiagnostico(
            $tipoDiagModel->id,
            $tipoDiagModel->descripcion
        );
    }

    public function remove(string $id): bool
    {
        $tipoDiagModel = TipoDiagModel::find($id);
        if ($tipoDiagModel) {
            return $tipoDiagModel->delete();
        }
    }
}