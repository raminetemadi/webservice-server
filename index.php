<?php

	$config = dirname(__FILE__) . '/protected/config/config.php';

	//error reporting
	defined('DEBUG_MODE') or define('DEBUG_MODE', false, true);

	//load main config file
	require dirname(__FILE__) . '/protected/config/main.php';
	
	//create web application
	App::createApp($config);
	
