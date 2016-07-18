<?php

	//Error driven
	
	/*
		@params[file]
		@params[type]
		@params[line]
		@params['context']
		@params['num']
	*/
	function error_log_file($params){
		
		$s = "File:" . $params['file'] . "; Line:" . $params['line'] . "; Message:" . $params['context'] . "; Type:" . $params['type'] . ";";
		$date = date("Y-m-d H:i:s");
		$s .= 'Date:' . $date . ";;";
		
		file_put_contents( App::$config->errorDriven->logFile, $s, FILE_APPEND );
		
		//Show error if allowed by user
		if( (App::$config->errorDriven->display != 'off' && App::$config->errorDriven->display != '0') || !isset(App::$config->errorDriven->display) ){
			$s = '[' . $params['type'] . '] ' . $params['context'] . '<br>' .
				 '<b>File:</b> ' . $params['file'] . '<br>' .
				 '<b>Line: </b>' . $params['line'];
			echo $s . '<br>';
		}
	}

	/*
		Check for a fatal error
	*/
	function check_for_fatal(){
		
		$er = error_get_last();
		
		if( $er['type'] == E_ERROR ){
	
			$p = array(
						'file'=>$er['file'],
						'type'=>$er['type'],
						'line'=>$er['line'],
						'context'=>$er['message'],
						'num'=>isset($er['number']) ? $er['number'] : 'NAN'
			);
			error_log_file($p);
		}
	}
	
	/*
		Error handler
	*/
	function error_handler($errno, $errstr, $errfile, $errline){
		$p = array(
					'file'=>$errfile,
					'type'=>$errno,
					'line'=>$errline,
					'context'=>$errstr,
					'num'=>$errno
		);
		error_log_file($p);
	}
	
	/*
		exception handler
	*/
	function check_exception(Exception $e){
		$p = array(
					'file'=>$e->getFile(),
					'type'=>$e->getCode(),
					'line'=>$e->getLine(),
					'context'=>$e->getMessage(),
					'num'=>$e->getCode()
		);
		error_log_file($p);
	}
	
	error_reporting( App::$config->errorDriven->reporting );
	ini_set('display_errors', App::$config->errorDriven->display);
	
	register_shutdown_function('check_for_fatal');
	set_error_handler('error_handler');
	set_exception_handler('check_exception');
