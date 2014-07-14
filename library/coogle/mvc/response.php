<?php

namespace Coogle\Mvc;

/**
 * The response object contains all of the output the user will see
 * and is also responsible for keeping track of the HTTP response code
 * content type and character set we are operating under.
 */
class Response
{
	/**
	 * @var int
	 */
	protected $_httpCode;
	
	/**
	 * @var string
	 */
	protected $_content;
	
	/**
	 * @var string
	 */
	protected $_contentType = "text/html";
	
	/**
	 * @var string
	 */
	protected $_charset = 'utf-8';
	
	/**
	 * @return string the $_charset
	 */
	public function getCharset() {
		return $this->_charset;
	}

	/**
	 * @param string $_charset
	 */
	public function setCharset($_charset) {
		$this->_charset = $_charset;
		return $this;
	}

	/**
	 * @return the $_contentType
	 */
	public function getContentType() {
		return $this->_contentType;
	}

	/**
	 * @param string $_contentType
	 */
	public function setContentType($_contentType) {
		$this->_contentType = $_contentType;
	}

	/**
	 * @return int the $_httpCode
	 */
	public function getHttpCode() {
		return !isset($this->_httpCode) ? 200 : $this->_httpCode;
	}

	/**
	 * @return string the $_content
	 */
	public function getContent() {
		return $this->_content;
	}

	/**
	 * @param number $_httpCode
	 * @return self
	 */
	public function setHttpCode($_httpCode) {
		$this->_httpCode = $_httpCode;
		return $this;
	}

	/**
	 * @param string $_content
	 * @return self
	 */
	public function setContent($_content) {
		$this->_content = $_content;
		return $this;
	}

}