<?php

use Coogle\Mvc\AbstractModel;

class Votes extends AbstractModel
{
	public function getVotesForColor($color)
	{
		$query = "SELECT SUM(votes) as votes FROM votes WHERE color = :color";
		
		$stmt = $this->db()->prepare($query);
		
		if($stmt->execute(array('color' => $color))) {
			return (int)$stmt->fetchAll(PDO::FETCH_COLUMN)[0];
		}
		
		return 0;
	}
}