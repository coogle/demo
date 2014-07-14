<?php

use Coogle\Mvc\AbstractModel;

class Colors extends AbstractModel
{
	public function getColors()
	{
		$query = "SELECT color FROM colors";
		return $this->db()->query($query)->fetchAll(PDO::FETCH_COLUMN);
	}
}