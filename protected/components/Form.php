<?php

class Form{

	public $error;

	public function __construct($callInit = true){		
		//run init first from child
		if( method_exists($this, 'init') && $callInit == true ) $this->init();
	}
	
	/*
		validate inputs
	*/
	public function validate($array){
		
		//check rules function exists
		if( method_exists($this, 'rules') ) $rules = $this->rules(); else return false; 
		
		foreach($array as $pkey=>$pval):

			//exit if $key not exists in $rules
			if( !isset($rules[$pkey]) ) return false;

            $allowEmpty = false;
			foreach($rules[$pkey] as $rkey=>$rval):
				
				switch($rkey):
					case 'allowEmpty':
                        $allowEmpty = $rval;
						if( $rval == false && (Empty($pval)&&$pval != '0') ){
							$this->error = ERROR_RULES_EMPTY;
							return false;
						}
					break;
					case 'minLength':
						if( strlen($pval) < (int)$rval ){
							$this->error = ERROR_RULES_MINLENGTH;
							return false;
						}
					break;
					case 'maxLength':
						if( strlen($pval) > (int)$rval ){
							$this->error = ERROR_RULES_MAXLENGTH;
							return false;
						}
					break;
					case 'notAllowCharecter':
						if( preg_match($rval, $pval) ){
							$this->error = ERROR_RULES_INVALID_CHARACTER;
							return false;
						}
					break;
					case 'email':
						$preg = "/^([\w+]((?:[\.\w])*))@([\w+]((?:[\.\w])*))\.[\w]{2,}$/";
						if( !preg_match($preg, $pval) ){
							$this->error = ERROR_RULES_EMAIL;
							return false;
						}
					break;
                    case 'username':
                        $preg = "/^(([a-zA-Z0-9]+)((?:\_[a-zA-Z0-9])*)){4,255}$/";
                        if( !preg_match($preg, $pval) ){
                            $this->error = ERROR_RULES_USERNAME;
                            return false;
                        }
                    break;
                    case 'max':
                        if( $pval > $rval ){
                            $this->error = ERROR_RULES_EXCEEDED;
                            return false;
                        }
                    break;
                    case 'min':
                        if( $pval < $rval ){
                            $this->error = ERROR_RULES_MIN_NUMBER;
                            return false;
                        }
                    break;
                    case 'link':
                        $preg = "/(http:\/\/)|((https:\/\/))/i";
                        if( !preg_match($preg, $pval) && $allowEmpty != true ){
                            $this->error = ERROR_RULES_INVALID_LINK;
                            return false;
                        }
                    break;
                    case 'trimTag':
                        if( $rval == true && preg_match('#(?<=<)\w+(?=[^<]*?>)#', $pval) ){
                            $this->error = ERROR_RULES_INVALID_TRIMTAG;
                            return false;
                        }
                    break;
 				endswitch;
				
			endforeach;
		endforeach;

		return true;
	}

    /**
     * set attributes
     * @a param is an array like $_POST or $_GET or $_REQUEST
     *
     * @param array $a
     */
	public function setAttributes($a){
		foreach($a as $k=>$v){
			$this->{$k} = $v;
		}
	}

    /*
     * Create random string
     *
     */
    public function randomString($length = 10, $justCharacter = false)
    {
        $ch = 'ABCDEFGHIJKLOMNPQRSTUVWXYZ';
        $digit = '0123456789';

        if( $length < 1 ) return '';

        if( $justCharacter === true ){
            return substr( str_shuffle($ch . strtolower($ch)), 0, $length-1 );
        }else{
            return substr( str_shuffle($ch . $digit . strtolower($ch)), 0, $length-1 );
        }
    }

    /*
     * create pagination array params
     *
     * @param $array is your array param
     * @param $per is count of you want to show
     * @param $start is index of start
     *
     * return in success process is array
     */
    public function createPagination($array, $per = 30, $start = 0)
    {
        if( empty($array) ) return array(
            'count'=>0,
            'per'=>$per,
            'start'=>$start,
            'list'=>null
        );

        $newList = array();
        for($i=$start; $i<=$start+($per-1); $i++){
            if( !isset($array[$i]) ) continue;

            $newList[] = $array[$i];
        }

        return array(
            'count'=>count($array),
            'per'=>$per,
            'start'=>$start,
            'list'=>$newList
        );
    }//end createPagination function

    /**
     * @param array $params, all params you need to check global and local
     * @param boolean $setToGlobal is allow to set all params to global mode or not
     * @return null|array
     */
    protected function createArray($params, $setToGlobal = false)
    {
        if( empty($params) ) return null;

        foreach ($params as $k=>$param) {
            if( $param === null || empty($param) )
                if( isset($this->{$k}) ) $params[$k] = $this->{$k};
        }

        if( $setToGlobal === true && !empty($params) ){
            foreach ($params as $k => $p) {
                $this->{$k} = $p;
            }
        }

        return $params;
    }

}