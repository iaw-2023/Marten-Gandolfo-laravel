<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomExceptionHandler extends Exception
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
        }else{
            Log::error($exception);
            return response()->view('errors.500', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //return parent::render($request, $exception);
    }
}
