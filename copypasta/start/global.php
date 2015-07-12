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
	
	if(!\Config::get('debug')) {
	    switch ($code) {
	        case 403:
	            return Response::view('errors.403', array(), 403);
	
	        case 404:
	            return Response::view('errors.404', array(), 404);
	
	        case 500:
	            return Response::view('errors.500', array(), 500);
	
	        default:
	            return Response::view('errors.default', array(), $code);
	    }
	}
	
});