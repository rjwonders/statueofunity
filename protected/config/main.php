<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Statue of Unity',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.YiiMailer.YiiMailer',
	),

	'defaultController'=>'home',

	// application components
	'components'=>array(
		'vars'=>array('class'=>'vars'),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'sendgrid' => array(  
            'class' => 'ext.yii-sendgrid.YiiSendGrid', //path to YiiSendGrid class  
            'username'=>'rahulbhatt', //replace with your actual username  
            'password'=>'Dswt@401', //replace with your actual password  
			'lists'=> 'SOU',
            //alias to the layouts path. Optional  
            //'viewPath' => 'application.views.mail',  
            //wheter to log the emails sent. Optional  
            //'enableLog' => YII_DEBUG, 
            //if enabled, it won't actually send the emails, only log. Optional  
            //'dryRun' => false, 
            //ignore verification of SSL certificate  
            //'disableSslVerification'=>true,
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
		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=foodonic_sou',
			'emulatePrepare' => true,
			'username' => 'foodonic_sou',
			'password' => 'Dswt@401',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),*/
		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sou',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'mysql',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),*/
		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=redesign_unity',
			'emulatePrepare' => true,
			'username' => 'redesign_unity',
			'password' => 'Dswt@401',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),*/
		'db'=>array(
			'connectionString' => 'mysql:host=192.185.226.159;dbname=deckoxde_unity',
			'emulatePrepare' => true,
			'username' => 'deckoxde_unity',
			'password' => 'Dswt@401',
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
				'contact-us'=>'cms/Contact',
				'about-us'=>'cms/aboutUs',
				'explore'=>'explore/index',
				'blogs'=>'blogs/index',
				'blogs/<title:.*?>'=>'blogs/index',
				'project/contribute'=>'project/contribute',
				'project/payment'=>'project/payment',
				'project/paymentError'=>'project/paymentError',
				'project/pledge/<ProjectID:\S+>/<Amount:\S+>'=>'project/pledge/ProjectID/<ProjectID>/Amount/<Amount>',
				'project/pledge/<ProjectID:\S+>'=>'project/pledge/ProjectID/<ProjectID>',
				'explore/all'=>'explore/all',
				'explore/tag/<TagID:.*>'=>'explore/tag/TagID/<TagID>',
				'explore/<CategoryID:\S+>'=>'explore/index/CategoryID/<CategoryID>',
				'project/<ProjectID:\S+>'=>'project/index/ProjectID/<ProjectID>',
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
		/*'cache'=>array(
            'class'=>'system.caching.CMemCache',
        ),*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);