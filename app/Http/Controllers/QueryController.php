<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;

class QueryController extends Controller
{
    /*
    Función: Genera un reporte mensual de todas las impresiones realizadas en el plantel.
    */
    public function reporteGeneralMensual(Request $request)
    {
        $request->validate([
            'fecha_reporte' => 'date',
        ]);

        $fechaReporte = $request->input('fecha_reporte');
        $fecha = Carbon::parse($fechaReporte);

        $month = $fecha->month;
        $year = $fecha->year;

        // Datos De Licenciaturas
        $totales_licenciatura = DB::table('impressions')
            ->join('users', 'impressions.user_id', '=', 'users.id')
            ->select(
                'users.licenciatura',
                DB::raw('SUM(impressions.coste_impresion) AS total_gastado_por_licenciatura'),
                DB::raw('COUNT(*) AS total_impresiones_por_licenciatura'),
                DB::raw('SUM(impressions.total_hojas) AS total_hojas_por_licenciatura')
            )
            ->whereYear('fecha_impresion', $year)
            ->whereMonth('fecha_impresion', $month)
            ->groupBy('users.licenciatura')
            ->get();

        // Datos Generales
        $totales_generales = DB::table(function ($query) use ($year, $month) {
            $query->select(
                'users.licenciatura',
                DB::raw('SUM(impressions.coste_impresion) AS total_gastado_por_licenciatura'),
                DB::raw('COUNT(*) AS total_impresiones_por_licenciatura'),
                DB::raw('SUM(impressions.total_hojas) AS total_hojas_por_licenciatura')
            )
                ->from('impressions')
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->whereYear('fecha_impresion', $year)
                ->whereMonth('fecha_impresion', $month)
                ->groupBy('users.licenciatura');
        }, 'subconsulta')
            ->select(
                DB::raw('SUM(total_gastado_por_licenciatura) AS total_gastado_todas_licenciaturas'),
                DB::raw('SUM(total_impresiones_por_licenciatura) AS total_impresiones_todas_licenciaturas'),
                DB::raw('SUM(total_hojas_por_licenciatura) AS total_hojas_todas_licenciaturas')
            )
            ->get();

        // Datos De Tipo De Impresión
        $impresiones = DB::table('impressions')
            ->select('color', DB::raw('COUNT(*) as tipo_color'))
            ->whereMonth('fecha_impresion', '=', $month)
            ->whereYear('fecha_impresion', '=', $year)
            ->groupBy('color')
            ->get();


        $pdf = PDF::loadView('PDF.reporte-general-mensual', compact('month', 'year', 'totales_licenciatura', 'totales_generales', 'impresiones'));

        $nombrePDF = 'Reporte Mensual ' . $month . ' De ' . $year . '.pdf';

        return $pdf->download($nombrePDF);
    }

    /*
    Función: Genera un reporte de las impresiones realizadas por una licenciatura en especifico.
    */
    public function reporteLicenciatura(Request $request)
    {
        $licenciatura = $request->input('licenciatura_reporte');

        // Datos Personales De Usuarios
        $historial = DB::table('impressions')
            ->join('users', 'impressions.user_id', '=', 'users.id')
            ->select(
                'impressions.user_id',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno',
                DB::raw('SUM(coste_impresion) AS suma_total_gastado'),
                DB::raw('SUM(impressions.total_hojas) AS suma_total_hojas')
            )
            ->where('users.licenciatura', $licenciatura)
            ->groupBy(
                'impressions.user_id',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno'
            )
            ->get();

        // Datos De Impresiones Por Cada Usuario
        $totales = DB::table(function ($query) use ($licenciatura) {
            $query->select(
                'user_id',
                DB::raw('SUM(coste_impresion) AS suma_total_gastado'),
                DB::raw('SUM(total_hojas) AS suma_total_hojas')
            )
                ->from('impressions')
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->where('users.licenciatura', $licenciatura)
                ->groupBy('user_id')
                ->get();
        }, 'subconsulta')
            ->select(
                DB::raw('SUM(suma_total_gastado) AS suma_general_total_gastado'),
                DB::raw('SUM(suma_total_hojas) AS suma_general_total_hojas')
            )
            ->get();

        // Datos De Tipo De Impresión
        $impresiones = DB::table('impressions')
            ->select('color', DB::raw('COUNT(*) as tipo_color'))
            ->join('users', 'impressions.user_id', '=', 'users.id')
            ->where('users.licenciatura', $licenciatura)
            ->groupBy('color')
            ->get();

        $pdf = PDF::loadView('PDF.reporte-licenciatura', compact('licenciatura', 'historial', 'totales', 'impresiones'));

        $nombrePDF = 'Reporte De ' . $licenciatura . '.pdf';

        return $pdf->download($nombrePDF);
    }

    /*
    Función: Genera un reporte de las impresiones realizadas por un usuario en especifico.
    */
    public function reporteIndividual(Request $request)
    {
        $errors = new MessageBag();

        $matricula = $request->input('matricula_reporte');

        $usuario = User::where('matricula', $matricula)->first();

        if ($usuario) {
            // Datos Generales De Impresiones
            $totales = DB::table('impressions')
                ->select(DB::raw('SUM(impressions.coste_impresion) AS suma_total_gastado, SUM(impressions.total_hojas) AS suma_total_hojas'))
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->where('users.matricula', $matricula)
                ->get();

            // Datos Personales Del Usuario
            $historial = DB::table('users')
                ->join('impressions', 'users.id', '=', 'impressions.user_id')
                ->where('users.matricula', '=', $matricula)
                ->select('users.matricula', 'users.name', 'users.apellido_paterno', 'users.apellido_materno', 'users.licenciatura', 'impressions.impresora', 'impressions.total_hojas', 'impressions.fecha_impresion', 'impressions.coste_impresion')
                ->get();

            // Datos De Tipo De Impresión
            $impresiones = DB::table('impressions')
                ->select('color', DB::raw('COUNT(*) as tipo_color'))
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->where('users.matricula', $matricula)
                ->groupBy('color')
                ->get();
        } else {
            $errors->add('Error', 'La matrícula que ingresaste no se encuentra en los registros.');

            return redirect()->back()->withErrors($errors);
        }

        $pdf = PDF::loadView('PDF.reporte-individual', compact('historial', 'totales', 'impresiones', 'usuario'));

        $nombrePDF = 'Reporte De ' . $usuario->name . '.pdf';

        return $pdf->download($nombrePDF);
    }

    /*
    Función: Muestra las últimas 8 impresiones realizadas por un usuario.
    */
    public function historialImpresiones()
    {
        $id = Auth::user()->id;

        $usuario = User::find($id);

        // Historico Usuario
        $historial = DB::table('users')
            ->join('impressions', 'users.id', '=', 'impressions.user_id')
            ->where('users.id', '=', $usuario->id)
            ->select('impressions.color', 'impressions.impresora', 'impressions.total_hojas', 'impressions.fecha_impresion', 'impressions.coste_impresion')
            ->orderByDesc('impressions.fecha_impresion')
            ->take(10)
            ->get();

        return view('historial', compact('historial'));
    }
}