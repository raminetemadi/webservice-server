<?php
/**
 * Created by PhpStorm.
 * User: etema
 * Date: 7/16/16
 * Time: 9:34 PM
 */
class authenticateForm {

    /**
     * Create authenticate key
     * Expire this key is 60 second
     * @return int
     */
    public  function createKey()
    {
        return md5('Our-Calculator') . (time() + 60);
    }

    /**
     * @param int $key
     * @return bool
     */
    public static function checkKey($key = 0)
    {
        $k = time();

        //Remove prifix
        $p = md5('Our-Calculator');
        $_p = substr($key, 0, strlen($p));

        if( $p == $_p ) $key = substr($key, strlen($p), strlen($p));

        if( $key >= $k ) return true; else return false;
    }
}