<?php

/**
 * Better error log formatting and information
 */

Log::useDailyFiles(storage_path().'/logs/'.'log-'.php_sapi_name().'.txt');
App::error(function(Exception $exception, $code) {
	
	if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
		Log::info('NotFoundHttpException Route: ' . Request::url() . ' ['.Request::method().']' );
	} elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
		Log::info('MethodNotAllowedHttpException Route: ' . Request::url() . ' ['.Request::method().']' );
	} elseif ($exception instanceof \Illuminate\Database\QueryException) {
		Log::error('QueryException : ' . "\n *** " . query_interpolate($exception->getSql(), $exception->getBindings()) . " *** \n" . $exception->getMessage() );
	} else {
		Log::error($exception);
	}
	
});