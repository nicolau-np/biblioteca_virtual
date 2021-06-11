<?php

namespace App\Http\Controllers;

use App\Leitor;
use App\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $leitors = Leitor::with(['pessoa'])->get();
            return response()->json(['status' => "ok", 'data' => $leitors], 200);
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
                'nome' => ['required', 'string', 'min:10', 'max:255'],
                'genero' => ['required', 'string', 'min:1'],
                'estado' => ['required', 'string', 'min:2'],

                'telefone' => ['required', 'Integer',],
                'bairro' => ['required', 'string', 'min:5', 'max:255']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }

            $data['pessoa'] = [
                'nome'=>$request->nome,
                'genero'=>$request->genero,
                'bi'=>$request->bilhete,
                'foto'=>null,
                'estado'=>$request->estado,
            ];

            $data['leitor'] = [
                'id_pessoa'=>null,
                'telefone'=>$request->telefone,
                'bairro'=>$request->bairro,
            ];

            $pessoa = Pessoa::create($data['pessoa']);
            if($pessoa){
                $data['leitor']['id_pessoa'] = $pessoa->id;
                if(Leitor::create($data['leitor'])){
                    return response()->json(['status' => "success", 'data' => "Feito com sucesso"], 200);
                }
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
            $leitor = Leitor::with(['pessoa'])->find($id);
            if (!$leitor) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Leitor"], 404);
            }
            return response(['status' => "ok", 'data' => $leitor], 200);
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
            $leitor = Leitor::find($id);
            if (!$leitor) {
                return response()->json(['status' => "not_found", 'data' => "Não encontrou Leitor"], 404);
            }


            $rules = [
                'nome' => ['required', 'string', 'min:10', 'max:255'],
                'genero' => ['required', 'string', 'min:1'],
                'estado' => ['required', 'string', 'min:2'],

                'telefone' => ['required', 'Integer',],
                'bairro' => ['required', 'string', 'min:5', 'max:255']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }

            $data['pessoa'] = [
                'nome'=>$request->nome,
                'genero'=>$request->genero,
                'bi'=>$request->bilhete,
                'foto'=>null,
                'estado'=>$request->estado,
            ];

            $data['leitor'] = [
                'id_pessoa'=>$leitor->id_pessoa,
                'telefone'=>$request->telefone,
                'bairro'=>$request->bairro,
            ];

            if(Pessoa::find($id)->update($data['pessoa'])){
                if(Leitor::find($id)->update($data['leitor'])){
                    return response()->json(['status' => "success", 'data' => "Feito com sucesso"], 200);
                }
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