<?php
/**
 * Created by PhpStorm.
 * User: etema
 * Date: 12/23/2014
 * Time: 10:50 AM
 */

/*
 *Upload file class
 */
class CUploadFile{

    public function __construct(){
    }

    /*
     * nested create directory
     */
    public function nestedMKDir($path)
    {
        //Remove document-root if found in destination
        $p = str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);

        $p = explode('/', $p);

        $nPath = $_SERVER['DOCUMENT_ROOT'];
        for($i=0; $i<=count($p)-1; $i++){
            if( empty($p[$i]) ) continue;

            $nPath .= '/' . $p[$i];
            if( !file_exists($nPath) ) mkdir($nPath, 0777);
        }
    }

    /*
     * Move uploaded file
     *
     * @param uName, is tag name
     * @param destination, The destination of the moved file
     * @param option, the array of rules
     */
    public function moveUploadedFile($uName, $destination, $option = null, &$output){

        //Check destination
        if( !file_exists($destination) ) $this->nestedMKDir($destination);


        //Check file uploaded or not
        if( !isset($_FILES[$uName]['tmp_name']) || !file_exists($_FILES[$uName]['tmp_name']) ) return ER_UP_FILE_NOT_EXISTS;

        $tmpFile = $_FILES[$uName]['tmp_name'];
        $tmpFileType = strtolower(substr($_FILES[$uName]['name'], strlen($_FILES[$uName]['name'])-3, 3));

        //Set water-marker if file is image
        if( $tmpFileType == 'jpg' || $tmpFileType == 'png' || $tmpFileType == 'tif' || $tmpFileType == 'bmp' ){
            list($width, $height) = getimagesize($_FILES[$uName]['tmp_name']);

            if( $width >= 400 || $height >= 400 ){
                $gdForm = new gdForm();

                $gdForm->appendWaterMark($_FILES[$uName]['tmp_name']);
            }
        }

        $randomFileName = false;
        $overWrite = false;
        $desfilename = null;

        if( !is_array($option) ) $option = array();

        foreach($option as $k=>$v){

            switch($k):
                case 'filetype':
                    //Get ext
                    $ext = $tmpFileType;

                    if( empty($ext) ) return ER_UP_FILE_INVALID_TYPE;

                    if( !preg_grep("/" . $ext . "/i", $v) ) return ER_UP_FILE_INVALID_TYPE;
                break;
                case 'maxfilesize':
                    $fs = filesize($tmpFile);
                    if( $fs > $v ) return ER_UP_FILE_EXCEEDED_SIZE;
                break;
                case 'allowOverWrite':
                    ///if( $v == false && file_exists($destination) ) return ER_UP_FILE_EXISTS;
                    $overWrite = $v;
                break;
                case 'randomFileName':
                    $randomFileName = $v;
                break;
                case 'desFileName':
                    $desfilename = $v;
                break;
            endswitch;

        }//end foreach

        if( $randomFileName == true ){
            $des = filetype($destination) == 'file' ? dirname($destination) : $destination;
            $des .= substr($des, strlen($des)-1, 1) != '/' ? '/' : '';

            $ext = $tmpFileType;
            $des .= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10) . '.'. $ext;
        }else if( $desfilename == null ){
            $des = $destination;
            $des.= substr($des, strlen($des)-1, 1) != '/' ? '/' : '';
            $name= $_FILES[$uName]['name'];/*pathinfo($tmpFile, PATHINFO_BASENAME);*/
            $des.= $name;
        }else{
            $des = $destination;
            $des.= substr($des, strlen($des)-1, 1) != '/' ? '/' : '';
            $des.= $desfilename;
        }
        if( $overWrite == false && file_exists($des) ) return ER_UP_FILE_EXISTS;

        $r = @move_uploaded_file($tmpFile, $des);
        if( $r ){
            $des = str_replace($_SERVER['DOCUMENT_ROOT'], '', $des);
            $output = $des;
            return true;
        }else{
            return ER_UP_FILE_UNDEFINED;
        }
    }//end function

    public function moveUploadedFiles($uName, $destination, $option = null, &$output=null){

        #Check is files array or not
        if( is_array($_FILES[$uName]['name']) )
            $count = count($_FILES[$uName]['name']);
        else{
            return $this->moveUploadedFile($uName, $destination, $option, $output[]);
        }

        for($i=0; $i<=$count-1; $i++) {
            //Check file uploaded or not
            if (!isset($_FILES[$uName]['tmp_name'][$i]) || !file_exists($_FILES[$uName]['tmp_name'][$i])) return ER_UP_FILE_NOT_EXISTS;

            $tmpFile = $_FILES[$uName]['tmp_name'][$i];
            if( !file_exists($tmpFile) ) continue;

            $tmpFileType = substr($_FILES[$uName]['name'][$i], strlen($_FILES[$uName]['name'][$i]) - 3, 3);

            $randomFileName = true;
            $overWrite = false;
            $desfilename = null;
            foreach ($option as $k => $v) {

                switch ($k):
                    case 'filetype':
                        //Get ext
                        $ext = $tmpFileType;

                        if (empty($ext)) return ER_UP_FILE_INVALID_TYPE;

                        if (!preg_grep("/" . $ext . "/i", $v)) return ER_UP_FILE_INVALID_TYPE;
                        break;
                    case 'maxfilesize':
                        $fs = filesize($tmpFile);
                        if ($fs > $v) return ER_UP_FILE_EXCEEDED_SIZE;
                        break;
                    case 'allowOverWrite':
                        ///if( $v == false && file_exists($destination) ) return ER_UP_FILE_EXISTS;
                        $overWrite = $v;
                        break;
                    case 'desFileName':
                        $desfilename = $v;
                        break;
                endswitch;

            }//end foreach

            if ($randomFileName == true) {
                $des = filetype($destination) == 'file' ? dirname($destination) : $destination;
                $des .= substr($des, strlen($des) - 1, 1) != '/' ? '/' : '';

                $ext = $tmpFileType;
                $des .= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10) . '.' . $ext;

            } else if ($desfilename == null) {
                $des = $destination;
                $des .= substr($des, strlen($des) - 1, 1) != '/' ? '/' : '';
                $name = $_FILES[$uName]['name'][$i];/*pathinfo($tmpFile, PATHINFO_BASENAME);*/
                $des .= $name;
            } else {
                $des = $destination;
                $des .= substr($des, strlen($des) - 1, 1) != '/' ? '/' : '';
                $des .= $desfilename;
            }
            if ($overWrite == false && file_exists($des)) return ER_UP_FILE_EXISTS;

            $r = @move_uploaded_file($tmpFile, $des);
            if ($r) {
                $des = str_replace($_SERVER['DOCUMENT_ROOT'], '', $des);
                $output[] = $des;
//                return true;
            } else {
                return ER_UP_FILE_UNDEFINED;
            }
        }//end for
        return true;
    }//end moveUploadedFiles function

    /*
     * Create new director
     * @param $name is directory path
     * @param chmod is:
     * 	    Chmod is 0000 -> 0=no matter, 0=owner, 0=group owner, 0=every one
	 *		4 = read, 2 = write, 1 = execute -> rwx
     *
     */
    public  function createDir($name, $chmod){
        if( !file_exists($name) ){
            umask(0);
            return mkdir($name, $chmod);
        }//end if

        return true;
    }//end function

    /*
     * Remove a directory
     */
    public function removeDir($p){
        //remove / from last character
        if( substr($p, strlen($p)-1, 1) == '/' ) $p = substr($p, 0, strlen($p)-1);

        //check is dir
        if( is_dir($p) ){
            $files = scandir($p);

            foreach($files as $file){
                if( $file != '..' && $file != '.' ){
                    if( !is_dir($p . '/' . $file) ) unlink($p . '/' . $file); else $this->removeDir($p . '/' . $file);
                }
            }//end foreach

            rmdir( $p );//remove empty folder
        }//end if

        return true;
    }//end function
}


