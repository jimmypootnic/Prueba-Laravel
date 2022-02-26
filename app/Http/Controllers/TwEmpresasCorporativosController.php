<?php

namespace App\Http\Controllers;

use App\Models\tw_empresas_corporativos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TwEmpresasCorporativosController extends Controller
{
    public function getAll(Request $request ){
        $oData = new tw_empresas_corporativos();
        $data = $oData->all();
        return response()->json([
            'data' => $data], Response::HTTP_OK);
    }

    public function getById( $id, Request $request )
    {
        $oRegistro = tw_empresas_corporativos::find( $id );
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
                'unique:tw_empresas_corporativos' => ':attribute ya existe'
            ];

            $validator = Validator::make($request->all(), [
                'tw_corporativos_id' => 'required|numeric|exists:App\Models\tw_corporativos,id|',
                'S_RazonSocial' => 'required|string|',
                'S_RFC' => 'required|string|unique:tw_empresas_corporativos',
                'S_Activo' => 'required|numeric|',
            ], $messages);

            $errors = '';
            if ($validator->fails()) {
                $arrayMsj = json_decode($validator->getMessageBag());
                foreach ($arrayMsj as $key => $value) {
                    $input = str_replace( "tw corporativos id", "tw_corporativos_id", $value[0]);
                    $input = str_replace( "S RazonSocial", "S_RazonSocial", $input);
                    $input = str_replace( "S RFC", "S_RFC", $input);
                    $input = str_replace( "S Activo", "S_Activo", $input);
                    $errors .= ', ' . $input;
                }
                $errors = substr($errors, 2, strlen($errors));
                return response()->json([
                    'message' => $errors], Response::HTTP_BAD_REQUEST);
            }

            $oRegistro = new tw_empresas_corporativos();
            $oRegistro->tw_corporativos_id = $request->tw_corporativos_id;
            $oRegistro->S_RazonSocial = $request->S_RazonSocial;
            $oRegistro->S_RFC = $request->S_RFC;
            $oRegistro->S_Activo = $request->S_Activo;
            if ($request->exists('S_Pais')) {
                $oRegistro->S_Pais = $request->S_Pais;
            }if ($request->exists('S_Estado')) {
                $oRegistro->S_Estado = $request->S_Estado;
            }if ($request->exists('S_Municipio')) {
                $oRegistro->S_Municipio = $request->S_Municipio;
            }if ($request->exists('S_ColoniaLocalidad')) {
                $oRegistro->S_ColoniaLocalidad = $request->S_ColoniaLocalidad;
            }if ($request->exists('S_Domicilio')) {
                $oRegistro->S_Domicilio = $request->S_Domicilio;
            }if ($request->exists('S_CodigoPostal')) {
                $oRegistro->S_CodigoPostal = $request->S_CodigoPostal;
            }if ($request->exists('S_UsoCFDI')) {
                $oRegistro->S_UsoCFDI = $request->S_UsoCFDI;
            }if ($request->exists('S_UrlRFC')) {
                $oRegistro->S_UrlRFC = $request->S_UrlRFC;
            }if ($request->exists('S_UrlActaConstitutiva')) {
                $oRegistro->S_UrlActaConstitutiva = $request->S_UrlActaConstitutiva;
            }if ($request->exists('S_Comentarios')) {
                $oRegistro->S_Comentarios = $request->S_Comentarios;
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
            $oRegistro = tw_empresas_corporativos::find($id);
            if($oRegistro) {
                $messages = [
                    'required' => ':attribute es requerido',
                    'string' => ':attribute debe ser de tipo texto',
                    'numeric' => ':attribute debe ser de tipo número',
                    'exists' => ':attribute no existe en la base de datos',
                ];

                $validator = Validator::make($request->all(), [
                    'tw_corporativos_id' => 'required|numeric|exists:App\Models\tw_corporativos,id|',
                    'S_RazonSocial' => 'required|string|',
                    'S_RFC' => 'required|string|',
                    'S_Activo' => 'required|numeric|',
                ], $messages);

                $errors = '';
                if($validator->fails()){
                    $arrayMsj = json_decode($validator->getMessageBag());
                    foreach ($arrayMsj as $key => $value){
                        $input = str_replace( "tw corporativos id", "tw_corporativos_id", $value[0]);
                        $input = str_replace( "S RazonSocial", "S_RazonSocial", $input);
                        $input = str_replace( "S RFC", "S_RFC", $input);
                        $input = str_replace( "S Activo", "S_Activo", $input);
                        $errors .= ', '.$input;
                    }
                    $errors = substr($errors, 2, strlen($errors));
                    return response()->json([
                        'message' => $errors], Response::HTTP_NOT_ACCEPTABLE);
                }
                $oRegistro->tw_corporativos_id = $request->tw_corporativos_id;
                $oRegistro->S_RazonSocial = $request->S_RazonSocial;
                $oRegistro->S_RFC = $request->S_RFC;
                $oRegistro->S_Activo = $request->S_Activo;
                if ($request->exists('S_Pais')) {
                    $oRegistro->S_Pais = $request->S_Pais;
                }if ($request->exists('S_Estado')) {
                    $oRegistro->S_Estado = $request->S_Estado;
                }if ($request->exists('S_Municipio')) {
                    $oRegistro->S_Municipio = $request->S_Municipio;
                }if ($request->exists('S_ColoniaLocalidad')) {
                    $oRegistro->S_ColoniaLocalidad = $request->S_ColoniaLocalidad;
                }if ($request->exists('S_Domicilio')) {
                    $oRegistro->S_Domicilio = $request->S_Domicilio;
                }if ($request->exists('S_CodigoPostal')) {
                    $oRegistro->S_CodigoPostal = $request->S_CodigoPostal;
                }if ($request->exists('S_UsoCFDI')) {
                    $oRegistro->S_UsoCFDI = $request->S_UsoCFDI;
                }if ($request->exists('S_UrlRFC')) {
                    $oRegistro->S_UrlRFC = $request->S_UrlRFC;
                }if ($request->exists('S_UrlActaConstitutiva')) {
                    $oRegistro->S_UrlActaConstitutiva = $request->S_UrlActaConstitutiva;
                }if ($request->exists('S_Comentarios')) {
                    $oRegistro->S_Comentarios = $request->S_Comentarios;
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
        $oRegistro = tw_empresas_corporativos::find($id);
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
