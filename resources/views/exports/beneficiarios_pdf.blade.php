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
        thead th { background:#4f46e5; color:#fff; padding:7px 8px; text-align:left; font-size:9px; font-weight:600; text-transform:uppercase; letter-spacing:.4px; }
        tbody tr { border-bottom:1px solid #e5e7eb; }
        tbody tr:nth-child(even) { background:#f9fafb; }
        tbody td { padding:6px 8px; font-size:9.5px; color:#374151; }
        .activo { color:#16a34a; font-weight:600; }
        .inactivo { color:#6b7280; }
        .footer { margin-top:16px; text-align:center; font-size:9px; color:#9ca3af; border-top:1px solid #e5e7eb; padding-top:8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Fundación Don Benjamín — Beneficiarios</h1>
        <p>Total: {{ $beneficiarios->count() }} registros — Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre completo</th>
                <th>CURP</th>
                <th>Sexo</th>
                <th>Teléfono</th>
                <th>Colonia</th>
                <th>Estado</th>
                <th>Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beneficiarios as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->nombre_completo }}</td>
                    <td>{{ $b->curp ?? '—' }}</td>
                    <td>{{ $b->sexo ?? '—' }}</td>
                    <td>{{ $b->telefono ?? '—' }}</td>
                    <td>{{ $b->colonia ?? '—' }}</td>
                    <td class="{{ $b->estado === 'Activo' ? 'activo' : 'inactivo' }}">{{ $b->estado }}</td>
                    <td>{{ $b->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Fundación Don Benjamín — Sistema de Control Administrativo Interno</div>
</body>
</html>
