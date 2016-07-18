<?php

//connect to database with pdo
class database extends Form {

	protected $db;
	/*
		database construct
	*/
	public function __construct(){
		parent::__construct(false);


		//connect to database
		if( App::$config->db->ping ){
			if( isset(App::$cacheDatabase) && App::$cacheDatabase !== NULL ){
				$this->db = App::$cacheDatabase;
			}else{
				$this->db = new PDO(App::$config->db->stringConnection, App::$config->db->username, App::$config->db->password,
                                    array(PDO::ATTR_PERSISTENT => true));
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->exec('SET NAMES utf8');
				App::$cacheDatabase = $this->db;			
			}
		}else{
				$this->db = new PDO(App::$config->db->stringConnection, App::$config->db->username, App::$config->db->password,
                                    array(PDO::ATTR_PERSISTENT => true));
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->exec('SET NAMES utf8');
		}
/**/
        //add user privilege
        if( isset(App::$config->db->privileges) ){
            if( App::$config->db->privileges->enable == true ){
                $u = App::$config->db->privileges->user;
                $p = App::$config->db->privileges->pass;
                $d = App::$config->db->privileges->dbname;
                $h = App::$config->db->privileges->host;

                $sql = "GRANT ALL PRIVILEGES ON {$d}.* TO '{$u}'@'{$h}' identified by '{$p}';";
                $this->db->exec($sql) or die($this->db->errorInfo());
            }
        }
        /**/
		//cache mode
        if( isset(App::$config->db->cache->enable) && App::$config->db->cache->enable )
		$this->db->exec("SET GLOBAL query_cache_size = " . App::$config->db->cache->size . ";" .
						"SET " . App::$config->db->cache->var_scope . " query_cache_type = " . App::$config->db->cache->type . ";" .
						"SET " . App::$config->db->cache->var_scope . " query_cache_wlock_invalidate = " . App::$config->db->cache->wlock_invalidate . ";");


		//run init first from child
		if( method_exists($this, 'init') ) $this->init();
	}


    /**
     * @param string $s is your query
     * @return int
     */
    public function dbExec($s){
        return $this->db->exec($s);
    }//end function

    /**
     * @param string $q is your query for database
     * @return PDOStatement
     */
    public function dbQuery($q){
        return $this->db->query($q);
    }//end function

    /**
     * @param array|null $criteria is your search order, element for this array is condition and params
     * @param array|null $order is sort params for result, elements in this array is order=your column name and sort=ASC or DESC
     * @param string $or_and it can OR | AND
     * @param string $select set columns name or *
     * @return array|bool|null
     */
	public function findAll($criteria = NULL, $order = NULL, $or_and = 'OR', $select = '*' ){

        if( method_exists($this, 'tableName') ) {
            $tn = $this->tableName();
            if( empty($tn) ) return false;
        }else return false;

		$sql = "SELECT " . $select . " FROM " . $this->tableName() . ' ';
		if( $criteria !== NULL ){
			$sql .= 'WHERE ';
	
			$condition = explode(',', $criteria['condition']);
			foreach($condition as $key=>$val){
				if( Empty($val) ) continue;
				$val = explode('=', $val);
				if( $criteria['params'][$val[1]][1] == PDO::PARAM_STR )
					$sql .= $val[0] . '=' . "'" . $criteria['params'][$val[1]][0] . "'";
				else 
					$sql .= $val[0] . '=' . $criteria['params'][$val[1]][0];
				
				$sql .= ' ';
				if( $key < count($condition)-1 ) $sql .= $or_and.' ';
			}
		}
		
		if( $order !== NULL ){
			$sql .= 'ORDER BY ' . $order['order'] . ' ';
			if( isset($order['sort']) ) $sql .= $order['sort'];
		}

		$STH = $this->db->query($sql);
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		$list = array();
		while( $row = $STH->fetch() ):
			$list[] = $row;
		endwhile;
		
		return (count($list)-1 < 0) ? NULL : $list; 
	}

