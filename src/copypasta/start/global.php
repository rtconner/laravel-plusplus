<?php

/**
 * Use this to make 404's not clutter up your log files so much.
 * ... or just comment out the Log::info line of code
 */
App::error(function(Exception $exception, $code) {
	
	if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
		Log::info('NotFoundHttpException Route: ' . Request::url() );
	} else {
		Log::error($exception);
	}
	
});