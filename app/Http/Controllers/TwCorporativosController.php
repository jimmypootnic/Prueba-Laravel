<?php

namespace App\Http\Controllers;

use App\Models\tw_contactos_corporativos;
use App\Models\tw_contratos_corporativos;
use App\Models\tw_corporativos;
use App\Models\tw_documentos_corporativos;
use App\Models\tw_empresas_corporativos;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PhpParser\Node\Expr\Array_;

class TwCorporativosController extends Controller
{
    public function getAll(Request $request ){
        $oData = new tw_corporativos();
        $data = $oData->all();
        return response()->json([
            'data' => $data], Response::HTTP_OK);
    }

    public function getById( $id, Request $request )
    {
        $oCorporativo = tw_corporativos::find($id);
        if ($oCorporativo) {
            $arrayCorp = $oCorporativo->toArray();
            $oEmpresasC = $oCorporativo->tw_empresas_corporativos;
            $oContactosC =  $oCorporativo->tw_contactos_corporativos;
            $oContratosC =  $oCorporativo->tw_contratos_corporativos;
            $oDocumentosC =  $oCorporativo->tw_documentos_corporativos;
            $arrayCorp = Arr::add($arrayCorp, 'tw_empresas_corporativos', $oEmpresasC);
            $arrayCorp = Arr::add($arrayCorp, 'tw_contactos_corporativo', $oContactosC);
            $arrayCorp = Arr::add($arrayCorp, 'tw_contratos_corporativo', $oContratosC);
            $arrayCorp = Arr::add($arrayCorp, 'tw_documentos_corporativo', $oDocumentosC);
        }else {
            $arrayCorp = Array();
        }
        $data = [
            'Corporativo' => $arrayCorp
        ];

        return response()->json([
            'data' => $data], Response::HTTP_OK);
    }

    public function create( Request $request )
    {
        if ($request->isMethod('post')) {
            $messages = [
                'required' => ':attribute es requerido',
                'string' => ':attribute debe ser de tipo texto',
                'numeric' => ':attribute debe ser de tipo número',
                'unique:tw_corporativos' => ':attribute ya existe'
            ];

            $validator = Validator::make($request->all(), [
                'S_NombreCorto' => 'required|string|unique:tw_corporativos',
                'SNombreCompleto' => 'required|string|',
                'SDBName' => 'required|string|',
                'SDBUsuario' => 'required|string|',
                'SDBPassword' => 'required|string|',
                'SSystemUrl' => 'required|string|',
                'SActivo' => 'required|numeric|',
                'DFechaIncorporacion' => 'required|string|',
                'TwUsuariosId' => 'required|numeric|',
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
            $oUser = User::find($request->TwUsuariosId);
            if ($oUser) {
                $oRegistro = new tw_corporativos();
                $oRegistro->S_NombreCorto = $request->S_NombreCorto;
                $oRegistro->S_NombreCompleto = $request->SNombreCompleto;
                $oRegistro->S_DBName = $request->SDBName;
                $oRegistro->S_DBUsuario = $request->SDBUsuario;
                $oRegistro->S_DBPassword = $request->SDBPassword;
                $oRegistro->S_SystemUrl = $request->SSystemUrl;
                $oRegistro->S_Activo = $request->SActivo;
                $oRegistro->D_FechaIncorporacion = $request->DFechaIncorporacion;
                $oRegistro->tw_usuarios_id = $request->TwUsuariosId;
                if ($request->exists('SLogoURL')){
                    $oRegistro->S_LogoURL = $request->SLogoURL;
                }
                $oRegistro->save();
                return response()->json([
                    'message' => 'Registrado'], Response::HTTP_CREATED);
            }else{
                return response()->json([
                    'message' => 'Id de usuario no encontrado'],
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
            $oRegistro = tw_corporativos::find($id);
            if($oRegistro) {
                $messages = [
                    'required' => ':attribute es requerido',
                    'string' => ':attribute debe ser de tipo texto',
                    'numeric' => ':attribute debe ser de tipo número',
                ];

                $validator = Validator::make($request->all(), [
                    'S_NombreCorto' => 'required|string|',
                    'SNombreCompleto' => 'required|string|',
                    'SDBName' => 'required|string|',
                    'SDBUsuario' => 'required|string|',
                    'SDBPassword' => 'required|string|',
                    'SSystemUrl' => 'required|string|',
                    'SActivo' => 'required|numeric|',
                    'DFechaIncorporacion' => 'required|string|',
                    'TwUsuariosId' => 'required|numeric|',
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
                $oRegistro->S_NombreCorto = $request->S_NombreCorto;
                $oRegistro->S_NombreCompleto = $request->SNombreCompleto;
                $oRegistro->S_DBName = $request->SDBName;
                $oRegistro->S_DBUsuario = $request->SDBUsuario;
                $oRegistro->S_DBPassword = $request->SDBPassword;
                $oRegistro->S_SystemUrl = $request->SSystemUrl;
                $oRegistro->S_Activo = $request->SActivo;
                $oRegistro->D_FechaIncorporacion = $request->DFechaIncorporacion;
                $oRegistro->tw_usuarios_id = $request->TwUsuariosId;
                if ($request->exists('SLogoURL')){
                    $oRegistro->S_LogoURL = $request->SLogoURL;
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
        $oRegistro = tw_corporativos::find($id);
        if ($oRegistro) {
            $oRegistro->delete_at = Now();
            $oRegistro->save();
            return response()->json(['message' => 'Registro dado de baja'], Response::HTTP_NO_CONTENT);
        } else {
            return response()->json([
                'message' => 'Registro no encontrado'], Response::HTTP_NOT_FOUND);
        }
    }
}
