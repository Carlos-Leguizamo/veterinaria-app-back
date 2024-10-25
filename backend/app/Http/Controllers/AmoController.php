<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Amo;

class AmoController extends Controller
{
    // Método para registrar un nuevo Amo
    public function registro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:amos',
            'password' => 'required|string|min:8',
            'tipo_identidad' => 'required|string|in:C.C.,Cédula de extranjería',
            'numero_identidad' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'genero' => 'required|string|in:Masculino,Femenino',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $veterinario=$request->user();

        $amo = Amo::create([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'second_last_name' => $request->second_last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_identidad' => $request->tipo_identidad,
            'numero_identidad' => $request->numero_identidad,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'genero' => $request->genero,
        ]);

        $veterinario->amos()->attach($amo->id);

        // Crear y retornar el token
        $token = $amo->createToken('Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Amo registrado correctamente',
            'data' => $amo,
            'token' => $token,
        ], 201);
    }

    // Método para iniciar sesión
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $amo = Amo::where('email', $request->email)->first();

        if (!$amo || !Hash::check($request->password, $amo->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Crear y retornar el token
        $token = $amo->createToken('Amo Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Amo autenticado correctamente',
            'data' => $amo,
            'token' => $token,
        ], 200);
    }

    // Método para obtener todos los Amos
    public function index()
    {
        $amos = Amo::all();

        return response()->json([
            'success' => true,
            'data' => $amos,
        ], 200);
    }

    // Método para obtener un Amo por su ID
    public function show($id)
    {
        $amo = Amo::find($id);

        if (!$amo) {
            return response()->json(['error' => 'Amo no encontrado'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $amo,
        ], 200);
    }

    // Método para actualizar un Amo
    public function update(Request $request, $id)
    {
        $amo = Amo::find($id);

        if (!$amo) {
            return response()->json(['error' => 'Amo no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'second_name' => 'sometimes|nullable|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'second_last_name' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:amos,email,' . $amo->id,
            'password' => 'sometimes|nullable|string|min:8',
            'tipo_identidad' => 'sometimes|required|string|in:C.C.,Cédula de extranjería',
            'numero_identidad' => 'sometimes|required|string|max:255',
            'direccion' => 'sometimes|required|string|max:255',
            'telefono' => 'sometimes|required|string|max:255',
            'genero' => 'sometimes|required|string|in:Masculino,Femenino',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->has('password')) {
            $amo->password = Hash::make($request->password);
        }

        $amo->fill($request->only([
            'first_name',
            'second_name',
            'last_name',
            'second_last_name',
            'email',
            'tipo_identidad',
            'numero_identidad',
            'direccion',
            'telefono',
            'genero'
        ]));
        $amo->save();

        return response()->json([
            'success' => true,
            'message' => 'Amo actualizado correctamente',
            'data' => $amo,
        ], 200);
    }

    // Método para eliminar un Amo
    public function destroy($id)
    {
        $amo = Amo::find($id);

        if (!$amo) {
            return response()->json(['error' => 'Amo no encontrado'], 404);
        }

        $amo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Amo eliminado correctamente',
        ], 200);
    }
}