/*
	All labels saved to default.xml, you can find this file in xml folder
*/
class CLabels extends CUploadFile{

    private $lang;
    private $basic;

    public $labels;
    private static $iSort = 0;

    /*
        call default.xml file
    */
    public function __construct(){
        parent::__construct();

        //Call basic xml file
        $lang = 'fa'; //App::$config->lang
        $this->basic = new SimpleXMLElement('protected/xml/lang/' . $lang . '/basic.xml', null, true);

        if( App::$isModule == false ) {

            //In s controller
            if( App::$controllerId == 'cms' )
                $this->lang = new SimpleXMLElement('protected/xml/lang/' . $lang . '/default.xml', null, true);
            else
                $this->lang = new SimpleXMLElement('protected/xml/' . App::$controllerId . '/lang/' . App::$config->lang . '/default.xml', null, true);
        }else {
            $path = 'protected/modules/' . App::$config->module->moduleName . '/xml/lang/' . $lang . '/default.xml';

            if( !file_exists($path) ) return false;

            $this->lang = new SimpleXMLElement($path, null, true);
        }
        $this->labels = $this->getLabels($this->lang);

        if( isset($this->labels['menu']) )
        $this->labels['menu'] = $this->reSortMenu($this->labels['menu']);

        return true;
    }

    /*
     * Get labels function from default.xml
     * @param xml must be xml file
     */
    private function getLabels($xml, $first = true){

        if( empty($xml) ) return null;

        if( $first == true ) {
            //Get controller part
            $labels = isset($xml->{App::$controllerId}) ? $xml->{App::$controllerId} : null;
            //Get action part
            $labels = isset($labels->{App::$actionId}) ? $labels->{App::$actionId} : null;

            //Get op part
            if ($labels != null && isset($_REQUEST['op'])) {
                $labels = isset($labels->{$_REQUEST['op']}) ? $labels->{$_REQUEST['op']} : $labels;
            }
        }else{
            $labels = $xml;
        }

        //now normalize labels
        $new_labels = null;
        if( $labels != null ){
            foreach( $labels->children() as $l ){

                //check $l have child
                $haveChild = ( $l->count() <= 0 ) ? false : true;

                if( $haveChild === false ) {
                    $new_labels[$l->getName()] = strip_tags($l->saveXML());
                }
                else {
                    $new_labels[ (string)$l->getName() ] = $this->getLabels($l, false);
                }
            }
        }

        //Get basic part
        //Get controller part
        if( $first == true ) {
            $labels = isset($this->lang->{App::$controllerId}) ? $this->lang->{App::$controllerId} : null;
            if ($labels !== null) {
                if (isset($labels->basic))
                    $basic = self::basicLabels($labels->basic);


                if (isset($new_labels) && !empty($new_labels)) {
                    if (isset($basic) && !empty($basic)) $new_labels = array_replace_recursive($basic, $new_labels);
                } else {
                    if (isset($basic) && !empty($basic)) $new_labels = $basic;
                }//end if new_labels
            }//end labels not be null
        }//end if

        //generate menu
        if( $first == true ){
            if( !App::$isModule && App::$controllerId == 'cms' ) {
                $menu = new SimpleXMLElement($_SERVER['DOCUMENT_ROOT'] . '/protected/xml/lang/fa/menu.xml', 0, true);
                $menu = isset($menu->{App::$controllerId}) ? $menu->{App::$controllerId} : null;
            }else{
                $menu = isset($this->lang->{App::$controllerId}) ? $this->lang->{App::$controllerId} : null;
                if( $menu !== null )
                    $menu = isset($menu->menu) ? $menu->menu : null;
            }
            if($menu !== null){
                if( isset($menu) )
                    $menu = self::generateMenu($menu);

                if( isset($menu) ) $new_labels['menu'] = $menu;

                //Generate modules memnu
                $modulesMenu = self::generateModulesMenu();
                if( !empty($modulesMenu) )
                    if( isset($new_labels['menu']) ) {
                        foreach($modulesMenu as $k=>$m){
                            if( isset($new_labels['menu'][$k]) ) $modulesMenu[$k]['id'] = $new_labels['menu'][$k]['id'];
                        }
                        $new_labels['menu'] = array_replace_recursive($new_labels['menu'], $modulesMenu);
                    }else
                        $new_labels['menu'] = $modulesMenu;

            }//end labels not be null
        }//end if

        //Generate breadcrumb
        if( $first == true ){
            $labels = isset($this->lang->{App::$controllerId}) ? $this->lang->{App::$controllerId} : null;

            if($labels !== null){
                if( isset($labels->breadcrumb) )
                    $bc = self::generateBreadCrumb($labels->breadcrumb);

                if( isset($bc) ) $new_labels['breadcrumb'] = $bc;
            }//end if labels not null
        }//end if

        //Now get gbasic labels in basic.xml
        if( $first == true ){
            $gbasic = $this->basic->gbasic;
            $gb = self::basicLabels($gbasic);
            $new_labels['gbasic'] = $gb;
        }//end if

        return  $new_labels;
    }//end function

