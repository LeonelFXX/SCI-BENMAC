<?php

namespace App\Http\Controllers;

use App\Mail\Solicitud;
use Illuminate\Http\Request;
use App\Models\Impression;
use App\Models\User;
use App\Models\Price;
use App\Models\Binding;
use App\Models\Printer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Mail;

class ImpressionController extends Controller
{
    /*
    Función: Muestra la vista Home después de realizar una impresión.
    */
    public function mostrarVistaImpresion()
    {
        $price = Price::find(1);

        return view('home', compact('price'));
    }

    /*
    Función: Muestra la vista Precios para modificar precios.
    */
    public function mostrarVistaPrecios()
    {
        $price = Price::find(1);

        return view('impressions.precios', compact('price'));
    }

    /*
    Función: Aplica los precios que se establecieron para las impresiones.
    */
    public function aplicarPrecios(Request $request, Price $price)
    {
        $price = Price::find(1);

        $request->validate([
            'blanco_y_negro' => ['required', 'numeric'],
            'color' => ['required', 'numeric'],
            'engargolado' => ['required', 'numeric']
        ]);

        if ($request->blanco_y_negro > 0 && $request->color > 0 && $request->engargolado > 0) {
            $price->blanco_y_negro = $request->blanco_y_negro;
            $price->color = $request->color;
            $price->engargolado = $request->engargolado;
            $price->save();

            return redirect()->back()->with('success', 'Se aplicaron los precios con éxito.');
        } else {
            $errors = new MessageBag();

            $errors->add('Error', 'No se pueden guardar valores negativos.');

            return redirect()->back()->withErrors($errors);
        }

    }

    /*
    Función: Valida la configuración de la impresión a realizar.
             Hace la transacción del cobro del coste de la impresión.
    */
    public function configurarImpresion(Request $request, User $user)
    {
        $errors = new MessageBag();

        $price = Price::find(1);

        $request->validate([
            'numero_hojas' => ['required', 'numeric', 'min:0'],
            'numero_copias' => ['required', 'numeric', 'min:0'],
            'tamaño' => ['required', 'string'],
            'impresora' => ['required', 'string'],
            'sin_engargolado' => ['required_without:con_engargolado'],
            'con_engargolado' => ['required_without:sin_engargolado']
        ]);

        $printer_id = $request->input('impresora');

        $printer = Printer::find($printer_id);

        // Variables
        $usuario = Auth::user(); // Usuario En Sesión
        $id = $usuario->id; // ID
        $saldo = $usuario->saldo; // Saldo

        // Configuración De Impresión
        $numero_hojas = $request->numero_hojas; // Número De Hojas
        $numero_copias = $request->numero_copias; // Número De Copias
        $tamaño = $request->tamaño; // Tamaño
        $sin_eng = $request->input('sin_engargolado'); // Sin Engargolado
        $con_eng = $request->input('con_engargolado'); // Con Engargolado

        // Contabilidad
        $total_hojas = $numero_hojas * $numero_copias; // Total De Hojas Impresas
        $coste_impresion = null; // Total Coste De Impresión

        // Validación De Precios
        if ($printer->color == 'Color') {
            $coste_impresion += $price->color;
            $coste_impresion *= $total_hojas;
        } else if ($printer->color == 'Blanco Y Negro') {
            $coste_impresion += $price->blanco_y_negro;
            $coste_impresion *= $total_hojas;
        }

        // Validación De Engargolados
        if ($sin_eng == "1") {
            $estado = 'Sin Engargolado';
        } else if ($con_eng == "2") {
            $estado = 'Con Engargolado';
            $coste_impresion += $price->engargolado;
        }

        // Comprueba Si Cumple Con El Saldo...
        if ($coste_impresion > $saldo) {
            $errors->add('Error', 'No cuentas con el saldo suficiente para continuar con la impresión.');

            return redirect()->back()->withErrors($errors);
        } else {
            DB::beginTransaction();

            try {
                // Decrementa El Saldo Del Usuario Por El Coste De La Impresión
                $usuario = User::find($id);
                $usuario->saldo -= $coste_impresion;
                $usuario->save();

                // Guarda Los Datos
                $registro = new Impression();
                $registro->user_id = $id;
                $registro->numero_hojas = $numero_hojas;
                $registro->numero_copias = $numero_copias;
                $registro->tamaño = $tamaño;
                $registro->color = $printer->color;
                $registro->impresora = $printer->nombre;
                $registro->total_hojas = $total_hojas;
                $registro->engargolado = $estado;
                $registro->pago = "Si";
                $registro->descripcion = null;
                $registro->estado = "Realizado";
                $registro->coste_impresion = $coste_impresion;
                $registro->encargado = null;
                $registro->save();

                // ID De La Impresión Creada
                $impresion_id = $registro->id;

                if ($registro->engargolado === 'Con Engargolado') {
                    // Guarda La Solicitud De Engargolado Asociada A La Impresión
                    $engargolado = new Binding();
                    $engargolado->impresion_id = $impresion_id;
                    $engargolado->user_id = $id;
                    $engargolado->coste_engargolado = $price->engargolado;
                    $engargolado->estado = 'Pendiente';
                    $engargolado->encargado = null;
                    $engargolado->save();
                }

                // Commit
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                return $e->getMessage();
            }
            return view('imprimir', compact('price', 'registro', 'saldo'));
        }
    }

