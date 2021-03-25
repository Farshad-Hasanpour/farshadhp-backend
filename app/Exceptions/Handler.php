<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->reportable(function (Throwable $e) {
            //
        });
	
		$this->renderable(function (HttpException $e) {
			$code = $e->getStatusCode();
			return response([
				'success' => false,
				'code' => $code,
				'message' => $e->getMessage()
			], $code);
		});
	
		$this->renderable(function (AuthenticationException $e) {
			return response([
				'success' => false,
				'code' => 401,
				'message' => __('auth.unauthorized')
			], 401);
		});
	
		$this->renderable(function (Throwable $e) {
			return response([
				'success' => false,
				'code' => 500,
				'message' => $e->getMessage()
			], 500);
		});
		
		
    }
}
