<?php

/**
 * The configuration array
 */
return array(
	'view' => array(
		// Where views are found
		'viewPath' => COOGLE_APP_DIR . 'views'
	),
	'dispatcher' => array(
		// Where controllers are found
		'controllerPath' => COOGLE_APP_DIR . 'controllers'
	),
	'migrater' => array(
		// The table name used to store database migrations which
		// have already been loaded
		'migrationTable' => 'migrations'
	),
	// Routes for the application
	'routes' => array(
		'home' => array(
			'path' => '/',
			'controller' => '\App\Controllers\IndexController',
			'action' => 'index'
		),
		'votes' => array(
			'path' => '/votes',
			'controller' => '\App\Controllers\VotesController',
			'action' => 'votes'
		)
	)
);