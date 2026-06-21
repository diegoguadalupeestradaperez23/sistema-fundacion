<x-app-layout>
    <x-slot name="header">
        <h1>Historial de Asistencia</h1>
    </x-slot>

    <style>
        .toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
        .search-group { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
        .search-input, .filter-select {
            padding:9px 14px; background:rgba(255,255,255,0.04);
            border:1px solid rgba(255,255,255,0.09); border-radius:10px;
            color:#f4f4f5; font-family:'Plus Jakarta Sans',sans-serif;
            font-size:13.5px; outline:none; transition:border-color .18s;
        }
        .search-input:focus, .filter-select:focus { border-color:rgba(99,102,241,0.5); }
        .btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; font-weight:600; cursor:pointer; text-decoration:none; border:none; transition:all .18s; }
        .btn svg { width:15px; height:15px; }
        .btn-primary { background:linear-gradient(135deg,#4f46e5,#3b82f6); color:#fff; box-shadow:0 4px 14px rgba(79,70,229,.3); }
        .btn-primary:hover { background:linear-gradient(135deg,#6366f1,#60a5fa); transform:translateY(-1px); }
        .btn-search { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.09); color:#a1a1aa; }
        .btn-search:hover { background:rgba(255,255,255,0.1); color:#e4e4e7; }
        .table-card { background:rgba(18,18,20,.8); border:1px solid rgba(255,255,255,.07); border-radius:16px; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,.3); }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        thead tr { border-bottom:1px solid rgba(255,255,255,.07); }
        thead th { padding:13px 16px; text-align:left; font-size:11.5px; font-weight:600; color:#52525b; letter-spacing:.8px; text-transform:uppercase; }
        tbody tr { border-bottom:1px solid rgba(255,255,255,.04); transition:background .15s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,.03); }
        tbody td { padding:13px 16px; font-size:13.5px; color:#a1a1aa; }
        .td-primary { color:#e4e4e7; font-weight:600; }
        .badge { display:inline-block; padding:3px 10px; border-radius:99px; font-size:12px; font-weight:600; }
        .badge-alto { background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.2); color:#86efac; }
        .badge-medio { background:rgba(234,179,8,.1); border:1px solid rgba(234,179,8,.2); color:#fde047; }
        .badge-bajo { background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.18); color:#f87171; }
        .empty-state { text-align:center; padding:60px 20px; }
        .empty-state p { color:#52525b; font-size:14px; }
        .pagination-wrap { padding:16px; border-top:1px solid rgba(255,255,255,.06); display:flex; justify-content:center; }
        .btn-ver { padding:6px 12px; border-radius:8px; font-size:12.5px; font-weight:600; background:rgba(99,102,241,.1); border:1px solid rgba(99,102,241,.2); color:#a5b4fc; text-decoration:none; transition:all .15s; }
        .btn-ver:hover { background:rgba(99,102,241,.18); color:#c7d2fe; }
        [data-theme="light"] .table-card { background:rgba(255,255,255,.9); border-color:rgba(0,0,0,.07); box-shadow:0 8px 32px rgba(0,0,0,.06); }
        [data-theme="light"] .search-input,[data-theme="light"] .filter-select { background:rgba(0,0,0,.03); border-color:rgba(0,0,0,.1); color:#18181b; }
        [data-theme="light"] .btn-search { background:rgba(0,0,0,.04); border-color:rgba(0,0,0,.1); color:#52525b; }
        [data-theme="light"] thead th { color:#71717a; }
        [data-theme="light"] thead tr { border-bottom-color:rgba(0,0,0,.08); }
        [data-theme="light"] tbody tr { border-bottom-color:rgba(0,0,0,.05); }
        [data-theme="light"] tbody td { color:#52525b; }
        [data-theme="light"] .td-primary { color:#18181b; }
        [data-theme="light"] .pagination-wrap { border-top-color:rgba(0,0,0,.07); }
    </style>

    <div class="toolbar">
        <form class="search-group" method="GET" action="{{ route('asistencia.historial') }}">
            <input class="search-input" type="month" name="mes"
                   value="{{ request('mes', now()->format('Y-m')) }}"
                   style="width:170px;">
            <button type="submit" class="btn btn-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                Filtrar
            </button>
        </form>
        <a href="{{ route('asistencia.index') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Registrar asistencia
        </a>
    </div>

    <div class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Evento</th>
                        <th>Total</th>
                        <th>Presentes</th>
                        <th>Ausentes</th>
                        <th>% Asistencia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registros as $r)
                        @php
                            $pct     = $r->total > 0 ? round(($r->presentes / $r->total) * 100) : 0;
                            $badge   = $pct >= 75 ? 'badge-alto' : ($pct >= 40 ? 'badge-medio' : 'badge-bajo');
                            $ausentes = $r->total - $r->presentes;
                        @endphp
                        <tr>
                            <td class="td-primary">{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $r->evento }}</td>
                            <td>{{ $r->total }}</td>
                            <td><span style="color:#86efac;font-weight:600;">{{ $r->presentes }}</span></td>
                            <td><span style="color:#f87171;font-weight:600;">{{ $ausentes }}</span></td>
                            <td><span class="badge {{ $badge }}">{{ $pct }}%</span></td>
                            <td>
                                <a href="{{ route('asistencia.personas', ['fecha' => $r->fecha, 'evento' => $r->evento]) }}" class="btn-ver">
                                    Ver lista
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <p>No hay registros de asistencia para este mes.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registros->hasPages())
            <div class="pagination-wrap">{{ $registros->links() }}</div>
        @endif
    </div>
</x-app-layout>