    /*
     * Get basic labels from xml file
     * @param xml just must be controller part
     */
    private static function basicLabels($xml){
        if( $xml == null ) return null;

        $labels = array();
        //Get xml children
        $xml = $xml->children();
        if( empty($xml) ) return null;

        foreach($xml as $l){

            //check $l have child
            $haveChild = ( $l->count() <= 0 ) ? false : true;
            if( $haveChild === false )
                $labels[ $l->getName() ] = strip_tags( $l->asXML() );
            else
                $labels[ (string)$l->getName() ] = self::basicLabels($l);
        }

        return $labels;
    }

    /*
     * reSort menu function
     */
    private function cmpSortMenu($a, $b)
    {
        return $a['id'] - $b['id'];
    }
    private function reSortMenu($menu){
        if( empty($menu) ) return null;

        usort($menu, array($this, 'cmpSortMenu'));
        foreach($menu as $k=>$m){
            if( isset($m['submenu']) ){
                usort($menu[$k]['submenu'], array($this, 'cmpSortMenu'));
            }
        }

        return $menu;
    }//end reSortMenu function

    /*
     * Create menu list with menu tag in default.xml file
     */
    private static function generateMenu($xml, $mode = '', $resetSort=false, $isModule=0, $mName = 'crm'){

        if( empty($xml) ) return null;

        //get children
        $xml = $xml->children();
        if( empty($xml) ) return null;

        #Call rules class
        if( class_exists('rules') ) {
            $rules = new rules();
            $rulesClassFound = true;
        }else{
            $rulesClassFound = false;
            $allow = true;
        }

        $gm = array();//generated menu
        $iSort = $resetSort == true ? 0 : self::$iSort;
        foreach($xml as $l){

            if( $rulesClassFound )
                if(!empty($l) && isset($l->attributes()->check) ) $allow = $rules->checkMethods((string)$l->attributes()->check); else $allow = true;
            else
                $allow = true;

            if( $allow !== true ) continue;

            $haveChild = (!isset($l->attributes()->link)) ? true : false;
            if( $haveChild == false ){
                if( isset($l->attributes()->id) ) $iSort++;
                $gm[ $l->getName() ] = array(
                    'title'=>(string)$l->attributes()->title,
                    'link'=>(string)$l->attributes()->link,
                    'mode'=>$mode,
                    'tagName'=>(string)$l->getName(),
                    'id'=>isset($l->attributes()->id) ? (string)$l->attributes()->id : $iSort,
                    'module'=>$isModule,
                    'mName'=>$mName
                );
            }else{
                if( isset($l->attributes()->id) ) $iSort++;
                $gm[ $l->getName() ] = array(
                    'title'=>(string)$l->attributes()->title,
                    'submenu'=>self::generateMenu($l, $mode, true, $isModule, $mName),
                    'tagName'=>(string)$l->getName(),
                    'id'=>isset($l->attributes()->id) ? (string)$l->attributes()->id : $iSort,
                    'module'=>$isModule,
                    'mName'=>$mName
                );
            }//end if
            //Get class or icon attributes if found
            if( isset($l->attributes()->class) )
                $gm[ $l->getName() ]['class'] =  (string)$l->attributes()->class;
            else if( isset($l->attributes()->icon) )
                $gm[ $l->getName() ]['icon'] =  (string)$l->attributes()->icon;

            if( $resetSort ) $iSort++; else{ $iSort++; self::$iSort = $iSort; };
        }//end foreach

        return $gm;
    }//end function

