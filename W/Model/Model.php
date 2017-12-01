<?php

namespace W\Model;

/**
 * Base model
 */
abstract class Model{

	/** @var string $table Table name */
	protected $table;

	/** @var integer $primaryKey Primary key */
	protected $primaryKey = 'id';

	/** @var \PDO $dbh DB connection */
	protected $dbh;

	/**
	 * Constructor
	 */
	public function __construct(){

		$this->setTableFromClassName();
		$this->dbh = ConnectionModel::getDbh();

	}


	/**
	 * Guesses the table name from the child model class
	 * @return W\Model $this
	 */
	private function setTableFromClassName(){

		$app = getApp();

		if(empty($this->table)){
			// Child model class name
			$className = (new \ReflectionClass($this))->getShortName();

			// Removes "Model" from the name and converts it to snake case
			$tableName = str_replace('Model', '', $className);
			$tableName = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $tableName)), '_');
		}
		else {
			$tableName = $this->table;
		}

		$this->table = $app->getConfig('db_table_prefix') . $tableName;

		return $this;

	}


	/**
	 * Manually define table name
	 * @param string $table table name
	 * @return W\Model $this
	 */
	public function setTable($table){

		$this->table = $table;
		return $this;

	}


	/**
	 * Get table name
	 * @return string
	 */
	public function getTable(){

		return $this->table;

	}


	/**
	 * Manually define primary key
	 * @param string $primaryKey Primary key
	 * @return W\Model $this
	 */
	public function setPrimaryKey($primaryKey){

		$this->primaryKey = $primaryKey;
		return $this;

	}


	/**
	 * Get primary key
	 * @return string
	 */
	public function getPrimaryKey(){

		return $this->primaryKey;

	}


	/**
	 * Select a single row from id
	 * @param  integer id
	 * @return mixed associative array with query result
	 */
	public function find($id){

		if (!is_numeric($id)){
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey .'  = :id LIMIT 1';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		$sth->execute();

		return $sth->fetch();

	}


    /**
     * Select row right after id
     * @param integer id
     * @return mixed associative array with query result
     */
    public function findNext($id){

        if (!is_numeric($id)){
            return false;
        }

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey .'  = (SELECT MIN(id) FROM ' . $this->table . ' WHERE id > :id ) LIMIT 1';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id);
        $sth->execute();

        $result = $sth->fetch();
        if(!$result) {
            $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey .'  = (SELECT MIN(id) FROM ' . $this->table . ') LIMIT 1';
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetch();
        }

        return $result;

    }


    /**
     * Select row right before id
     * @param integer id
     * @return mixed associative array with query result
     */
    public function findPrevious($id){

        if (!is_numeric($id)){
            return false;
        }

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey .'  = (SELECT MAX(id) FROM ' . $this->table . ' WHERE id < :id ) LIMIT 1';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id);
        $sth->execute();

        $result = $sth->fetch();
        if(!$result) {
            $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey .'  = (SELECT MAX(id) FROM ' . $this->table . ') LIMIT 1';
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetch();
        }

        return $result;

    }


	/**
	 * Select all rows from table
	 * @param $orderBy column to order by
	 * @param $orderDir order direction (ASC, DESC)
	 * @param $limit limit
	 * @param $offset offset
	 * @return array multidimensional associative array with query result
	 */
	public function findAll($orderBy = '', $orderDir = 'ASC', $limit = null, $offset = null){

		$sql = 'SELECT * FROM ' . $this->table;
		if (!empty($orderBy)){

			// Secure parameters against SQL injections
			if(!preg_match('#^[a-zA-Z0-9_$]+$#', $orderBy)){
				die('Error: invalid orderBy param');
			}
			$orderDir = strtoupper($orderDir);
			if($orderDir != 'ASC' && $orderDir != 'DESC'){
				die('Error: invalid orderDir param');
			}
			if ($limit && !is_int($limit)){
				die('Error: invalid limit param');
			}
			if ($offset && !is_int($offset)){
				die('Error: invalid offset param');
			}

			$sql .= ' ORDER BY '.$orderBy.' '.$orderDir;
		}
        if($limit){
            $sql .= ' LIMIT '.$limit;
            if($offset){
                $sql .= ' OFFSET '.$offset;
            }
        }
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();

	}


	/**
	 * Approximative search (LIKE)
	 * @param array $data associative array with columns and values to search
	 * @param string $operator condition operator if multiple values searched (AND, OR)
	 * @param boolean $stripTags if false, don't use strip_tags
	 * @return mixed multidimensional associative array with query result, false if error
	 */
	public function search(array $search, $operator = 'OR', $stripTags = true){

		// Secure parameters against SQL injections
		$operator = strtoupper($operator);
		if($operator != 'OR' && $operator != 'AND'){
			die('Error: invalid operator param');
		}

        $sql = 'SELECT * FROM ' . $this->table.' WHERE';

		foreach($search as $key => $value){
			$sql .= " `$key` LIKE :$key ";
			$sql .= $operator;
		}

		if($operator == 'OR') {
			$sql = substr($sql, 0, -3);
		}
		elseif($operator == 'AND') {
			$sql = substr($sql, 0, -4);
		}

		$sth = $this->dbh->prepare($sql);

		foreach($search as $key => $value){
			$value = ($stripTags) ? strip_tags($value) : $value;
			$sth->bindValue(':'.$key, '%'.$value.'%');
		}
		if(!$sth->execute()){
			return false;
		}
        return $sth->fetchAll();

	}


	/**
	 * Exact search (=)
	 * @param array $data associative array with columns and values to search
	 * @param string $operator condition operator if multiple values searched (AND, OR)
	 * @param boolean $stripTags if false, don't use strip_tags
	 * @return mixed associative array with query result, false if error
	 */
	public function exactSearch(array $search, $operator = 'OR', $stripTags = true){

		// Secure parameters against SQL injections
		$operator = strtoupper($operator);
		if($operator != 'OR' && $operator != 'AND'){
			die('Error: invalid operator param');
		}

        $sql = 'SELECT * FROM ' . $this->table.' WHERE';

		foreach($search as $key => $value){
			$sql .= " `$key` = :$key ";
			$sql .= $operator;
		}

		if($operator == 'OR') {
			$sql = substr($sql, 0, -3);
		}
		elseif($operator == 'AND') {
			$sql = substr($sql, 0, -4);
		}

		$sth = $this->dbh->prepare($sql);

		foreach($search as $key => $value){
			$value = ($stripTags) ? strip_tags($value) : $value;
			$sth->bindValue(':'.$key, $value);
		}
		if(!$sth->execute()){
			return false;
		}
        return $sth->fetchAll();
	}


	/**
	 * Delete a row from id
	 * @param mixed $id id
	 * @return mixed execute() return value
	 */
	public function delete($id){

		if (!is_numeric($id)){
			return false;
		}

		$sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey .' = :id LIMIT 1';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		return $sth->execute();

	}


	/**
	 * Insert a row
	 * @param array $data associative array with columns and values to insert
	 * @param boolean $stripTags if false, don't use strip_tags
	 * @return mixed multidimensional associative array with inserted rows, false if error
	 */
	public function insert(array $data, $stripTags = true){

		$colNames = array_keys($data);
		$colNamesEscapes = $this->escapeKeys($colNames);
		$colNamesString = implode(', ', $colNamesEscapes);

		$sql = 'INSERT INTO ' . $this->table . ' (' . $colNamesString . ') VALUES (';
		foreach($data as $key => $value){
			$sql .= ":$key, ";
		}

		$sql = substr($sql, 0, -2);
		$sql .= ')';

		$sth = $this->dbh->prepare($sql);
		foreach($data as $key => $value){
			if(is_int($value)){
				$sth->bindValue(':'.$key, $value, \PDO::PARAM_INT);
			}
			elseif(is_null($value)){
				$sth->bindValue(':'.$key, $value, \PDO::PARAM_NULL);
			}
			else {
				$sth->bindValue(':'.$key, ($stripTags) ? strip_tags($value) : $value, \PDO::PARAM_STR);
			}
		}

		if (!$sth->execute()){
			return false;
		}
		return $this->find($this->lastInsertId());

	}


	/**
	 * Updates a row from id
	 * @param array $data associative array with columns and values to update
	 * @param mixed $id id
	 * @param boolean $stripTags if false, don't use strip_tags
	 * @return mixed multidimensional associative array with updated values, false if error
	 */
	public function update(array $data, $id, $stripTags = true){

		if (!is_numeric($id)){
			return false;
		}

		$sql = 'UPDATE ' . $this->table . ' SET ';
		foreach($data as $key => $value){
			$sql .= "`$key` = :$key, ";
		}

		$sql = substr($sql, 0, -2);
		$sql .= ' WHERE ' . $this->primaryKey .' = :id';

		$sth = $this->dbh->prepare($sql);
		foreach($data as $key => $value){
			if(is_int($value)){
				$sth->bindValue(':'.$key, $value, \PDO::PARAM_INT);
			}
			elseif(is_null($value)){
				$sth->bindValue(':'.$key, $value, \PDO::PARAM_NULL);
			}
			else {
				$sth->bindValue(':'.$key, ($stripTags) ? strip_tags($value) : $value, \PDO::PARAM_STR);
			}
		}
		$sth->bindValue(':id', $id);

		if(!$sth->execute()){
			return false;
		}
		return $this->find($id);

	}

	/**
	 * Gets id from last inserted row
	 * @return integer id
	 */
	protected function lastInsertId(){

		return $this->dbh->lastInsertId();

	}

	/**
	 * Adds escape to table keys to prevent conflict with SQL commands
	 * @param array $datas Array of keys
	 * @return array Escaped keys
	 */
	private function escapeKeys($datas)
	{
		return array_map(function($val){
			return '`'.$val.'`';
		}, $datas);
	}
}
