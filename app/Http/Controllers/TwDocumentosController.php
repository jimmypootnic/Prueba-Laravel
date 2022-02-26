<?php

namespace App\Http\Controllers;

use App\Models\tw_corporativos;
use App\Models\tw_documentos;
use App\Models\tw_documentos_corporativos;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class TwDocumentosController extends Controller
{
    public function getAll(Request $request ){
        $oData = new tw_documentos();
        $data = $oData->all();
        return response()->json([
            'data' => $data], Response::HTTP_OK);
    }

    public function getById( $id, Request $request )
    {
        $oDocumento = tw_documentos::find($id);
        if ($oDocumento) {
            $arrayDoc = $oDocumento;
            if ($oDocumento->tw_documentos_corporativos){
                $arrayDocCorp = $oDocumento->tw_documentos_corporativos->toArray();
                $docsCorp = $oDocumento->tw_documentos_corporativos;
                foreach ($docsCorp as $tw_documentos_corporativo){
                    $arrayDocCorp= Arr::add($arrayDocCorp, 'tw_corporativos', $tw_documentos_corporativo->tw_corporativos);
                }
                $arrayDoc = Arr::add($arrayDoc, 'tw_documentos_corporativos', $arrayDocCorp);
            }
        } else {
            $arrayDoc = array();
        }
        return response()->json([
            'data' => $arrayDoc], Response::HTTP_OK);
    }

    public function create( Request $request )
    {
        if ($request->isMethod('post')) {
            $messages = [
                'required' => ':attribute es requerido',
                'string' => ':attribute debe ser de tipo texto',
                'numeric' => ':attribute debe ser de tipo número',
                'unique:tw_documentos' => ':attribute ya existe'
            ];

            $validator = Validator::make($request->all(), [
                'S_Nombre' => 'required|string|unique:tw_documentos',
                'NObligatorio' => 'required|numeric|',
            ], $messages);

            $errors = '';
            if ($validator->fails()) {
                $arrayMsj = json_decode($validator->getMessageBag());
                foreach ($arrayMsj as $key => $value) {
                    $errors .= ', ' . $value[0];
                }
                $errors = substr($errors, 2, strlen($errors));
                return response()->json([
                    'message' => $errors], Response::HTTP_BAD_REQUEST);
            }

            $oRegistro = new tw_documentos();
            $oRegistro->S_Nombre = $request->S_Nombre;
            $oRegistro->N_Obligatorio = $request->NObligatorio;
            if ($request->exists('SDescripcion')) {
                $oRegistro->S_Descripcion = $request->SDescripcion;
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
            $oRegistro = tw_documentos::find($id);
            if($oRegistro) {
                $messages = [
                    'required' => ':attribute es requerido',
                    'string' => ':attribute debe ser de tipo texto',
                    'numeric' => ':attribute debe ser de tipo número',
                ];

                $validator = Validator::make($request->all(), [
                    'S_Nombre' => 'required|string|',
                    'NObligatorio' => 'required|numeric|',
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
                $oRegistro->N_Obligatorio = $request->NObligatorio;
                if ($request->exists('SDescripcion')){
                    $oRegistro->S_Descripcion = $request->SDescripcion;
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
        $oRegistro = tw_documentos::find($id);
        if ($oRegistro) {
            $oRegistro->delete();
            return response()->json(['message' => 'Registro eliminado'], Response::HTTP_NO_CONTENT);
        } else {
            return response()->json([
                'message' => 'Registro no encontrado'], Response::HTTP_NOT_FOUND);
        }
    }
}