    /*
     * Create menu list from modules, modules menu file is in subfolder
     */
    private static function generateModulesMenu(){

        //This class check menu rules
        #Call rules class
        if( class_exists('rules') ) {
            $rules = new rules();
            $rulesClassFound = true;
        }else{
            $rulesClassFound = false;
            $allow = true;
        }

        if( !isset(App::$config->modules->list) ) return null;

        $modules = App::$config->modules->list;

        //modules path
        $p = $_SERVER['DOCUMENT_ROOT'] . '/protected/modules/';
        $allGeneratedMenu = null; $newM = null;
        if( !empty($modules) )
            foreach($modules as $m):
                if( empty($m) ) continue;
                if( !file_exists($p.$m . '/menu.xml') ) continue;

                $menu = new SimpleXMLElement($p . $m . '/menu.xml', null, true);

                #Check if is modal
                $allow = true;
                if( App::$isModule ) {
                    $menu = $menu->{App::$config->module->moduleName};

                    if( $rulesClassFound )
                        if(!empty($menu)&& isset($menu->attributes()->check) ) $allow = $rules->checkMethods((string)$menu->attributes()->check); else $allow = true;
                    else $allow = true;
                }

                if( $allow === true ) {
                    $menu = $menu->{App::$controllerId};

                    if( $rulesClassFound )
                        if(!empty($menu)&& isset($menu->attributes()->check) ) $allow = $rules->checkMethods((string)$menu->attributes()->check); else $allow = true;
                    else
                        $allow = true;

                    if( $allow === true ) {
                        if (!empty($menu)) {
                            $mode = (string)$menu->attributes()->mode;
                            if (empty($mode)) $mode = '';
                        } else $mode = '';
                        $newM = self::generateMenu($menu, $mode, false, 1, $m);
                    }
                }

                if( !empty($allGeneratedMenu)  ) {
                    if( is_array($newM) )
                        $allGeneratedMenu = array_replace_recursive($allGeneratedMenu, $newM);
                }else
                    $allGeneratedMenu = $newM;

            endforeach;

        return $allGeneratedMenu;
    }//end function

