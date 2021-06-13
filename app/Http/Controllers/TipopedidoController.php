<?php

namespace App\Http\Controllers;

use App\TipoPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipopedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tipo_pedidos = TipoPedido::all();
            return response()->json(['status' => "ok", 'data' => $tipo_pedidos], 200);
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'tipo' => ['required', 'string', 'min:4', 'max:255', 'unique:tipo_pedidos,tipo'],
            'estado' => ['required', 'string', 'min:2'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
        }
        $data = [
            'tipo' => $request->tipo,
            'estado' => $request->estado,
        ];
        if (TipoPedido::create($data)) {
            return response()->json(['status' => "success", 'data' => "Feito com sucesso"], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $tipo_pedido = TipoPedido::find($id);
            if (!$tipo_pedido) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Tipo de Pedido"], 404);
            }
            return response(['status' => "ok", 'data' => $tipo_pedido], 200);
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $tipo_pedido = TipoPedido::find($id);
            if (!$tipo_pedido) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Tipo de Pedido"], 404);
            }


            $rules = [
                'tipo' => ['required', 'string', 'min:4', 'max:255',],
                'estado' => ['required', 'string', 'min:2'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }
            $data = [
                'tipo' => $request->tipo,
                'estado' => $request->estado,
            ];
            if (TipoPedido::find($id)->update($data)) {
                return response()->json(['status' => "success", 'data' => "Actualização feita com sucesso"], 200);
            }
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tipo_pedido = TipoPedido::find($id);
            if (!$tipo_pedido) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Tipo de Pedido"], 404);
            }


            if (TipoPedido::find($id)->delete()) {
                return response()->json(['status' => "success", 'data' => "Eliminado com sucesso"], 200);
            }
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }
}