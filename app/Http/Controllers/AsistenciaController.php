<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Beneficiario;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $fecha  = $request->get('fecha', today()->toDateString());
        $evento = $request->get('evento', 'General');
        $buscar = $request->get('buscar', '');

        $query = Beneficiario::where('estado', 'Activo')
            ->orderBy('apellido_paterno');

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                  ->orWhere('apellido_paterno', 'like', "%$buscar%")
                  ->orWhere('apellido_materno', 'like', "%$buscar%");
            });
        }

        $beneficiarios = $query->get();

        $asistencias = Asistencia::where('fecha', $fecha)
            ->where('evento', $evento)
            ->pluck('presente', 'beneficiario_id');

        $visitantes = Visitante::where('fecha', $fecha)
            ->where('evento', $evento)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPresentes = $asistencias->filter(fn($v) => $v)->count();

        $eventos = Asistencia::select('evento')
            ->distinct()
            ->orderBy('evento')
            ->pluck('evento');

        return view('asistencia.index', compact(
            'beneficiarios', 'asistencias', 'visitantes',
            'fecha', 'evento', 'eventos', 'buscar', 'totalPresentes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'         => 'required|date',
            'evento'        => 'required|string|max:150',
            'asistencias'   => 'nullable|array',
        ]);

        $fecha  = $request->fecha;
        $evento = $request->evento;

        $beneficiarios = Beneficiario::where('estado', 'Activo')->pluck('id');
        $datos         = $request->input('asistencias', []);

        foreach ($beneficiarios as $id) {
            $presente = isset($datos[$id]) && $datos[$id] === '1';
            Asistencia::updateOrCreate(
                ['beneficiario_id' => $id, 'fecha' => $fecha, 'evento' => $evento],
                ['presente' => $presente]
            );
        }

        return redirect()->route('asistencia.index', ['fecha' => $fecha, 'evento' => $evento])
            ->with('success', 'Asistencia guardada correctamente.');
    }

    public function storeVisitante(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'fecha'  => 'required|date',
            'evento' => 'required|string|max:150',
        ]);

        Visitante::create($request->only('nombre', 'fecha', 'evento'));

        return redirect()->route('asistencia.index', [
            'fecha'  => $request->fecha,
            'evento' => $request->evento,
        ])->with('success', 'Visitante agregado.');
    }

    public function destroyVisitante(Visitante $visitante)
    {
        $fecha  = $visitante->fecha->toDateString();
        $evento = $visitante->evento;
        $visitante->delete();

        return redirect()->route('asistencia.index', compact('fecha', 'evento'))
            ->with('success', 'Visitante eliminado.');
    }

    public function historial(Request $request)
    {
        $mes = $request->get('mes', now()->format('Y-m'));

        $registros = Asistencia::with('beneficiario')
            ->select('fecha', 'evento',
                \DB::raw('COUNT(*) as total'),
                \DB::raw('SUM(presente) as presentes')
            )
            ->groupBy('fecha', 'evento')
            ->whereRaw("strftime('%Y-%m', fecha) = ?", [$mes])
            ->orderByDesc('fecha')
            ->paginate(20)
            ->withQueryString();

        return view('asistencia.historial', compact('registros', 'mes'));
    }

    public function personas(Request $request)
    {
        $fecha  = $request->get('fecha', today()->toDateString());
        $evento = $request->get('evento', 'General');

        $lista = Asistencia::with('beneficiario')
            ->where('fecha', $fecha)
            ->where('evento', $evento)
            ->orderBy('presente', 'desc')
            ->get();

        $visitantes = Visitante::where('fecha', $fecha)
            ->where('evento', $evento)
            ->get();

        return view('asistencia.personas', compact('lista', 'visitantes', 'fecha', 'evento'));
    }

    public function pdf(Request $request)
    {
        $fecha  = $request->get('fecha', today()->toDateString());
        $evento = $request->get('evento', 'General');

        $lista = Asistencia::with('beneficiario')
            ->where('fecha', $fecha)
            ->where('evento', $evento)
            ->orderBy('presente', 'desc')
            ->get();

        $visitantes = Visitante::where('fecha', $fecha)
            ->where('evento', $evento)
            ->get();

        $pdf = Pdf::loadView('asistencia.pdf', compact('lista', 'visitantes', 'fecha', 'evento'))
            ->setPaper('letter', 'portrait');

        return $pdf->download("asistencia_{$fecha}.pdf");
    }
}
