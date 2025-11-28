<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use App\Models\TipoResponsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    public function create()
    {
        $tipos = TipoResponsable::all();
        return view('responsables.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cedula' => 'required|unique:responsables,cedula',
            'nombre' => 'required|string|max:150',
            'tipo_id' => 'required|exists:tipos_responsables,id',
        ]);

        Responsable::create($request->only('cedula', 'nombre', 'tipo_id'));

        return redirect()->route('responsables.index')
            ->with('success', 'Responsable registrado correctamente');
    }

    public function index()
    {
        $responsables = Responsable::with('tipo')->get();
        return view('responsables.index', compact('responsables'));
    }
}

