<?php

class Mysql {

	public $connectionstring;
	public $dataSet;
	private $sqlQuery;

    private $username;
    private $hostname;
    private $password;
    private $databasename;
	public $error;

	function __construct() {
		$this->username="root";
		$this->hostname="localhost";
		$this->password="Master1234!";
		$this->databasename="dbo";
	}

	function Connect()    {
		$this->connection = new mysqli($this->hostname,$this->username,$this->password,$this->databaseName);
		if ($this->connection->connect_error)
		{
			$this->error= "Failed to connect to MySQL: " . $this->connection->connect_error;
			return false;
		}

		return true;
	}

	function Disconnect() {
		$this->connection = NULL;
		$this->sqlQuery = NULL;
		$this->dataSet = NULL;
		$this->databaseName = NULL;
		$this->hostName = NULL;
		$this->userName = NULL;
		$this->passCode = NULL;
		$conn->close();
	}

	function selectAll($tableName)  {
		$this->sqlQuery = 'SELECT * FROM '. $this->databasename.'.'.$tableName;
		$this->dataSet = $this->connection->query($this->sqlQuery);
		return $this->dataSet;
	}

	function selectWhere($tableName,$rowName,$operator,$value,$valueType)   {
		$this->sqlQuery = 'SELECT * FROM '.$tableName.' WHERE '.$rowName.' '.$operator.' ';
		if($valueType == 'int') {
			$this->sqlQuery .= $value;
		}
		else if($valueType == 'char')   {
			$this->sqlQuery .= "'".$value."'";
		}
		$this->dataSet = $this->connection->query($this->sqlQuery);
		$this->sqlQuery = NULL;
		return $this->dataSet;
	}

	function Insert($tableName,$values) {
		$i = NULL;

		$this->sqlQuery = 'INSERT INTO '.$tableName.' VALUES (';
		$i = 0;
		while($values[$i]["val"] != NULL && $values[$i]["type"] != NULL)    {
			if($values[$i]["type"] == "char")   {
				$this->sqlQuery .= "'";
				$this->sqlQuery .= $values[$i]["val"];
				$this->sqlQuery .= "'";
			}
			else if($values[$i]["type"] == 'int')   {
				$this->sqlQuery .= $values[$i]["val"];
			}
			$i++;
			if($values[$i]["val"] != NULL)  {
				$this->sqlQuery .= ',';
			}
		}
		$this->sqlQuery .= ')';
		$this->connection->query($this->sqlQuery);
		return $this->sqlQuery;
	}

	function selectFreeRun($query)  {
		$this->dataSet = $this->connection->query($this ->sqlQuery);
		return $this->dataSet;
	}

	function freeRun($query)    {
		return $this->connection->query($query);
	}
}
?>