<?php

namespace Coogle\Migration;

use Coogle\Database\Migration;

class CreateVotesTable extends Migration
{
	protected $_data = [
		[
			'city' => 'Anchorage',
			'color' => 'Blue',
			'votes' => 10000
		],
		[
			'city' => 'Anchorage',
			'color' => 'Yellow',
			'votes' => 15000
		],
		[
			'city' => 'Brooklyn',
			'color' => 'Red',
			'votes' => 100000
		],
		[
			'city' => 'Brooklyn',
			'color' => 'Blue',
			'votes' => 250000
		],
		[
			'city' => 'Detroit',
			'color' => 'Red',
			'votes' => 160000
		],
		[
			'city' => 'Selma',
			'color' => 'Yellow',
			'votes' => 15000
		],
		[
			'city' => 'Selma',
			'color' => 'Violet',
			'votes' => 5000
		]
		
	];
	
	public function up()
	{
		if($this->db()->query("SELECT 1 FROM votes") === false) {
			$createTableSql = "CREATE TABLE votes(
									id INT AUTO_INCREMENT PRIMARY KEY,
									city VARCHAR(255),
									color VARCHAR(255),
									votes BIGINT,
									FOREIGN KEY (color)
									REFERENCES colors(color));";
			
			if($this->db()->exec($createTableSql) === false) {
				throw new \Exception("Could not create table");
			}
			
			$query = 'INSERT INTO votes VALUES(NULL, :city, :color, :votes)';
			
			$stmt = $this->db()->prepare($query);
			
			foreach($this->_data as $row) {
				$stmt->execute(array(
					'city' => $row['city'],
					'color' => $row['color'],
					'votes' => $row['votes']
				));
			}
		}
	}
	
	public function down()
	{
		$this->db()->exec('DROP TABLE votes');
	}
}