<?php

/* - - - - - - - - - - - - - - - - - - - - -

 Title : PHP Quick Profiler MySQL Class
 Author : Created by Ryan Campbell
 URL : http://particletree.com/features/php-quick-profiler/

 Last Updated : April 22, 2009

 Description : A simple database wrapper that includes
 logging of queries.

- - - - - - - - - - - - - - - - - - - - - */

class MySqlDatabase {

	private $host;			
	private $user;		
	private $password;	
	private $database;	
	public $queryCount = 0;
	public $queries = array();
	public $conn;
	
	/*------------------------------------
	          CONFIG CONNECTION
	------------------------------------*/
	
	function __construct($host, $user, $password) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		add_filter('query',array(&$this,'query'));
	}
	
	function connect($new = false) {
		$this->conn = mysqli_connect($this->host, $this->user, $this->password, $new);
		if(!$this->conn) {
			throw new Exception('We\'re working on a few connection issues.');
		}
	}
	
	function changeDatabase($database) {
		$this->database = $database;
		if($this->conn) {
			if(!mysqli_select_db($this->conn,$database)) {
				throw new Exception('We\'re working on a few connection issues.');
			}
		}
	}
	
	function lazyLoadConnection() {
		$this->connect($this->database);
		if($this->database) $this->changeDatabase($this->database);
	}
	
	/*-----------------------------------
	   				QUERY
	------------------------------------*/
	
	function query($sql) {
		if(!$this->conn) $this->lazyLoadConnection();
		$start = $this->getTime();
		$rs = mysqli_query($this->conn,$sql);
		
		$this->lastresult = array();
		$num_rows = 0;
		while ( $row = @mysqli_fetch_object( $rs ) ) {
			$this->lastresult[$num_rows] = $row;
			$num_rows++;
		}
		//$row = mysqli_fetch_array($rs);
		$this->queryCount += 1;
		$this->logQuery($sql, $start, strlen(serialize($this->lastresult)));
                // Comment out this, as preventing JS panel to load
		//if(!$rs) {
		//	throw new Exception('Could not execute query.'.$sql);
		//}
		
		//return $rs;
		return $sql;
	}
	
	function fetch_array($sql) {
		$rs = mysqli_query($this->conn,$sql);
		$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
		return $row;
	}
	
	/*-----------------------------------
	          	DEBUGGING
	------------------------------------*/
	
	function logQuery($sql, $start, $size) {
		$query = array(
				'sql' => $sql,
				'time' => ($this->getTime() - $start)*1000,
				'size' => $size
			);
		array_push($this->queries, $query);
	}
	
	function getTime() {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		return $start;
	}
	
	public function getReadableTime($time) {
		$ret = $time;
		$formatter = 0;
		$formats = array('ms', 's', 'm');
		if($time >= 1000 && $time < 60000) {
			$formatter = 1;
			$ret = ($time / 1000);
		}
		if($time >= 60000) {
			$formatter = 2;
			$ret = ($time / 1000) / 60;
		}
		$ret = number_format($ret,3,'.','') . ' ' . $formats[$formatter];
		return $ret;
	}
	
	function __destruct()  {
		remove_filter('query',array(&$this,'query'));
		@mysqli_close($this->conn);
	}
	
}

?>
