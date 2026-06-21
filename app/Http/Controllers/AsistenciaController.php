<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Beneficiario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $fecha  = $request->get('fecha', today()->toDateString());
        $evento = $request->get('evento', 'General');

        $beneficiarios = Beneficiario::where('estado', 'Activo')
            ->orderBy('apellido_paterno')
            ->get();

        $asistencias = Asistencia::where('fecha', $fecha)
            ->where('evento', $evento)
            ->pluck('presente', 'beneficiario_id');

        $eventos = Asistencia::select('evento')
            ->distinct()
            ->orderBy('evento')
            ->pluck('evento');

        return view('asistencia.index', compact('beneficiarios', 'asistencias', 'fecha', 'evento', 'eventos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'     => 'required|date',
            'evento'    => 'required|string|max:150',
            'presentes' => 'nullable|array',
            'presentes.*' => 'exists:beneficiarios,id',
        ]);

        $fecha     = $request->fecha;
        $evento    = $request->evento;
        $presentes = collect($request->presentes ?? []);

        $beneficiarios = Beneficiario::where('estado', 'Activo')->pluck('id');

        foreach ($beneficiarios as $id) {
            Asistencia::updateOrCreate(
                ['beneficiario_id' => $id, 'fecha' => $fecha, 'evento' => $evento],
                ['presente' => $presentes->contains($id)]
            );
        }

        return redirect()->route('asistencia.index', ['fecha' => $fecha, 'evento' => $evento])
            ->with('success', 'Asistencia registrada correctamente.');
    }

    public function historial(Request $request)
    {
        $query = Asistencia::with('beneficiario')
            ->select('fecha', 'evento',
                \DB::raw('COUNT(*) as total'),
                \DB::raw('SUM(presente) as presentes')
            )
            ->groupBy('fecha', 'evento')
            ->orderByDesc('fecha');

        if ($request->filled('mes')) {
            $query->whereRaw("strftime('%Y-%m', fecha) = ?", [$request->mes]);
        }

        $registros = $query->paginate(20)->withQueryString();

        return view('asistencia.historial', compact('registros'));
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

        return view('asistencia.personas', compact('lista', 'fecha', 'evento'));
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

        $pdf = Pdf::loadView('asistencia.pdf', compact('lista', 'fecha', 'evento'))
            ->setPaper('letter', 'portrait');

        return $pdf->download("asistencia_{$fecha}_{$evento}.pdf");
    }
}
