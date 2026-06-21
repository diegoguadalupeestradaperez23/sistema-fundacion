<x-app-layout>
    <x-slot name="header">
        <h1>Beneficiarios</h1>
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

        .search-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

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

        .search-input { min-width: 220px; }
        .search-input::placeholder { color: #52525b; }
        .search-input:focus, .filter-select:focus { border-color: rgba(99,102,241,0.5); }
        .filter-select option { background: #18181a; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.18s;
        }

        .btn svg { width: 15px; height: 15px; }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: #fff;
            box-shadow: 0 4px 14px rgba(79,70,229,0.3);
        }
        .btn-primary:hover { background: linear-gradient(135deg, #6366f1, #60a5fa); transform: translateY(-1px); }

        .btn-search {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.09);
            color: #a1a1aa;
        }
        .btn-search:hover { background: rgba(255,255,255,0.1); color: #e4e4e7; }

        .btn-periodo {
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.2);
            color: #a5b4fc;
        }
        .btn-periodo:hover { background: rgba(99,102,241,0.18); color: #c7d2fe; }
        .btn-periodo.active { background: rgba(99,102,241,0.25); color: #c7d2fe; border-color: rgba(99,102,241,0.4); }

        .btn-pdf {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.2);
            color: #f87171;
        }
        .btn-pdf:hover { background: rgba(239,68,68,0.18); }

        .btn-excel {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.2);
            color: #86efac;
        }
        .btn-excel:hover { background: rgba(34,197,94,0.18); }

        .periodo-input {
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
        .periodo-input:focus { border-color: rgba(99,102,241,0.5); }

        /* Alerta */
        .alert {
            display: flex; align-items: center; gap: 8px;
            padding: 12px 16px; border-radius: 10px;
            font-size: 13.5px; margin-bottom: 20px;
        }
        .alert-success { background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); color: #86efac; }

        /* Tabla */
        .table-card {
            background: rgba(18,18,20,0.8);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { border-bottom: 1px solid rgba(255,255,255,0.07); }
        thead th { padding: 13px 16px; text-align: left; font-size: 11.5px; font-weight: 600; color: #52525b; letter-spacing: .8px; text-transform: uppercase; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid rgba(255,255,255,0.04); transition: background .2s, transform .2s, box-shadow .2s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,0.04); transform: translateX(3px); box-shadow: -3px 0 0 #6366f1; }
        tbody td { padding: 13px 16px; font-size: 13.5px; color: #a1a1aa; }
        .td-name { color: #e4e4e7; font-weight: 600; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 12px; font-weight: 600; }
        .badge-activo { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #86efac; }
        .badge-inactivo { background: rgba(113,113,122,0.12); border: 1px solid rgba(113,113,122,0.2); color: #71717a; }

        .actions { display: flex; gap: 6px; }
        .btn-edit { padding: 6px 12px; border-radius: 8px; font-size: 12.5px; font-weight: 600; background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.2); color: #a5b4fc; text-decoration: none; transition: all .15s; }
        .btn-edit:hover { background: rgba(99,102,241,0.18); color: #c7d2fe; }
        .btn-del { padding: 6px 12px; border-radius: 8px; font-size: 12.5px; font-weight: 600; background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.18); color: #f87171; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: all .15s; }
        .btn-del:hover { background: rgba(239,68,68,0.15); }

        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state svg { width: 40px; height: 40px; color: #3f3f46; margin-bottom: 12px; }
        .empty-state p { color: #52525b; font-size: 14px; }

        .pagination-wrap { padding: 16px; border-top: 1px solid rgba(255,255,255,0.06); display: flex; justify-content: center; }

        /* Light mode */
        [data-theme="light"] .table-card { background: rgba(255,255,255,0.9); border-color: rgba(0,0,0,0.07); box-shadow: 0 8px 32px rgba(0,0,0,0.06); }
        [data-theme="light"] .search-input, [data-theme="light"] .filter-select, [data-theme="light"] .periodo-input { background: rgba(0,0,0,0.03); border-color: rgba(0,0,0,0.1); color: #18181b; }
        [data-theme="light"] .search-input::placeholder { color: #a1a1aa; }
        [data-theme="light"] .filter-select option { background: #fff; }
        [data-theme="light"] .btn-search { background: rgba(0,0,0,0.04); border-color: rgba(0,0,0,0.1); color: #52525b; }
        [data-theme="light"] .btn-search:hover { background: rgba(0,0,0,0.07); color: #18181b; }
        [data-theme="light"] thead th { color: #71717a; }
        [data-theme="light"] thead tr { border-bottom-color: rgba(0,0,0,0.08); }
        [data-theme="light"] tbody tr { border-bottom-color: rgba(0,0,0,0.05); }
        [data-theme="light"] tbody tr:hover { background: rgba(0,0,0,0.03); }
        [data-theme="light"] tbody td { color: #52525b; }
        [data-theme="light"] .td-name { color: #18181b; }
        [data-theme="light"] .empty-state p { color: #71717a; }
        [data-theme="light"] .pagination-wrap { border-top-color: rgba(0,0,0,0.07); }
    </style>

    @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Barra de herramientas -->
    <div class="toolbar">
        <form class="search-group" method="GET" action="{{ route('beneficiarios.index') }}" id="filter-form">
            <input class="search-input" type="text" name="buscar"
                   value="{{ request('buscar') }}"
                   placeholder="Buscar por nombre, CURP o teléfono…">

            <select class="filter-select" name="estado">
                <option value="">Todos los estados</option>
                <option value="Activo"   {{ request('estado') === 'Activo'   ? 'selected' : '' }}>Activo</option>
                <option value="Inactivo" {{ request('estado') === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>

            <!-- Toggle Por Día / Por Mes -->
            <input type="hidden" name="tipo_periodo" id="tipo_periodo" value="{{ request('tipo_periodo', '') }}">

            <button type="button" id="btn-dia" class="btn btn-periodo {{ request('tipo_periodo') === 'dia' ? 'active' : '' }}"
                    onclick="togglePeriodo('dia')">
                Por Día
            </button>
            <button type="button" id="btn-mes" class="btn btn-periodo {{ request('tipo_periodo') === 'mes' ? 'active' : '' }}"
                    onclick="togglePeriodo('mes')">
                Por Mes
            </button>

            <div id="periodo-wrap" style="{{ request('tipo_periodo') ? '' : 'display:none;' }}">
                <input class="periodo-input" id="periodo-input"
                       type="{{ request('tipo_periodo') === 'mes' ? 'month' : 'date' }}"
                       name="periodo"
                       value="{{ request('periodo', request('tipo_periodo') === 'mes' ? now()->format('Y-m') : now()->format('Y-m-d')) }}">
            </div>

            <button type="submit" class="btn btn-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                Buscar
            </button>
        </form>

        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            <!-- PDF -->
            <a href="{{ route('beneficiarios.export', array_merge(request()->query(), ['formato' => 'pdf'])) }}"
               class="btn btn-pdf" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                PDF
            </a>
            <!-- Excel/CSV -->
            <a href="{{ route('beneficiarios.export', array_merge(request()->query(), ['formato' => 'excel'])) }}"
               class="btn btn-excel">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Excel
            </a>
            <!-- Nuevo -->
            <a href="{{ route('beneficiarios.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Nuevo beneficiario
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <div class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre completo</th>
                        <th>CURP</th>
                        <th>Teléfono</th>
                        <th>Colonia</th>
                        <th>Estado</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($beneficiarios as $b)
                        <tr>
                            <td>{{ $b->id }}</td>
                            <td class="td-name">{{ $b->nombre_completo }}</td>
                            <td>{{ $b->curp ?? '—' }}</td>
                            <td>{{ $b->telefono ?? '—' }}</td>
                            <td>{{ $b->colonia ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $b->estado === 'Activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                    {{ $b->estado }}
                                </span>
                            </td>
                            <td>{{ $b->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('beneficiarios.edit', $b) }}" class="btn-edit">Editar</a>
                                    <form method="POST" action="{{ route('beneficiarios.destroy', $b) }}"
                                          onsubmit="return confirm('¿Eliminar a {{ $b->nombre_completo }}? Esta acción no se puede deshacer.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-del">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                                    <p>
                                        @if(request()->hasAny(['buscar','estado','tipo_periodo']))
                                            No se encontraron beneficiarios registrados en este rango temporal.
                                        @else
                                            No hay beneficiarios registrados. <a href="{{ route('beneficiarios.create') }}" style="color:#818cf8;">Registra el primero.</a>
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($beneficiarios->hasPages())
            <div class="pagination-wrap">
                {{ $beneficiarios->links() }}
            </div>
        @endif
    </div>

    <script>
        const tipoPeriodoInput = document.getElementById('tipo_periodo');
        const periodoWrap      = document.getElementById('periodo-wrap');
        const periodoInput     = document.getElementById('periodo-input');
        const btnDia           = document.getElementById('btn-dia');
        const btnMes           = document.getElementById('btn-mes');

        function togglePeriodo(tipo) {
            const current = tipoPeriodoInput.value;

            if (current === tipo) {
                // Desactivar filtro
                tipoPeriodoInput.value = '';
                periodoWrap.style.display = 'none';
                btnDia.classList.remove('active');
                btnMes.classList.remove('active');
                return;
            }

            tipoPeriodoInput.value = tipo;
            periodoWrap.style.display = '';

            if (tipo === 'dia') {
                periodoInput.type  = 'date';
                periodoInput.value = periodoInput.value.length === 7
                    ? new Date().toISOString().split('T')[0]
                    : periodoInput.value;
                btnDia.classList.add('active');
                btnMes.classList.remove('active');
            } else {
                periodoInput.type  = 'month';
                periodoInput.value = periodoInput.value.length === 10
                    ? periodoInput.value.substring(0, 7)
                    : periodoInput.value;
                btnMes.classList.add('active');
                btnDia.classList.remove('active');
            }
        }
    </script>
</x-app-layout>
