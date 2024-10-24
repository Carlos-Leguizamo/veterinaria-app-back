<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Consulta;


class ConsultasController extends Controller
{
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'historias_clinicas_id' => 'required',
            'mascotas_id' => 'required',
            'veterinarios_id' => 'required',
            'amos_id' => 'required',
            'fecha_consulta' => 'required',
            'detalles' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $consulta = Consulta::create([
            'historias_clinicas_id' => $request->historias_clinicas_id,
            'mascotas_id' => $request->mascotas_id,
            'veterinarios_id' => $request->veterinarios_id,
            'amos_id' => $request->amos_id,
            'fecha_consulta' => $request->fecha_consulta,
            'detalles' => $request->detalles
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consulta registrada correctamente',
            'data' => $consulta
        ]);
    }

    public function index()
    {

        $consultas = Consulta::all();

        return response()->json([
            'success' => true,
            'message' => 'Consulta obtenida correctamente',
            'data' => $consultas
        ], 200);
    }


    public function show($id)
    {

        $consulta = Consulta::find($id);

        if (!$consulta) {
            return response()->json(['error' => 'Consulta no encontrada'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Consulta obtenida correctamente',
            'data' => $consulta
        ], 200);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'historias_clinicas_id' => 'required',
            'mascotas_id' => 'required',
            'veterinarios_id' => 'required',
            'amos_id' => 'required',
            'fecha_consulta' => 'required',
            'detalles' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $consulta = Consulta::find($id);

        if (!$consulta) {
            return response()->json(['error' => 'Consulta no encontrada'], 404);
        }

        $consulta->historias_clinicas_id = $request->historias_clinicas_id;
        $consulta->mascotas_id = $request->mascotas_id;
        $consulta->veterinarios_id = $request->veterinarios_id;
        $consulta->amos_id = $request->amos_id;
        $consulta->fecha_consulta = $request->fecha_consulta;
        $consulta->detalles = $request->detalles;

        $consulta->save();

        return response()->json([
            'success' => true,
            'message' => 'Consulta actualizada correctamente',
            'data' => $consulta
        ], 200);
    }


    public function destroy($id)
    {

        $consulta = Consulta::find($id);

        if (!$consulta) {
            return response()->json(['error' => 'Consulta no encontrada'], 404);
        }

        $consulta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Consulta eliminada correctamente',
        ], 200);
    }
}
