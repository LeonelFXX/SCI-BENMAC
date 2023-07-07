<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use App\Models\Price;

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

        $fechaReporteInicial = $request->input('fecha_reporte_inicio');
        $fechaReporteFinal = $request->input('fecha_reporte_final');

        $fechaInicial = Carbon::parse($fechaReporteInicial);
        $fechaFinal = Carbon::parse($fechaReporteFinal);

        $diaInicial = $fechaInicial->day;
        $mesInicial = $fechaInicial->month;
        $añoInicial = $fechaInicial->year;

        $diaFinal = $fechaFinal->day;
        $mesFinal = $fechaFinal->month;
        $añoFinal = $fechaFinal->year;

        // Datos De Licenciaturas
        $totales_licenciatura = DB::table('impressions')
            ->join('users', 'impressions.user_id', '=', 'users.id')
            ->select(
                'users.licenciatura',
                DB::raw('SUM(impressions.coste_impresion) AS total_gastado_por_licenciatura'),
                DB::raw('COUNT(*) AS total_impresiones_por_licenciatura'),
                DB::raw('SUM(impressions.total_hojas) AS total_hojas_por_licenciatura')
            )
            ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
            ->where('impressions.pago', '=', 'Si')
            ->groupBy('users.licenciatura')
            ->get();

        // Datos Generales De Impresiones Pagadas
        $totales_generales = DB::table(function ($query) use ($fechaInicial, $fechaFinal) {
            $query->select(
                'users.licenciatura',
                DB::raw('SUM(impressions.coste_impresion) AS total_gastado_por_licenciatura'),
                DB::raw('COUNT(*) AS total_impresiones_por_licenciatura'),
                DB::raw('SUM(impressions.total_hojas) AS total_hojas_por_licenciatura')
            )
                ->from('impressions')
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
                ->where('impressions.pago', '=', 'Si')
                ->groupBy('users.licenciatura');
        }, 'subconsulta')
            ->select(
                DB::raw('SUM(total_gastado_por_licenciatura) AS total_gastado_todas_licenciaturas'),
                DB::raw('SUM(total_impresiones_por_licenciatura) AS total_impresiones_todas_licenciaturas'),
                DB::raw('SUM(total_hojas_por_licenciatura) AS total_hojas_todas_licenciaturas')
            )
            ->get();

        // Datos Generales De Impresiones No Pago
        $totales_generales_no_pago = DB::table(function ($query) use ($fechaInicial, $fechaFinal) {
            $query->select(
                'users.licenciatura',
                DB::raw('COUNT(*) AS total_impresiones_por_licenciatura'),
                DB::raw('SUM(impressions.total_hojas) AS total_hojas_por_licenciatura')
            )
                ->from('impressions')
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
                ->where('impressions.pago', '=', 'No')
                ->where('users.licenciatura', '=', 'Personal Administrativo')
                ->groupBy('users.licenciatura');
        }, 'subconsulta')
            ->select(
                DB::raw('SUM(total_impresiones_por_licenciatura) AS total_impresiones_todas_licenciaturas'),
                DB::raw('SUM(total_hojas_por_licenciatura) AS total_hojas_todas_licenciaturas')
            )
            ->get();

        // Datos De Tipo De Impresión
        $impresiones = DB::table('impressions')
            ->select('color', DB::raw('COUNT(*) as tipo_color'))
            ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
            ->groupBy('color')
            ->get();


        $pdf = PDF::loadView(
            'PDF.reporte-general-mensual',
            compact(
                'diaInicial',
                'mesInicial',
                'añoInicial',
                'diaFinal',
                'mesFinal',
                'añoFinal',
                'fechaFinal',
                'totales_licenciatura',
                'totales_generales',
                'totales_generales_no_pago',
                'impresiones'
            )
        );

        $nombrePDF = 'Reporte General ' . $diaInicial . '-' . $mesInicial . '-' . $añoInicial . ' Hasta ' . $diaFinal . '-' . $mesFinal . '-' . $añoFinal . '.pdf';

        return $pdf->download($nombrePDF);
    }

    /*
    Función: Genera un reporte de las impresiones realizadas por una licenciatura en especifico.
    */
    public function reporteLicenciatura(Request $request)
    {
        $request->validate([
            'fecha_reporte' => 'date',
        ]);

        $fechaReporteInicial = $request->input('lic_fecha_reporte_inicio');
        $fechaReporteFinal = $request->input('lic_fecha_reporte_final');

        $fechaInicial = Carbon::parse($fechaReporteInicial);
        $fechaFinal = Carbon::parse($fechaReporteFinal);

        $diaInicial = $fechaInicial->day;
        $mesInicial = $fechaInicial->month;
        $añoInicial = $fechaInicial->year;

        $diaFinal = $fechaFinal->day;
        $mesFinal = $fechaFinal->month;
        $añoFinal = $fechaFinal->year;

        $licenciatura = $request->input('licenciatura_reporte');

        $price = Price::find(1);

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
                DB::raw('COUNT(impressions.user_id) AS veces_impreso'),
                DB::raw('SUM(impressions.total_hojas) AS suma_total_hojas')
            )
            ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
            ->where('users.licenciatura', $licenciatura)
            ->where('impressions.pago', '=', 'Si')
            ->groupBy(
                'impressions.user_id',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno'
            )
            ->get();

        // Datos De Impresiones Por Cada Usuario
        $totales_generales = DB::table(function ($query) use ($licenciatura, $fechaInicial, $fechaFinal) {
            $query->select(
                'user_id',
                DB::raw('COUNT(*) AS total_impresiones_por_licenciatura'),
                DB::raw('SUM(total_hojas) AS suma_total_hojas')
            )
                ->from('impressions')
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
                ->where('users.licenciatura', $licenciatura)
                ->groupBy('user_id')
                ->get();
        }, 'subconsulta')
            ->select(
                DB::raw('SUM(total_impresiones_por_licenciatura) AS total_impresiones_todas_licenciaturas'),
                DB::raw('SUM(suma_total_hojas) AS suma_general_total_hojas')
            )
            ->get();

        // Datos De Impresiones Por Cada Usuario
        $totales = DB::table(function ($query) use ($licenciatura, $fechaInicial, $fechaFinal) {
            $query->select(
                'user_id',
                DB::raw('SUM(coste_impresion) AS suma_total_gastado'),
                DB::raw('COUNT(*) AS total_impresiones_por_licenciatura'),
                DB::raw('SUM(total_hojas) AS suma_total_hojas')
            )
                ->from('impressions')
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
                ->where('users.licenciatura', $licenciatura)
                ->where('impressions.pago', '=', 'Si')
                ->groupBy('user_id')
                ->get();
        }, 'subconsulta')
            ->select(
                DB::raw('SUM(suma_total_gastado) AS suma_general_total_gastado'),
                DB::raw('SUM(total_impresiones_por_licenciatura) AS total_impresiones_todas_licenciaturas'),
                DB::raw('SUM(suma_total_hojas) AS suma_general_total_hojas')
            )
            ->get();

        // Datos De Engargolados
        $engargolados = DB::table('bindings')
            ->select(
                DB::raw('SUM(bindings.coste_engargolado) AS total_coste_engargolados'),
                DB::raw('COUNT(bindings.id) AS suma_total_engargolados')
            )
            ->join('users', 'bindings.user_id', '=', 'users.id')
            ->whereBetween('bindings.fecha_engargolado', [$fechaInicial, $fechaFinal])
            ->where('users.licenciatura', '=', $licenciatura)
            ->where('bindings.coste_engargolado', '=', $price->engargolado)
            ->get();

        // Datos De Tipo De Impresión
        $impresiones = DB::table('impressions')
            ->select('color', DB::raw('COUNT(*) as tipo_color'))
            ->join('users', 'impressions.user_id', '=', 'users.id')
            ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
            ->where('users.licenciatura', $licenciatura)
            ->where('impressions.pago', '=', 'Si')
            ->groupBy('color')
            ->get();

        // Datos De Impresiones Por Cada Usuario
        $totales_no_pago = DB::table(function ($query) use ($licenciatura, $fechaInicial, $fechaFinal) {
            $query->select(
                'user_id',
                DB::raw('COUNT(*) AS total_impresiones_por_licenciatura'),
                DB::raw('SUM(total_hojas) AS suma_total_hojas')
            )
                ->from('impressions')
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
                ->where('users.licenciatura', $licenciatura)
                ->where('impressions.pago', '=', 'No')
                ->groupBy('user_id')
                ->get();
        }, 'subconsulta')
            ->select(
                DB::raw('SUM(total_impresiones_por_licenciatura) AS total_impresiones_todas_licenciaturas'),
                DB::raw('SUM(suma_total_hojas) AS suma_general_total_hojas')
            )
            ->get();

        // Datos De Usuarios Con Impresiones No Pago
        $historial_no_pago = DB::table('impressions')
            ->join('users', 'impressions.user_id', '=', 'users.id')
            ->select(
                'impressions.user_id',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno',
                'impressions.total_hojas',
                'impressions.descripcion',
                'impressions.fecha_impresion',
                'impressions.encargado',
            )
            ->whereBetween('fecha_impresion', [$fechaInicial, $fechaFinal])
            ->where('users.licenciatura', $licenciatura)
            ->where('impressions.pago', '=', 'No')
            ->where('impressions.estado', '=', 'Realizado')
            ->groupBy(
                'impressions.user_id',
                'users.matricula',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno',
                'impressions.total_hojas',
                'impressions.descripcion',
                'impressions.fecha_impresion',
                'impressions.encargado',
            )
            ->get();

        $pdf = PDF::loadView(
            'PDF.reporte-licenciatura',
            compact(
                'diaInicial',
                'mesInicial',
                'añoInicial',
                'diaFinal',
                'mesFinal',
                'añoFinal',
                'fechaFinal',
                'licenciatura',
                'historial',
                'totales_generales',
                'totales',
                'engargolados',
                'totales_no_pago',
                'historial_no_pago',
                'impresiones'
            )
        );

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

        $price = Price::find(1);

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
                ->select('impressions.id', 'impressions.numero_hojas', 'impressions.numero_copias', 'impressions.tamaño', 'impressions.color', 'impressions.impresora', 'impressions.total_hojas', 'impressions.engargolado', 'impressions.fecha_impresion', 'impressions.coste_impresion')
                ->get();

            // Datos De Tipo De Impresión
            $impresiones = DB::table('impressions')
                ->select('color', DB::raw('COUNT(*) as tipo_color'))
                ->join('users', 'impressions.user_id', '=', 'users.id')
                ->where('users.matricula', $matricula)
                ->groupBy('color')
                ->get();

            // Datos De Los Engargolados
            $engargolados = DB::table('bindings')
                ->select('bindings.*')
                ->join('users', 'bindings.user_id', '=', 'users.id')
                ->where('users.matricula', '=', $matricula)
                ->get();

            // Datos Totales De Engargolados
            $totales_engargolados = DB::table('bindings')
                ->select(DB::raw('SUM(bindings.coste_engargolado) AS total_gastado_engargolados'))
                ->selectRaw('COUNT(*) AS solicitudes_engargolados')
                ->join('users', 'users.id', '=', 'bindings.user_id')
                ->where('users.matricula', '=', $matricula)
                ->where('bindings.coste_engargolado', '=', $price->engargolado)
                ->get();

            // Impresiones No Pago
            $impresiones_no_pago = DB::table('impressions')
                ->select(
                    'impressions.impresora',
                    'impressions.total_hojas',
                    'impressions.fecha_impresion',
                    'impressions.engargolado',
                    'impressions.descripcion',
                    'impressions.encargado',
                    'users.matricula'
                )
                ->join('users', 'users.id', '=', 'impressions.user_id')
                ->where('users.licenciatura', '=', 'Personal Administrativo')
                ->where('impressions.pago', '=', 'No')
                ->where('impressions.estado', '=', 'Realizado')
                ->get();


        } else {
            $errors->add('Error', 'La matrícula que ingresaste no se encuentra en los registros.');

            return redirect()->back()->withErrors($errors);
        }

        $pdf = PDF::loadView('PDF.reporte-individual', compact('historial', 'totales', 'impresiones', 'usuario', 'engargolados', 'totales_engargolados', 'impresiones_no_pago'));

        $nombrePDF = 'Reporte De ' . $usuario->name . '.pdf';

        return $pdf->download($nombrePDF);
    }

    /*
    Función: Muestra las últimas 10 impresiones y recargas realizadas por un usuario.
    */
    public function historial()
    {
        $id = Auth::user()->id;

        $usuario = User::find($id);

        // Historico De Impresiones Por Usuario
        $historial = DB::table('users')
            ->join('impressions', 'users.id', '=', 'impressions.user_id')
            ->where('users.id', '=', $usuario->id)
            ->select('impressions.color', 'impressions.engargolado', 'impressions.total_hojas', 'impressions.fecha_impresion', 'impressions.coste_impresion')
            ->orderByDesc('impressions.fecha_impresion')
            ->take(10)
            ->get();

        // Historico De Recargas Por Usuario
        $recargas = DB::table('recharges')
            ->join('users', 'users.id', '=', 'recharges.user_id')
            ->where('users.id', $usuario->id)
            ->select('recharges.monto', 'recharges.fecha_recarga')
            ->orderByDesc('recharges.fecha_recarga')
            ->take(10)
            ->get();

        return view('historial', compact('historial', 'recargas'));
    }
}