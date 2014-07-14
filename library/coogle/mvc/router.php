<?php

namespace Coogle\Mvc;

use Coogle\Utils\Registry;

/**
 * The router looks at the application config and maps the URI requested on the server
 * (i.e. /foo/bar) to a controller and an action for the dispatcher to do something with
 */
class Router
{
	/**
	 * An array of valid routes
	 * 
	 * @var array
	 */
	protected $_routes;
	
	/**
	 * @var \Coogle\Mvc\Request;
	 */
	protected $_request;
	
	/**
	 * @return \Coogle\Mvc\Request the $_request
	 */
	public function getRequest() {
		return $this->_request;
	}

	/**
	 * @param \Coogle\Mvc\Request; $_request
	 */
	public function setRequest(\Coogle\Mvc\Request $_request) {
		$this->_request = $_request;
	}

	/**
	 * @return array the $_routes
	 */
	public function getRoutes() {
		return $this->_routes;
	}

	/**
	 * @param array $_routes
	 */
	public function setRoutes(array $_routes) {
		$this->_routes = $_routes;
		
		return $this;
	}

	public function __construct()
	{
		$this->setRoutes(Registry::get('Config')['routes']);
	}
	
	/**
	 * Route the request to a controller and action.
	 * 
	 * @param \Coogle\Mvc\Request $request
	 * @param \Coogle\Mvc\Response $response
	 * @return boolean
	 */
	public function route(\Coogle\Mvc\Request $request, \Coogle\Mvc\Response $response)
	{
		$this->setRequest($request);
		
		$uri = $request->uuri();
		
		if(!$this->match($uri)) {
			$response->setHttpCode(404)->setContent("Route Not found");
			return false;
		}
		
		return true;
	}
	
	/**
	 * Matches the string input URI to a route based on routing
	 * rules.
	 * 
	 * @param string $uri
	 * @return bool true if route was matched, false if no route found
	 */
	public function match($uri)
	{
		$uri = strtolower($uri);
		
		foreach($this->getRoutes() as $route)
		{
			if($route['path'] == $uri) {
				
				$this->getRequest()->setController($route['controller'])
								   ->setAction($route['action']);
				return true;
			}
		}
		
		return false;
	}
}