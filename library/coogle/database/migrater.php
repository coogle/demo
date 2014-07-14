<?php

namespace Coogle\Database;

use Coogle\Utils\Registry;

/**
 * The migrater is a simple object used to load PHP Migration classes from the
 * filesystem and apply them to the database (and then record that this was done)
 * so that we can keep track of database changes over time.
 * 
 * Migration files exist in migrations/ and have the format YYYY-MM-DD-II_<classname>.php
 * 
 * where YYYY-MM-DD is the Year/month/date
 * where II is an incrementing integer (00 for first one that day, 01 for second, etc)
 * where <classname> is an underscore representation of the classname
 * 
 * i.e.
 * 
 * 2014-04-25-00_foo_bar.php should have the FooBar class inside of it and extend from an AbstractMigration
 *
 */
class Migrater
{
	/**
	 * @var array
	 */
	protected $_config;
	
	/**
	 * The constructor
	 */
	public function __construct()
	{
		$this->setConfig(Registry::get('Config')['migrater']);
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
	}

	/**
	 * Run the migrations, creating the migration table if it doesn't
	 * already exist.
	 * 
	 * @throws Exception
	 */
	public function run()
	{
		$this->createMigrationTable();
		
		$driver = Driver::getInstance();
		
		$query = "SELECT migration FROM migrations";
		
		$installedMigrations = [];
		foreach($driver->query($query) as $migration)
		{
			$installedMigrations[] = $migration['migration'];
		}
		
		$path = COOGLE_APP_DIR . 'migrations';
		
		$dir = new \RecursiveDirectoryIterator($path);
		$iterator = new \RecursiveIteratorIterator($dir);
		
		$filtered = new \RegexIterator($iterator, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
		
		foreach($filtered as $migrationFile)
		{
			include_once $migrationFile[0];
			
			$migrationFilename = strtolower(str_replace('.php', '', basename($migrationFile[0])));
			
			if(!in_array($migrationFilename, $installedMigrations)) {
				echo "Executing migration: {$migrationFilename}\n";
			}
			try {
				$this->executeMigration($migrationFile);
			} catch(\Exception $e) {
				echo "Error executing migration!\n";
				throw $e;
			}
		}
	}
	
	/**
	 * Execute a specific migration
	 * 
	 * @param string $migrationFile The migration to execute
	 */
	protected function executeMigration($migrationFile) 
	{
		$driver = Driver::getInstance();
		$migrationFilename = strtolower(str_replace('.php', '', basename($migrationFile[0])));
		
		list($year, $month, $day, $order, $classname) = sscanf($migrationFilename, "%d-%d-%d-%d_%s");
		
		$classname = '\\Coogle\\Migration\\' . $this->convertToCamelCase($classname);
		
		$migration = new $classname();
		
		$success = true;
		try {
			$migration->up();
		} catch(\Exception $e) {
			$success = false;
			echo "Failed to execute migration: {$e->getMessage()}\n";
		}
		
		if($success) {
			$query = "INSERT INTO migrations VALUES(NULL, :migration)";
			$stmt = $driver->prepare($query);
			$stmt->execute(array('migration' => $migrationFilename));
		}
	}
	
	/**
	 * Converts class_name to ClassName
	 * 
	 * @param string $str
	 * @return string
	 */
	protected function convertToCamelCase($str)
	{
		$str = strtolower($str);
		$str[0] = strtoupper($str[0]);
		return preg_replace_callback('/_([a-z])/', function($c) {
			return strtoupper($c[1]);
		}, $str);
	}
	
	/**
	 * Checks to see if the migration table exists, and if it doesn't
	 * then creates it.
	 * 
	 * @throws \Exception
	 */
	protected function createMigrationTable()
	{
		$driver = Driver::getInstance();
		
		$tableName = $this->getConfig()['migrationTable'];
		
		if($driver->query("SELECT 1 FROM {$tableName}") === false) {
			echo "Creating Migration Table\n";
			$createQuery = "CREATE TABLE {$tableName} (
			id INT AUTO_INCREMENT PRIMARY KEY,
			migration VARCHAR(255)
			)";
				
			if($driver->exec($createQuery) === false) {
			throw new \Exception("Could not create migration table");
			}
		}
	}
}