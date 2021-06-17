<?php

namespace App\Http\Controllers;

use App\Pessoa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            $rules = [
                'email' => ['required', 'email', 'unique:usuarios,email'],
                'password'=>['required', 'string','min:6', 'max:100'],
                'acesso' =>['required', 'string', 'min:3', 'max:255'],
                'estado1' => ['required', 'string', 'min:2'],

                'nome'=> ['required', 'string', 'min:10', 'max:255',],
                'genero' =>['required', 'string', 'min:1', 'max:255'],
                'estado2'=> ['required', 'string', 'min:2']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }
            $data['user'] = [
                'id_pessoa'=>null,
                'email'=>$request->email,
                'password'=> $request->password,
                'acesso'=> $request->acesso,
                'estado'=> $request->estado1,
            ];
            $data['pessoa'] = [
                'nome'=>$request->nome,
                'genero'=>$request->genero,
                'bi'=> $request->bi,
                'foto'=>null,
                'estado'=> $request->estado2,
            ];

            if ($request->hasFile('foto') && $request->foto->isValid()) {

                $rules = [
                    'foto'=>['required', 'mimes:jpg,jpeg,png,JPG,JPEG,PNG', 'max:10000']
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
                }

                $path = $request->file('foto')->store('img_leitores');
                $data['pessoa']['foto'] = $path;
            }


            $pessoa = Pessoa::create($data['pessoa']);
            if($pessoa){
                if(User::create($data['user'])){
                    return response()->json(['status' => "success", 'data' => "Feito com sucesso"], 200);
                }
            }
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    public function user(){

    }


}