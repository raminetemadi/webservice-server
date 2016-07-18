<?php

class xml extends Form{

    protected $xmlPath;
    protected $xmlFile;

    private $isOK;
    private $lastError;

    /*
     * Create new xml file
     */
    public function createXML($s, $path, $overWrite = false, $createHead = false){
        if( file_exists($path) && $overWrite == false ){
            return $this->loadXML($path);
        }else{
            if( $createHead === true ) $s = '<?xml version="1.0" encoding="utf-8"?>' . $s;
            file_put_contents($path, $s);
            return $this->loadXML($path);
        }
    }//end createXML function

    /*
     * Load xml file
     */
    public function loadXML($path){
        if( file_exists($path) ){
            $this->xmlFile = new SimpleXMLElement($path, 0, true);
            $this->xmlPath = $path;

            return true;
        }else{
            $this->isOK = false;
            $this->lastError = ER_FILE_NOT_FOUND;
            return ER_FILE_NOT_FOUND;
        }
    }//end loadXML function

    /*
     * Add new element
     *
     * $tagName must be selected look like $this->xmlFile->addChild($tagName)
     * $ntagName is new tag name
     * $tagVal is value for element
     * $path if selected user can add child in this path
     * $attributes is array
     * $pk = PRIMARY KEY
     */
    public function addElement($tagName, $ntagName = '', $tagVal = '', $path = '', $attributes = null, $pk = '', $autoSave = true, $justPath = false){

        if( $this->isOK === false ) return false;

        #Check all attributes
        if( !empty($attributes) && !$this->validate($attributes) ) return $this->error;

        if( empty($ntagName) ) $ntagName = $tagName;

        if( !empty($path) ) {
            $els = $this->xPath($path, 0);
        }else
            $els = $this->xmlFile->{$tagName};

        #First search in all elements
        if( !empty($pk) && count($els)>=0 ) {
            for($i=0; $i<=count($els)-1; $i++){
                if( !isset($els[$i]) ) continue;

                if( (string)$els[$i]->attributes()->{$pk} == (string)$attributes[$pk] ) return ER_G_EXISTS;
            }
            /*
            foreach($els as $el):
                if( (string)$el->attributes()->{$pk} == (string)$attributes[$pk] ) return ER_G_EXISTS;
            endforeach;
            */
        }

        $elCount = count($els);

        if( !empty($path) ) {
            $els->addChild($ntagName, $tagVal);
        }else {
            $this->xmlFile->addChild($ntagName, $tagVal);
        }

        if( !empty($path) ) {
            if( $justPath == false )
                $els = $this->xPath($path, 0)->{$tagName};
            else
                $els = $this->xPath($path, 0);
        }else
            $els = $this->xmlFile->{$tagName};

        if( !empty($attributes) ){
            foreach($attributes as $k=>$v):
                if( $ntagName == $tagName ) {
                    $els[$elCount]->addAttribute($k, $v);
                }else
                    $els->{$ntagName}[$elCount]->addAttribute($k, $v);
            endforeach;
        }

        if( $autoSave ) return $this->saveXML(); else return true;
    }//end AddElement function

