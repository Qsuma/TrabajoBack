<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\formaPago;
use App\Models\Matrimonio;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class formasPagosController extends Controller
{
    public function getFormaPago(Request $request)
    {
        try {

            $validator = $request->validate([
                'id' => 'required|numeric'
            ]);

            $forma = formaPago::with('cuotas')->where('id_matrimonio', $validator['id'])->get();
            return response()->json($forma);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Registro no encontrado',
                'message' => 'No se pudo encontrar el registro con el ID proporcionado',
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $validator = $request->validate([
                'id_matrimonio' => 'required|numeric',
                'tipo' => 'required', 'string',
                function ($attribute, $value, $fail) {
                    $allowedValues = ['Pagato totale', 'Acconto'];
                    if (!in_array(strtolower($value), array_map('strtolower', $allowedValues))) {
                        $fail($attribute . ' Campo no valido');
                    }
                },
                'monto_pago' => 'required|numeric',
                'fecha' => 'required|date|date_format:d/m/Y',
            ]);

            $matrimonio = Matrimonio::findOrFail($request->input('id_matrimonio'));
            $forma = formaPago::create($validator);

            $forma->matrimonio()->associate($matrimonio);

            return response()->json($forma);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function modificar(Request $request)
    {
        try {
            $validator = $request->validate([
                'id_matrimonio' => 'required|numeric',
                'tipo' => 'required', 'string',
                function ($attribute, $value, $fail) {
                    $allowedValues = ['Pagato totale', 'Acconto'];
                    if (!in_array(strtolower($value), array_map('strtolower', $allowedValues))) {
                        $fail($attribute . ' Campo no valido');
                    }
                },
                'monto_pago' => 'required|numeric',
                'fecha' => 'required|date|date_format:d/m/Y',
            ]);

            $matrimonio = Matrimonio::findOrFail($request->input('id_matrimonio'));
            $forma = formaPago::findOrFail($request->input('id'));

            $forma->update($validator);

            $forma->matrimonio()->associate($matrimonio);

            return response()->json($forma);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Registro no encontrado',
                'message' => 'No se pudo encontrar el registro con el ID proporcionado',
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {

            $validator = $request->validate([
                'id' => 'required|numeric'
            ]);

            $forma = formaPago::findOrFail($validator['id']);
            $forma->delete();
            $forma->cuotas()->delete();


            return response()->json($forma);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Registro no encontrado',
                'message' => 'No se pudo encontrar el registro con el ID proporcionado',
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
