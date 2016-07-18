<?php

//auto load models file, is too faster
function __autoload($class_name){
	if( preg_match("/(Form)/", $class_name) && file_exists('protected/models/' . $class_name . '.php') ){
		require_once 'protected/models/' . $class_name . '.php';
	}
}


/*
	Create apllication 
*/
class App{
	
	//Convert application config to stdClass
	static $config;
	
	//Current control id
	public static $controllerId;
	
	//Current action id
	public static $actionId;
	
	public static $cacheDatabase;

    public static $isModule;
	
	//import all file in include paths.
	public static function importFiles($path){
		foreach($path as $p){
			
			if( is_string($p) ){
				//Check precedence files first
				if( property_exists(self::$config->imports->precedence, $p) ){
					foreach(self::$config->imports->precedence->{$p} as $file){
						include_once 'protected/' . $p . '/' . $file . '.php';
					}
				}

				$p = 'protected/' . $p;
			    if( !file_exists($p) ) continue;

				$list = scandir( $p );
				foreach($list as $l){
					if( is_dir($p . '/' . $l) ) continue;

					if( $l != '..' && $l != '.' ) include_once $p . '/' . $l;
				}//end foreach

			}//end if p is string
		}//end foreach

        //Import modules models
        if( isset(self::$config->modules->loadModel) && self::$config->modules->loadModel === true && !empty(self::$config->modules->list) ){
            foreach(self::$config->modules->list as $model){
                if( empty($model) || strlen($model) < 3 ) continue;

                $files = scandir('protected/modules/' . $model . '/models/');
                foreach($files as $file){
                    if( $file != '..' && $file != '.' ) include_once 'protected/modules/' . $model . '/models/' . $file;
                }
            }
        }
	}//end function

    /*
     * Check this name is in module list or not
     */
    public static function itIsModule($m){

        if( empty($m) ) return false;

        if( isset(App::$config->modules->list) && !empty(App::$config->modules->list) ){
            foreach(App::$config->modules->list as $module){
                if( empty($module) ) continue;
                if( $module == $m ) return true;
            }//end foreach
        }//end if

        return false;
    }//end function

	/*
		Router function
	*/
	private static function router(){

		$isModule = false;
		if( isset($_REQUEST['params_uri']) ){
			
			//split uri
			$p = explode('/', $_REQUEST['params_uri']);

			//check is module or not
			if( isset($p[1]) && !empty($p[1]) ){
				if( App::itIsModule($p[1]) ) $isModule = true; else $isModule = false;
			}else if( isset($_REQUEST['m']) ){
				if( App::itIsModule($_REQUEST['m']) ) $isModule = true; else $isModule = false;
			}else{
				$isModule = false;
			}

            self::$isModule = $isModule;

			//first array is controller and seconde array is action
			switch( $isModule ):
				case true:
					  //Module name
					  if( isset($p[1]) && !empty($p[1]) ){
						  $_GET['m'] = $p[1];
						  $_REQUEST['m'] = $_GET['m'];
					  }
					  
					  //Module controller name
					  if( isset($p[2]) && !empty($p[2]) ){
						  $_GET['r'] = $p[2];
						  $_REQUEST['r'] = $_GET['r'];
					  }
					  
					  //Module action name
					  if( isset($p[3]) && !empty($p[3]) ){
						  $_GET['a'] = $p[3];//action
						  $_REQUEST['a'] = $_GET['a'];
					  }				

                      //Set op if exists
                      if( isset($p[4]) && !empty($p[4]) ){
                          $_GET['op'] = $p[4];
                          $_REQUEST['op'] = $_GET['op'];
                      }
				break;
				case false:
					  if( isset($p[1]) && !empty($p[1]) ){
						  $_GET['r'] = $p[1];//controller
						  $_REQUEST['r'] = $_GET['r'];
					  }
					  if( isset($p[2]) && !empty($p[2]) ){
						  $_GET['a'] = $p[2];//action
						  $_REQUEST['a'] = $_GET['a'];
					  }
                    //Set op if exists
                    if( isset($p[3]) && !empty($p[3]) ){
                        $_GET['op'] = $p[3];
                        $_REQUEST['op'] = $_GET['op'];
                    }
				break;
			endswitch;
		}//end if

		return $isModule;
	}//end function

