<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recordatorio de Evento</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px;">
    <div style="background: white; padding: 20px; border-radius: 8px;">
        <h2 style="color: #2563eb;">📅 Recordatorio de Evento</h2>

        <p>Hola <strong>{{ $responsable->nombre }}</strong>,</p>

        <p>Este es un recordatorio sobre el evento:</p>

        <ul>
            <li><strong>Título:</strong> {{ $evento->titulo }}</li>
            <li><strong>Fecha límite:</strong> {{ $evento->due_date?->format('d/m/Y') }}</li>
            <li><strong>Estado:</strong> {{ $evento->estado }}</li>
        </ul>

        <p>Por favor, asegúrate de cumplir con las actividades correspondientes antes de la fecha límite.</p>

        <p style="margin-top: 20px;">Saludos,<br><strong>Equipo AlertaPro</strong></p>
    </div>
</body>
</html>
