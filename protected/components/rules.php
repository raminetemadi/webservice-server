<?php
/**
 * Created by PhpStorm.
 * User: etema
 * Date: 5/24/2015
 * Time: 9:38 PM
 */
class rules{

    public function checkMethods($check){
        if( empty($check) ) return true;

        if( method_exists($this, $check) ){
            return $this->{$check}();
        }else return false;
    }//end checkMethods function

    /*
     * This rules check menu can show or not
     */
    private function storeMenu(){
        #Get username from session
        if( isset($_SESSION['account']['username']) ) $username = $_SESSION['account']['username']; else return false;

        //Connect to database
        $db = new database();
        $sql = "SELECT * FROM store WHERE admin='{$username}'";
        try {
            $sth = $db->dbQuery($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $row = $sth->fetch();

            if (isset($row['admin'])) return true; else return false;
        }catch (Exception $e){
            return false;
        }
    }//end storeMenu function
}