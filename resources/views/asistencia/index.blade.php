<x-app-layout>
    <x-slot name="header">
        <h1>Asistencia</h1>
    </x-slot>

    <style>
        /* ── Toolbar ── */
        .toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:18px; }
        .search-group { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
        .field { padding:9px 13px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:#e4e4e7; font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; outline:none; transition:border-color .18s; }
        .field::placeholder { color:#52525b; }
        .field:focus { border-color:rgba(99,102,241,0.5); }
        .field-date { width:160px; }
        .field-search { width:200px; }

        .btn { display:inline-flex; align-items:center; gap:6px; padding:9px 16px; border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; font-weight:600; cursor:pointer; text-decoration:none; border:none; transition:all .18s; white-space:nowrap; }
        .btn svg { width:14px; height:14px; flex-shrink:0; }
        .btn-ghost { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#a1a1aa; }
        .btn-ghost:hover { background:rgba(255,255,255,0.1); color:#e4e4e7; }
        .btn-pdf { background:rgba(234,179,8,0.1); border:1px solid rgba(234,179,8,0.2); color:#fde047; }
        .btn-pdf:hover { background:rgba(234,179,8,0.18); }
        .btn-save { background:linear-gradient(135deg,#4f46e5,#3b82f6); color:#fff; box-shadow:0 4px 14px rgba(79,70,229,.3); }
        .btn-save:hover { background:linear-gradient(135deg,#6366f1,#60a5fa); transform:translateY(-1px); }
        .btn-mark-all { padding:7px 13px; border-radius:8px; font-size:12.5px; font-weight:600; cursor:pointer; border:none; font-family:'Plus Jakarta Sans',sans-serif; transition:all .15s; }
        .btn-mark-present { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.2); color:#86efac; }
        .btn-mark-present:hover { background:rgba(34,197,94,0.2); }
        .btn-mark-absent { background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.18); color:#f87171; }
        .btn-mark-absent:hover { background:rgba(239,68,68,0.15); }

        /* ── Alert ── */
        .alert { display:flex; align-items:center; gap:8px; padding:12px 16px; border-radius:10px; font-size:13.5px; margin-bottom:18px; }
        .alert-success { background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2); color:#86efac; }

        /* ── Counter badge ── */
        .counter-badge { display:inline-flex; align-items:center; gap:8px; padding:8px 16px; background:rgba(99,102,241,0.08); border:1px solid rgba(99,102,241,0.15); border-radius:10px; font-size:13.5px; color:#a1a1aa; margin-bottom:18px; }
        .counter-dot { width:10px; height:10px; border-radius:50%; background:#6366f1; box-shadow:0 0 6px #6366f1; flex-shrink:0; }
        .counter-num { color:#c7d2fe; font-weight:700; font-size:15px; }

        /* ── Card ── */
        .card { background:rgba(18,18,20,0.8); border:1px solid rgba(255,255,255,0.07); border-radius:16px; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,.3); margin-bottom:16px; }
        .card-header { display:flex; align-items:center; justify-content:space-between; padding:14px 18px; border-bottom:1px solid rgba(255,255,255,0.06); }
        .card-title { font-size:14px; font-weight:700; color:#e4e4e7; }
        .card-actions { display:flex; gap:8px; }

        /* ── Table ── */
        table { width:100%; border-collapse:collapse; }
        thead th { padding:11px 16px; text-align:left; font-size:11px; font-weight:600; color:#52525b; letter-spacing:.8px; text-transform:uppercase; border-bottom:1px solid rgba(255,255,255,0.06); }
        tbody tr { border-bottom:1px solid rgba(255,255,255,0.04); transition:background .15s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,0.025); }
        tbody td { padding:11px 16px; font-size:13.5px; color:#a1a1aa; }
        .td-name { color:#e4e4e7; font-weight:600; }
        .td-actions { text-align:right; }

        /* ── Presente / Ausente toggle ── */
        .toggle-wrap { display:inline-flex; border-radius:8px; overflow:hidden; border:1px solid rgba(255,255,255,0.08); }
        .btn-toggle { padding:6px 14px; font-size:12.5px; font-weight:600; cursor:pointer; border:none; font-family:'Plus Jakarta Sans',sans-serif; transition:all .15s; background:transparent; color:#52525b; }
        .btn-toggle-present.is-active { background:rgba(34,197,94,0.15); color:#86efac; }
        .btn-toggle-absent.is-active  { background:rgba(239,68,68,0.15); color:#f87171; }
        .btn-toggle:hover:not(.is-active) { background:rgba(255,255,255,0.05); color:#a1a1aa; }

        /* ── Guardar footer ── */
        .card-footer { display:flex; justify-content:flex-end; padding:14px 18px; border-top:1px solid rgba(255,255,255,0.06); }

        /* ── Visitantes ── */
        .visitor-row { display:flex; align-items:center; justify-content:space-between; padding:10px 18px; border-bottom:1px solid rgba(255,255,255,0.04); font-size:13.5px; color:#a1a1aa; }
        .visitor-row:last-child { border-bottom:none; }
        .visitor-name { color:#e4e4e7; font-weight:600; }
        .btn-del-visitor { padding:4px 10px; border-radius:6px; font-size:11.5px; font-weight:600; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.18); color:#f87171; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; }
        .btn-del-visitor:hover { background:rgba(239,68,68,0.15); }
        .visitor-input-wrap { display:flex; gap:8px; padding:14px 18px; align-items:center; }
        .visitor-input { flex:1; padding:9px 13px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:#e4e4e7; font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; outline:none; }
        .visitor-input::placeholder { color:#52525b; }
        .visitor-input:focus { border-color:rgba(99,102,241,0.5); }
        .btn-add-visitor { padding:9px 16px; border-radius:10px; font-size:13.5px; font-weight:600; background:rgba(99,102,241,0.1); border:1px solid rgba(99,102,241,0.2); color:#a5b4fc; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; white-space:nowrap; }
        .btn-add-visitor:hover { background:rgba(99,102,241,0.18); color:#c7d2fe; }

        .empty-msg { text-align:center; padding:28px; color:#52525b; font-size:13.5px; }

        /* ── Light mode ── */
        [data-theme="light"] .card { background:rgba(255,255,255,0.95); border-color:rgba(0,0,0,0.08); box-shadow:0 4px 24px rgba(0,0,0,0.07); }
        [data-theme="light"] .card-header { border-bottom-color:rgba(0,0,0,0.07); }
        [data-theme="light"] .card-title { color:#18181b; }
        [data-theme="light"] .card-footer { border-top-color:rgba(0,0,0,0.07); }
        [data-theme="light"] .field { background:rgba(0,0,0,0.03); border-color:rgba(0,0,0,0.1); color:#18181b; }
        [data-theme="light"] .field::placeholder { color:#a1a1aa; }
        [data-theme="light"] .btn-ghost { background:rgba(0,0,0,0.04); border-color:rgba(0,0,0,0.1); color:#52525b; }
        [data-theme="light"] .btn-ghost:hover { background:rgba(0,0,0,0.07); color:#18181b; }
        [data-theme="light"] thead th { color:#71717a; border-bottom-color:rgba(0,0,0,0.08); }
        [data-theme="light"] tbody tr { border-bottom-color:rgba(0,0,0,0.05); }
        [data-theme="light"] tbody td { color:#52525b; }
        [data-theme="light"] .td-name { color:#18181b; }
        [data-theme="light"] .toggle-wrap { border-color:rgba(0,0,0,0.1); }
        [data-theme="light"] .btn-toggle:hover:not(.is-active) { background:rgba(0,0,0,0.05); color:#52525b; }
        [data-theme="light"] .counter-badge { background:rgba(99,102,241,0.06); border-color:rgba(99,102,241,0.15); }
        [data-theme="light"] .counter-num { color:#4f46e5; }
        [data-theme="light"] .counter-badge { color:#52525b; }
        [data-theme="light"] .visitor-row { border-bottom-color:rgba(0,0,0,0.05); }
        [data-theme="light"] .visitor-name { color:#18181b; }
        [data-theme="light"] .visitor-row { color:#52525b; }
        [data-theme="light"] .visitor-input { background:rgba(0,0,0,0.03); border-color:rgba(0,0,0,0.1); color:#18181b; }
        [data-theme="light"] .visitor-input::placeholder { color:#a1a1aa; }
        [data-theme="light"] .empty-msg { color:#71717a; }
    </style>

    @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Barra de herramientas ── --}}
    <div class="toolbar">
        <form class="search-group" method="GET" action="{{ route('asistencia.index') }}" id="filter-form">
            <input class="field field-date" type="date" name="fecha" value="{{ $fecha }}"
                   onchange="document.getElementById('filter-form').submit()">
            <input class="field field-search" type="text" name="buscar"
                   value="{{ $buscar }}" placeholder="Nombre o apellido…">
            <button type="submit" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                Buscar
            </button>
            <input type="hidden" name="evento" value="{{ $evento }}">
        </form>

        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('asistencia.historial') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                Historial
            </a>
            <a href="{{ route('asistencia.personas', ['fecha' => $fecha, 'evento' => $evento]) }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                Por persona
            </a>
            <a href="{{ route('asistencia.pdf', ['fecha' => $fecha, 'evento' => $evento]) }}" class="btn btn-pdf" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Exportar PDF
            </a>
        </div>
    </div>

    {{-- ── Contador de presentes ── --}}
    <div class="counter-badge">
        <span class="counter-dot"></span>
        <span class="counter-num" id="count-presentes">{{ $totalPresentes }}</span>
        presentes el {{ \Carbon\Carbon::parse($fecha)->translatedFormat('d \d\e F\, Y') }}
    </div>

    {{-- ── Formulario de asistencia ── --}}
    <form method="POST" action="{{ route('asistencia.store') }}" id="form-asistencia">
        @csrf
        <input type="hidden" name="fecha"  value="{{ $fecha }}">
        <input type="hidden" name="evento" value="{{ $evento }}">

        <div class="card">
            <div class="card-header">
                <span class="card-title">Beneficiarios</span>
                <div class="card-actions">
                    <button type="button" class="btn-mark-all btn-mark-present" onclick="marcarTodos(1)">
                        Marcar todos presentes
                    </button>
                    <button type="button" class="btn-mark-all btn-mark-absent" onclick="marcarTodos(0)">
                        Marcar todos ausentes
                    </button>
                </div>
            </div>

            @if($beneficiarios->isEmpty())
                <div class="empty-msg">No hay beneficiarios activos registrados.</div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Nombre completo</th>
                            <th style="text-align:right;">Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($beneficiarios as $b)
                            @php
                                $estado = isset($asistencias[$b->id])
                                    ? ($asistencias[$b->id] ? '1' : '0')
                                    : '';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="td-name">{{ $b->nombre_completo }}</td>
                                <td class="td-actions">
                                    <input type="hidden"
                                           name="asistencias[{{ $b->id }}]"
                                           id="val-{{ $b->id }}"
                                           value="{{ $estado }}">
                                    <div class="toggle-wrap">
                                        <button type="button"
                                                class="btn-toggle btn-toggle-present {{ $estado === '1' ? 'is-active' : '' }}"
                                                onclick="setEstado({{ $b->id }}, 1, this)">
                                            Presente
                                        </button>
                                        <button type="button"
                                                class="btn-toggle btn-toggle-absent {{ $estado === '0' ? 'is-active' : '' }}"
                                                onclick="setEstado({{ $b->id }}, 0, this)">
                                            Ausente
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="card-footer">
                    <button type="submit" class="btn btn-save">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Guardar asistencia
                    </button>
                </div>
            @endif
        </div>
    </form>

    {{-- ── Visitantes del día ── --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Visitantes del día</span>
        </div>

        <div class="visitor-input-wrap">
            <form method="POST" action="{{ route('asistencia.visitante.store') }}"
                  style="display:flex;gap:8px;flex:1;" id="form-visitante">
                @csrf
                <input type="hidden" name="fecha"  value="{{ $fecha }}">
                <input type="hidden" name="evento" value="{{ $evento }}">
                <input class="visitor-input" type="text" name="nombre"
                       placeholder="Nombre del visitante…" required>
                <button type="submit" class="btn-add-visitor">+ Agregar visitante</button>
            </form>
        </div>

        @if($visitantes->isEmpty())
            <div class="empty-msg">Aún no hay visitantes registrados este día.</div>
        @else
            @foreach($visitantes as $v)
                <div class="visitor-row">
                    <span class="visitor-name">{{ $v->nombre }}</span>
                    <form method="POST" action="{{ route('asistencia.visitante.destroy', $v) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del-visitor"
                                onclick="return confirm('¿Eliminar a {{ $v->nombre }}?')">
                            Eliminar
                        </button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        function setEstado(id, val, btn) {
            document.getElementById('val-' + id).value = val;

            const wrap = btn.closest('.toggle-wrap');
            wrap.querySelectorAll('.btn-toggle').forEach(b => {
                b.classList.remove('is-active');
            });
            btn.classList.add('is-active');
            actualizarContador();
        }

        function marcarTodos(val) {
            document.querySelectorAll('[id^="val-"]').forEach(inp => {
                const id   = inp.id.replace('val-', '');
                const wrap = inp.closest('tr').querySelector('.toggle-wrap');
                if (!wrap) return;

                inp.value = val;
                wrap.querySelectorAll('.btn-toggle').forEach(b => b.classList.remove('is-active'));

                if (val === 1) {
                    wrap.querySelector('.btn-toggle-present').classList.add('is-active');
                } else {
                    wrap.querySelector('.btn-toggle-absent').classList.add('is-active');
                }
            });
            actualizarContador();
        }

        function actualizarContador() {
            const presentes = [...document.querySelectorAll('[id^="val-"]')]
                .filter(inp => inp.value === '1').length;
            const el = document.getElementById('count-presentes');
            if (el) el.textContent = presentes;
        }

        // Limpiar input de visitante tras submit
        document.getElementById('form-visitante')?.addEventListener('submit', function() {
            this.querySelector('input[name="nombre"]').value = '';
        });
    </script>
</x-app-layout>
