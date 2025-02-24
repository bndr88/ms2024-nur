<?php

namespace Mod2Nur\Infraestructura\RepositoriosEloquent;

use Exception;
use Mod2Nur\Dominio\Diagnostico\Diagnostico;
use Mod2Nur\Dominio\Diagnostico\DiagnosticoRepository;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use Mod2Nur\Infraestructura\Modelos\Diagnostico as DiagnosticoModel;
use Mod2Nur\Infraestructura\Modelos\TipoDiagnostico as TipoDiagnosticoModel;

class EloquentDiagnosticoRepository implements DiagnosticoRepository
{
    public function save(Diagnostico $diagnostico): ?Diagnostico
    {
        $DiagnosticoModel = DiagnosticoModel::find($diagnostico->getId()) ?? new DiagnosticoModel();
        
        $DiagnosticoModel->id = $diagnostico->getId();
        $DiagnosticoModel->pacienteId = $diagnostico->getPaciente()->getId();
        $DiagnosticoModel->peso = $diagnostico->getPeso();
        $DiagnosticoModel->altura = $diagnostico->getAltura();
        $DiagnosticoModel->descripcion = $diagnostico->getDescripcion();
        $DiagnosticoModel->tipoDiagnostico_id = $diagnostico->getTipoDiagnostico()->getId();
        
        if ($DiagnosticoModel->save()) {
            $diagnostico->setId($DiagnosticoModel->id);
            return $diagnostico;
        }else {
            throw new Exception("Error al guardar Diagnostico");
        }
    }

    public function findById(string $id): ?Diagnostico
    {
       /* $DiagnosticoModel = DiagnosticoModel::find($id);

        if (!$DiagnosticoModel) {
            return null;
        }
        
        $tipoDiagModel = TipoDiagnosticoModel::find($DiagnosticoModel->tipoDiagnostico_id) ?? new TipoDiagnosticoModel();
        $tipoDiagnostico = new TipoDiagnostico($tipoDiagModel->id,$tipoDiagModel->descripcion);
        return new Diagnostico(
            $DiagnosticoModel->id,
            $DiagnosticoModel->paciente,
            $DiagnosticoModel->fechaDiagnostico,
            $DiagnosticoModel->peso,
            $DiagnosticoModel->altura,
            $DiagnosticoModel->composicion,
            $DiagnosticoModel->estadoDiagnostico,
            $tipoDiagnostico
        );
        */
        return null;
    }

    public function delete(string $id): void
    {
        $DiagnosticoModel = DiagnosticoModel::find($id);

        if ($DiagnosticoModel) {
            $DiagnosticoModel->delete();
        }
    }
}