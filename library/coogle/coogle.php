<?php

use Coogle\Utils\Config;
use Coogle\Utils\Registry;
use Coogle\Mvc\Request;
use Coogle\Mvc\Response;
use Coogle\Mvc\Router;
use Coogle\Mvc\Dispatcher;
use Coogle\Database\Migrater;

/**
 * Base application class, responsible for bootstrapping, etc.
 */
class Coogle
{
	/**
	 * Called to init the app from index.php, sets up include paths,
	 * loads config, etc.
	 * 
	 * @return Coogle;
	 */
	public function initApp()
	{
		ob_start();
		ob_clean();
		
		date_default_timezone_set('UTC');
		
		ini_set('display_errors', true);
		
		set_include_path(get_include_path() . PATH_SEPARATOR . COOGLE_APP_DIR . 'library');
		set_include_path(get_include_path() . PATH_SEPARATOR . COOGLE_APP_DIR . 'controllers');
		set_include_path(get_include_path() . PATH_SEPARATOR . COOGLE_APP_DIR . 'models');
		// Just using the default autoloader, not as pretty filenames
		// but I think we'll survive.
		spl_autoload_extensions(".php");
		spl_autoload_register();
		
		$config = new Config();
		$config->loadConfigs(COOGLE_APP_DIR . 'config');
		
		Registry::set('Config', $config);
		
		set_exception_handler(array('Coogle\Mvc\ErrorHandler', 'exceptionHandler'));
		
		return $this;
	}

	public function runMigrater()
	{
		try {
			$migrater = new Migrater();
			$migrater->run();
		} catch(\Exception $e) {
			print "Exception Caught: {$e->getMessage()}\n\n";
			print $e->getTraceAsString();
			exit;
		}
	}
	
	public function run(Coogle\Mvc\Request $request = null, Coogle\Mvc\Response $response = null)
	{
		$request = is_null($request) ? new Request() : $request;
		$response = is_null($response) ? new Response() : $response;
		
		$router = new Router();
		if(!$router->route($request, $response)) {
			return $this->renderResponse($response);
		}
		
		$dispatcher = new Dispatcher();
		
		$response = $dispatcher->dispatch($request, $response);
		return $this->renderResponse($response);
	}
	
	public function renderResponse(\Coogle\Mvc\Response $response)
	{
		ob_clean();
		
		$contentTypeStr = "{$response->getContentType()}; charset={$response->getCharset()}";
		
		header("Content-type: $contentTypeStr");
		
		http_response_code($response->getHttpCode());
		
		echo $response->getContent();
		
		ob_end_flush();
	}
}