    /*
    Función: Deshace La Transacción Previa.
             Devuelve El Coste De La Impresión Al Usuario.
    */
    public function rollback($registro_id)
    {
        DB::beginTransaction();

        try {
            $registro = Impression::find($registro_id); // Obtiene El Registro         
            $usuario = User::find($registro->user_id); // Busca Al Usuario Asociado Al Registro

            // Devuelve El Coste De La Impresión Al Usuario
            $usuario->saldo += $registro->coste_impresion;
            $usuario->save();

            // Elimina La Solicitud De Engargolado
            DB::table('bindings')->where('impresion_id', $registro_id)->delete();

            // Elimina El Registro
            $registro->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
        return redirect()->route('home')->with('success', 'Transacción Deshecha Correctamente.');
    }

    /*
    Función: Valida el archivo a imprimir.
    */
    public function validacionArchivo(Request $request, $registro_id)
    {
        $validator = Validator::make($request->all(), [
            'archivoImprimir' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120']
        ]);

        if ($validator->fails()) {
            DB::beginTransaction();

            try {
                $registro = Impression::find($registro_id);
                $usuario = User::find($registro->user_id);

                $usuario->saldo += $registro->coste_impresion;
                $usuario->save();

                // Elimina La Solicitud De Engargolado
                DB::table('bindings')->where('impresion_id', $registro_id)->delete();

                $registro->delete();

                DB::commit();

                throw new \Exception('El Archivo a Imprimir debe ser PDF o formato JPG, JPEG, PNG (En caso de ser Imagen).');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        $registro = Impression::find($registro_id);
        $registro->estado = "Realizado";
        $registro->save();

        return redirect()->route('home')->with('success', 'Impresión Realizada Correctamente.');
    }

    /*
    Función: Extrae los datos de los gastos denegados por cada licenciatura.
             Extrae datos variados de las impresiones.
    */
    public function index()
    {
        $price = Price::find(1);

        // Gráfica
        $resultado = DB::table('users')
            ->select('users.licenciatura', DB::raw('SUM(impressions.coste_impresion) AS suma_coste_impresion_licenciatura'))
            ->join('impressions', 'users.id', '=', 'impressions.user_id')
            ->groupBy('users.licenciatura')
            ->get();

        // Dinero General Gastado
        $general_gastado = DB::table('impressions')
            ->select(DB::raw('SUM(coste_impresion) AS suma_coste_impresion'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users');
            })
            ->get();

        // Total De Impresiones Realizadas
        $total_impresiones = DB::table('impressions')
            ->whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users');
            })
            ->count();

        // Impresora Más Utilizada
        $total_utilizaciones = DB::table('users')
            ->join('impressions', 'users.id', '=', 'impressions.user_id')
            ->select('users.licenciatura', 'impressions.impresora', DB::raw('COUNT(*) AS total_utilizaciones'))
            ->groupBy('users.licenciatura', 'impressions.impresora')
            ->havingRaw('COUNT(*) = (SELECT MAX(total_utilizaciones) FROM (SELECT users.licenciatura, impressions.impresora, COUNT(*) AS total_utilizaciones FROM users JOIN impressions ON users.id = impressions.user_id GROUP BY users.licenciatura, impressions.impresora) AS subquery WHERE subquery.licenciatura = users.licenciatura)')
            ->orderBy('users.licenciatura');

        $impresoras = $total_utilizaciones->get();

        // Total De Impresiones A Color
        $impresiones_color = DB::table('impressions')
            ->select(DB::raw('COUNT(*) as total_impresiones'))
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM impressions WHERE color = "Color" AND user_id IN (SELECT id FROM users)) as impresiones_color'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users');
            })
            ->get();

        // Total De Impresiones A Blanco Y Negro
        $impresiones_byn = DB::table('impressions')
            ->select(DB::raw('COUNT(*) as total_impresiones'))
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM impressions WHERE color = "Blanco Y Negro" AND user_id IN (SELECT id FROM users)) as impresiones_byn'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users');
            })
            ->get();

        return view('impressions.index', compact('resultado', 'general_gastado', 'total_impresiones', 'impresoras', 'price', 'impresiones_color', 'impresiones_byn'));
    }

    /*
    Función: Carga la vista de las solicitudes de impresiones.
    */
    public function mostrarVistaSolicitudesImpresiones()
    {
        $pendientes = DB::table('impressions')
            ->where('estado', '=', 'Pendiente')
            ->count();

        $realizadas = DB::table('impressions')
            ->where('impressions.pago', '=', 'No')
            ->where('estado', '=', 'Realizado')
            ->count();

        $denegados = DB::table('impressions')
            ->where('estado', '=', 'Denegado')
            ->count();

        $resultados = DB::table('users')
            ->join('impressions', 'users.id', '=', 'impressions.user_id')
            ->select('users.matricula', 'users.name', 'users.apellido_paterno', 'users.apellido_materno', 'users.licenciatura', 'impressions.id', 'impressions.numero_hojas', 'impressions.numero_copias', 'impressions.tamaño', 'impressions.color', 'impressions.impresora', 'impressions.fecha_impresion', 'impressions.total_hojas', 'impressions.engargolado', 'impressions.pago', 'impressions.descripcion', 'impressions.estado')
            ->where('impressions.pago', '=', 'No')
            ->where('impressions.estado', '=', 'Pendiente')

            ->paginate(4);

        return view('impressions.solicitudes-impresiones', compact('resultados', 'pendientes', 'realizadas', 'denegados'));
    }

    /*
    Funcion: Muestra la solicitud de impresión.
    */
    public function mostrarSolicitud($id)
    {
        $impresion = Impression::find($id);

        return view('impressions.solicitud', compact('impresion'));
    }

    /*
    Función: Solicitar una impresión "No Pago".
    */
    public function solicitarImpresion(Request $request, User $user)
    {
        $errors = new MessageBag();

        $price = Price::find(1);

        $request->validate([
            'numero_hojas' => ['required', 'numeric', 'min:0'],
            'numero_copias' => ['required', 'numeric', 'min:0'],
            'tamaño' => ['required', 'string'],
            'impresora' => ['required', 'string'],
            'sin_engargolado' => ['required_without:con_engargolado'],
            'con_engargolado' => ['required_without:sin_engargolado'],
            'descripcion' => ['required', 'string']
        ]);

        $printer_id = $request->input('impresora');

        $printer = Printer::find($printer_id);

        // Variables
        $usuario = Auth::user(); // Usuario En Sesión
        $id = $usuario->id; // ID

        // Configuración De Impresión
        $numero_hojas = $request->numero_hojas; // Número De Hojas
        $numero_copias = $request->numero_copias; // Número De Copias
        $tamaño = $request->tamaño; // Tamaño
        $sin_eng = $request->input('sin_engargolado'); // Sin Engargolado
        $con_eng = $request->input('con_engargolado'); // Con Engargolado
        $descripcion = $request->descripcion;

        // Contabilidad
        $total_hojas = $numero_hojas * $numero_copias; // Total De Hojas Impresas
        $coste_impresion = null; // Total Coste De Impresión

        // Validación De Engargolados
        if ($sin_eng == "1") {
            $estado = 'Sin Engargolado';
        } else if ($con_eng == "2") {
            $estado = 'Con Engargolado';
            $coste_impresion += $price->engargolado;
        }

        DB::beginTransaction();

        try {
            // Guarda Los Datos
            $registro = new Impression();
            $registro->user_id = $id;
            $registro->numero_hojas = $numero_hojas;
            $registro->numero_copias = $numero_copias;
            $registro->tamaño = $tamaño;
            $registro->color = $printer->color;
            $registro->impresora = $printer->nombre;
            $registro->total_hojas = $total_hojas;
            $registro->engargolado = $estado;
            $registro->pago = 'No';
            $registro->descripcion = $descripcion;
            $registro->estado = "Pendiente";
            $registro->coste_impresion = 0.00;
            $registro->encargado = null;
            $registro->save();

            // ID De La Impresión Creada
            $impresion_id = $registro->id;

            if ($registro->engargolado === 'Con Engargolado') {
                // Guarda La Solicitud De Engargolado Asociada A La Impresión
                $engargolado = new Binding();
                $engargolado->impresion_id = $impresion_id;
                $engargolado->user_id = $id;
                $engargolado->coste_engargolado = 0.00;
                $engargolado->estado = 'Pendiente';
                $engargolado->encargado = null;
                $engargolado->save();
            }

            // Commit
            DB::commit();

            return redirect()->back()->with('success', 'Tu solicitud ha sido enviada a revisión. Puedes ver los detalles en "Solicitudes De Impresiones" en tu perfil.');
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    /*
    Función: Autoriza si se realiza la impresión.
    */
    public function autorizarImpresion($id)
    {
        $impresion = Impression::find($id);
        $usuario = User::find($impresion->user_id);

        $nombre = Auth::user()->name;
        $ap = Auth::user()->apellido_paterno;
        $am = Auth::user()->apellido_materno;
        $encargado = $nombre . " " . $ap . " " . $am;

        if ($impresion) {
            $impresion->estado = "Autorizado";
            $impresion->encargado = $encargado;
            $impresion->save();

            $destinatario = $usuario->email;
            $correo = new Solicitud($usuario, $impresion, $encargado);
            Mail::to($destinatario)->send($correo);

            return redirect()->route('solicitudesImpresiones')->with('success', 'Has autorizado la impresión. Enseguida se le notificará al usuario para que realice su impresión.');
        }
    }

    /*
    Función: Denega la impresión.
    */
    public function denegarImpresion($id)
    {
        $impresion = Impression::find($id);
        $usuario = User::find($impresion->user_id);

        $nombre = Auth::user()->name;
        $ap = Auth::user()->apellido_paterno;
        $am = Auth::user()->apellido_materno;
        $encargado = $nombre . " " . $ap . " " . $am;

        if ($impresion) {
            $impresion->estado = "Denegado";
            $impresion->encargado = $encargado;
            $impresion->save();

            $destinatario = $usuario->email;
            $correo = new Solicitud($usuario, $impresion, $encargado);
            Mail::to($destinatario)->send($correo);

            return redirect()->route('solicitudesImpresiones')->with('success', 'Has denegado la impresión.');
        }
    }

    /*
    Función: Muestra el panel de solicitudes de impresiones.
    */
    public function mostrarPanelSolicitudes()
    {
        $id = Auth::user()->id;

        $resultados = DB::table('users')
            ->join('impressions', 'users.id', '=', 'impressions.user_id')
            ->select('users.matricula', 'users.name', 'users.apellido_paterno', 'users.apellido_materno', 'users.licenciatura', 'impressions.id', 'impressions.numero_hojas', 'impressions.numero_copias', 'impressions.tamaño', 'impressions.color', 'impressions.impresora', 'impressions.fecha_impresion', 'impressions.total_hojas', 'impressions.engargolado', 'impressions.pago', 'impressions.descripcion', 'impressions.estado')
            ->where('impressions.user_id', '=', $id)
            ->where('impressions.pago', '=', 'No')
            ->paginate(4);

        return view('panel-solicitudes', compact('resultados'));
    }

    /*
    Función: Imprime la solicitud de impresión.
    */
    public function imprimirSolicitud($id)
    {
        $impresion = Impression::find($id);

        return view('imprimir-solicitud', compact('impresion'));
    }

    /*
    Función: Valida el archivo de impresión.
    */
    public function validarArchivoImpresion(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'archivoImprimir' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120']
        ]);

        if ($validator->fails()) {
            $errors = new MessageBag();

            $errors->add('Error', 'El Archivo a Imprimir debe ser PDF o formato JPG, JPEG, PNG (En caso de ser Imagen).');

            return redirect()->back()->withErrors($errors);
        } else {
            $impresion = Impression::find($id);

            $impresion->estado = "Realizado";
            $impresion->save();

            return redirect()->route('home')->with('success', 'La impresión se realizó correctamente.');
        }
    }

    /*
    Función: Muestra las impresiones realizadas.
    */
    public function mostrarVistaRealizadas()
    {
        $pendientes = DB::table('impressions')
            ->where('estado', '=', 'Pendiente')
            ->count();

        $realizadas = DB::table('impressions')
            ->where('impressions.pago', '=', 'No')
            ->where('estado', '=', 'Realizado')
            ->count();

        $denegados = DB::table('impressions')
            ->where('estado', '=', 'Denegado')
            ->count();

        $resultados = DB::table('users')
            ->join('impressions', 'users.id', '=', 'impressions.user_id')
            ->select('users.matricula', 'impressions.id', 'impressions.color', 'impressions.impresora', 'impressions.fecha_impresion', 'impressions.total_hojas', 'impressions.engargolado', 'impressions.descripcion', 'impressions.estado', 'impressions.encargado')
            ->where('impressions.pago', '=', 'No')
            ->where('impressions.estado', '=', 'Realizado')
            ->get();

        return view('impressions.realizadas', compact('resultados', 'pendientes', 'realizadas', 'denegados'));
    }

    /*
    Función: Muestra las impresiones denegadas.
    */
    public function mostrarVistaDenegadas()
    {
        $pendientes = DB::table('impressions')
            ->where('estado', '=', 'Pendiente')
            ->count();

        $realizadas = DB::table('impressions')
            ->where('impressions.pago', '=', 'No')
            ->where('estado', '=', 'Realizado')
            ->count();

        $denegados = DB::table('impressions')
            ->where('estado', '=', 'Denegado')
            ->count();

        $resultados = DB::table('users')
            ->join('impressions', 'users.id', '=', 'impressions.user_id')
            ->select('users.matricula', 'impressions.id', 'impressions.color', 'impressions.impresora', 'impressions.fecha_impresion', 'impressions.total_hojas', 'impressions.engargolado', 'impressions.descripcion', 'impressions.estado', 'impressions.encargado')
            ->where('impressions.pago', '=', 'No')
            ->where('impressions.estado', '=', 'Denegado')
            ->get();

        return view('impressions.denegadas', compact('resultados', 'pendientes', 'realizadas', 'denegados'));
    }

    /*
    Función: Cancela la solicitud de impresión.
    */
    public function rollbackImpresion($id)
    {
        DB::beginTransaction();

        try {
            $solicitud = Impression::find($id);

            $solicitud->delete();

            if ($solicitud->engargolado == 'Con Engargolado') {
                $impresion_id = $solicitud->impresion_id;

                DB::table('bindings')->where('impresion_id', $impresion_id)->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
        return redirect()->route('home')->with('success', 'Impresión Deshecha Correctamente.');
    }
}