    /*
     * Update an element by PK
     */
    private function _issame($el, $where, $mode = 'AND'){
        $isSame = true;
        foreach($where as $k=>$v):
            if( !isset($el->attributes()->{$k}) ) return ER_XML_ATTRIBUTES_NOT_FOUND;

            if( $mode == 'AND' ) {
                if ((string)$el->attributes()->{$k} != $v) {
                    $isSame = false;
                    break 1;
                }
            }else if( $mode == 'OR' ){
                if ((string)$el->attributes()->{$k} == $v){
                    $isSame = true;
                    break 1;
                }
            }
        endforeach;
        return $isSame;
    }
    private function _changeEl(&$els, $index = null, $attributes = null){
        if( $index !== null ){
            $i = $index;
            foreach($attributes as $k=>$v):
                #Unset current attribute
                if( isset($els[$i]->attributes()->{$k}) )
                    unset($els[$i]->attributes()->{$k});

                #Now set new attribute
                $els[$i]->addAttribute($k, $v);
            endforeach;
        }else{
            foreach($attributes as $k=>$v):
                #Unset current attribute
                if( isset($els->attributes()->{$k}) )
                    unset($els->attributes()->{$k});

                #Now set new attribute
                $els->addAttribute($k, $v);
            endforeach;
        }
    }
    public function updateElement($tagName, $path = '', $where, $attributes = null, $autoSave = true, $mode = 'AND', $justPath = true)
    {
        if( $this->isOK === false ) return false;

        #Check all attributes
        if( !empty($attributes) && !$this->validate($attributes) ) return $this->error;

        #Get All elements
        if( !empty($path) ) {
            if( $justPath == false )
                $els = $this->xPath($path, 0)->{$tagName};
            else
                $els = $this->xPath($path, 0);
        }else
            $els = $this->xmlFile->{$tagName};

        if( $els === null ) return ER_XML_INVALID_XPATH;

        if( count($els)> 0 ) {
            $isSame = $this->_issame($els, $where, $mode);
            if ($isSame) $this->_changeEl($els, null, $attributes);

            for($i=0; $i<=count($els)-1; $i++){
                if( !isset($els[$i]) ) continue;

                $isSame = $this->_issame($els[$i], $where, $mode);

                if ($isSame) $this->_changeEl($els[$i], null, $attributes);

            }
        }else{
            $isSame = $this->_issame($els, $where, $mode);
            if ($isSame) $this->_changeEl($els, null, $attributes);
        }
        if( $autoSave ) return $this->saveXML(); else return true;
    }//end updateElement function

    /**
     * @param string $tagName
     * @param string $path
     * @param array $where
     * @param string $newVal
     * @param bool|true $autoSave
     * @param string $mode
     * @param bool|false $justPath
     * @return bool|int
     */
    public function updateTagValueElement($tagName, $path = '', $where, $newVal = '', $autoSave = true, $mode = 'AND', $justPath = false)
    {
        if( $this->isOK === false ) return false;

        //check special character
        $newVal = htmlspecialchars($newVal, ENT_QUOTES);

        #Get All elements
        if( !empty($path) ) {
            if( $justPath == false )
                $els = $this->xPath($path, 0)->{$tagName};
            else
                $els = $this->xPath($path, 0);
        }else
            $els = $this->xmlFile->{$tagName};

        if( $els === null ) return ER_XML_INVALID_XPATH;

        if( count($els)> 0 ) {
            for($i=0; $i<=count($els)-1; $i++){
                if( !isset($els[$i]) ) continue;

                $isSame = $this->_issame($els[$i], $where, $mode);
                if ($isSame) $els[$i] = $newVal;

            }
        }else{
            $isSame = $this->_issame($els, $where, $mode);
            if ($isSame) $els = $newVal;
        }
        if( $autoSave ) return $this->saveXML(); else return true;

    }

    /*
     * Remove an element
     */
    public function deleteElement($tagName, $path = '', $where, $mode = 'AND', $autoSave = true, $justPath = true){
        if( $this->isOK === false ) return false;

        #Get All elements
        if( !empty($path) ) {
            if( $justPath === false )
                $els = $this->xPath($path, 0)->{$tagName};
            else
                $els = $this->xPath($path, 0);
        }else
            $els = $this->xmlFile->{$tagName};

        if( $els === null ) return ER_XML_INVALID_XPATH;

        $indexs = null;
        if( count($els)> 0 ) {
            $isSame = $this->_issame($els, $where, $mode);
            if ($isSame){
                unset($els[0]);
                $allow = false;
            }else{ $allow = true; }

            if ( $allow && isset($els) && !empty($els)) {
                for($i=0; $i<=count($els)-1; $i++){
                    if( !isset($els[$i]) ) continue;
                    $isSame = $this->_issame($els[$i], $where, $mode);

                    if ($isSame) $indexs[] = $i;
                }
                /*
                foreach ($els as $el):
                    $isSame = $this->_issame($el, $where, $mode);

                    if ($isSame) $indexs[] = $i;
                    $i++;
                endforeach;
*/
                //Remove
                if ($indexs !== null) {
                    for ($i = 0; $i <= count($indexs) - 1; $i++) {
                        if (isset($els[$indexs[$i]])) unset($els[$indexs[$i]]);
                    }
                }
            }

        }else{
            $isSame = $this->_issame($els, $where, $mode);
            if ($isSame) unset($els[0]);
        }


        if( $autoSave ) return $this->saveXML(); else return true;
    }//end deleteElement function