	/*
		Create web application function
	*/
	static function createApp($configFile){

		//Error reporting mode
		if( DEBUG_MODE == 0 ) error_reporting(0);

		//get $config file array
		$configArray = include $configFile; 

		self::$config = json_decode( json_encode($configArray), false );

		//run session if autoStart is true
		if( self::$config->session->autoStart ) session_start();
		
		//set include path
		$include = '';
		for($i=0; $i<=count(self::$config->includes)-1; $i++){
			$include .= self::$config->includes[$i];
			if( $i<count(self::$config->includes)-1 ) $include .= PATH_SEPARATOR;
		}
		set_include_path( $include );

        //Set php ini
        if( isset(self::$config->ini) )
            foreach(self::$config->ini as $k=>$v){
                ini_set($k, $v);
            }

		//set defaultTimeZone
		date_default_timezone_set(self::$config->defaultTimeZone);

		//Router
		$isModule = self::router();

		if( $isModule !== true ){
			  //run controller and action
			  $controller = (!isset($_REQUEST['r'])) ? self::$config->controller->default : $_REQUEST['r'];
			  $action = (!isset($_REQUEST['a'])) ? 'index' : $_REQUEST['a'];

			  //get controller id
			  self::$controllerId = $controller;
			  //get action id
			  self::$actionId = $action;

			  //imports...
			  self::importFiles(self::$config->imports);

			  $class = self::$controllerId . 'Controller';

			  //check controller...
			  if( class_exists($class) ) 
				  $controller = new $class();
              else{
				  //save history
				  $tmpC = self::$controllerId;

				  $controllerString = self::$config->controller->default . 'Controller';
				  self::$controllerId = self::$config->controller->default;
                  $defaultController = new $controllerString();

				  self::$controllerId = $tmpC;

                  if( method_exists($defaultController, 'action'.self::$controllerId) ){
                      self::$actionId = self::$controllerId;
                      self::$controllerId = self::$config->controller->default;

					  $request = explode('?', $_SERVER['REQUEST_URI']);

					  if( is_array($request) ) $request = $request[0]; else $request = $_SERVER['REQUEST_URI'];

                      $_REQUEST['params_uri'] = '/'. self::$controllerId . $request;
					  $_GET['params_uri'] = '/'. self::$controllerId . $request;

                      $isModule = self::router();

                      $class = self::$controllerId . 'Controller';
                      $controller = new $class();
                  }else{
					  exit;
//					  header('Location: ' . App::$config->baseUrl . '/errors/index?er=404');
//                      die('404  ' . self::$controllerId);
                  } //header('Location: ' . App::$config->baseUrl . '/errors/index?er=404');
              }
				  
			  //run before action function if exists
			  if( method_exists($controller, 'beforeAction') )
				  $controller->beforeAction();
			  
			  //run action
			  if( method_exists($controller, 'action'.self::$actionId) ) 
				  $controller->{'action'.self::$actionId}();
			  else
				  if( method_exists($controller, 'redirect') ) $controller->redirect('index');
		}else{//end if is not module

			  //call default.php file to run module
			  require_once self::$config->modules->basePath . '/' . $_REQUEST['m'] . '/default.php';
		}

	}//end function

	public static function getRequestParam()
	{
		$r = isset($_REQUEST['params_uri']) ? $_REQUEST['params_uri'] : null;

		if( empty($r) ) return null;

		$r = explode('/', $r);

		$l = array();
		for($i=3; $i<=count($r)-1; $i++){
			$l['p'.($i-2)] = $r[$i];
		}

		return $l;
	}

}