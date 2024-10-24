<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Historia;
use Illuminate\Support\Facades\Validator;

class HistoriasController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mascotas_id' => 'required|exists:mascotas,id',
            'veterinarios_id' => 'required|exists:mascotas,id',
            'fecha_consulta' => 'required|date',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',


        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $historia = Historia::create([
            'mascotas_id' => $request->mascotas_id,
            'veterinarios_id' => $request->veterinarios_id,
            'fecha_consulta' => $request->fecha_consulta,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Historia registrada correctamente',
            'data' => $historia,
        ]);
    }
    public function index()
    {
        $historias = Historia::all();

        return response()->json([
            'success' => true,
            'message' => 'Historias obtenidas correctamente',
            'data' => $historias,
        ], 200);
    }

    public function show($id)
    {
        $historia = Historia::find($id);

        if (!$historia) {

            return response()->json(['error' => 'Historia no encontrada'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $historia,
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'mascotas_id' => 'required|exists:mascotas,id',
            'veterinarios_id' => 'required|exists:mascotas,id',
            'fecha_consulta' => 'required|date',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $historia = Historia::find($id);

        if (!$historia) {
            return response()->json(['error' => 'Historia no encontrada'], 404);
        }

        $historia->mascotas_id = $request->mascotas_id;
        $historia->veterinarios_id = $request->veterinarios_id;
        $historia->fecha_consulta = $request->fecha_consulta;
        $historia->diagnostico = $request->diagnostico;
        $historia->tratamiento = $request->tratamiento;

        $historia->save();

        return response()->json([
            'success' => true,
            'message' => 'Historia actualizada correctamente',
            'data' => $historia,
        ], 200);
    }


    public function destroy($id)
    {

        $historia = Historia::find($id);

        if (!$historia) {
            return response()->json(['error' => 'Historia no encontrada'], 404);
        }

        $historia->delete();

        return response()->json([
            'success' => true,
            'message' => 'Historia eliminada correctamente',
        ], 200);
    }
}
