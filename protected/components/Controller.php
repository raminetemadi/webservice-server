<?php

/*
 * CController come from CController.php file in components folder
 */
class Controller extends CController{

	public $default_parameters;
	public $current_parameters;
	
	function __construct(){
		parent::__construct();
		//Create default parameters for twig
		$this->default_parameters = array(
											'header'=>array(
															 'title'=>App::$config->name,
															 'baseUrl'=>App::$config->baseUrl,
															 'lang'=>App::$config->lang,
															 'langAlignment'=>array(
															 						 'align'=>App::$config->langAlignment->align,
																					 'dir'=>App::$config->langAlignment->dir
															 ),
											),
											'labels'=>$this->labels,
                                            'websocket'=>array(
                                                            'host'=>App::$config->websocket->host,
                                                            'port'=>App::$config->websocket->port
                                            ),
                                            'app'=>array(
                                                    'controller'=>App::$controllerId,
                                                    'action'=>App::$actionId,
                                                    'config'=>App::$config
                                            ),
		);

        //call user identity method if exists
        if( method_exists($this, 'userIdentity') ) $this->userIdentity();

		//run accessController
//		$this->accessController();

        //events records
        //For more detail see init function in eventForm.php
//        new eventsForm();
	}
	
	public function render($name, $mixed = null){		

		$this->current_parameters = $mixed;

		//load action file...
		$this->current_parameters['content_path'] = App::$controllerId . '/' . App::$actionId . '/' . $name . '.html';
		$this->current_parameters['render_mode'] = 'standard';
		
		if( !isset(App::$config->module) ){
			//now call pagelayouts
			include_once 'protected/views/' . App::$config->pageLayouts . '.php';	
		}else{			
			//now call pagelayouts
			include_once 'protected/modules/' . App::$config->module->moduleName . '/views/' . App::$config->module->pageLayouts . '.php';				
		}
	}//end function

	//render partial
	public function renderPartial($name, $mixed = null){

		$this->current_parameters = $mixed;
		
		//load action file...
		$this->current_parameters['content_path'] = App::$actionId . '/' . $name . '.html';
		$this->current_parameters['render_mode'] = 'partial';

		if( !isset(App::$config->module) ){
			//now call pagelayouts
			include_once 'protected/views/' . App::$config->pageLayouts . '.php';	
		}else{
//			var_dump($this->current_parameters['content_path']);
			//now call pagelayouts
			include_once 'protected/modules/' . App::$config->module->moduleName . '/views/' . App::$config->module->pageLayouts . '.php';
		}

		exit;
	}//end function

    /*
     * Render partial an script with custom actionID
     * Note: Script can run in another action not controller
     */
    public function renderPartialWithAction($name, $action = null, $mixed = null)
    {
        //If action not found or is empty call normal renderPartial function
        if( empty($action) ){
            $this->renderPartial($name, $mixed);
            return true;
        }

        $this->current_parameters = $mixed;

        //load action file...
        $this->current_parameters['content_path'] = $action . '/' . $name . '.html';
        $this->current_parameters['render_mode'] = 'partial';

        if( !isset(App::$config->module) ){
            //now call pagelayouts
            include_once 'protected/views/' . App::$config->pageLayouts . '.php';
        }else{
            //now call pagelayouts
            include_once 'protected/modules/' . App::$config->module->moduleName . '/views/' . App::$config->module->pageLayouts . '.php';
        }

        exit;
    }//end renderPartialWithAction function

	//Redirect 
	public function redirect($name, $params = ''){
		//$name = (!Empty($params)) ? $name . '&' . $params : $name; 
		//header( 'Location: ' . App::$config->baseUrl . '/?r=' . App::$controllerId . '&a=' . $name );
		
		if( !isset(App::$config->module) ){
			header( 'Location: ' . App::$config->baseUrl . '/' . App::$controllerId . '/' . $name . '?' . $params);
		}else{
			header('Location: ' . App::$config->baseUrl .'/' .App::$config->module->moduleName .'/' . App::$controllerId . '/' . $name . '?' . $params);
		}
		exit; 
	}

    /*
     * Redirect to another controller
     */
    public function redirectToNewController($controller, $name = '', $params = ''){
        header( 'Location: ' . App::$config->baseUrl . '/' . $controller . '/' . $name . '?' . $params);
        exit;
    }
	/*
		accessController method 
		@param userLevel if user signed get user level else zero set for general users
			   ** Admin, this user can access to all action
			   * super user, access to all action expect admin username and password
	*/
//	public function accessController(){
//
//		$crmAdmin = new crmAdminForm();
//
//		$check = false;
//		if( isset($_REQUEST['_whichUser']) && $_REQUEST['_whichUser'] == 'crm' ){
//			$check = true;
//		}else if( App::$controllerId == 'crm' ){
//			$check = true;
//		}
//
//		if( method_exists($crmAdmin, 'accessRules') && $check ){
//
////			$rules = $this->accessRules();
//			$rules = $crmAdmin->accessRules();
//
//			//Get user access level
//			$userLevel = (isset($_SESSION['user']['accessLevel'])) ? $_SESSION['user']['accessLevel'] : '0';
//
//			$rules = ( $userLevel != '0' ) ? $rules[$userLevel] : '0';
//            /*
//			if( $rules == '**' ){
//				//this user access to every things
//			}else if( $rules == '*' ){
//				  		//this is super user
//				  }else if( $rules == '0' ){
//				  			//access to login action
//							if( App::$actionId != 'login' ){
//								header('Location: ' . App::$config->baseUrl . '/errors/?er=403');
//								exit;
//							}
//						}else if( !empty($rules) ){
//								$r = explode(',', $rules);
//								if( !in_array(App::$actionId, $r) ){
//									header('Location: ' . App::$config->baseUrl . '/errors/?er=403');
//									exit;
//								}
//							  }*/
//
//            if( $rules == '0' ){
//                //access to login action
//                if( App::$actionId != 'login' ){
//                    header('Location: ' . App::$config->baseUrl . '/errors/?er=403');
//                    exit;
//                }
//            }else{
//                if( !accesslevelForm::userCanAccess($rules) && App::$actionId != 'error' ){
//					if( App::$controllerId == 'crm' )
//						$mode = '';
//					else
//						$mode = 'post';
//
//					header('Location: ' . App::$config->baseUrl . '/crm/error/e403?_m=' . $mode);
//                }
//            }
//		}//end if accessRules method find
//
//	}//end function

	/**
	 * @param boolean|int $return is your return function
	 */
	public function sendMessageToClient($return)
	{
		if( $return === true ) {echo ''; exit;} else
			if( $return === false ) die( $this->getErrorLabel(ER_UNKNOWN)); else
				die( $this->getErrorLabel($return) );
	}
}