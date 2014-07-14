<?php

namespace Coogle\Mvc\View;

use \Coogle\Utils\Registry;

/**
 * The renderer class is responsible for actually loading the 
 * view template, injecting the variables into it, providing
 * escape functionality, etc.
 */
class Renderer
{
	/**
	 * @var array
	 */
	protected $_config = [];
	
	/**
	 * @var string
	 */
	protected $_contentTemplate = null;
	
	/**
	 * The variables available in the view template
	 * @var array
	 */
	protected $_renderVars = [];
	
	/**
	 * The constructor
	 */
	public function __construct()
	{
		$this->setConfig(Registry::get('Config')['view']);
	}
	
	/**
	 * This magic method is used from within a view template to provide
	 * access to the variables.. i.e. from within view $this->foobar
	 * 
	 * @param string $key
	 * @return multitype:
	 */
	public function __get($key) 
	{
		if(isset($this->_renderVars[$key])) {
			return $this->_renderVars[$key];
		}
	}

	/**
	 * Called by the View class to render a given template, given layout with
	 * the given variables injected into it.
	 * 
	 * @param unknown $__templateFile
	 * @param unknown $__layoutFile
	 * @param array $__vars
	 * @throws \Exception
	 * @return string
	 */
	public function render($__templateFile, $__layoutFile, array $__vars = [])
	{
		if(!file_exists($__templateFile) && is_readable($__templateFile)) {
			throw new \Exception("Could not locate view: {$__templateFile}");
		}
		
		$this->setContentTemplate($__templateFile);
		$this->setRenderVars($__vars);
		
		ob_start();
		
		if(isset($__layoutFile)) {
			include $__layoutFile;
		} else {
			include $__templateFile;
		}
		
		return ob_get_clean();
	}
	
	/**
	 * @param array $_renderVars
	 */
	public function setRenderVars(array $_renderVars) {
		$this->_renderVars = $_renderVars;
		return $this;
	}

	/**
	 * @return string the $_contentTemplate
	 */
	public function getContentTemplate() {
		return $this->_contentTemplate;
	}

	/**
	 * @param string $_contentTemplate
	 */
	public function setContentTemplate($_contentTemplate) {
		$this->_contentTemplate = $_contentTemplate;
		return $this;
	}

	/**
	 * @return array the $_config
	 */
	public function getConfig() {
		return $this->_config;
	}
	
	/**
	 * @param multitype: $_config
	 */
	public function setConfig(array $_config) {
		$this->_config = $_config;
		return $this;
	}
	
	/**
	 * Return the actual content of the template, used
	 * when using layouts
	 */
	public function content()
	{
		include $this->getContentTemplate();
	}
	
	/**
	 * Make the given string HTML friendly.
	 * @param unknown $data
	 * @return string
	 */
	public function esc($data)
	{
		return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	}
}