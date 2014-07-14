<?php

namespace Coogle\Mvc;

use Coogle\Database\Driver;

/**
 * An abstract model class 
 */
abstract class AbstractModel
{
	/**
	 * Return a reference to the DB driver
	 * @return \Coogle\Database\Driver
	 */
	protected function db()
	{
		return Driver::getInstance();
	}
}