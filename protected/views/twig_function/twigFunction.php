<?php
/**
 * Created by PhpStorm.
 * User: etema
 * Date: 12/22/2014
 * Time: 5:18 PM
 */
class twigFunction extends  Twig_Extension{

    public function getName()
    {
        return 'twigFunction';
    }
    public function getFunctions()
    {
        return array(
            'generateMenu'=> new Twig_Function_Method($this, 'generateMenu', array('pre_escape' => 'html', 'is_safe' => array('all') ) ),
            'generateMenu2'=> new Twig_Function_Method($this, 'generateMenu2', array('pre_escape' => 'html', 'is_safe' => array('all') ) ),

            'inArray'=> new Twig_Function_Method($this, 'inArray'),
            'search'=> new Twig_Function_Method($this, 'search'),
            'arraySearchByK'=> new Twig_Function_Method($this, 'arraySearchByK', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'arraySearchByKGroup'=> new Twig_Function_Method($this, 'arraySearchByKGroup', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'arraySearchProductItems'=>new Twig_Function_Method($this, 'arraySearchProductItems'),

            'splitDigit'=>new Twig_Function_Method($this, 'splitDigit', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'textToParam'=>new Twig_Function_Method($this, 'textToParam', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'changeDate'=>new Twig_Function_Method($this, 'changeDate'),
            'getParam'=>new Twig_Function_Method($this, 'getParam'),
            'getDateDifEN'=>new Twig_Function_Method($this, 'getDateDifEN'),
            'plusDate'=>new Twig_Function_Method($this, 'plusDate'),
            'dump'=>new Twig_Function_Method($this, 'dump'),
            'jsonStringify'=>new Twig_Function_Method($this, 'jsonStringify'),
            'normalizeTimeStamp'=>new Twig_Function_Method($this, 'normalizeTimeStamp'),
            'safePrint'=>new Twig_Function_Method($this, 'safePrint'),
            'printWithTags'=> new Twig_Function_Method($this, 'printWithTags', array('pre_escape' => 'html', 'is_safe' => array('all') ) ),

            'generateGroups'=>new Twig_Function_Method($this, 'generateGroups', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'generateGroupsOPT'=>new Twig_Function_Method($this, 'generateGroupsOPT', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'generateGroupBreadCrumb'=>new Twig_Function_Method($this, 'generateGroupBreadCrumb', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'generateGroupBreadCrumbScrollBox'=>new Twig_Function_Method($this, 'generateGroupBreadCrumbScrollBox', array('pre_escape'=>'html', 'is_safe'=>array('all'))),

            'getProductGroup'=>new Twig_Function_Method($this, 'getProductGroup'),
            'createSpecialMenu'=>new Twig_Function_Method($this, 'createSpecialMenu2', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'createSpecialHideMenu'=>new Twig_Function_Method($this, 'createSpecialHideMenu', array('pre_escape'=>'html', 'is_safe'=>array('all'))),

            'createSpecialFooter'=>new Twig_Function_Method($this, 'createSpecialFooter', array('pre_escape'=>'html', 'is_safe'=>array('all'))),

            'getProduct'=>new Twig_Function_Method($this, 'getProduct'),

            'getProductInputValue'=>new Twig_Function_Method($this, 'getProductInputValue'),

            'getPartWithPath'=>new Twig_Function_Method($this, 'getPartWithPath'),

            'getComments'=>new Twig_Function_Method($this, 'getComments'),
            'calculateOverAll'=>new Twig_Function_Method($this, 'calculateOverAll'),

            'getProfileByUsername'=>new Twig_Function_Method($this, 'getProfileByUsername'),
        );
    }
    public function  getFilters(){
        return array(
            'generateMenu'=> new Twig_Function_Method($this, 'generateMenu', array('pre_escape' => 'html', 'is_safe' => array('all') ) ),
            'generateMenu2'=> new Twig_Function_Method($this, 'generateMenu2', array('pre_escape' => 'html', 'is_safe' => array('all') ) ),

            'inArray'=> new Twig_Function_Method($this, 'inArray'),
            'search'=> new Twig_Function_Method($this, 'search'),
            'arraySearchByK'=> new Twig_Function_Method($this, 'arraySearchByK', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'arraySearchByKGroup'=> new Twig_Function_Method($this, 'arraySearchByKGroup', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'arraySearchProductItems'=>new Twig_Function_Method($this, 'arraySearchProductItems'),

            'splitDigit'=>new Twig_Function_Method($this, 'splitDigit', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'textToParam'=>new Twig_Function_Method($this, 'textToParam', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'changeDate'=>new Twig_Function_Method($this, 'changeDate'),
            'getParam'=>new Twig_Function_Method($this, 'getParam'),
            'getDateDifEN'=>new Twig_Function_Method($this, 'getDateDifEN'),
            'plusDate'=>new Twig_Function_Method($this, 'plusDate'),
            'dump'=>new Twig_Function_Method($this, 'dump'),
            'jsonStringify'=>new Twig_Function_Method($this, 'jsonStringify'),
            'normalizeTimeStamp'=>new Twig_Function_Method($this, 'normalizeTimeStamp'),
            'safePrint'=>new Twig_Function_Method($this, 'safePrint'),
            'printWithTags'=> new Twig_Function_Method($this, 'printWithTags', array('pre_escape' => 'html', 'is_safe' => array('all') ) ),

            'generateGroups'=>new Twig_Function_Method($this, 'generateGroups', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'generateGroupsOPT'=>new Twig_Function_Method($this, 'generateGroupsOPT', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'generateGroupBreadCrumb'=>new Twig_Function_Method($this, 'generateGroupBreadCrumb', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'generateGroupBreadCrumbScrollBox'=>new Twig_Function_Method($this, 'generateGroupBreadCrumbScrollBox', array('pre_escape'=>'html', 'is_safe'=>array('all'))),

            'getProductGroup'=>new Twig_Function_Method($this, 'getProductGroup'),
            'createSpecialMenu'=>new Twig_Function_Method($this, 'createSpecialMenu2', array('pre_escape'=>'html', 'is_safe'=>array('all'))),
            'createSpecialHideMenu'=>new Twig_Function_Method($this, 'createSpecialHideMenu', array('pre_escape'=>'html', 'is_safe'=>array('all'))),

            'createSpecialFooter'=>new Twig_Function_Method($this, 'createSpecialFooter', array('pre_escape'=>'html', 'is_safe'=>array('all'))),

            'getProduct'=>new Twig_Function_Method($this, 'getProduct'),

            'getProductInputValue'=>new Twig_Function_Method($this, 'getProductInputValue'),

            'getPartWithPath'=>new Twig_Function_Method($this, 'getPartWithPath'),

            'getComments'=>new Twig_Function_Method($this, 'getComments'),
            'calculateOverAll'=>new Twig_Function_Method($this, 'calculateOverAll'),

            'getProfileByUsername'=>new Twig_Function_Method($this, 'getProfileByUsername'),

        );
    }

    /*
     * Generate menu function
     */
    public function generateMenu($menu, $openable_class, $class = false, $fromSubmenu = false){

        if( empty($menu) ) return '';

        // if( $class ) $s = '<li class="' . $openable_class . '">'; else $s = '<li>';
        $s = '';
        foreach($menu as $m){

            if( isset($m['class']) )
                $cl = ' class="' . $m['class'] . '"';
            else if( isset($m['icon']) )
                $cl = ' icon="' . $m['icon'] . '"';
            else $cl = '';

            if( !isset($m['submenu']) ){
                if( isset($m['mode']) && strtolower($m['mode']) == 'post' ) {
                    if( $fromSubmenu )
                        $s .= '<li title="'. $m['title'] .'" data-toggle="tooltip" data-placement="left"><a href="#" link="' . $m['link'] . '" mode="post" id="mainmenu-side" ><span ' . $cl . '></span> ' . $m['title'] . '</a></li>';
                    else
                        $s .= '<li title="'. $m['title'] .'" data-toggle="tooltip" data-placement="left"><a href="#" link="' . $m['link'] . '" mode="post" id="mainmenu-side" ><span ' . $cl . '></span> <span class="xn-text">' . $m['title'] . '</span></a></li>';
                }else {
                    if( $fromSubmenu )
                        $s .= '<li title="'.$m['title'] . '" data-toggle="tooltip" data-placement="left"><a href="' . $m['link'] . '" ><span ' . $cl . '></span> ' . $m['title'] . '</a></li>';
                    else
                        $s .= '<li title="'.$m['title'] . '" data-toggle="tooltip" data-placement="left"><a href="' . $m['link'] . '" ><span ' . $cl . '></span> <span class="xn-text">' . $m['title'] . '</span></a></li>';
                }
            }else{
                $s .= '<li class="' . $openable_class . '" title="' . $m['title'] . '">';
                $s .= '<a href="#" data-toggle="tooltip" data-placement="left" title="' . $m['title'] . '"><span ' . $cl . '></span> <span class="xn-text">' . $m['title'] . '</span></a>';
                $s .= '<ul>' . $this->generateMenu($m['submenu'], $openable_class, true, true) . '</ul>';
                $s .= '</li>';
                //$s .= '<li><a href="#"><span '. $cl . '></span> <span class="xn-text">'. $m['title'] . '</span></a></li><ul>' . $this->generateMenu($m['submenu'], $openable_class, true) . '</ul>';
            }//end else
        }//end foreach
        // $s .= '</li>';

        return $s;
    }//end function
    public function generateMenu2($menu, $class = false, $fromSubmenu = false){

        if( empty($menu) ) return '';

        // if( $class ) $s = '<li class="' . $openable_class . '">'; else $s = '<li>';
        $s = '';
        foreach($menu as $m){

            if( isset($m['class']) )
                $cl = ' class="' . $m['class'] . '"';
            else if( isset($m['icon']) )
                $cl = ' icon="' . $m['icon'] . '"';
            else $cl = '';

            if( !isset($m['submenu']) ){
                if( isset($m['mode']) && strtolower($m['mode']) == 'post' ) {
                    if( $fromSubmenu )
                        $s .= '<li tagName="'. $m['tagName'] .'" sort-id="' . $m['id'] . '" isModule="'.$m['module'].'" mName="'.$m['mName'].'" title="'.$m['title'].'" icon="'.$m['class'].'"><span ' . $cl . '></span><span class="xn-text"> ' . $m['title'] . '</span></li>';
                    else
                        $s .= '<li tagName="'. $m['tagName'] .'" sort-id="' . $m['id'] . '" isModule="'.$m['module'].'" mName="'.$m['mName'].'" title="'.$m['title'].'" icon="'.$m['class'].'"><span ' . $cl . '></span><span class="xn-text"> ' . $m['title'] . '</span></li>';
                }else {
                    if( $fromSubmenu )
                        $s .= '<li tagName="'. $m['tagName'] .'" sort-id="' . $m['id'] . '" isModule="'.$m['module'].'" mName="'.$m['mName'].'" title="'.$m['title'].'" icon="'.$m['class'].'"><span ' . $cl . '></span><span class="xn-text"> ' . $m['title'] . '</span></li>';
                    else
                        $s .= '<li tagName="'. $m['tagName'] .'" sort-id="' . $m['id'] . '" isModule="'.$m['module'].'" mName="'.$m['mName'].'" title="'.$m['title'].'" icon="'.$m['class'].'"><span ' . $cl . '></span><span class="xn-text"> ' . $m['title'] . '</span></li>';
                }
            }else{
                $s .= '<li tagName="'. $m['tagName'] .'" sort-id="' . $m['id'] . '" isModule="'.$m['module'].'" mName="'.$m['mName'].'" title="'.$m['title'].'" icon="'.$m['class'].'">';
                $s .= '<span ' . $cl . '></span> <span class="xn-text">' . $m['title'] . '</span>';
                $s .= '<ul>' . $this->generateMenu2($m['submenu'], true, true) . '</ul>';
                $s .= '</li>';
            }//end else
        }//end foreach
        // $s .= '</li>';

        return $s;
    }//end function

    /**
     * @param string $value
     * @param array $arr
     *
     * @return boolean in success is true or false
     */
    public function inArray($value = '', $arr)
    {
        return in_array($value, $arr);
    }

    /*
     * Search in string to find a keyword
     * return is false or true
     */
    public function search($keyword, $string){

        $r = strpos($string, $keyword);
        if( $r === false ) return false; else return true;
    }//end function

    /*
     * Search in multi array with key name
     */
    public function arraySearchByK($array, $kName, $val, $negativeResult = 'false'){

        if( empty($array) ) return $negativeResult;
        foreach($array as $k=>$a){
            if( isset($a[$kName]) && $a[$kName] == $val ) return $k;
        }//end foreach

        return $negativeResult;
    }//end arraySearchByK
    /*
     * Search in multi array group
     */
    public function arraySearchByKGroup($array, $kName, $val){
        if( empty($array) ) return null;

        foreach($array as $k=>$a){
            if( isset($a['@attributes']) ) {
                if ((string)$a['@attributes'][$kName] == $val) {
                    return $k;
                }
            }else{
                if( isset($a[$kName]) ){
                    if( $a[$kName] == $val) return $k;
                }else continue;
            }
        }
        return null;
    }

    /*
     * Search in product items
     */
    public function arraySearchProductItems($array, $kName, $val, $navigateResult = 'false')
    {
        if( empty($array) ) return $navigateResult;
        foreach($array as $k=>$a){
            if( $a[$kName] == $val ) return $k;
        }

        return $navigateResult;
    }//end arraySearchProductItems function


    /*
     * Split digit
     */
    public function splitDigit($s)
    {
        $s = strrev($s);

        $_s = str_split($s, 3);

        $out = '';
        for($i=count($_s)-1; $i>=0; $i--){
            $out .= strrev($_s[$i]);

            if( $i > 0 ) $out .= ',';
        }

        return $out;
    }//end splitDigit function

    /*
     * convert text to param
     */
    public function textToParam($s, $splitBy)
    {
        $s = explode($splitBy, $s);

        if( empty($s) ) return null;

        $r = array();
        for($i=0; $i<=count($s)-1; $i++){
            if( empty($s) ) continue;

            $p = explode('=', $s[$i]);

            if( !isset($p[0]) || !isset($p[1]) ) continue;

            $r[$p[0]] = $p[1];
        }

        return $r;
    }//end textToParam function

    /*
     * Change date to shamsi or miladi
     * $to can 's'=>shamsi or can be 'm'=>miladi
     */
    public function changeDate($timeStamp, $to = null, $format='Y/m/d')
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/extentions/jdf.php';
        $jd = new jdf();

        if( $to === null ){
            if( App::$config->lang == 'fa' ) $to = 's'; else $to = 'm';
        }

        if( $timeStamp == 'now' ) $timeStamp = time();
        else if( !is_numeric($timeStamp) ){
            $t = explode('/', $timeStamp);
            if( count($t) < 3 )
                $t = explode('-', $timeStamp);
            if( count($t) < 3 )
                $t = explode(',', $timeStamp);

            if( count($t) < 3 ) return false;

            if( $to == 's' && $t[0] > 1899 ) {
//                $timeStamp = $jd->gregorian_to_jalali($t[0], $t[1], $t[2], '/');
            }else if( $to == 'm' && $t[0] < 1500 ) $timeStamp = $jd->jalali_to_gregorian($t[0], $t[1], $t[2], '/');
        }

        if( !is_numeric($timeStamp) ) $timeStamp = strtotime($timeStamp);

        $y =        isset($format[0]) ? $format[0] : 'Y';
        $split1 =   isset($format[1]) ? $format[1] : '/';
        $m =        isset($format[2]) ? $format[2] : 'm';
        $split2 =   isset($format[3]) ? $format[3] : '/';
        $d =        isset($format[4]) ? $format[4] : 'd';
        $split3 =   isset($format[5]) ? $format[5] : '/';
        $o =        isset($format[6]) ? $format[6] : '';

        if( $to == 's' ) {
            return $jd->jdate($y, $timeStamp) . $split1 . $jd->jdate($m, $timeStamp) . $split2 . $jd->jdate($d, $timeStamp) . (!empty($o) ? ($split3 . $jd->jdate($o, $timeStamp)) : '');
        }else if( $to == 'm' ){
            return date($format, $timeStamp);
        }
    }//end changeDate

    /*
     * calculate different between two date
     */
    public function getDateDifEN($d1, $d2)
    {
        $d1 = !is_numeric($d1) ? strtotime($d1) : $d1;
        $d2 = !is_numeric($d2) ? strtotime($d2) : $d2;

        return ($d1 - $d2) /(60*60*24);
    }

    /*
     * plus 2 date
     *
     * @param timeStamp can be now or an other date number
     * @param day must be number of day you want to sum with timeStamp
     * @param to is 's' or 'm'.it can be empty, system can select automatically.
     * @param format is string of format date you want
     */
    public function plusDate($timeStamp = 'now', $day, $to = null, $format = 'Y/m/d')
    {
        if( $timeStamp == 'now' ) $timeStamp = time();
        if( !is_numeric($timeStamp) ) $timeStamp = strtotime($timeStamp);

        $timeStamp += $day*60*60*24;
        $timeStamp = date($format, $timeStamp);

        return $this->changeDate($timeStamp, $to, $format);
    }//end plusDate function

    /*
     * Get all param from $_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER, or $_REQUEST in unknown param
     */
    public function getParam($where = 'request', $name)
    {
        switch( $where ){
            case 'request': return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null; break;
            case 'get': return isset($_GET[$name]) ? $_GET[$name] : null; break;
            case 'post': return isset($_POST[$name]) ? $_POST[$name] : null; break;
            case 'cookie': return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null; break;
            case 'session': return isset($_SESSION[$name]) ? $_SESSION[$name] : null; break;
            case 'server': return isset($_SERVER[$name]) ? $_SERVER[$name] : null; break;
        }
        return null;
    }//end getParam function


    /*
     * var_dump function
     */
    public function dump($p)
    {
        var_dump($p);
    }//end dump function


    public function jsonStringify($array)
    {
        return json_encode($array);
    }

    /*
     * Normalize timeStamp, your time string must be like this: 2015-12-31 23:44 or 2015/12/31 23:44
     * first part is date and second part is time
     */
    public function normalizeTimeStamp($timeStamp)
    {
        $ts = explode(' ', $timeStamp);

        $d = $this->changeDate(isset($ts[0]) ? $ts[0] : 'now');
        $t = isset($ts[1]) ? $ts[1] : '';

        return array(
            'time'=>$t,
            'date'=>$d
        );
    }//end normalizeTimeStamp function

    /*
     * Create safe characters
     * this function remove all js script tags
     */
    public function safePrint($html)
    {
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);

        return $html;
    }

    public function printWithTags($s)
    {
        $tags = array(
            array('tag'=>'&lt;', 'replace'=>'<'),
            array('tag'=>'&gt;', 'replace'=>'>'),
            array('tag'=>'&quot;', 'replace'=>'"'),
        );

        foreach ($tags as $tag) {
            $s = str_replace($tag['tag'], $tag['replace'], $s);
        }

        return $s;
    }

    function generateGroups($gs, $staticGS, $gsName, $att = false){
        $ulF = '<ul>';
        $ulE = '</ul>';
        if( empty($gs) ) return null;

        $s = '';
        foreach($gs as $k=>$g){
            $k = $this->convertIntToString($k);
            if( $att ){
                if( $k == 'title' ){
                    $d = false; $p = 0;
                    $path = $this->router($staticGS, $gs['name'], true, $d, $p, $gsName);
                    $s .= '<li g-name="' . $gs['name'] . '"  path="' . $path . '">' . $g . '</li>';
                }
            }else if( is_array($g) ){
                if( ($k === '@attributes' || $k === 'part') ){
                    $s .= $ulF;
                }

                if( $k == '@attributes' )
                    $s .=  $this->generateGroups($g, $staticGS, $gsName, true);

                $_s =$this->generateGroups($g, $staticGS, $gsName, false);
                if( !empty($_s) ){

                    $s .= $_s;

                }

                if( ($k === '@attributes' || $k === 'part') )
                    $s .= $ulE;

            }

        }

        return $s;
    }//end generateGroups function

    /*
     * Generate groups in select tags
     */
    public function generateGroupsOPT($gs, $staticGS, $gsName, $att = false){
        if( empty($gs) ) return null;

        $s = '';
        foreach($gs as $k=>$g){
            $k = $this->convertIntToString($k);
            if( $att ){
                if( $k == 'title' ){
                    $d = false; $p = 0;
                    $path = $this->router($staticGS, $gs['name'], true, $d, $p, $gsName);
                    $s .= '<option g-name="' . $gs['name'] . '"  value="' . $path . '">' . $g . '</option>';
                }
            }else if( is_array($g) ){
                if( $k == '@attributes' )
                    $s .=  $this->generateGroupsOPT($g, $staticGS, $gsName, true);

                $_s =$this->generateGroupsOPT($g, $staticGS, $gsName, false);
                if( !empty($_s) ){
                    $s .= $_s;
                }

            }

        }

        return $s;
    }//end router function

    /*
     * Generate like breadcrumb
     */
    private function generateArray($gs, $staticGS, $gsName, $att = false, &$items = null){
        if( empty($gs) ) return null;

        foreach($gs as $k=>$g){
            $k = $this->convertIntToString($k);
            if( $att ){
                if( $k == 'title' ){
                    $d = false; $p = 0;
                    $path = $this->router($staticGS, $gs['name'], true, $d, $p, $gsName);

                    #Remove gs[name] from path if found
                    $foundWithSlash = strpos($path, $gs['name'] . '//');
                    if( $foundWithSlash ){
                        $newPath = substr($path, 0, $foundWithSlash);
                        $newPath.= substr($path, $foundWithSlash+strlen($gs['name'] . '//'), strlen($path));

                        $path = $newPath;
                    }else{
                        $found = strpos($path, $gs['name']);
                        if( $found ){
                            $newPath = substr($path, 0, $found);
                            $newPath.= substr($path, $found+strlen($gs['name']), strlen($path));

                            $path = $newPath;
                        }
                    }

                    $items[] = array(
                        'name'=>$gs['name'],
                        'title'=>$g,
                        'path'=>$path
                    );
                }
            }else if( is_array($g) ){
                if( $k == '@attributes' )
                    $this->generateArray($g, $staticGS, $gsName, true, $items);
                $this->generateArray($g, $staticGS, $gsName, false, $items);
            }

        }
    }
    private function _search($s, $findMe){
        for($i=0; $i<=strlen($s)-1; $i++){
            if( substr($s, $i, strlen($findMe)) == $findMe ) return true;
        }

        return false;
    }
    public function generateGroupBreadCrumb($gs, $staticGS, $gsName, $att = false, $type='checkbox', $isPage=false){
        $this->generateArray($gs, $staticGS, $gsName, $att, $items);

        #Now check selectable items
        for($i=0; $i<=count($items)-1; $i++){
            $name = $items[$i]['name'];

            for($j=0; $j<=count($items)-1; $j++){
                $found = $this->_search($items[$j]['path'], $name);
                if( $found == false ){
                    $items[$i]['selectable'] = 1;
                } else{
                    $items[$i]['selectable'] = 0;
                    break;
                }
            }

        }

        #Now create a group
        $paths = array();
        $selectable = array();
        for($i=0; $i<=count($items)-1; $i++){
            if( $items[$i]['selectable'] == 1 ){
                $search = array_search($items[$i]['path'], $paths);
                if( $search !== false ){
                    $selectable[$search][] = $items[$i];
                }else{
                    $paths[] = $items[$i]['path'];
                    $selectable[count($paths)-1][] = $items[$i];
                }
            }
        }

        $translatePaths = array();

        #Now translate paths.
        if( $isPage === true )
            $gsForm = new pageGroupForm();
        else
            $gsForm = new groupForm();
        foreach($paths as $k=>$path){
            $_p = explode('//', $path);

            #first index is group after them is part
            $s = '';
            for($i=1; $i<=count($_p); $i++){
                if( empty($_p[$i]) ) continue;

                if( $i==1 ){
                    $g = $gsForm->getGroup($_p[$i]);
                    $s .= $g['@attributes']['title'] . ' &raquo; ';
                }else{
                    #Now Create xpath
                    $xpath = '';
                    for($j=0; $j<=$i; $j++){
                        if( empty($_p[$j]) ) continue;
                        if( $j == 1 ) $xpath = '//group[@name="' . $_p[$j] . '"]';
                        else{
                            $xpath .= '//part[@name="' . $_p[$j] . '"]';
                        }
                    }//end for
                    $part = $gsForm->getPartWithPath($xpath);
                    $s .= $part['@attributes']['title'] . ' &raquo; ';
                }//end else
            }

            #remove last from s ' > '
            $aquoLength = strlen(' &raquo; ');
            if( substr($s, strlen($s)-$aquoLength, $aquoLength) == ' &raquo; ' ) $s = substr($s, 0, strlen($s)-$aquoLength);
            $translatePaths[$k] = $s;
        }

        $out = '<div class="form-group"><div class="col-md-12"> ';
        foreach($selectable as $k=>$sel){
            $randGID = substr(str_shuffle('ABCDEFGHIJKLOMNPQRSTUVWXYZ0987654321'), 0, 4);
            if( $type == 'checkbox' ) {
                $out .= '<label class="check col-md-12" group-id="' . $randGID . '" id="lbgroup" >';
                $out .= '<input type="checkbox" class="icheckbox" group-id="' . $randGID . '" id="chgroup"> ';
            }
            $out.= '<strong>' . $translatePaths[$k] . ': </strong><br>';
            if( $type == 'checkbox' )
                $out.='</label>';
            foreach($sel as $s){
                $out .= '<div class="col-md-4 pull-right text-right" dir="ltr" style="padding-right: 40px;">' . '<label class="check">' . $s['title'] .
                    ' <input type="' . $type . '" class="i' . $type .'" id="part" name="part" group-id="'.$randGID.'" path="' . $s['path'] . $s['name'] . '//' .'">' . '</label></div>';
            }
            $out .= '<br><br>';
        }

        $out .= '</div></div>';

        return $out;
    }//end generateGroupBreadCrumb function

    public function generateGroupBreadCrumbScrollBox($gs, $staticGS, $gsName, $att = false){
        $this->generateArray($gs, $staticGS, $gsName, $att, $items);

        #Now check selectable items
        for($i=0; $i<=count($items)-1; $i++){
            $name = $items[$i]['name'];

            for($j=0; $j<=count($items)-1; $j++){
                $found = $this->_search($items[$j]['path'], $name);
                if( $found == false ){
                    $items[$i]['selectable'] = 1;
                } else{
                    $items[$i]['selectable'] = 0;
                    break;
                }
            }

        }

        #Now create a group
        $paths = array();
        $selectable = array();
        for($i=0; $i<=count($items)-1; $i++){
            if( $items[$i]['selectable'] == 1 ){
                $search = array_search($items[$i]['path'], $paths);
                if( $search !== false ){
                    $selectable[$search][] = $items[$i];
                }else{
                    $paths[] = $items[$i]['path'];
                    $selectable[count($paths)-1][] = $items[$i];
                }
            }
        }

        $translatePaths = array();

        #Now translate paths
        $gsForm = new groupForm();
        foreach($paths as $k=>$path){
            $_p = explode('//', $path);

            #first index is group after them is part
            $s = '';
            for($i=1; $i<=count($_p); $i++){
                if( empty($_p[$i]) ) continue;

                if( $i==1 ){
                    $g = $gsForm->getGroup($_p[$i]);
                    $s .= $g['@attributes']['title'] . ' &raquo; ';
                }else{
                    #Now Create xpath
                    $xpath = '';
                    for($j=0; $j<=$i; $j++){
                        if( empty($_p[$j]) ) continue;
                        if( $j == 1 ) $xpath = '//group[@name="' . $_p[$j] . '"]';
                        else{
                            $xpath .= '//part[@name="' . $_p[$j] . '"]';
                        }
                    }//end for
                    $part = $gsForm->getPartWithPath($xpath);
                    $s .= $part['@attributes']['title'] . ' &raquo; ';
                }//end else
            }

            #remove last from s ' > '
            $aquoLength = strlen(' &raquo; ');
            if( substr($s, strlen($s)-$aquoLength, $aquoLength) == ' &raquo; ' ) $s = substr($s, 0, strlen($s)-$aquoLength);
            $translatePaths[$k] = $s;
        }

        $out = '';
        foreach($selectable as $k=>$sel){
            $out.= '<optgroup label="' . $translatePaths[$k] .'">';
            foreach($sel as $s){
                $out .= '<option value="'. $s['path'] . $s['name'] . '//' .'">' . $s['title'] . '</option>';
            }
            $out .= '</optgroup>';
        }

        return $out;
    }//end generateGroupBreadCrumb function

    /*
     * Generate groups
     */
    private function convertIntToString($k){
        $ss = '';
        for($i=0; $i<=strlen($k)-1; $i++){
            $ss .= substr($k, $i, 1);
        }
        return $ss;
    }
    private function addGroupNameInXPath($s, $firstName, $first){
        if( $first && (substr($s, 0, strlen('//'.$firstName)-1) != '//'.$firstName || substr($s, 0, strlen($firstName)-1) != $firstName) ){
            if( substr($s, 0, strlen('//'.$firstName)) != '//'.$firstName && substr($s, 0, strlen($firstName)) != $firstName )
                $s = '//'.$firstName . '//' . $s;
            else if( substr($s, 0, strlen('//'.$firstName)) != '//'.$firstName && substr($s, 0, strlen($firstName)) == $firstName )
                $s = '//' . $s;
        }

        #Normalize $s
        $array = explode('//', $s);
        foreach($array as $_k=>$_s){
            if( empty($_s) ) continue;
            $count = 0;
            for($i=0; $i<=strlen($s)-1; $i++){
                if ( substr($s, $i, strlen($_s)) == $_s )
                    $count++;
            }
            if( $count > 1 ){
                unset($array[$_k]);
                $s = implode('//', $array);
            }
        }
        return $s;
    }
    private function router($gs, $findMe, $first=true, &$doFind = false, &$partCount = 0, $firstName = '', $repeat = false){
        $firstName = $this->convertIntToString($firstName);

        $s = '';
        foreach($gs as $k=>$g){
            $k = $this->convertIntToString($k);
            if( (is_numeric($k) || isset($g['@attributes']['name'])) && $doFind == false ){
                if( $firstName == '' ) $firstName = $g['@attributes']['name'];

                $s .= $g['@attributes']['name'] . '//';

                if( (string)$findMe == $this->convertIntToString($g['@attributes']['name']) ){
                    $doFind = true;
                    if( $repeat )
                        return $s;
                    else return $this->addGroupNameInXPath($s, $firstName, $first);
                }
                if( $partCount == 0 ) $s = '';
            }

            if( $k == (string)'part' ){
                $_s = $gs['@attributes']['name'] . '//';
                $_s.= $this->router($g, $findMe, false, $doFind, $partCount, $firstName, true);

                if( $doFind ) $s .= $_s;
            }else if( is_numeric($k) ){
                $partCount++;

                $_s = $this->router($g, $findMe, false, $doFind, $partCount, $firstName, true);

                $partCount--;
                if( $doFind ) $s .= $_s;

                if( $doFind == false && $first == false ) $s = '';

            }else if ( $k == '@attributes' ){
                if( $firstName == '' ) $firstName = $g['name'];

                $s .= $g['name'] . '//';

                if( (string)$findMe == $this->convertIntToString($g['name']) ){
                    $doFind = true;
                    return $s;
                }
                if( $partCount == 0 ) $s = '';
            }

            if( $doFind ){

                return $this->addGroupNameInXPath($s, $firstName, $first);
            }
        } //end foreach

        return '';
    }//end router function

    /**
     * @param string $pgName
     * @return array|int|null
     */
    public function getProductGroup($pgName)
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/models/modulesForm.php";

        $mForm = new modulesForm();
        $ms = $mForm->getModuleList();

        if( !is_array($ms) ) return null;

        if( !in_array('m_product', $ms) ) return null;

        require_once $_SERVER['DOCUMENT_ROOT'] . "/protected/modules/m_product/models/productGroupForm.php";

        $pgForm = new productGroupForm();
        $pg = $pgForm->getPG($pgName);

        return $pg;
    }


    public function createSpecialHideMenu()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/models/modulesForm.php";

        if( !modulesForm::checkModuleByName('m_product') ) return '';

        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/modules/m_product/models/groupForm.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/modules/m_product/models/productGroupForm.php";

        $gForm = new groupForm();
        $pgForm = new productGroupForm();

        $groups = $gForm->getGroups();

        if( !is_array($groups) ) return '';

        $pgLists = array();
        foreach($groups as $g){
            //Now get product group by group name
            $gName = $g['@attributes']['name'];

            $pgs = $pgForm->getPGByAssignedGroup($gName);

            if( !is_array($pgs) ) continue;

            //Add Group Title
            $pgLists[$gName]['name'] = $g['@attributes']['name'];
            $pgLists[$gName]['title'] = $g['@attributes']['title'];
            $pgLists[$gName]['img'] = $g['@attributes']['img'];
            $pgLists[$gName]['controller'] = $g['@attributes']['controller'];
            foreach ($pgs as $k=>$pg) {
                $xPath = $pg['@attributes']['xpath'];

                if( empty($xPath) ) continue;

                //Get last path
                $xPath = explode('//', $xPath);

                //Now unset path
                unset($xPath[count($xPath)-2]);

                $xPath = implode('//', $xPath);

                if( empty($xPath)) continue;

                $part = $gForm->getPartWithPath($xPath, true, false);

                $pgName = $pg['@attributes']['name'];

                $pgLists[$gName]['parts']['title'] = $part['@attributes']['title'];
                $pgLists[$gName]['parts']['name'] = $part['@attributes']['name'];

                //Get part with xpath
                $part = $gForm->getPartWithPath($pg['@attributes']['xpath'], true);

                $pgLists[$gName]['parts'][] = array(
                    'title'=>$part['@attributes']['title'],
                    'des'=>$pg['@attributes']['description'],
                    'pgName'=>$pgName
                );

            }
        }

        if( empty($pgLists) ) return '';

        //Now create element
        $s = '';
        foreach ($pgLists as $g) {
//            var_dump($g);return '';
            //Create main-menu title

            $_gName = $g['controller'] == 1 ? $g['name'] : '';
            $prifix = $_gName == '' ? 'group/' . $g['name'] . '/' : '';
            $href = str_replace(' ', '_', $_gName . '/' . $prifix . $g['title']);
            $s .= '<li>';
            $s .= '<span class="name"><span class="expander">-</span><a href="' . $href . '">' .  $g['title'] . '</a></span>';
            $s .= '<ul>';
            foreach ($g['parts'] as $k=>$p) {
                if( is_numeric($k) ){
                    $_gName = $g['controller'] == 1 ? $g['name'] : '';
                    $href = str_replace(' ', '_', $_gName . '/products/' . $p['pgName'] . '/' . $p['title'] . '_' . $p['des']);
                    $s .= '<li>';
                    $s .= '<a href="' . $href . '">' . $p['title'] . ' ' . $p['des'] . '</a></li>';
                }
            }
            $s .= '</ul></li>';

        }

        return $s;
    }
    private function getFromAttributes($g, $keyName)
    {
        if( isset($g['@attributes']) ) $value = $g['@attributes'][$keyName]; else
            if( isset($g[$keyName]) ) $value = $g[$keyName]; else
                $value = null;

        return $value;
    }
    public function createSpecialMenu2()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/models/modulesForm.php";

        if( !modulesForm::checkModuleByName('m_product') ) return '';

        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/modules/m_product/models/productGroupForm.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/modules/m_product/models/groupForm.php";

        $pgForm = new productGroupForm();
        $gForm = new groupForm();

        //Get products-group first
        $pgs = $pgForm->getPGs();

        if( !is_array($pgs) ) return null;

        //New List
        $nList = array();
        foreach ($pgs as $pg) {

            //Get Group name
            $gName = $this->getFromAttributes($pg, 'assigned_group');

            if( empty($gName) ) continue;

            //Check nList this group name
            if( !isset($nList[$gName]) ) $nList[$gName] = array();

            //Get xpath
            $xpath = $this->getFromAttributes($pg, 'xpath');

            if( empty($xpath) ) continue;

            //Now check nList[gName] xpath
            if( !isset($nList[$gName][$xpath]) ) $nList[$gName][$xpath] = array();

            $pgName = $this->getFromAttributes($pg, 'name');
            $des = $this->getFromAttributes($pg, 'description');
            $icon = $this->getFromAttributes($pg, 'icon');

            $nList[$gName][$xpath][] = array(
                'name'=>$pgName,
                'description'=>$des,
                'icon'=>$icon
            );

        }

        if( empty($nList) ) return null;

        //Create html tags
        $s = '';
        foreach ($nList as $k=>$group) {
            if( empty($group) ) continue;

            $g = $gForm->getGroup($k);

            //Get group attributes
            $gTitle = $this->getFromAttributes($g, 'title');
            $gController = $this->getFromAttributes($g, 'controller');
            $gName = $this->getFromAttributes($g, 'name');
            $gImage = $this->getFromAttributes($g, 'img');

            $_gName = $gController == 1 ? $gName : '';
            $prifix = $_gName == '' ? 'group/' . $gName . '/' : '';

            $href = str_replace(' ', '_', $_gName . '/' . $prifix . $gTitle);

            $s .= '<dt class="item"><a href="' . $href . '" class="btn-main line">' . $gTitle . '</a></dt>';
            $s .= '<dd class="item-content">';
            $s .=   '<div class="megamenuClose"></div>';
            $s .=   '<div class="navbar-main-submenu">';
            $s .=       '<ul class="exclusive top">';

            $prifix = $_gName == '' ? $gName . '/' : '';
            $href = str_replace(' ', '_', $_gName . '/best/' . $prifix . $gTitle);
            $s .=           '<li><span class="icon fa fa-bar-chart-o"></span><a href="' . $href .  '"> [%BESTSELLERS%]</a></li>';

            $href = str_replace(' ', '_', $_gName . '/newest/' . $prifix . $gTitle);
            $s .=           '<li><span class="icon fa fa-star"></span><a href="' . $href .  '"> [%NEWEST%]</a></li>';
            $s .=       '</ul>';
            $s .=       '<div class="wrapper-border">';
            $s .=           '<div class="row">';
            $s .=               '<div class="col-sm-12 col-md-9">';
            $s .=                   '<div class="row ">';

            foreach ($group as $xpath=>$part) {
                if( empty($part) ) continue;

                $p = $gForm->getPartWithPath($xpath, true, false);

                if( !is_array($p) ) continue;

                //Get p attributes
                $pName = $this->getFromAttributes($p, 'name');
                $pTitle = $this->getFromAttributes($p, 'title');

                $s .=                   '<div class="col-xs-6 col-md-4 col-lg-3">';
                $s .=                       '<div class="row col-divider" >';
                $s .=                       '<div class="submenu-block ">';

                $href = str_replace(' ', '_', $_gName . '/part/' . $prifix . $pName . '/' . $pTitle);
                $s .=                           '<span class="icon"></span><a class="name" href="' . $href .  '"><strong>'. $pTitle . '</strong></a>';
                $s .=                           '<ul>';

                foreach ($part as $pg) {
                    $href = str_replace(' ', '_', $_gName . '/products/' . $pg['name'] . '/' . $pTitle . '_' . $pg['description']);
                    $s .=                               '<li style="padding-bottom: 10px;"><a href="' . $href .  '">' . $pTitle . ' ' . $pg['description'] . '</a></li>';
                }

                $s .=                                   '</ul>';
                $s .=                               '</div>';
                $s .=                           '</div>';
                $s .=                       '</div>';


            }
            $s .=                   '</div>';
            $s .=               '</div>';

            $s .=               '<div class="col-md-3 hidden-sm hidden-xs">';
            $s .=                   '<div class="img-fullheight">';
            $s .=                           '<img class="img-responsive" src="' . $gImage . '" alt="">';
            $s .=                   '</div>';
            $s .=               '</div>';


            $s .=           '</div>';
            $s .=       '</div>';

            $s .=       '<ul class="exclusive bottom">';
            $prifix = $_gName == '' ? 'group/' . $gName . '/' : '';
            $href = str_replace(' ', '_', $_gName . '/' . $prifix . $gTitle);
            $s .=           '<li><span class="icon fa fa-asterisk"></span><a href="' . $href . '"> [%SHOW_ALL%]</a></li>';
            $s .=       '</ul>';

            $s .=   '</div>';
            $s .= '</dd>';

        }

        return $s;
    }

    public function createSpecialFooter()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/models/modulesForm.php";

        if( !modulesForm::checkModuleByName('m_page') ) return '';

        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/modules/m_page/models/pageGroupForm.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/protected/modules/m_page/models/pageForm.php";

        $gForm = new pageGroupForm();
        $pForm = new pageForm();

        $groups = $gForm->getGroups();

        if( !is_array($groups) ) return '';

        $s = '';
        foreach ($groups as $g) {
            $gName = $g['@attributes']['name'];

            $randomID = 'id' . rand(10, 4567);

            $s .= '<div class="collapsed-block">';
            $s .=   '<div class="inside">';
            $s .=   '<h3><span class="link">' . $g['@attributes']['title'] . '</span>';
            $s .=        '<a class="expander visible-sm visible-xs" href="#' . $randomID . '">+</a></h3>';
            $s .=   '<div class="tabBlock" id="' . $randomID . '">';
            $s .=       '<ul class="menu">';

            //Get all page have this name in path
            $pages = $pForm->getAllPage();
            if( is_array($pages) ){
                foreach($pages as $p){
                    $path = $p['path'];

                    if( strpos($path, '//' . $gName . '//') === false ) continue;

                    $s .= '<li><a href="/page/' . $p['name'] . '/' . str_replace(' ', '_', $p['title']) . '">' . $p['title'] . '</a></li>';
                }
            }

            $s .=       '</ul>';
            $s .=   '</div>';
            $s .=   '</div>';
            $s .= '</div>';

        }

        return $s;
    }

    /**
     * @param int $productCode
     * @return array|bool|int|null
     */
    public function getProduct($productCode)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/models/modulesForm.php';
        if( !modulesForm::checkModuleByName('m_product') ) return false;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/modules/m_product/models/productForm.php';

        $pForm = new productForm();
        $product = $pForm->getProduct($productCode);

        return $product;
    }

    /**
     * @param array $product
     * @param string $name
     * @return null
     */
    public function getProductInputValue($product, $name)
    {
        if( !isset($product['_input']) ) return null;

        $index = $this->arraySearchProductItems($product['_input'], 'key-name', $name);

        return is_numeric($index) ? $product['_input'][$index]['value'] : '';
    }

    public function getPartWithPath($xpath)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/models/modulesForm.php';
        if( !modulesForm::checkModuleByName('m_product') ) return null;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/modules/m_product/models/groupForm.php';

        $gForm = new groupForm();
        $part = $gForm->getPartWithPath($xpath, true, false);

        return $part;
    }

    public function getComments($pCode)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/models/modulesForm.php';
        if( !modulesForm::checkModuleByName('m_comment') ) return null;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/modules/m_comment/models/commentForm.php';

        $cmForm = new commentForm();
        $path = $cmForm->crPath($pCode);

        $r = $cmForm->getCommentsByPath($path, 1);

        return $r;
    }

    public function calculateOverAll($comments)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/models/modulesForm.php';
        if( !modulesForm::checkModuleByName('m_comment') ) return null;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/modules/m_comment/models/commentForm.php';

        $cmForm = new commentForm();
        $r = $cmForm->calculateRate5Star($comments);

        if( $r <= 0 ) $r = 0;

        return $r;
    }

    public function getProfileByUsername($username)
    {
        if( empty($username) ) return null;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/models/modulesForm.php';
        if( !modulesForm::checkModuleByName('m_profile') ) return null;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/modules/m_profile/models/profileForm.php';

        $pForm = new profileForm();
        return $pForm->getAccountWithoutPasswordCheck($username);
    }
}