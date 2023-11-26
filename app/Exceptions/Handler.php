<?php

namespace App\Exceptions;

use App\Http\Traits\ApiResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (\Exception $e, $request) {
            Log::error($e);

            if ($request->is('api/*')) {
                return $this->respondWithError('Something went wrong, Try again later, '.$e->getMessage(),$e->getCode(),Response::HTTP_NOT_FOUND);
            }

        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
