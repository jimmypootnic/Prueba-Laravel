<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $messages = [
                'required' => ':attribute es requerido',
                'string' => ':attribute debe ser de tipo texto',
                'email' => ':attribute no es un correo válido',
                'unique:tw_usuarios' => ':attribute ya existe',
                'confirmed' => 'falta confirmar :attribute',
            ];

            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string',
                'email' => 'required|string|email|unique:tw_usuarios',
                'password' => 'required|string',
                'confirmed' => 'required|string'
            ], $messages);

            $errors = '';
            if ($validator->fails()) {
                $arrayMsj = json_decode($validator->getMessageBag());
                foreach ($arrayMsj as $key => $value) {
                    $errors .= ', ' . $value[0];
                }
                $errors = substr($errors, 2, strlen($errors));
                return response()->json([
                    'result' => 'error',
                    'message' => $errors], Response::HTTP_BAD_REQUEST);
            }

            $user = new User([
                'username' => $request->nombre,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $user->save();
            return response()->json([
                'result' => 'success',
                'message' => 'Cuenta registrada exitosamente'], Response::HTTP_OK);
        }catch (\Throwable $e){
            return response()->json([
                'result' => 'error',
                'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(Request $request)
    {
        $messages = [
            'required' => ':attribute es requerido',
            'string' => ':attribute debe ser de tipo texto',
            'email' => ':attribute no es un correo válido',
        ];

        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email|',
            'password' => 'required|string|'
        ], $messages);
        $errors = '';
        if ($validator->fails()) {
            $arrayMsj = json_decode($validator->getMessageBag());
            foreach ($arrayMsj as $key => $value) {
                $errors .= ', ' . $value[0];
            }
            $errors = substr($errors, 2, strlen($errors));
            return response()->json([
                'result' => 'error',
                'mensaje' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($credentials)) {
            $tokenResult = auth()->user()->createToken('LaravelTestJ Personal Access Client');
        }else{
            return response()->json([
                'result' => 'error',
                'message' => 'Usuario y/o password incorrectos'],
                401);
        }
        $user = $request->user();
        $token = $tokenResult->token;
        //if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addDays(1);
        //}
        $token->save();
        return response()->json([
            'result' => 'success',
            'id' => $user->id,
            'username' => $user->username,
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function userInfo(Request $request)
    {
        return response()->json($request->user());
    }
}
