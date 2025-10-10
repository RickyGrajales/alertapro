{{-- Modules/Organizaciones/Resources/views/partials/show-fields.blade.php --}}
<div class="grid grid-cols-1 gap-3">
    <div><strong>Nombre:</strong> {{ $organizacion->nombre }}</div>
    <div><strong>NIT:</strong> {{ $organizacion->nit }}</div>
    <div><strong>Tipo:</strong> {{ $organizacion->tipo }}</div>
    <div><strong>Representante:</strong> {{ $organizacion->representante }}</div>
    <div><strong>Email:</strong> {{ $organizacion->email }}</div>
    <div><strong>Teléfono:</strong> {{ $organizacion->telefono }}</div>
    <div><strong>Dirección:</strong> {{ $organizacion->direccion }}</div>
    <div><strong>Ciudad:</strong> {{ $organizacion->ciudad }}</div>
    <div><strong>Departamento:</strong> {{ $organizacion->departamento }}</div>
    <div><strong>Página Web:</strong> {{ $organizacion->pagina_web }}</div>
    <div><strong>Estado:</strong> {{ $organizacion->activo ? 'Activo' : 'Inactivo' }}</div>
    <div><strong>Descripción:</strong> <div class="whitespace-pre-line">{{ $organizacion->descripcion }}</div></div>
    @if($organizacion->logo)
        <div><strong>Logo:</strong><br><img src="{{ asset('storage/'.$organizacion->logo) }}" class="h-24 object-contain mt-2"></div>
    @endif
</div>
