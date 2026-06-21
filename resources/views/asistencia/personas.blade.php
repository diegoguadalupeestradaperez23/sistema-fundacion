<x-app-layout>
    <x-slot name="header">
        <h1>Lista de Asistencia</h1>
    </x-slot>

    <style>
        .meta-bar { display:flex; gap:16px; margin-bottom:20px; flex-wrap:wrap; }
        .meta-item { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); border-radius:10px; padding:10px 16px; font-size:13px; color:#a1a1aa; }
        .meta-item span { color:#e4e4e7; font-weight:600; }
        .btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; font-weight:600; cursor:pointer; text-decoration:none; border:none; transition:all .18s; }
        .btn svg { width:15px; height:15px; }
        .btn-back { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.09); color:#a1a1aa; margin-bottom:20px; }
        .btn-back:hover { background:rgba(255,255,255,.1); color:#e4e4e7; }
        .btn-pdf { background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.2); color:#f87171; margin-bottom:20px; }
        .btn-pdf:hover { background:rgba(239,68,68,.18); }
        .table-card { background:rgba(18,18,20,.8); border:1px solid rgba(255,255,255,.07); border-radius:16px; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,.3); }
        table { width:100%; border-collapse:collapse; }
        thead tr { border-bottom:1px solid rgba(255,255,255,.07); }
        thead th { padding:13px 16px; text-align:left; font-size:11.5px; font-weight:600; color:#52525b; letter-spacing:.8px; text-transform:uppercase; }
        tbody tr { border-bottom:1px solid rgba(255,255,255,.04); }
        tbody tr:last-child { border-bottom:none; }
        tbody td { padding:13px 16px; font-size:13.5px; color:#a1a1aa; }
        .td-name { color:#e4e4e7; font-weight:600; }
        .badge { display:inline-block; padding:3px 10px; border-radius:99px; font-size:12px; font-weight:600; }
        .badge-presente { background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.2); color:#86efac; }
        .badge-ausente { background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.18); color:#f87171; }
        [data-theme="light"] .table-card { background:rgba(255,255,255,.9); border-color:rgba(0,0,0,.07); }
        [data-theme="light"] .meta-item { background:rgba(0,0,0,.03); border-color:rgba(0,0,0,.08); }
        [data-theme="light"] .meta-item span { color:#18181b; }
        [data-theme="light"] thead th { color:#71717a; }
        [data-theme="light"] thead tr { border-bottom-color:rgba(0,0,0,.08); }
        [data-theme="light"] tbody tr { border-bottom-color:rgba(0,0,0,.05); }
        [data-theme="light"] tbody td { color:#52525b; }
        [data-theme="light"] .td-name { color:#18181b; }
        [data-theme="light"] .btn-back { background:rgba(0,0,0,.04); border-color:rgba(0,0,0,.1); color:#52525b; }
    </style>

    <div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;">
        <a href="{{ route('asistencia.historial') }}" class="btn btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            Volver
        </a>
        <a href="{{ route('asistencia.pdf', ['fecha' => $fecha, 'evento' => $evento]) }}" class="btn btn-pdf" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            Descargar PDF
        </a>
    </div>

    <div class="meta-bar">
        <div class="meta-item">Fecha: <span>{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</span></div>
        <div class="meta-item">Evento: <span>{{ $evento }}</span></div>
        <div class="meta-item">Total: <span>{{ $lista->count() }}</span></div>
        <div class="meta-item">Presentes: <span style="color:#86efac;">{{ $lista->where('presente', true)->count() }}</span></div>
        <div class="meta-item">Ausentes: <span style="color:#f87171;">{{ $lista->where('presente', false)->count() }}</span></div>
    </div>

    <div class="table-card">
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
                @forelse($lista as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="td-name">{{ $a->beneficiario->nombre_completo }}</td>
                        <td>{{ $a->beneficiario->curp ?? '—' }}</td>
                        <td>{{ $a->beneficiario->colonia ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $a->presente ? 'badge-presente' : 'badge-ausente' }}">
                                {{ $a->presente ? '✓ Presente' : '✗ Ausente' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:40px;color:#52525b;">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
