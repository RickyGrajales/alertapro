<?php

namespace Modules\Eventos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Eventos\Models\DocumentoEvento;
use Modules\Eventos\Models\Event;

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

    $evento = \Modules\Eventos\Models\Event::findOrFail($evento_id);
    $usuario = auth()->user();

    // Guardar el archivo
    $archivo = $request->file('archivo');
    $nombreOriginal = $archivo->getClientOriginalName();
    $ruta = $archivo->store('documentos_evento', 'public');
    $tipo = $archivo->getClientOriginalExtension();

    // Registrar en la tabla documentos_evento
    $documento = \Modules\Eventos\Models\DocumentoEvento::create([
        'evento_id' => $evento->id,
        'user_id'   => $usuario->id,
        'nombre'    => $nombreOriginal,
        'ruta'      => $ruta,
        'tipo'      => $tipo,
    ]);

    // 🔹 REGISTRAR EN NOTIFICACION_LOGS
    \Modules\Eventos\Models\NotificacionLog::create([
        'evento_id'    => $evento->id,
        'user_id'      => $usuario->id,
        'canal'        => 'sistema',
        'destinatario' => $usuario->email ?? 'N/A',
        'mensaje'      => "📁 {$usuario->nombre} subió el documento '{$nombreOriginal}' al evento '{$evento->titulo}'.",
        'enviado_en'   => now(),
        'exitoso'      => true,
    ]);

    return redirect()
        ->back()
        ->with('success', "✅ Documento '{$nombreOriginal}' subido correctamente y registrado en auditoría.");
}

    /**
     * Descargar documento.
     */
    public function download($id)
    {
        $doc = DocumentoEvento::findOrFail($id);
        return Storage::disk('public')->download($doc->ruta, $doc->nombre);
    }

    /**
     * Eliminar documento.
     */
    public function destroy($id)
{
    $documento = DocumentoEvento::with('evento', 'usuario')->findOrFail($id);
    $usuario = auth()->user();

    // Verificar permisos (solo Admin o propietario)
    if (!$usuario->hasRole('Admin') && $usuario->id !== $documento->user_id) {
        return back()->with('error', 'No tienes permiso para eliminar este documento.');
    }

    // Eliminar físicamente el archivo si existe
    if ($documento->ruta && Storage::disk('public')->exists($documento->ruta)) {
        Storage::disk('public')->delete($documento->ruta);
    }

    // Guardar datos antes de eliminar el registro
    $nombreDoc = $documento->nombre;
    $tituloEvento = $documento->evento->titulo ?? 'Evento desconocido';

    // Eliminar el registro
    $documento->delete();

    // 🔹 Registrar en notificacion_logs
    NotificacionLog::create([
        'evento_id'    => $documento->evento_id,
        'user_id'      => $usuario->id,
        'canal'        => 'sistema',
        'destinatario' => $usuario->email ?? 'N/A',
        'mensaje'      => "🗑 {$usuario->nombre} eliminó el documento '{$nombreDoc}' del evento '{$tituloEvento}'.",
        'enviado_en'   => now(),
        'exitoso'      => true,
    ]);

    return redirect()->back()->with('success', "🗑 Documento '{$nombreDoc}' eliminado correctamente y registrado en auditoría.");
}

}
