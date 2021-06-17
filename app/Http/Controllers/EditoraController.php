<?php

namespace App\Http\Controllers;

use App\Editora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $editoras = Editora::all();
            return response()->json(['status' => "ok", 'data' => $editoras], 200);
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
        try {
            $rules = [
                'editora' => ['required', 'string', 'min:10', 'max:255', 'unique:editoras,editora'],
                'estado' => ['required', 'string', 'min:2'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }
            $data = [
                'editora' => $request->editora,
                'estado' => $request->estado,
            ];
            if (Editora::create($data)) {
                return response()->json(['status' => "success", 'data' => "Feito com sucesso"], 200);
            }
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
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
            $editora = Editora::find($id);
            if (!$editora) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Editora"], 404);
            }
            return response(['status' => "ok", 'data' => $editora], 200);
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
            $editora = Editora::find($id);
            if (!$editora) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Editora"], 404);
            }


            $rules = [
                'editora' => ['required', 'string', 'min:10', 'max:255',],
                'estado' => ['required', 'string', 'min:2'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }
            $data = [
                'editora' => $request->editora,
                'estado' => $request->estado,
            ];
            if (Editora::find($id)->update($data)) {
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
            $editora = Editora::find($id);
            if (!$editora) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Editora"], 404);
            }


            if (Editora::find($id)->delete()) {
                return response()->json(['status' => "success", 'data' => "Eliminado com sucesso"], 200);
            }
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }
}