<?php

namespace Coogle\Migration;

use Coogle\Database\Migration;

class CreateColorsTable extends Migration
{
	protected $_colors = array(
		'Red', 'Orange', 'Yellow', 'Green',
		'Blue', 'Indigo', 'Violet'
	);
	
	public function up()
	{
		if($this->db()->query("SELECT 1 FROM colors") === false) {
			$createTableSql = "CREATE TABLE colors(
					id INT AUTO_INCREMENT PRIMARY KEY,
					color VARCHAR(255) UNIQUE);";
			
			if($this->db()->exec($createTableSql) === false) {
				throw new \Exception("Could not create table");
			}
			
			$query = 'INSERT INTO colors VALUES(NULL, :color)';
			
			$stmt = $this->db()->prepare($query);
			
			foreach($this->_colors as $color) {
				$stmt->execute(array(':color' => $color));
			}
		}
	}
	
	public function down()
	{
		$this->db()->exec('DROP TABLE colors');
	}
} 