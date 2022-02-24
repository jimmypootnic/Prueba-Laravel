<?php

namespace App\Http\Controllers;

use App\Models\tw_contratos_corporativos;
use App\Models\tw_corporativos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TwContratosCorporativosController extends Controller
{
    public function getAll(Request $request ){
        $oData = new tw_contratos_corporativos();
        $data = $oData->all();
        return response()->json([
            'data' => $data], Response::HTTP_OK);
    }

    public function getById( $id, Request $request )
    {
        $oRegistro = tw_contratos_corporativos::find( $id );
        if($oRegistro === null){
            return response()->json([
                'message' => 'Registro no encontrado'], Response::HTTP_NOT_FOUND);
        }else{
            return response()->json([
                'data' => $oRegistro], Response::HTTP_OK);
        }
    }

    public function create( Request $request )
    {
        if ($request->isMethod('post')) {
            $messages = [
                'required' => ':attribute es requerido',
                'string' => ':attribute debe ser de tipo texto',
                'numeric' => ':attribute debe ser de tipo número',
                'unique:tw_contratos_corporativos' => ':attribute ya existe'
            ];

            $validator = Validator::make($request->all(), [
                'S_Nombre' => 'required|string|unique:tw_contratos_corporativos',
                'S_Puesto' => 'required|string|',
                'S_Email'  => 'required|string|',
                'tw_corporativos_id' => 'required|numeric|'
            ], $messages);

            $errors = '';
            if($validator->fails()){
                $arrayMsj = json_decode($validator->getMessageBag());
                foreach ($arrayMsj as $key => $value){
                    $errors .= ', '.$value[0];
                }
                $errors = substr($errors, 2, strlen($errors));
                return response()->json([
                    'message' => $errors], Response::HTTP_BAD_REQUEST);
            }
            $oCorporativo = tw_corporativos::find($request->tw_corporativos_id);
            if ($oCorporativo) {
                $oRegistro = new tw_contratos_corporativos();
                $oRegistro->S_Nombre = $request->S_Nombre;
                $oRegistro->S_Puesto = $request->S_Puesto;
                $oRegistro->S_Email = $request->S_Email;
                $oRegistro->tw_corporativos_id = $request->tw_corporativos_id;
                $oRegistro->save();
                return response()->json([
                    'message' => 'Registrado'], Response::HTTP_CREATED);
            }else{
                return response()->json([
                    'message' => 'Id de corporativo no encontrado'],
                    Response::HTTP_NOT_FOUND);
            }
        }else{
            return response()->json([
                'message' => 'Metodo debe ser post'],
                Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

    public function update($id, Request $request)
    {
        if ($request->isMethod('put')) {
            $oRegistro = tw_contratos_corporativos::find($id);
            if($oRegistro) {
                $messages = [
                    'required' => ':attribute es requerido',
                    'string' => ':attribute debe ser de tipo texto',
                    'numeric' => ':attribute debe ser de tipo número'
                ];

                $validator = Validator::make($request->all(), [
                    'S_Nombre' => 'required|string|unique:tw_contratos_corporativos',
                    'S_Puesto' => 'required|string|',
                    'S_Email'  => 'required|string|',
                    'tw_corporativos_id' => 'required|numeric|'
                ], $messages);

                $errors = '';
                if($validator->fails()){
                    $arrayMsj = json_decode($validator->getMessageBag());
                    foreach ($arrayMsj as $key => $value){
                        $errors .= ', '.$value[0];
                    }
                    $errors = substr($errors, 2, strlen($errors));
                    return response()->json([
                        'message' => $errors], Response::HTTP_NOT_ACCEPTABLE);
                }
                $oRegistro->S_Nombre = $request->S_Nombre;
                $oRegistro->S_Puesto = $request->S_Puesto;
                $oRegistro->S_Email = $request->S_Email;
                $oRegistro->tw_corporativos_id = $request->tw_corporativos_id;
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
        $oRegistro = tw_contratos_corporativos::find($id);
        if ($oRegistro) {
            $oRegistro->delete();
            return response()->json([
                'message' => 'Registro dado de baja'], Response::HTTP_NO_CONTENT);
        } else {
            return response()->json([
                'message' => 'Registro no encontrado'], Response::HTTP_NOT_FOUND);
        }
    }
}