    /**
     * @param array|null $criteria is your search order, element for this array is condition and params
     * @param array||null $order is sort params for result, elements in this array is order=your column name and sort=ASC or DESC
     * @param string $or_and it can OR | AND
     * @param string $select set columns name or *
     * @return array|bool|null
     */
	public function find($criteria = NULL, $order = NULL, $or_and = 'OR', $select = '*'){
		$list = $this->findAll($criteria, $order, $or_and, $select);
		return ($list !== NULL) ? $list[0] : NULL;
	}

    /**
     * @param array|null $where
     * @param null|array $param
     * @param bool|false $duplicate
     * @return bool
     */
	public function save($where = NULL, $param = NULL, $duplicate = false){

		if( $param == NULL ){
			$param = array();
			foreach($this->rules() as $key=>$val){
				$param[$key] = $this->{$key}; 
			}
		}

		if( $this->validate($param) ){
			if( $where !== NULL ){
				$sql = "UPDATE ".$this->tableName()." SET ";
				foreach($param as $key=>$val){
					$sql .= $key . "=?, ";
				}
				$sql = substr($sql, 0, strlen($sql)-2) . ' ';
				$sql .= 'WHERE ';
				foreach($where as $key=>$val){
					$sql .= $key . "=? AND ";
				}
				$sql = substr($sql, 0, strlen($sql)-strlen('AND ')) . ' ';
				$p = array_values($param);
				$STH = $this->db->prepare($sql);
				foreach($where as $key=>$val)
					$p[] = $val;

//                $this->db->beginTransaction();

				$STH->execute($p);

//                $this->db->rollBack();
				return true;
			}else{
				$sql = "INSERT INTO " . $this->tableName() . " (";
				foreach($param as $key=>$val){
					$sql .= $key . ", ";
				}
				$sql = substr($sql, 0, strlen($sql)-2);
				$sql .= ') VALUES (';
				for($i=0; $i<=count($param)-1; $i++){
					$sql .= ($i<count($param)-1) ? '?,' : '?';
				}
				$sql .= ')';
				if( $duplicate === true ){
					$sql .= ' ON DUPLICATE KEY UPDATE ';
					foreach($param as $key=>$val){
						if( is_string($val) )
							$sql .= $key . "='" . $val . "'";
						else 
							$sql .= $key . '=' .$val;
						$sql .= ', '; 
					}
					//remove ,
					$sql = substr($sql, 0, strlen($sql)-2);
				}
				$STH = $this->db->prepare($sql);
				$p = array_values($param);

//                $this->db->beginTransaction();

				$STH->execute($p);

//                $this->db->rollBack();
				return true;
			}
		}else return false;
	}

    /**
     * @return int
     */
	public function deleteAll(){
		$sql = "TRUNCATE " . $this->tableName();
		return $this->db->exec($sql);
	}

    /**
     * @param null|array $where
     * @param string $or_and
     * @return bool|int
     */
    public function delete($where = NULL, $or_and = "AND"){

		if( $where != NULL ){
			$sql = "DELETE FROM ".$this->tableName() . " WHERE ";
			foreach($where as $key=>$val){
				$sql .= $key . "=? " . $or_and . " ";
			}
			$sql = substr($sql, 0, strlen($sql)-strlen($or_and.' ')) . ' ';
			foreach($where as $key=>$val)
				$p[] = $val;
			$STH = $this->db->prepare($sql);
			$STH->execute($p);
			return true;
		}else{
			return $this->deleteAll();
		}
	}

    /**
     * @param null $name
     * @return string
     */
    public function laseInsertId($name = null){
        return $this->db->lastInsertId($name);
    }

    /**
     * @return null|int
     */
	public function getLastIdFrom()
	{
		$r = $this->find(null, array('order'=>'id', 'sort'=>'DESC'));

		return isset($r['id']) ? $r['id'] : null;
	}//end getLastIdFrom function
}