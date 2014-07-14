<?php

namespace Coogle\Mvc;

/**
 * A simple error handler to display the exception in a nicer way.
 */
class ErrorHandler
{
	/**
	 * A callback when an uncaught exception is throw.
	 * @param \Exception $exception
	 */
	static public function exceptionHandler(\Exception $exception)
	{
		ob_clean();
		
		echo "Exception: {$exception->getMessage()}</hr>";
		echo "<pre>";
		echo $exception->getTraceAsString();
		echo "</pre>";
		
		ob_end_flush();
		exit;
	}
}