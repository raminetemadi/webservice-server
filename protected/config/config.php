<?php

    $path = $_SERVER['DOCUMENT_ROOT'] . '/protected/config/';

    $general = json_decode( file_get_contents($path . 'general.json'), true );
    $general['lang'] = isset($_GET['lang']) ? $_GET['lang'] : $general['lang'];

    $main = require_once $path . '_config.php';

    $main = array_merge($main, $general);

    $sys = json_decode( file_get_contents($path . 'sys.json'), true );
//    $sys['cookie']['expire'] = time() + 60*60*$sys['cookie']['expire'];
    $sys['ini']['post_max_size'] .= 'M';
    $sys['ini']['upload_max_filesize'] .= 'M';

    //Find base url like this /home/CPanel_username
    $cPanelUsername = $main['CPanel']['username'];
    if( empty($cPanelUsername) ){
        $baseDir = scandir('/home/');
        for($i=0; $i<=count($baseDir)-1; $i++){
            if( $baseDir[$i] == '.' || $baseDir[$i] == '..'  || empty($baseDir[$i])) continue;

            $cPanelUsername = $baseDir[$i];
            break;
        }
    }
//    $main['basePath'] = '/home/' . $cPanelUsername . '/';
$main['basePath'] = '../';
    $main = array_merge($main, $sys);

    return $main;