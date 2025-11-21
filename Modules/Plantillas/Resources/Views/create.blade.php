@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">➕ Crear Plantilla</h1>

    <form action="{{ route('plantillas.store') }}" method="POST">
        @csrf

        @include('plantillas::partials.form')

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('plantillas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
        </div>
    </form>
</div>
@endsection
