<x-app-layout>
    <x-slot name="header">
        <h1>Asistencia</h1>
    </x-slot>

    <style>
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }
        .search-group { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .search-input, .filter-select {
            padding: 9px 14px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 10px;
            color: #f4f4f5;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.18s;
        }
        .search-input:focus, .filter-select:focus { border-color: rgba(99,102,241,0.5); }
        .filter-select option { background: #18181a; }
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none; transition: all 0.18s;
        }
        .btn svg { width: 15px; height: 15px; }
        .btn-primary { background: linear-gradient(135deg,#4f46e5,#3b82f6); color:#fff; box-shadow:0 4px 14px rgba(79,70,229,0.3); }
        .btn-primary:hover { background: linear-gradient(135deg,#6366f1,#60a5fa); transform:translateY(-1px); }
        .btn-search { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.09); color:#a1a1aa; }
        .btn-search:hover { background:rgba(255,255,255,0.1); color:#e4e4e7; }
        .btn-historial { background:rgba(99,102,241,0.1); border:1px solid rgba(99,102,241,0.2); color:#a5b4fc; }
        .btn-historial:hover { background:rgba(99,102,241,0.18); color:#c7d2fe; }
        .btn-pdf { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#f87171; }
        .btn-pdf:hover { background:rgba(239,68,68,0.18); }
        .alert { display:flex; align-items:center; gap:8px; padding:12px 16px; border-radius:10px; font-size:13.5px; margin-bottom:20px; }
        .alert-success { background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2); color:#86efac; }
        .table-card { background:rgba(18,18,20,0.8); border:1px solid rgba(255,255,255,0.07); border-radius:16px; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,0.3); }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        thead tr { border-bottom:1px solid rgba(255,255,255,0.07); }
        thead th { padding:13px 16px; text-align:left; font-size:11.5px; font-weight:600; color:#52525b; letter-spacing:.8px; text-transform:uppercase; }
        tbody tr { border-bottom:1px solid rgba(255,255,255,0.04); transition:background 0.15s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,0.03); }
        tbody td { padding:12px 16px; font-size:13.5px; color:#a1a1aa; }
        .td-name { color:#e4e4e7; font-weight:600; }
        .checkbox-cell { text-align:center; }
        .asistencia-check {
            width:20px; height:20px; accent-color:#6366f1; cursor:pointer;
            transform:scale(1.2);
        }
        .form-actions {
            padding:16px 20px; border-top:1px solid rgba(255,255,255,0.06);
            display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;
        }
        .counter { font-size:13px; color:#71717a; }
        .counter span { color:#a5b4fc; font-weight:600; }
        .empty-state { text-align:center; padding:60px 20px; }
        .empty-state svg { width:40px; height:40px; color:#3f3f46; margin-bottom:12px; }
        .empty-state p { color:#52525b; font-size:14px; }
        [data-theme="light"] .table-card { background:rgba(255,255,255,0.9); border-color:rgba(0,0,0,0.07); box-shadow:0 8px 32px rgba(0,0,0,0.06); }
        [data-theme="light"] .search-input, [data-theme="light"] .filter-select { background:rgba(0,0,0,0.03); border-color:rgba(0,0,0,0.1); color:#18181b; }
        [data-theme="light"] .filter-select option { background:#fff; }
        [data-theme="light"] .btn-search { background:rgba(0,0,0,0.04); border-color:rgba(0,0,0,0.1); color:#52525b; }
        [data-theme="light"] thead th { color:#71717a; }
        [data-theme="light"] thead tr { border-bottom-color:rgba(0,0,0,0.08); }
        [data-theme="light"] tbody tr { border-bottom-color:rgba(0,0,0,0.05); }
        [data-theme="light"] tbody td { color:#52525b; }
        [data-theme="light"] .td-name { color:#18181b; }
        [data-theme="light"] .form-actions { border-top-color:rgba(0,0,0,0.07); }
        [data-theme="light"] .counter { color:#71717a; }
    </style>

    @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="toolbar">
        <form class="search-group" method="GET" action="{{ route('asistencia.index') }}">
            <input class="search-input" type="date" name="fecha" value="{{ $fecha }}" style="width:160px;">
            <select class="filter-select" name="evento">
                <option value="General" {{ $evento === 'General' ? 'selected' : '' }}>General</option>
                @foreach($eventos as $ev)
                    @if($ev !== 'General')
                        <option value="{{ $ev }}" {{ $evento === $ev ? 'selected' : '' }}>{{ $ev }}</option>
                    @endif
                @endforeach
            </select>
            <button type="submit" class="btn btn-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                Cargar
            </button>
        </form>

        <div style="display:flex;gap:8px;">
            <a href="{{ route('asistencia.historial') }}" class="btn btn-historial">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                Historial
            </a>
            <a href="{{ route('asistencia.pdf', ['fecha' => $fecha, 'evento' => $evento]) }}" class="btn btn-pdf" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                PDF
            </a>
        </div>
    </div>

    <div class="table-card">
        @if($beneficiarios->isEmpty())
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                <p>No hay beneficiarios activos para registrar asistencia.</p>
            </div>
        @else
            <form method="POST" action="{{ route('asistencia.store') }}" id="asistencia-form">
                @csrf
                <input type="hidden" name="fecha" value="{{ $fecha }}">
                <input type="hidden" name="evento" value="{{ $evento }}">

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:50px;">
                                    <input type="checkbox" class="asistencia-check" id="select-all" title="Seleccionar todos">
                                </th>
                                <th>#</th>
                                <th>Nombre completo</th>
                                <th>CURP</th>
                                <th>Colonia</th>
                                <th>Presente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beneficiarios as $b)
                                <tr>
                                    <td class="checkbox-cell">
                                        <input type="checkbox"
                                               class="asistencia-check chk-presente"
                                               name="presentes[]"
                                               value="{{ $b->id }}"
                                               {{ isset($asistencias[$b->id]) ? ($asistencias[$b->id] ? 'checked' : '') : '' }}>
                                    </td>
                                    <td>{{ $b->id }}</td>
                                    <td class="td-name">{{ $b->nombre_completo }}</td>
                                    <td>{{ $b->curp ?? '—' }}</td>
                                    <td>{{ $b->colonia ?? '—' }}</td>
                                    <td>
                                        @if(isset($asistencias[$b->id]))
                                            @if($asistencias[$b->id])
                                                <span style="color:#86efac;font-size:12px;font-weight:600;">✓ Presente</span>
                                            @else
                                                <span style="color:#f87171;font-size:12px;font-weight:600;">✗ Ausente</span>
                                            @endif
                                        @else
                                            <span style="color:#52525b;font-size:12px;">Sin registrar</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="form-actions">
                    <p class="counter">
                        Seleccionados: <span id="count-presentes">0</span> de {{ $beneficiarios->count() }}
                    </p>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Guardar asistencia
                    </button>
                </div>
            </form>
        @endif
    </div>

    <script>
        const checkboxes = document.querySelectorAll('.chk-presente');
        const selectAll  = document.getElementById('select-all');
        const counter    = document.getElementById('count-presentes');

        function updateCount() {
            const n = document.querySelectorAll('.chk-presente:checked').length;
            if (counter) counter.textContent = n;
        }

        checkboxes.forEach(chk => chk.addEventListener('change', updateCount));

        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach(chk => chk.checked = selectAll.checked);
                updateCount();
            });
        }

        updateCount();
    </script>
</x-app-layout>
