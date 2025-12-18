<?php

namespace Modules\Eventos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Eventos\Models\DocumentoEvento;
use Modules\Eventos\Models\Event;
use Modules\Eventos\Models\NotificacionLog;

class DocumentosController extends Controller
{
    /**
     * Muestra todos los documentos de un evento.
     */
    public function index($eventoId)
    {
        $evento = Event::findOrFail($eventoId);

        $documentos = DocumentoEvento::where('evento_id', $eventoId)
            ->with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('eventos::documentos.index', compact('evento', 'documentos'));
    }

    /**
     * Guarda un documento asociado a un evento.
     */
    public function store(Request $request, $evento_id)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        $evento = Event::findOrFail($evento_id);
        $usuario = auth()->user();

        $archivo = $request->file('archivo');
        $nombreOriginal = $archivo->getClientOriginalName();

        // 🔐 Nombre seguro para evitar colisiones
        $nombreSeguro = time() . '_' . Str::slug(
            pathinfo($nombreOriginal, PATHINFO_FILENAME)
        );

        $extension = $archivo->getClientOriginalExtension();

        // 📂 Guardar archivo (local / S3 / Wasabi según FILESYSTEM_DISK)
        $ruta = $archivo->storeAs(
            "documentos/eventos/{$evento->id}",
            "{$nombreSeguro}.{$extension}"
        );

        // 💾 Registrar en BD
        DocumentoEvento::create([
            'evento_id' => $evento->id,
            'user_id'   => $usuario->id,
            'nombre'    => $nombreOriginal,
            'ruta'      => $ruta,
            'tipo'      => $extension,
        ]);

        // 🧾 Auditoría
        NotificacionLog::create([
            'evento_id'    => $evento->id,
            'user_id'      => $usuario->id,
            'canal'        => 'sistema',
            'destinatario' => $usuario->email ?? 'N/A',
            'mensaje'      => "📁 {$usuario->nombre} subió el documento '{$nombreOriginal}' al evento '{$evento->titulo}'.",
            'enviado_en'   => now(),
            'exitoso'      => true,
        ]);

        return back()->with(
            'success',
            "Documento '{$nombreOriginal}' subido correctamente."
        );
    }

    /**
     * Descargar documento (seguro por evento).
     */

        public function preview($evento_id, $id)
    {
        $documento = DocumentoEvento::where('id', $id)
            ->where('evento_id', $evento_id)
            ->firstOrFail();

        $usuario = auth()->user();

        // 🔒 Seguridad: solo Admin o relacionado al evento
        if (!$usuario->hasRole('Admin') && $usuario->id !== $documento->user_id) {
            abort(403, 'No tienes permiso para ver este documento.');
        }

        // 🧪 Solo PDFs
        if (strtolower($documento->tipo) !== 'pdf') {
            return back()->with('error', 'La vista previa solo está disponible para archivos PDF.');
        }

        // 📄 Mostrar PDF en navegador
        return response()->file(
            Storage::disk('public')->path($documento->ruta),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$documento->nombre.'"'
            ]
        );
    }


    

    public function download($evento_id, $id)
    {
        $doc = DocumentoEvento::where('id', $id)
            ->where('evento_id', $evento_id)
            ->firstOrFail();

        return Storage::download($doc->ruta, $doc->nombre);
    }

    /**
     * Eliminar documento (archivo + BD).
     */
    public function destroy($evento_id, $id)
    {
        $documento = DocumentoEvento::with('evento')
            ->where('id', $id)
            ->where('evento_id', $evento_id)
            ->firstOrFail();

        $usuario = auth()->user();

        // 🔐 Permisos
        if (!$usuario->hasRole('Admin') && $usuario->id !== $documento->user_id) {
            return back()->with(
                'error',
                'No tienes permiso para eliminar este documento.'
            );
        }

        // 🗑 Eliminar archivo
        if (Storage::exists($documento->ruta)) {
            Storage::delete($documento->ruta);
        }

        $nombreDoc = $documento->nombre;
        $tituloEvento = $documento->evento->titulo ?? 'Evento';

        // 🗑 Eliminar registro
        $documento->delete();

        // 🧾 Auditoría
        NotificacionLog::create([
            'evento_id'    => $evento_id,
            'user_id'      => $usuario->id,
            'canal'        => 'sistema',
            'destinatario' => $usuario->email ?? 'N/A',
            'mensaje'      => "🗑 {$usuario->nombre} eliminó el documento '{$nombreDoc}' del evento '{$tituloEvento}'.",
            'enviado_en'   => now(),
            'exitoso'      => true,
        ]);

        return back()->with(
            'success',
            "Documento '{$nombreDoc}' eliminado correctamente."
        );
    }
}
