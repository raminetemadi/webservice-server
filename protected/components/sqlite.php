<?php

class sqlite extends Form{

	protected $db;
	/*
		database counstruct
	*/
	function __construct($driveName, $drive = ''){
		parent::__construct(false);
		//connect to database
		if( Empty($drive) )
			$this->db = new PDO(App::$config->sqlite->drive . $driveName);
		else
			$this->db = new PDO($drive . $driveName);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->exec('PRAGMA encoding="UTF-8"');
		
		//run init first from child
		if( method_exists($this, 'init') ) $this->init();
	}
	
	function __destruct(){
		$this->app = NULL;
		$this->db = NULL;
	}
	
	/*
		find all from database
	*/
	public function findAll($criteria = NULL, $order = NULL, $or_and = 'OR'){
		
		$sql = "SELECT * FROM " . $this->tableName() . ' ';
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
				if( $key < count($condition)-1 ) $sql .= $or_and . ' ';
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
	
	/*
		find first record from database
	*/
	public function find($criteria = NULL, $order = NULL, $or_and = 'OR'){
		$list = $this->findAll($criteria, $order, $or_and);
		return ($list !== NULL) ? $list[0] : NULL;
	}
	
	/*
		insert or update in database
	*/
	public function save($where = NULL, $param = NULL){
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
					
				$STH->execute($p);
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
				$STH = $this->db->prepare($sql);
				$p = array_values($param);					
				$STH->execute($p);
				return true;			
			}
		}else return false;
	}
	
	public function delete($where = NULL){
		if( $where != NULL ){
			$sql = "DELETE FROM ".$this->tableName() . " WHERE ";
			foreach($where as $key=>$val){
				$sql .= $key . "=? AND ";
			}
			$sql = substr($sql, 0, strlen($sql)-strlen('AND ')) . ' ';
			foreach($where as $key=>$val)
				$p[] = $val;
			$STH = $this->db->prepare($sql);
			$STH->execute($p);
			return true;
		}else{
			return $this->db->exec("DELETE FROM ".$this->tableName());
		}
	}
}