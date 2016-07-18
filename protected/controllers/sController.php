<?php
/**
 * Created by PhpStorm.
 * User: etema
 * Date: 7/16/16
 * Time: 11:08 AM
 */
class sController extends Controller{

    private $HTTP_RAW_POST_DATA;
    private $nameSpace;
    private $server;

    function __construct(){
        $GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents ('php://input');
        $this->HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];

        $this->nameSpace = App::$config->baseUrl . '/' . App::$actionId  . '?wsdl';

        //Create server
        $this->server = new soap_server(false);

        //configuration wsdl
        $this->server->configureWSDL(App::$config->name, $this->nameSpace);

        parent::__construct();
    }

    public function actionIndex()
    {

        $this->server->register('calculatorForm.calculate',
                                array(
                                    'n1'=>'xsd:string',
                                    'n2'=>'xsd:string',
                                    'c'=>'xsd:string',
                                    'authenticateKey'=>'xsd:string'
                                ),
                                array(
                                    'return'=>'xsd:string'
                                ), $this->nameSpace, false
                                );

        $this->server->service($this->HTTP_RAW_POST_DATA);
    }

    public function actionMyKey()
    {
        $this->server->register('authenticateForm.createKey',
            array(
            ),
            array(
                'return'=>'xsd:string'
            ), $this->nameSpace, false
        );

        $this->server->service($this->HTTP_RAW_POST_DATA);
    }
}
