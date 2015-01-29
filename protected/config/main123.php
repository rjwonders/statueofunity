<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SOU',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.YiiMailer.YiiMailer',
		'ext.streamsend.streamsend',
	),

	'defaultController'=>'home',

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		/*'db'=>array(
			'connectionString' => 'sqlite:protected/data/blog.db',
			'tablePrefix' => 'tbl_',
		),*/
		// uncomment the following to use a MySQL database
		
		/*'db'=>array(
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=foodonic_sou',
			'emulatePrepare' => true,
			'username' => 'foodonic_statue',
			'password' => 'Dswt@401',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),*/
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sou',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'mysql',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),
		'iwi' => array(
			'class' => 'application.extensions.iwi.IwiComponent',
			// GD or ImageMagick
			'driver' => 'GD',
			// ImageMagick setup path
			//'params'=>array('directory'=>'C:/ImageMagick'),
		),
		'errorHandler'=>array(
			'errorAction'=>'404',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);