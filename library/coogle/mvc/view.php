<?php

namespace Coogle\Mvc;

use Coogle\Utils\Registry;
use Coogle\Mvc\View\Renderer;

/**
 * This View class is used within a controller to indicate the template you
 * want to render. i.e.
 * 
 * return View::render('index.index')
 * 
 * from within a controller will render the index/index.phtml template
 */
class View
{
	/**
	 * @var array
	 */
	static protected $_config = [];
	
	/**
	 * @return array the $_config
	 */
	static public function getConfig() {
		return static::$_config;
	}
	
	/**
	 * @param multitype: $_config
	 */
	static public function setConfig(array $_config) {
		static::$_config = $_config;
	}
	
	/**
	 * Render a given template and return a string of the rendering
	 * 
	 * @param string $template Either a template in <controller>.<action> format or a full path
	 * @param array $variables An array of variables to include in the template
	 * @param string $layout The layout to use, or if null just the template will be rendered
	 * @throws \Exception
	 * @return string
	 */
	static public function render($template, $variables = [], $layout = 'main')
	{
		static::setConfig(Registry::get('Config')['view']);
		
		if(strpos($template, '.') === false) {
			$templateFile = strtolower(static::getConfig()['viewPath'] . DIRECTORY_SEPARATOR . $template);
		} else {
			
			$templateFile = strtolower(static::getConfig()['viewPath'] . DIRECTORY_SEPARATOR . 
							str_replace('.', DIRECTORY_SEPARATOR, $template) . '.phtml');
		}
		
		if(!file_exists($templateFile) || !is_readable($templateFile)) {
			throw new \Exception("Could not locate view: {$templateFile}");
		}
		
		$layoutFile = strtolower(static::getConfig()['viewPath'] . DIRECTORY_SEPARATOR . 
								'layouts' . DIRECTORY_SEPARATOR . "$layout.phtml");
		
		if(!file_exists($layoutFile) || !is_readable($layoutFile)) {
			$layoutFile = null;
		}
		
		$renderer = new Renderer();
		
		return $renderer->render($templateFile, $layoutFile, $variables);
	}
}