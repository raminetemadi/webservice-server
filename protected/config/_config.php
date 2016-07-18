<?php

/* Application config */
return array(

    //base path for client side
    'baseUrl'=>'http://' . $_SERVER['HTTP_HOST'],
    'baseUrlWithoutPrifix'=> str_replace('https://', '', str_replace('http://', '',str_replace('www.', '', $_SERVER['HTTP_HOST']))),

    //web application name
    'name'=>'AnalysisCode | Web-Service',
    'title'=>'Web service',
//    'description'=>'',
//    'keyword'=>'',

    //set default time zone
    'defaultTimeZone'=>'Asia/Tehran',
    'normalTimeFormat'=>'Y-m-d H:i',

    //Language selected
    'lang'=> isset($_GET['lang']) ? $_GET['lang'] : 'fa',

    //Language for save
    'langForSave'=> isset($_GET['slang']) ? $_GET['slang'] : 'fa',

    //registered controllers
    'controller'=>array(
        'list'=>array('s'),
        'default'=>'s',
    ),

    //set default pagelayouts
    'pageLayouts'=>'sLayouts/column1',

    //set include paths
    'includes'=>array(
        get_include_path(),
        $_SERVER['DOCUMENT_ROOT'],
        dirname(__FILE__),
        dirname( dirname(__FILE__) ),
        '..'
    ),

    //imports...
    'imports'=>array(
        'components',
        'controllers',
        //'models',
        'extentions',
        'messages',

        //call precedence files
        'precedence'=>array(
            'components'=>array(
                'interfaces',
                'CController',
                'Form',
                'database',
            ),
        ),
    ),

    //connect to database
    'db'=>array(
                 'stringConnection'=>'mysql:host=127.0.0.1;dbname=our-store;charset=utf8;',
                 'username'=>'root',
                 'password'=>'LRS',

        //add super privileges
        'privileges'=>array(
            'enable'=>false,
            'user'=>'root',
            'pass'=>'',
            'dbname'=>'*',
            'host'=>'localhost',
        ),

        //ping mode
        'ping'=>true,

        //cache mode
        'cache'=>array(
            'enable'=>false,
            /*
                0 or OFF caching is off
                1 or ON caching without use SQL_CACHE in SELECT query
                2 caching only whene you use SQL_CACHE in query
            */
            'type'=>1, //query_cache_type
            'size'=>1024*1024*20, //query_cahce_size
            'var_scope'=>'SESSION', //It can be global or session
            'wlock_invalidate'=>'false'
        ),
    ),

    'sqlite'=>array(
        'drive'=>'sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/' //. '/protected/sqlite/'
    ),

    //email account
    'email'=>array(
        'host'=>'',
        'username'=>'',
        'password'=>'',
        'port'=>25
    ),

    //set default language alignment
    'langAlignment'=>array(
        'dir'=>'rtl',
        'align'=>'right'
    ),

    //You must set all available language in this array to operator save change according to language.
    'availableLang'=>array(
        'fa',
    ),

    //cookie
    'cookie'=>array(
        'expire'=>time()+ (60*60*24)*10,
        'path'=>'/',
    ),

    //session
    'session'=>array(
        'autoStart'=>true,
    ),

    //Modules
    'modules'=>array(

        'list'=>(file_exists('protected/modules/modules.txt')) ? explode(',', file_get_contents('protected/modules/modules.txt')) : '',
        'loadModel'=>true,
        /*
        'test'=>array(
            'mytitle'=>'my param'
        ),
        */
        //uncomment the following to call module apart mode
        'apart'=>false,

        'basePath'=> /*dirname(dirname( __FILE__ )) .*/ $_SERVER['DOCUMENT_ROOT'] . '/protected/modules',
    ),

    //Twig template engine
    'Twig'=>array(
        'fileSystem'=>$_SERVER['DOCUMENT_ROOT'] . '/protected/views/',
        'cache'=>array(
            'folder'=>$_SERVER['DOCUMENT_ROOT'] . '/protected/templates/',
            'autoReload'=>true
        )
    ),

    //error driven
    'errorDriven'=>array(
        'reporting'=>E_ALL,
        'display'=>'on',
        'logFile'=>$_SERVER['DOCUMENT_ROOT'] . 'erlog.log'
    ),

    //WebSocket
//    'websocket'=>array(
//        'host'=>'ws://localhost',
//        '_path'=>'/_websocket/client.php',
//        'port'=>'9000'
//    ),

    //set ini
    'ini'=>array(
        'post_max_size'=>'50M',
        'upload_max_filesize'=>'50M'
    ),

    //CPanel information
    'CPanel'=>array(
        'username'=>'',
        'password'=>'',
        'totalSize'=>50
    ),

    //Webmaster code
    'webmasterCode'=>'',
);
