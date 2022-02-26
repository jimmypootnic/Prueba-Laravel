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
                'numeric' => ':attribute debe ser de tipo número',
                'email' => ':attribute no es un correo válido',
                'unique:tw_usuarios' => ':attribute ya existe',
                'confirmed' => 'falta confirmar :attribute',
            ];

            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string',
                'email' => 'required|string|email|unique:tw_usuarios',
                'password' => 'required|string',
                'confirmed' => 'required|string',
                'Activo' => 'required|numeric',
                'verified' => 'required|string',
                'tw_rol_id' => 'required|numeric',
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
                'password' => bcrypt($request->password),
                'Activo' => $request->Activo,
                'verified' => $request->verified,
                'tw_rol_id' => $request->tw_rol_id,
            ]);
            if ($request->exists('S_Nombre')){
                $user->S_Nombre = $request->S_Nombre;
            } if ($request->exists('S_Apellidos')){
                $user->S_Apellidos = $request->S_Apellidos;
            } if ($request->exists('S_FotoPerfilUrl')){
                $user->S_FotoPerfilUrl = $request->S_FotoPerfilUrl;
            } if ($request->exists('verification_token')){
                $user->verification_token = $request->verification_token;
            }
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

    public function update($id, Request $request)
    {
        if ($request->isMethod('put')) {
            $oRegistro = User::find($id);
            if($oRegistro) {
                $messages = [
                    'required' => ':attribute es requerido',
                    'string' => ':attribute debe ser de tipo texto',
                    'numeric' => ':attribute debe ser de tipo número',
                    'email' => ':attribute no es un correo válido',
                    'unique:tw_usuarios' => ':attribute ya existe',
                    'confirmed' => 'falta confirmar :attribute',
                ];

                $validator = Validator::make($request->all(), [
                    'nombre' => 'required|string',
                    'email' => 'required|string|email|',
                    'confirmed' => 'required|string',
                    'Activo' => 'required|numeric',
                    'tw_rol_id' => 'required|numeric',
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
                $oRegistro->username = $request->nombre;
                $oRegistro->email = $request->email;
                $oRegistro->Activo = $request->Activo;
                $oRegistro->verified = $request->verified;
                $oRegistro->tw_rol_id = $request->tw_rol_id;
                if ($request->exists('S_Nombre')){
                    $oRegistro->S_Nombre = $request->S_Nombre;
                } if ($request->exists('S_Apellidos')){
                    $oRegistro->S_Apellidos = $request->S_Apellidos;
                } if ($request->exists('S_FotoPerfilUrl')){
                    $oRegistro->S_FotoPerfilUrl = $request->S_FotoPerfilUrl;
                } if ($request->exists('verification_token')){
                    $oRegistro->verification_token = $request->verification_token;
                }
                $oRegistro->save();
                return response()->json([
                    'message' => 'Modificado'], Response::HTTP_OK);
            }else{
                return response()->json([
                    'message' => 'Registro no encontrado'],
                    Response::HTTP_NOT_FOUND);
            }
        }else{
            return response()->json([
                'message' => 'Metodo debe ser put'],
                Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

    public function delete($id)
    {
        $oRegistro = User::find($id);
        if ($oRegistro) {
            $oRegistro->delete_at = now();
            $oRegistro->save();
            return response()->json(['message' => 'Registro eliminado'], Response::HTTP_NO_CONTENT);
        } else {
            return response()->json([
                'message' => 'Registro no encontrado'], Response::HTTP_NOT_FOUND);
        }
    }
}