    /*
     * Check menu can show in menu bar or not
     */
    private function checkMenu()
    {

    }//end checkMenu function

    /*
     * Generate breadcrumb function
     */
    private static function generateBreadCrumb($xml){

        if( empty($xml) ) return null;

        //Get controller
        $r['controller'] = (string)$xml->attributes()->title;

        $xml = $xml->children();
        if( empty($xml) ) return null;

        if( isset($xml->{App::$actionId}) ) $r['action'] = $xml->{App::$actionId}->attributes()->title; else return null;

        if( isset($_REQUEST['op']) && isset($xml->{App::$actionId}->{$_REQUEST['op']}) ) $r['op'] = $xml->{App::$actionId}->{$_REQUEST['op']}->attributes()->title;

        return $r;
    }//end generateBreadCrumb function

    /*
        get error label fro, default.xml file
    */
    public function getErrorLabel($errorNo){
        return strip_tags( $this->basic->errors->{'e'.$errorNo}->asXML() );
    }

    /*
     * Set session errors
     */
    public function setSessionError($errorNo = null, $mode = 'ERROR'){
        if( $errorNo !== null )
            $_SESSION['_ERROR'] = array(
                                        'msg'=>is_numeric($errorNo)?$this->getErrorLabel($errorNo) : $errorNo,
                                        'errorNo'=>$errorNo,
                                        'mode'=>$mode
            );
        else unset($_SESSION['_ERROR']);
    }//end setSessionError function
    /*
     * Session errors
     */
    public function getSessionError($json = false, $removeAfterShow = true){
        if( isset($_SESSION['_ERROR']) ){
            if( $json == false ) {
                $r = $_SESSION['_ERROR']['msg'];
                if( $removeAfterShow  ) $this->setSessionError();
                return $r;
            }else {
                $r = json_encode($_SESSION['_ERROR']);
                if( $removeAfterShow  ) $this->setSessionError();
                return $r;
            }
        }else return null;
    }//end session error

