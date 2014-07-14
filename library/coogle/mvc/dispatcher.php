<?php

namespace Coogle\Mvc;

use Coogle\Utils\Registry;

/**
 * The dispatcher class is used to actually locate a controller
 * which we need to use and execute the actions and ultimately
 * return a response object to be displayed to the user.
 */
Class Dispatcher
{
	/**
	 * @var \Coogle\Mvc\Request;
	 */
	protected $_request;
	
	/**
	 * @var \Coogle\Mvc\Response;
	 */
	protected $_response;
	
	/**
	 * @var array
	 */
	protected $_config;
	
	/**
	 * The constructor
	 */
	public function __construct()
	{
		$this->setConfig(Registry::get('Config')['dispatcher']);
	}
	
	/**
	 * @return array the $_config
	 */
	public function getConfig() {
		return $this->_config;
	}

	/**
	 * @param array $_config
	 */
	public function setConfig(array $_config) {
		$this->_config = $_config;
	}

	/**
	 * @return \Coogle\Mvc\Request the $_request
	 */
	public function getRequest() {
		return $this->_request;
	}

	/**
	 * @return \Coogle\Mvc\Response the $_response
	 */
	public function getResponse() {
		return $this->_response;
	}

	/**
	 * @param \Coogle\Mvc\Request; $_request
	 */
	public function setRequest($_request) {
		$this->_request = $_request;
		return $this;
	}

	/**
	 * @param \Coogle\Mvc\Response; $_response
	 */
	public function setResponse($_response) {
		$this->_response = $_response;
		return $this;
	}

	/**
	 * Dispatch the given request, execute the controller/action, and get back the response
	 * 
	 * @param \Coogle\Mvc\Request $request
	 * @param \Coogle\Mvc\Response $response
	 * @return boolean|\Coogle\Mvc\Response|Ambigous <\Coogle\Mvc\Response, unknown>
	 */
	public function dispatch(\Coogle\Mvc\Request $request, \Coogle\Mvc\Response $response = null)
	{
		$response = is_null($response) ? new Response() : $response;
		
		$this->setRequest($request)
			 ->setResponse($response);
		
		$includePath = $this->getConfig()['controllerPath'];
		
		$controller = $request->getController();
		$action = $request->getAction() . 'Action';
		
		$matches = null;
		if (preg_match('@\\\\([\w]+)$@', $controller, $matches)) {
			$className = $matches[1];
		}
		
		$fqfn = $includePath . DIRECTORY_SEPARATOR . strtolower($className) . '.php';
		
		if(!file_exists($fqfn)) {
			$response->setHttpCode(404);
			$response->setContent('Controller not found');
			return false;
		}
		
		include_once $fqfn;
		
		if(!class_exists($request->getController(), false)) {
			$response->setHttpCode(404);
			$response->setContent('Controller not found');
			return false;
		}
		
		$controller = new $controller($request, $response);
		
		if(!method_exists($controller, $action)) {
			$response->setHttpCode(404);
			$response->setContent('Action not found');
		}
		
		$controller->setRequest($request);
		$controller->setResponse($response);
		
		$result = $controller->$action();
		
		switch(true) {
			case $result instanceof Response:
				return $result;
				break;
			default:
			case is_string($result):
				$response->setContent((string)$result);
				break;
		}
		
		return $response;
	}
	
}