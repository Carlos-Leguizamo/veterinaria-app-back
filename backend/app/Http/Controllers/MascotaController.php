<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class MascotaController extends Controller
{
    // Método para registrar una nueva mascota
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'nullable|string|max:255',
            'edad' => 'required|integer|min:0',
            'peso' => 'nullable|numeric|min:0',
            'fecha_nacimiento' => 'required|date',
            'amo_id' => 'required|exists:amos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear una nueva mascota
        $mascota = Mascota::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mascota registrada correctamente',
            'data' => $mascota,
        ]);
    }

    // Método para obtener todas las mascotas
    public function index()
    {
        $veterinario = Auth::user(); // O lo que uses para identificar al veterinario

        // Obtener todos los amos creados por este veterinario
        $amos = $veterinario->amos;

        // Obtener todas las mascotas de los amos
        $mascotas = [];
        foreach ($amos as $amo) {
            $mascotas = array_merge($mascotas, $amo->mascotas->toArray());
        }


        return response()->json([
            'success' => true,
            'data' => $mascotas,
        ]);
    }

    // Método para obtener una mascota por su ID
    public function show($id)
    {
        $mascota = Mascota::find($id);

        if (!$mascota) {
            return response()->json(['error' => 'Mascota no encontrada'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $mascota,
        ]);
    }
    public function update(Request $request, $id)
    {
        $mascota = Mascota::find($id);

        if (!$mascota) {
            return response()->json(['error' => 'Mascota no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'tipo' => 'sometimes|required|string|max:255',
            'raza' => 'sometimes|nullable|string|max:255',
            'edad' => 'sometimes|required|integer|min:0',
            'peso' => 'sometimes|nullable|numeric|min:0',
            'amo_id' => 'sometimes|required|exists:amos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mascota->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mascota actualizada correctamente',
            'data' => $mascota,
        ]);
    }


    public function destroy($id)
    {
        $mascota = Mascota::find($id);

        if (!$mascota) {
            return response()->json(['error' => 'Mascota no encontrada'], 404);
        }


        $mascota->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mascota eliminada correctamente',
        ]);
    }
    public function generarPdfMascotas()
    {
        $veterinario = Auth::user();
        $amos = $veterinario->amos;
        $pdf = PDF::loadView('reportes.mascotas', compact('amos', 'veterinario'));
        return $pdf->stream('reporte_mascotas.pdf');
    }
}