    /*
     * Create json output
     */
    public function createJSONError($errorNo){
        $r = array(
                    'errorNumber'=>$errorNo,
                    'msg'=>$this->getErrorLabel($errorNo)
        );

        return json_encode($r);
    }

}


//************************************** System function ***********************************************************
class CSys extends CLabels{
    public function  __construct(){
        parent::__construct();
    }

    /**
     * Convert array in utf8
     *
     * @param array $array
     * @return mixed|string
     *
     */
    public function json_encode_utf8($array)
    {
        $array = json_encode($array);

        //normalize $info to utf-8 character
        $array = preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
            function ($matches){
                $s = mb_convert_encoding(pack('H*',$matches[1]), 'UTF-8', 'UTF-16');
                return $s;
            }, $array);

        return $array;
    }//end json_encode_utf8 function

    /**
     * Get total size of any path, result is in this case MB
     *
     * @param string $path
     * @return float|int
     */
    public function getTotalDskSize($path = '/')
    {
        $r = disk_total_space($path);
        return $r > 0 ? $r / (1024*1024) : 0;
    }

    /**
     * @param string $path
     * @return float|int
     */
    public function getFreeSpaceDskSize($path = '/')
    {
        $r = disk_free_space($path);
        return $r > 0 ? $r / (1024*1024) : 0;
    }

    /** *
    * Get the directory size
    * @param directory $directory
    * @return integer
    */
    public function get_dir_size($directory) {
        $r = 0;
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
            $r += @$file->getSize();
        }
        return $r > 0 ? $r / (1024*1024) : 0;
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $path
     * @param null $domain
     * @return bool
     */
    public static function setCookie($name = '', $value = '', $path = '/', $domain = null)
    {
        $domain = $domain === null ? $_SERVER["SERVER_NAME"] : $domain;

        return setcookie($name, $value, App::$config->cookie->expire, $path, $domain, 0);
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function freeCookie($name = '')
    {
        $domain = $_SERVER["SERVER_NAME"];

        return setcookie($name, '', 0, '/', $domain, 0);
    }

    /**
     * Check 2 time, return in this function if startTime < or = endTime is true, else is false
     * @param string|int $startTime
     * @param int $endTime
     * @return bool
     */
    public static function check2Time($startTime = '', $endTime = 0)
    {
        if( $startTime === 'now' ) $startTime = time();

        if( is_string($startTime) ) $startTime = strtotime($startTime);

        if( is_string($endTime) ) $endTime = strtotime($endTime);

        if( $startTime <= $endTime ) return true; else return false;
    }
}

//*******************************************All class in this file extends to CContoller class*************************
class CController extends CSys{

    public function  __construct(){
        parent::__construct();
    }

}