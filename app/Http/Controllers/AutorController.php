<?php

namespace App\Http\Controllers;

use App\Autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $autors = Autor::all();
            return response()->json(['status' => "ok", 'data' => $autors], 200);
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
            'autor' => ['required', 'string', 'min:10', 'max:255', 'unique:autors,autor'],
            'estado' => ['required', 'string', 'min:2'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
        }
        $data = [
            'autor' => $request->autor,
            'estado' => $request->estado,
        ];
        if (Autor::create($data)) {
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
            $autor = Autor::find($id);
            if (!$autor) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Autor"], 404);
            }
            return response(['status' => "ok", 'data' => $autor], 200);
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
            $autor = Autor::find($id);
            if (!$autor) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Autor"], 404);
            }


            $rules = [
                'autor' => ['required', 'string', 'min:10', 'max:255',],
                'estado' => ['required', 'string', 'min:2'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }
            $data = [
                'autor' => $request->autor,
                'estado' => $request->estado,
            ];
            if (Autor::find($id)->update($data)) {
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
            $autor = Autor::find($id);
            if (!$autor) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Autor"], 404);
            }


            if (Autor::find($id)->delete()) {
                return response()->json(['status' => "success", 'data' => "Eliminado com sucesso"], 200);
            }
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }
}