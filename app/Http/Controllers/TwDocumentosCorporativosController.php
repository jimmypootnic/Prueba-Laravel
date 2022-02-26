<?php

namespace App\Http\Controllers;

use App\Models\tw_documentos_corporativos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TwDocumentosCorporativosController extends Controller
{
    public function getAll(Request $request ){
        $oData = new tw_documentos_corporativos();
        $data = $oData->all();
        return response()->json([
            'data' => $data], Response::HTTP_OK);
    }

    public function getById( $id, Request $request )
    {
        $oRegistro = tw_documentos_corporativos::find( $id );
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
                'exists' => ':attribute no existe en la base de datos',
            ];

            $validator = Validator::make($request->all(), [
                'tw_corporativos_id' => 'required|numeric|exists:App\Models\tw_corporativos,id|',
                'tw_documentos_id' => 'required|numeric|exists:App\Models\tw_documentos,id|',
            ], $messages);

            $errors = '';
            if ($validator->fails()) {
                $arrayMsj = json_decode($validator->getMessageBag());
                foreach ($arrayMsj as $key => $value) {
                    $input = str_replace( "tw corporativos id", "tw_corporativos_id", $value[0]);
                    $input = str_replace( "tw documentos id", "tw_documentos_id", $input);
                    $errors .= ', ' . $input;
                }
                $errors = substr($errors, 2, strlen($errors));
                return response()->json([
                    'message' => $errors], Response::HTTP_BAD_REQUEST);
            }

            $oRegistro = new tw_documentos_corporativos();
            $oRegistro->tw_corporativos_id = $request->tw_corporativos_id;
            $oRegistro->tw_documentos_id = $request->tw_documentos_id;
            if ($request->exists('S_ArchivoUrl')) {
                $oRegistro->S_ArchivoUrl = $request->S_ArchivoUrl;
            }
            $oRegistro->save();
            return response()->json([
                'message' => 'Registrado'], Response::HTTP_CREATED);
        }else{
            return response()->json([
                'message' => 'Metodo debe ser post'],
                Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

    public function update($id, Request $request)
    {
        if ($request->isMethod('put')) {
            $oRegistro = tw_documentos_corporativos::find($id);
            if($oRegistro) {
                $messages = [
                    'required' => ':attribute es requerido',
                    'string' => ':attribute debe ser de tipo texto',
                    'numeric' => ':attribute debe ser de tipo número',
                    'exists' => ':attribute no existe en la base de datos',
                ];

                $validator = Validator::make($request->all(), [
                    'tw_corporativos_id' => 'required|numeric|exists:App\Models\tw_corporativos,id|',
                    'tw_documentos_id' => 'required|numeric|exists:App\Models\tw_documentos,id|',
                ], $messages);

                $errors = '';
                if($validator->fails()){
                    $arrayMsj = json_decode($validator->getMessageBag());
                    foreach ($arrayMsj as $key => $value){
                        $input = str_replace( "tw corporativos id", "tw_corporativos_id", $value[0]);
                        $input = str_replace( "tw documentos id", "tw_documentos_id", $input);
                        $errors .= ', '.$input;
                    }
                    $errors = substr($errors, 2, strlen($errors));
                    return response()->json([
                        'message' => $errors], Response::HTTP_NOT_ACCEPTABLE);
                }
                $oRegistro->tw_corporativos_id = $request->tw_corporativos_id;
                $oRegistro->tw_documentos_id = $request->tw_documentos_id;
                if ($request->exists('S_ArchivoUrl')) {
                    $oRegistro->S_ArchivoUrl = $request->S_ArchivoUrl;
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
        $oRegistro = tw_documentos_corporativos::find($id);
        if ($oRegistro) {
            $oRegistro->delete();
            return response()->json(['message' => 'Registro eliminado'], Response::HTTP_NO_CONTENT);
        } else {
            return response()->json([
                'message' => 'Registro no encontrado'], Response::HTTP_NOT_FOUND);
        }
    }
}
