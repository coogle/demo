<?php

namespace Coogle\Database;

use Coogle\Utils\Registry;

/**
 * Our Database driver, which is an extension of PDO
 * with it tied into our configuration system
 */
class Driver extends \PDO
{
	/**
	 * @var self
	 */
	static protected $_instance = null;
	
	/**
	 * @var array
	 */
	protected $_config;
	
	/**
	 * Singleton pattern to make sure we don't keep
	 * making DB connections. 
	 * @return self
	 */
	static public function getInstance()
	{
		if(is_null(static::$_instance) || !(static::$_instance instanceof self)) {
			
			$config = Registry::get('Config')['database'];
			
			$dsn = "mysql:host={$config['host']};dbname={$config['database']}";
			
			static::$_instance = new static($dsn, $config['username'], $config['password'], $config['options']);
		}
		
		return static::$_instance;
	}
	
	/**
	 * @return the $_config
	 */
	public function getConfig() {
		return $this->_config;
	}

	/**
	 * @param array $_config
	 */
	public function setConfig(array $_config) {
		$this->_config = $_config;
		return $this;
	}

	/**
	 * The constructor
	 * 
	 * @param string $message
	 * @param string $code
	 * @param string $previous
	 */
	public function __construct ($message = null, $code = null, $previous = null) 
	{
		parent::__construct($message, $code, $previous);
		
		$this->setConfig(Registry::get('Config')['database']);
	}
	
}