    /*
     * Find all elements
     */
    public function findAll($tagName, $path = '', $where = null, $mode = 'AND', $justPath = true, $searchMode = '='){
        if( $this->isOK === false ) return false;

        #Get all elements
        if( !empty($path) ) {
            if( $justPath === false )
                $els = $this->xPath($path, 0)->{$tagName};
            else
                $els = $this->xPath($path, 0);
        }else
            $els = $this->xmlFile->{$tagName};

        if( $where === null ){
            if( empty($els) ) return null;

            return $this->objectToArray($els);
        }

        $sels = null;
        foreach($els as $i=>$el):
            $isSame = true;
            foreach($where as $k=>$v):
                if( !isset($el->attributes()->{$k}) ) return ER_XML_ATTRIBUTES_NOT_FOUND;

                if( $mode == 'AND' ){
                    if( $searchMode == '=' ) {
                        if ((string)$el->attributes()->{$k} != $v) {
                            $isSame = false;
                            break 1;
                        }
                    }else if( $searchMode == '%' ){
                        if( strpos((string)$el->attributes()->{$k}, $v) === false ){
                            $isSame = false;
                            break 1;
                        }
                    }
                }else if( $mode == 'OR' ){
                    if( $searchMode == '=' ) {
                        if ((string)$el->attributes()->{$k} == $v) {
                            $isSame = true;
                            break 1;
                        }
                    }else if( $searchMode == '%' ){
                        if( strpos((string)$el->attributes()->{$k}, $v) ){
                            $isSame = true;
                            break 1;
                        }
                    }
                }
            endforeach;
            if( $isSame ){
                /*
                $el = (array)$el;
                if( isset($el['@attributes']) ){
                    $att = $el['@attributes'];
                    unset($el['@attributes']);
                    $el = array_merge($el, $att);
                }
                $sels[] = $el;
                */
                $sels[] = json_decode( json_encode($el), true );
            }
        endforeach;

        return $sels;
    }//end findAll function

    public function find($tagName, $path = '', $where = null, $mode = 'AND', $justPath = true, $searchMode = '='){
        $f = $this->findAll($tagName, $path, $where, $mode, $justPath, $searchMode);

        if( is_array($f) ) return $f[0]; else return $f;
    }//end find function

    /*
     * Get last error occur
     */
    public function lastError()
    {
        return $this->lastError;
    }//End lastError function

    /*
     * Save xmlFile change
     */
    public function saveXML()
    {
        $r = $this->xmlFile->saveXML($this->xmlPath);
        if( $r === true )
            return true;
        else
            if( $r === false )
                return false;
            else return ER_UNKNOWN;
    }//end saveXML function

    private function xPath($path, $index=null, $tagName = ''){
        if( $this->isOK === false ) return false;

        if( empty($path) && empty($tagName) ) return ER_XML_INVALID_XPATH;

        if( substr($path, strlen($path)-2, 2) == '//' ) $path = substr($path, 0, strlen($path)-2);

        if( !empty($path) )
            $p = $this->xmlFile->xpath($path);
        else
            $p = $this->xmlFile->{$tagName};

        if( $index === null )
            return  $p;
        else if( !empty($p) ){
            if( isset($p[$index]) ) return $p[$index]; else return $p;
        }
        return null;
    }

    /*
     * Convert object to array
     */
    private function objectToArray($obj){

        $n = array();
        if( count($obj)-1 >= 0 ) {
            for ($i = 0; $i <= count($obj) - 1; $i++) {
                if( !isset($obj[$i]) ) continue;
                $n[] = json_decode(json_encode((array)$obj[$i]), true);
            }
        }else if( method_exists($obj, 'attributes') ){
            $n[] = json_decode( json_encode((array)$obj->attributes()), true );
        }
        return $n;
    }//end objectToArray function
}