<?php

namespace Coogle\Mvc\Json;

/**
 * A Response object which represents it's data in JSON format
 */
class Response extends \Coogle\Mvc\Response
{
	protected $_arrayContent = [];
	
	protected $_contentType = "application/json";
	
	/**
	 * The Constructor
	 * @param $data The data to return as JSON
	 */
	public function __construct($data = [])
	{
		$this->setContent($data);
	}
	
	/**
	 * Set the data to be returned as JSON
	 * 
	 * @see \Coogle\Mvc\Response::setContent()
	 */
	public function setContent($data)
	{
		$this->_arrayContent = $data;
		
		return $this;
	}
	
	/**
	 * Get the data in JSON-encoded format
	 * 
	 * @see \Coogle\Mvc\Response::getContent()
	 */
	public function getContent()
	{
		return json_encode($this->_arrayContent);
	}
}