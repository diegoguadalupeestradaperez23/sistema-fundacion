<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size:10px; color:#1a1a1a; }
        .header { text-align:center; padding:16px 0 12px; border-bottom:2px solid #4f46e5; margin-bottom:14px; }
        .header h1 { font-size:16px; color:#4f46e5; font-weight:700; }
        .header p { font-size:10px; color:#6b7280; margin-top:3px; }
        table { width:100%; border-collapse:collapse; }
        thead th { background:#4f46e5; color:#fff; padding:7px 8px; text-align:left; font-size:9px; font-weight:600; text-transform:uppercase; }
        tbody tr { border-bottom:1px solid #e5e7eb; }
        tbody tr:nth-child(even) { background:#f9fafb; }
        tbody td { padding:6px 8px; font-size:9.5px; color:#374151; }
        .footer { margin-top:16px; text-align:center; font-size:9px; color:#9ca3af; border-top:1px solid #e5e7eb; padding-top:8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Fundación Don Benjamín — Actividades</h1>
        <p>Total: {{ $actividades->count() }} registros — Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Lugar</th>
                <th>Responsable</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actividades as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td>{{ $a->titulo }}</td>
                    <td>{{ $a->tipo ?? '—' }}</td>
                    <td>{{ $a->fecha_inicio->format('d/m/Y') }}</td>
                    <td>{{ $a->fecha_fin?->format('d/m/Y') ?? '—' }}</td>
                    <td>{{ $a->lugar ?? '—' }}</td>
                    <td>{{ $a->responsable ?? '—' }}</td>
                    <td>{{ $a->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Fundación Don Benjamín — Sistema de Control Administrativo Interno</div>
</body>
</html>
