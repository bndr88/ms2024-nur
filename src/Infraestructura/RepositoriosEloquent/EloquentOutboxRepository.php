<?php
namespace Mod2Nur\Infraestructura\RepositoriosEloquent;

use DateTime;
use Mod2Nur\Dominio\Outbox\OutboxMessage;
use Mod2Nur\Dominio\Outbox\OutboxRepository;
use Mod2Nur\Infraestructura\Modelos\Outbox;

class EloquentOutboxRepository implements OutboxRepository
{
    public function guardar(OutboxMessage $mensaje): ?OutboxMessage
    {
        $outboxModel = new Outbox();

        $outboxModel->id = $mensaje->id;
        $outboxModel->tipo = $mensaje->tipo;
        $outboxModel->contenido = $mensaje->contenido;
        $outboxModel->fecha_creacion = $mensaje->fechaCreacion->format('Y-m-d H:i:s');
        $outboxModel->fue_procesado = $mensaje->fueProcesado;
        $outboxModel->fecha_procesamiento = $mensaje->fechaProcesamiento?->format('Y-m-d H:i:s');

        if ($outboxModel->save()) {
            return new OutboxMessage(
                id: $outboxModel->id,
                tipo: $outboxModel->tipo,
                contenido: $outboxModel->contenido,
                fechaCreacion: new DateTime($outboxModel->fecha_creacion),
                fueProcesado: $outboxModel->fue_procesado,
                fechaProcesamiento: $outboxModel->fecha_procesamiento
                    ? new DateTime($outboxModel->fecha_procesamiento)
                    : null
            );
        }

        return null;
    }
}

