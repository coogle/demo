<?php

namespace Coogle\Database;

use Coogle\Database\Driver;

/**
 * An abstract class to be extended by each migration
 *
 */
abstract class Migration
{
	/**
	 * @return \Coogle\Database\Driver
	 */
	public function db()
	{
		return Driver::getInstance();
	}
	
	/**
	 * Called when executing the migration
	 */
	abstract public function up();
	
	/**
	 * Called when rolling back a migration (To be implemented)
	 */
	abstract public function down();
	
}
