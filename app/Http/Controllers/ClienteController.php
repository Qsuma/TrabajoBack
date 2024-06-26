<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClienteItalianoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\cliente;
use App\Models\ClienteItaliano;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    public function getCliente()
    {
        try{
            $clientes=Cliente::doesntHave('cliente_italiano')->get();
            return response()->json($clientes);

        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }

    }

    public function getAllCliente()
    {
        try{
            $clientes = Cliente::doesntHave('cliente_italiano')->get();
            $clienteItaliano = ClienteItaliano::all();

            $respuesta = [
                'clientes cubanos' => $clientes,
                'clientes italianos' => ClienteItalianoResource::collection($clienteItaliano)
            ];
            return response()->json($respuesta);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }

    }


    public function getClienteById(Request $request)
    {
        try {
            $validator=$request->validate([
                'id'=>'required|numeric'
            ]);

            $cliente = cliente::with('matrimonio')->findOrFail($validator['id']);
            return response()->json($cliente);
        }
        catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Usuario no encontrado',
                'message' => 'No se pudo encontrar el usuario con el ID proporcionado',
            ], 404);
        }
        catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->errors(),
            ], 422);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function busquedaClientes(Request $request){
        try{

            $validator=$request->validate([
                'username' => 'string|alpha_dash',
                'nombre' => 'string',
                'id'=>'numeric'
            ]);

            $clientes=cliente::query()
            ->when($request->has('nombre'), function ($query) use ($validator) {
                return $query->whereRaw('LOWER(nombre_apellidos) LIKE ?', ['%' . strtolower($validator['nombre']) . '%']);
            })
            ->when($request->has('username'), function ($query) use ($validator) {
                return $query->whereRaw('LOWER(username) LIKE ?', ['%' . strtolower($validator['nombre']) . '%']);
            })
            ->when($request->has('id'), function ($query) use ($validator) {
                return $query->where('id', $validator['id']);
            })
            ->with('cliente_italiano')
            ->get();

            if($clientes->isNotEmpty()){
                return response()->json($clientes);
            }else{
                return response()->json([
                    'error' => 'Usuario no encontrado',
                    'message' => 'No se pudo encontrar registros con los datos proporcionados',
                ], 404);
            }
        }
        catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->errors(),
            ], 422);
        }
        catch(\Exception $error){
            return response()->json($error->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $validator = $request->validate([
                'username' => 'required|string|min:8|max:100|alpha_dash|unique:clientes',
                'nombre_apellidos' => 'required|string|min:10',
                'direccion' => 'required|string|min:10',
                'telefono' => 'required|numeric|min:8',
                'email' => 'required|email'
            ]);

            $cliente = cliente::create([
                'username' => $validator['username'],
                'nombre_apellidos' => $validator['nombre_apellidos'],
                'direccion' => $validator['direccion'],
                'telefono' => $validator['telefono'],
                'email' => $validator['email']
            ]);

            $cliente->save();

            return response()->json($cliente);

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
            $validator= $request->validate([
               'id'=>'required|numeric'
            ]);
            $cliente = cliente::findOrFail($validator['id']);
            $cliente->delete();
            return response()->json($cliente);
        }catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Usuario no encontrado',
                'message' => 'No se pudo encontrar el usuario con el ID proporcionado',
            ], 404);
        }
        catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->errors(),
            ], 422);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function modificar(Request $request)
    {
        try {
            $validator = $request->validate([
                'username' => 'required|string|min:8|max:100|alpha_dash',
                'nombre_apellidos' => 'required|string|min:10',
                'direccion' => 'required|string|min:10',
                'telefono' => 'required|numeric|min:8',
                'email' => 'required|email'
            ]);

            $cliente = cliente::findOrFail($request->input('id'));
            $cliente->update($validator);
            return response()->json($cliente);
        }
        catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Usuario no encontrado',
                'message' => 'No se pudo encontrar el usuario con el ID proporcionado',
            ], 404);
        }
        catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->errors(),
            ], 422);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
