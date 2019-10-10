<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data,$message) {
            return Response::json([
                'message'=>$message,
                'errors'      => false,
                'data'        => $data,
                'status_code' => 200,
                'status'=>true
            ]);
        });
        Response::macro('error', function ($message, $status = 400) {
            return Response::json([
                'message'     => $message,
                'errors'      => [
                    'message' => [$message],
                ],
                'status_code' => $status,
                'status'=>false
            ], $status);
        });
        Response::macro('exception', function ($message, $status = 400) {
            return Response::json([
                'message'     => $status . ' error',
                'errors'      => [
                    'message' => [$message],
                ],
                'status_code' => $status,
                'status'=>false
            ], $status);
        });
        Response::macro('notFound', function ($message, $status = 404) {
            return Response::json([
                'message'     => $message,
                'data'        => null,
                'status_code' => $status,
                'status' => false,
                'errors' => false
            ], $status);
        });
        Response::macro('validationError', function ($errors) {
            return Response::json([
                'status_code' => 422,
                'errors'      => $errors,
                'message'     => count($errors)>0?$errors->first():'422 Unprocessable Entity',
                'status'=>false
            ], 422);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
