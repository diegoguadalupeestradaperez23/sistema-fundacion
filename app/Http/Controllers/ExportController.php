<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use App\Models\Apoyo;
use App\Models\Actividad;
use App\Models\Asistencia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function beneficiarios(Request $request)
    {
        $format = $request->get('formato', 'excel');
        $query  = Beneficiario::query();

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('buscar')) {
            $b = $request->buscar;
            $query->where(function ($q) use ($b) {
                $q->where('nombre', 'like', "%$b%")
                  ->orWhere('apellido_paterno', 'like', "%$b%")
                  ->orWhere('curp', 'like', "%$b%");
            });
        }
        if ($request->filled('tipo_periodo') && $request->filled('periodo')) {
            if ($request->tipo_periodo === 'dia') {
                $query->whereDate('created_at', $request->periodo);
            } elseif ($request->tipo_periodo === 'mes') {
                $query->whereRaw("strftime('%Y-%m', created_at) = ?", [$request->periodo]);
            }
        }

        $beneficiarios = $query->orderBy('apellido_paterno')->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.beneficiarios_pdf', compact('beneficiarios'))
                ->setPaper('letter', 'landscape');
            return $pdf->download('beneficiarios_' . now()->format('Y-m-d') . '.pdf');
        }

        return $this->csvResponse($beneficiarios->map(function ($b) {
            return [
                'ID'               => $b->id,
                'Nombre'           => $b->nombre_completo,
                'CURP'             => $b->curp ?? '',
                'Sexo'             => $b->sexo ?? '',
                'Fecha Nacimiento' => $b->fecha_nacimiento?->format('d/m/Y') ?? '',
                'Teléfono'         => $b->telefono ?? '',
                'Dirección'        => $b->direccion ?? '',
                'Colonia'          => $b->colonia ?? '',
                'Estado'           => $b->estado,
                'Registro'         => $b->created_at->format('d/m/Y'),
            ];
        }), 'beneficiarios');
    }

    public function apoyos(Request $request)
    {
        $format = $request->get('formato', 'excel');
        $apoyos = Apoyo::with('beneficiario')
            ->when($request->filled('estado'), fn($q) => $q->where('estado', $request->estado))
            ->latest('fecha_apoyo')
            ->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.apoyos_pdf', compact('apoyos'))
                ->setPaper('letter', 'landscape');
            return $pdf->download('apoyos_' . now()->format('Y-m-d') . '.pdf');
        }

        return $this->csvResponse($apoyos->map(function ($a) {
            return [
                'ID'            => $a->id,
                'Beneficiario'  => $a->beneficiario->nombre_completo,
                'Tipo de Apoyo' => $a->tipo_apoyo,
                'Fecha'         => $a->fecha_apoyo->format('d/m/Y'),
                'Monto'         => $a->monto ? number_format($a->monto, 2) : '',
                'Estado'        => $a->estado,
                'Descripción'   => $a->descripcion ?? '',
            ];
        }), 'apoyos');
    }

    public function actividades(Request $request)
    {
        $format     = $request->get('formato', 'excel');
        $actividades = \App\Models\Actividad::all();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.actividades_pdf', compact('actividades'))
                ->setPaper('letter', 'landscape');
            return $pdf->download('actividades_' . now()->format('Y-m-d') . '.pdf');
        }

        return $this->csvResponse($actividades->map(function ($a) {
            return [
                'ID'            => $a->id,
                'Título'        => $a->titulo,
                'Tipo'          => $a->tipo ?? '',
                'Fecha Inicio'  => $a->fecha_inicio->format('d/m/Y'),
                'Fecha Fin'     => $a->fecha_fin?->format('d/m/Y') ?? '',
                'Lugar'         => $a->lugar ?? '',
                'Responsable'   => $a->responsable ?? '',
                'Estado'        => $a->estado,
                'Participantes' => $a->participantes_esperados ?? '',
            ];
        }), 'actividades');
    }

    public function asistencia(Request $request)
    {
        $format = $request->get('formato', 'excel');
        $fecha  = $request->get('fecha', today()->toDateString());
        $evento = $request->get('evento', 'General');

        $lista = Asistencia::with('beneficiario')
            ->where('fecha', $fecha)
            ->where('evento', $evento)
            ->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('asistencia.pdf', compact('lista', 'fecha', 'evento'))
                ->setPaper('letter', 'portrait');
            return $pdf->download("asistencia_{$fecha}_{$evento}.pdf");
        }

        return $this->csvResponse($lista->map(function ($a) {
            return [
                'ID'           => $a->id,
                'Beneficiario' => $a->beneficiario->nombre_completo,
                'Fecha'        => $a->fecha->format('d/m/Y'),
                'Evento'       => $a->evento,
                'Presente'     => $a->presente ? 'Sí' : 'No',
            ];
        }), "asistencia_{$fecha}");
    }

    private function csvResponse($rows, string $name)
    {
        if ($rows->isEmpty()) {
            return back()->with('error', 'No hay datos para exportar.');
        }

        $headers = array_keys($rows->first());
        $csv     = implode(',', array_map(fn($h) => '"' . $h . '"', $headers)) . "\n";

        foreach ($rows as $row) {
            $csv .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', $v) . '"', $row)) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$name}_" . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
