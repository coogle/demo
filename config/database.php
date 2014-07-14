<?php

return array(
	'database' => array(
		'username' => 'root',
		'password' => 'password',
		'host' => 'localhost',
		'database' => 'demo',
		'options' => array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		)
	)
);