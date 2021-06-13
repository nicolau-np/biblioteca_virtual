<?php

namespace App\Http\Controllers;

use App\CategoriaLivro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategorialivroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categoria_livros = CategoriaLivro::all();
            return response()->json(['status' => "ok", 'data' => $categoria_livros], 200);
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
            'categoria' => ['required', 'string', 'min:10', 'max:255', 'unique:categoria_livros,categoria'],
            'estado' => ['required', 'string', 'min:2'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
        }
        $data = [
            'categoria' => $request->categoria,
            'estado' => $request->estado,
        ];
        if (CategoriaLivro::create($data)) {
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
            $categoria_livro = CategoriaLivro::find($id);
            if (!$categoria_livro) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Categoria"], 404);
            }
            return response(['status' => "ok", 'data' => $categoria_livro], 200);
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
            $categoria_livros = CategoriaLivro::find($id);
            if (!$categoria_livros) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Categoria"], 404);
            }


            $rules = [
                'categoria' => ['required', 'string', 'min:10', 'max:255',],
                'estado' => ['required', 'string', 'min:2'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }
            $data = [
                'categoria' => $request->categoria,
                'estado' => $request->estado,
            ];
            if (CategoriaLivro::find($id)->update($data)) {
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
        //
    }
}