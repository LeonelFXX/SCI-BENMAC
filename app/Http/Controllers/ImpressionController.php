<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impression;
use App\Models\User;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

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
            'blanco_y_negro' => ['numeric'],
            'color' => ['numeric']
        ]);

        $price->blanco_y_negro = $request->blanco_y_negro;
        $price->color = $request->color;

        $price->save();

        return redirect()->back()->with('success', 'Se aplicaron los precios con éxito.');
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
            'numero_hojas' => ['required', 'integer'],
            'numero_copias' => ['required', 'integer'],
            'tamaño' => ['required', 'string'],
            'impresora' => ['required', 'string']
        ]);

        // Variables
        $usuario = Auth::user(); // Usuario En Sesión
        $id = $usuario->id; // ID
        $saldo = $usuario->saldo; // Saldo

        // Configuración De Impresión
        $numero_hojas = $request->numero_hojas; // Número De Hojas
        $numero_copias = $request->numero_copias; // Número De Copias
        $tamaño = $request->tamaño; // Tamaño
        $impresora = $request->impresora; // Impresora

        // Contabilidad
        $total_hojas = $numero_hojas * $numero_copias; // Total De Hojas Impresas
        $coste_impresion = null; // Total Coste De Impresión

        // Validación De Precios
        if ($impresora == 'XRX9') {
            $coste_impresion += $price->color;
            $coste_impresion *= $total_hojas;
            $color = 'Color';
        } else if ($impresora == 'HP LaserJet M604') {
            $coste_impresion += $price->blanco_y_negro;
            $coste_impresion *= $total_hojas;
            $color = 'Blanco Y Negro';
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
                $registro->color = $color;
                $registro->impresora = $impresora;
                $registro->total_hojas = $total_hojas;
                $registro->coste_impresion = $coste_impresion;
                $registro->save();

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

            // Elimina El Registro
            $registro->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
        return redirect()->route('home')->with('success', 'Transacción Deshecha Correctamente.');
    }

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

                $registro->delete();

                DB::commit();

                throw new \Exception('El Archivo a Imprimir debe ser PDF o formato JPG, JPEG, PNG (En caso de ser Imagen).');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }
        return redirect()->route('home')->with('success', 'Impresión Realizada Correctamente.');
    }

    /*
    Función: Extrae los datos de los gastos realizados por cada licenciatura.
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
}