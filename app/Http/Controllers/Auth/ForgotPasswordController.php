<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function forgot(Request $request) {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => trans($validator->errors()->first())], Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                    $message->subject($this->getEmailSubject());
                });
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return response()->json([
                            'message' => "Se ha enviado un link a su correo para restablecer su contraseña"], Response::HTTP_OK);
                    case Password::INVALID_USER:
                        return response()->json([
                            'message' => trans($response)], Response::HTTP_NOT_FOUND);
                }
            }  catch (\Throwable $ex) {
                return response()->json([
                    'message' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
