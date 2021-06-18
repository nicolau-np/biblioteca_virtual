<?php

namespace App\Http\Controllers;

use App\Pessoa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function index()
    {
        try {
            $users = User::with(['pessoa'])->get();
            return response()->json(['status' => "ok", 'data' => $users], 200);
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $rules = [
                'email' => ['required', 'email', 'unique:usuarios,email'],
                'password' => ['required', 'string', 'min:6', 'max:100'],
                'acesso' => ['required', 'string', 'min:3', 'max:255'],
                'estadoU' => ['required', 'string', 'min:2'],

                'nome' => ['required', 'string', 'min:10', 'max:255',],
                'genero' => ['required', 'string', 'min:1', 'max:255'],
                'estadoP' => ['required', 'string', 'min:2']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }
            $password = Hash::make($request->password);
            $data['user'] = [
                'id_pessoa' => null,
                'email' => $request->email,
                'password' => $password,
                'acesso' => $request->acesso,
                'estado' => $request->estadoU,
            ];
            $data['pessoa'] = [
                'nome' => $request->nome,
                'genero' => $request->genero,
                'bi' => $request->bi,
                'foto' => null,
                'estado' => $request->estadoP,
            ];

            if ($request->hasFile('foto') && $request->foto->isValid()) {

                $rules = [
                    'foto' => ['required', 'mimes:jpg,jpeg,png,JPG,JPEG,PNG', 'max:10000']
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
                }

                $path = $request->file('foto')->store('img_users');
                $data['pessoa']['foto'] = $path;
            }


            $pessoa = Pessoa::create($data['pessoa']);
            if ($pessoa) {
                $data['user']['id_pessoa'] = $pessoa->id;
                if (User::create($data['user'])) {
                    return response()->json(['status' => "success", 'data' => "Feito com sucesso"], 200);
                }
            }
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:6'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'validation', 'data' => $validator->errors()], 400);
            }

            $credencials = $request->only('email', 'password');

            $token = JWTAuth::attempt($credencials);
            if ($token) {
                return response()->json(['status' => "error", 'error' => 'Unauthorized', 'data' => "Usuário não autoriazado"], 401);
            } else {
                return response()->json(['status' => "ok", 'access_token' => $token, 'token_type' => "bearer", 'expires_in' => JWTAuth::factory()->getTTL() * 60], 200);
            }
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate();
            return response()->json(['status' => 'success', 'data' => 'Sessão terminada com sucesso']);
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    public function refresh()
    {
        try {
            return response()->json(['status' => 'success', 'access_token' => JWTAuth::refresh(), 'token_type' => 'bearer', 'expires_in' => JWTAuth::factory()->getTTL() * 60]);
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }

    public function user()
    {
        try {
            return response()->json(JWTAuth::user());
        } catch (\Exception $erro) {
            return response()->json(['status' => "error", 'data' => $erro], 500);
        }
    }
}
