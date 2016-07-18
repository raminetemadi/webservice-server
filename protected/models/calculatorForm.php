<?php
/**
 * Created by PhpStorm.
 * User: etema
 * Date: 7/16/16
 * Time: 11:14 AM
 */

class calculatorForm extends Form{

    const CAL_MULTIPLE_MODE         = '*';
    const CAL_SUM_MODE              = '+';
    const CAL_NEG_MODE              = '-';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param null|int $n1
     * @param null|int $n2
     * @param null|string $c
     * @param int $authenticateKey
     * @return string
     */
    public function calculate($n1 = null, $n2 = null, $c = null, $authenticateKey = 0)
    {
        //Get param from global
        $this->createArray(array(
            'n1'=>$n1,
            'n2'=>$n2,
            'c'=>$c,
            'key'=>$authenticateKey
        ), true);

        if( !isset($this->key) ) return new soap_fault(ER_AUTHENTICATE_INVALID, '', '');

        $auth = authenticateForm::checkKey($this->key);

        if( $auth === false ) return new soap_fault(ER_AUTHENTICATE_INVALID, '', '');

        if( !isset($this->c)  ) return new soap_fault(ER_EMPTY_OPERATE, '', '');
        if( !isset($this->n1)  ) return new soap_fault(ER_EMPTY_PARAM_1, '', '');
        if( !isset($this->n2)  ) return new soap_fault(ER_EMPTY_PARAM_2, '', '');

        switch($this->c){
            case self::CAL_MULTIPLE_MODE:
                return $this->n1*$this->n2;
                break;
            case self::CAL_NEG_MODE:
                return $this->n1-$this->n2;
                break;
            case self::CAL_SUM_MODE:
                return $this->n1 + $this->n2;
                break;
        }

        return new soap_fault(ER_UNKNOWN, '', '');
    }

}