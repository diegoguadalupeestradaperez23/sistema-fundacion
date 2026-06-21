<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size:11px; color:#1a1a1a; background:#fff; }
        .header { text-align:center; padding:20px 0 14px; border-bottom:2px solid #4f46e5; margin-bottom:16px; }
        .header h1 { font-size:18px; color:#4f46e5; font-weight:700; }
        .header p { font-size:11px; color:#6b7280; margin-top:4px; }
        .meta { display:flex; gap:16px; margin-bottom:16px; flex-wrap:wrap; }
        .meta-item { background:#f3f4f6; border-radius:6px; padding:6px 12px; font-size:11px; }
        .meta-item strong { color:#1a1a1a; }
        table { width:100%; border-collapse:collapse; margin-top:8px; }
        thead th { background:#4f46e5; color:#fff; padding:8px 10px; text-align:left; font-size:10px; font-weight:600; letter-spacing:.5px; text-transform:uppercase; }
        tbody tr { border-bottom:1px solid #e5e7eb; }
        tbody tr:nth-child(even) { background:#f9fafb; }
        tbody td { padding:7px 10px; font-size:10.5px; color:#374151; }
        .presente { color:#16a34a; font-weight:700; }
        .ausente { color:#dc2626; font-weight:700; }
        .footer { margin-top:20px; text-align:center; font-size:10px; color:#9ca3af; border-top:1px solid #e5e7eb; padding-top:10px; }
        .stats { display:flex; gap:12px; margin-bottom:16px; }
        .stat { background:#f3f4f6; border-radius:8px; padding:10px 16px; flex:1; text-align:center; }
        .stat-num { font-size:22px; font-weight:700; color:#4f46e5; }
        .stat-label { font-size:10px; color:#6b7280; margin-top:2px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Fundación Don Benjamín</h1>
        <p>Registro de Asistencia — {{ \Carbon\Carbon::parse($fecha)->format('d \d\e F \d\e Y') }}</p>
    </div>

    <table style="width:100%;border:none;margin-bottom:16px;">
        <tr>
            <td style="padding:4px 0;font-size:11px;"><strong>Evento:</strong> {{ $evento }}</td>
            <td style="padding:4px 0;font-size:11px;text-align:right;"><strong>Generado:</strong> {{ now()->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    @php
        $presentes = $lista->where('presente', true)->count();
        $ausentes  = $lista->where('presente', false)->count();
        $total     = $lista->count();
        $pct       = $total > 0 ? round(($presentes / $total) * 100) : 0;
    @endphp

    <table style="width:100%;border:none;margin-bottom:16px;">
        <tr>
            <td style="text-align:center;background:#f0fdf4;border-radius:8px;padding:10px;border:1px solid #bbf7d0;">
                <div style="font-size:22px;font-weight:700;color:#16a34a;">{{ $presentes }}</div>
                <div style="font-size:10px;color:#16a34a;">Presentes</div>
            </td>
            <td style="width:12px;"></td>
            <td style="text-align:center;background:#fef2f2;border-radius:8px;padding:10px;border:1px solid #fecaca;">
                <div style="font-size:22px;font-weight:700;color:#dc2626;">{{ $ausentes }}</div>
                <div style="font-size:10px;color:#dc2626;">Ausentes</div>
            </td>
            <td style="width:12px;"></td>
            <td style="text-align:center;background:#eff6ff;border-radius:8px;padding:10px;border:1px solid #bfdbfe;">
                <div style="font-size:22px;font-weight:700;color:#1d4ed8;">{{ $pct }}%</div>
                <div style="font-size:10px;color:#1d4ed8;">Asistencia</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre completo</th>
                <th>CURP</th>
                <th>Colonia</th>
                <th>Asistencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lista->sortByDesc('presente') as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->beneficiario->nombre_completo }}</td>
                    <td>{{ $a->beneficiario->curp ?? '—' }}</td>
                    <td>{{ $a->beneficiario->colonia ?? '—' }}</td>
                    <td class="{{ $a->presente ? 'presente' : 'ausente' }}">
                        {{ $a->presente ? '✓ Presente' : '✗ Ausente' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Fundación Don Benjamín — Sistema de Control Administrativo Interno
    </div>
</body>
</html>
