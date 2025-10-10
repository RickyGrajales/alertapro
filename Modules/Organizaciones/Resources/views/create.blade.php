@extends('layouts.app')

@section('title', 'Crear Organización')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-4">➕ Crear nueva organización</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('organizaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        {{-- 🔧 Aquí estaba el error --}}
        @include('organizaciones::partials.form-fields', ['templates' => $templates])

        <div class="flex justify-end space-x-3 pt-4 border-t mt-6">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                💾 Guardar
            </button>
            <a href="{{ route('organizaciones.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded hover:bg-gray-600 transition">
                ↩️ Cancelar
            </a>
        </div>
    </form>

</div>
@endsection
