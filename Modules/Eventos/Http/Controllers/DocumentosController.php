<?php

namespace Modules\Eventos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Eventos\Models\DocumentoEvento;

class DocumentosController extends Controller
{
    /**
     * Mostrar lista de documentos asociados a eventos.
     */
    public function index()
    {
        $documentos = DocumentoEvento::with('evento')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('eventos::documentos.index', compact('documentos'));
    }

    /**
     * Mostrar formulario de carga de documento.
     */
    public function create()
    {
        return view('eventos::documentos.create');
    }

    /**
     * Guardar un nuevo documento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'archivo' => 'required|file|max:5120', // 5MB
        ]);

        $path = $request->file('archivo')->store('documentos_eventos', 'public');

        DocumentoEvento::create([
            'evento_id' => $request->evento_id,
            'nombre' => $request->file('archivo')->getClientOriginalName(),
            'ruta' => $path,
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento cargado correctamente.');
    }

    /**
     * Ver detalles del documento.
     */
    public function show($id)
    {
        $documento = DocumentoEvento::findOrFail($id);
        return view('eventos::documentos.show', compact('documento'));
    }

    /**
     * Eliminar un documento.
     */
    public function destroy($id)
    {
        $documento = DocumentoEvento::findOrFail($id);
        \Storage::disk('public')->delete($documento->ruta);
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado correctamente.');
    }
}
