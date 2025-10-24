@component('mail::message')
# 📅 Recordatorio de evento

Hola **{{ $notifiable->nombre }}**,  
Te recordamos que el evento **{{ $evento->titulo }}** vence el **{{ $evento->due_date->format('d/m/Y') }}**.

@component('mail::button', ['url' => url('/eventos/' . $evento->id)])
Ver evento
@endcomponent

Gracias,  
**Equipo AlertaPro**
@endcomponent
