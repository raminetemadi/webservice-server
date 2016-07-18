<?php
/**
 * Created by PhpStorm.
 * User: etema
 * Date: 3/19/16
 * Time: 9:35 PM
 */
	//Run Twig template engine
	require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/Twig/lib/Twig/Autoloader.php';

	//If you are not using composer, use Twig built-in autoloader.php
	Twig_Autoloader::register();

	//Set view files folder
	$loader = new Twig_Loader_Filesystem( App::$config->Twig->fileSystem );

	//Environment twig and set cache
	$twig = new Twig_Environment($loader, array('cache'=>App::$config->Twig->cache->folder, 'auto_reload'=>App::$config->Twig->cache->autoReload));

    //add extension function
    //you can find this class in view/twig_function/twigFunction.php file
    require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/views/twig_function/twigFunction.php';
    $twig->addExtension(new twigFunction());

    //Add jsfiles path to load all javascript files
    $this->current_parameters['jsfiles'] = dirname(App::$config->pageLayouts) . '/' . App::$config->lang . '/jsfiles.html';

	//Merge default parameters with current view parameters
	if( isset($this->default_parameters) ){
        if( isset($this->current_parameters) )
            $mixed = array_merge($this->default_parameters, $this->current_parameters);
        else
            $mixed = $this->default_parameters;
    }else if( isset($this->current_parameters) )
        $mixed = $this->current_parameters;
    else
        $mixed = null;

	//Render page with Twig
	if( $this->current_parameters['render_mode'] == 'standard' ) {

        //Set language folder in content_path
        $this->current_parameters['content_path'] = explode('/', $this->current_parameters['content_path']);
        $controllerId = $this->current_parameters['content_path'][0];
        unset($this->current_parameters['content_path'][0]);
        $this->current_parameters['content_path'] =  $controllerId . '/' . App::$config->lang . '/' . implode('/', $this->current_parameters['content_path']);
        $mixed['content_path'] = $this->current_parameters['content_path'];

        echo $twig->render(dirname(App::$config->pageLayouts) . '/' . App::$config->lang . '/main.html', $mixed);
    }else if( $this->current_parameters['render_mode'] == 'partial' )
        echo $twig->render(App::$controllerId . '/' . App::$config->lang . '/' . $this->current_parameters['content_path'], $mixed);
