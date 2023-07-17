<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    /*
    Función: Muestra todas las impresoras.
    */
    public function index()
    {
        $impresoras = Printer::all();

        return view('printers.index', compact('impresoras'));
    }

    /*
    Función: Carga la vista para crear una nueva impresora.
    */
    public function create()
    {
        return view('printers.create');
    }

    /*
    Función: Crea una nueva impresora.
    */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string'],
            'color' => ['required'],
            'ubicacion' => ['required']
        ]);

        $color = $request->input('color');

        $impresora = New Printer();
        $impresora->nombre = $request->nombre;
        $impresora->color = $color;
        $impresora->ubicacion = $request->ubicacion;
        $impresora->save();

        return redirect()->route('printers.index')->with('success', 'Nueva Impresora Agregada Correctamente.');
    }

    /*
    Función: Carga la vista para editar una impresora.
    */
    public function edit(Printer $printer)
    {
        return view('printers.edit', compact('printer'));
    }

    /*
    Función: Actualiza los datos de una impresora.
    */
    public function update(Request $request, Printer $printer)
    {
        $request->validate([
            'nombre' => ['required', 'string'],
            'color' => ['required'],
            'ubicacion' => ['required']
        ]);
        
        $color = $request->input('color');

        $impresora = Printer::find($printer->id);
        $impresora->nombre = $request->nombre;
        $impresora->color = $color;
        $impresora->ubicacion = $request->ubicacion;
        $impresora->save();

        return redirect()->route('printers.index')->with('success', 'Impresora Actualizada Correctamente.');
    }

    /*
    Función: Destruye una impresora.
    */
    public function destroy(Printer $printer)
    {
        $printer->delete();

        return redirect()->route('printers.index')->with('success', 'Impresora Eliminada Correctamente.');
    }
}