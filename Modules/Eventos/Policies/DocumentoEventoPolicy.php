<?php

namespace Modules\Eventos\Policies;

use App\Models\User;
use Modules\Eventos\Models\DocumentoEvento;

class DocumentoEventoPolicy
{
    /**
     * Ver documentos
     */
    public function view(User $user, DocumentoEvento $documento): bool
    {
        return true;
    }

    /**
     * Descargar documentos
     */
    public function download(User $user, DocumentoEvento $documento): bool
    {
        return true;
    }

    /**
     * Eliminar documentos
     */
    public function delete(User $user, DocumentoEvento $documento): bool
    {
        return $user->hasRole('Admin') || $user->id === $documento->user_id;
    }
}
