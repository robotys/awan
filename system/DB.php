<?php
namespace Awan;

$dbconn = null;

if(env('db_host'))
{
	$dbconn = new \mysqli(env('db_host'), env('db_user'), env('db_pass'), env('db_name'));
	// Check connection
	if ($dbconn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
}

class DB
{
	// manage all query needed

	function __construct()
	{
		global $dbconn;
		// connect
		$this->conn = $dbconn;
		$this->debug = env('db_debug');
		$this->query = null;
		$this->last_query = null;
		$this->delete = null;
		$this->select = [];
		$this->where = []; // key = logic strings, value = AND/OR
		$this->where_in = []; // key = logic strings, value = AND/OR
		$this->like = [];
		$this->join = [];
		$this->limit = [];
		$this->group_by = [];
		$this->order_by = [];
		$this->sql = null;
		$this->where_operator = ['!=', '>=', '<=', '=','>','<','IS NULL','IS NOT NULL'];
		$this->where_in_operator = ['IN','NOT IN'];
	}

	function getAllTable()
	{
		$db = new DB;

		$sql = "SELECT TABLE_NAME 
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".env('db_name')."' ";

		$res = $db->query($sql)->result();

		if(empty($res)) return null;
		else return $res;	
	}

	function isTableExists($table)
	{
		$ret = false;
		// $sql = "SELECT ";
		$tables = $this->getAllTable();

		if(!empty($tables))
		{
			foreach($tables as $row)
			{
				if($row->TABLE_NAME == $table)
				{
					$ret = true;
					break;
				}
			}
		}

		return $ret;
	}

	function query($sql = null)
	{
		if($sql != NULL) $this->sql = $sql;

		$this->query = $this->conn->query($this->sql);

		$this->last_query = $this->sql;

		$this->sql = null;
		$this->select = null;
		$this->where = null;
		$this->join = null;
		$this->group_by = null;
		$this->order_by = null;

		if($this->query == false) showError($this->conn->error);

		return $this;
	}

	function result()
	{
		$ret = null;
		
		if($this->query != false AND $this->query->num_rows > 0)
		{
			$ret = [];

			while($row = $this->query->fetch_assoc())
			{
				$ret[] = (object)$row;
			}
		}

		$this->query = null;
		
		return $ret;
	}

	function row()
	{
		$res = null;

		if($this->query != false AND $this->query->num_rows > 0)
		{
			while($row = $this->query->fetch_assoc())
			{
				$res = (object)$row;
				break;
			}
		}

		$this->query = null;

		return $res;
	}

	function insert_id()
	{

	}

	function last_query()
	{
		return $this->last_query;
	}

	function update($table, $data)
	{

	}

	function update_batch($table, $data, $key)
	{

	}

	function insert($table, $data)
	{
		$column = array_keys($data);
		$columns = implode(', ', $column);
		
		$values = "'".implode("','", $data)."'";

		$sql = "INSERT INTO $table ($columns) VALUES ($values)";

		return $this->query($sql);
	}

	function insert_batch($table, $data)
	{

	}

	function select($multi)
	{
		if(is_string($multi))
		{
			$exp = explode(',',trim($multi));

			foreach($exp as $raw)
			{
				$column = trim($raw);
				$this->select[] = $column;
			}
			
		}
		elseif(is_array($multi) or is_object($multi))
		{
			foreach($multi as $raw)
			{
				$column = trim($raw);
				$this->select[] = $column;
			}
		}
		else
		{
			showError('Wrong type for select: <code>$multi</code>');
		}

		return $this;
	}

	function where($column, $value, $combine = 'AND')
	{
		$operator = '=';

		// if has where operator in column
		$op = null;
		foreach($this->where_operator as $oper)
		{

			if(strpos($column, $oper) !== FALSE)
			{
				break;
			}
		}


		if($op != null)
		{
			$column = trim(str_replace($op, '', $column));
			$operator = $op;
		}

		// dd($value === null);

		if($value === NULL OR $value === 'null')
		{
			if($operator == '!=') $operator = 'IS NOT';
			if($operator == '=') $operator = 'IS';
		}

		$this->where[] = (object)[
			'combine' => $combine,
			'column' => $column, 
			'operator' => $operator, 
			'value' => $value,
		];

		return $this;
	}

	function or_where($column, $value)
	{
		$this->where($column, $value, 'OR');
		
		return $this;
	}

	function where_in($column, $array, $combine = 'AND')
	{
		foreach($array as $i=>$val)
		{	
			if(is_numeric($val) == FALSE) $array[$i] = "'".$val."'";
		}
		// dd($array);

		$this->where[] = (object)[
			'combine' => $combine,
			'column' => $column,
			'operator' => 'IN',
			'value' => '('.implode(', ', $array).')'
		];

		return $this;
	}

	function or_where_in($column, $array)
	{

	}

	function where_not_in($column, $array)
	{

	}

	function or_where_not_in($column, $array)
	{

	}

	function like($column, $value)
	{

	}

	function or_like($columne, $value)
	{

	}

	function bracket_open()
	{

	}

	function bracket_close()
	{

	}

	function join($table, $on, $type)
	{

	}

	function left_join($table, $on)
	{

	}

	function right_join($table, $on)
	{

	}

	function group_by($column)
	{

	}

	function order_by($column, $direction)
	{

	}

	function limit($offset, $limit)
	{

	}

	function get($table)
	{
		$this->from = $table;

		$sql = $this->generateSql();

		$this->query($sql);

		return $this;
	}

	function delete($table)
	{
		if(empty($this->where))
		{
			showError('Please include WHERE condition before delete query');
		}
		else
		{
			$this->delete = $table;

			$sql = $this->generateSql();

			$this->query($sql);

			return $this;	
		}
		
	}

	function generateSql()
	{
		// do select first
		if(empty($this->select)) $this->select('*');

		$select = implode(",\n", $this->select);
		$table = $this->from;

		if(!empty($this->where))
		{
			$this->where[0]->combine = 'WHERE';
			$tmp = [];
			foreach($this->where as $obj)
			{
				$obj = (array)$obj;
				$tmp[] = implode(' ', $obj);
			}

			$where = implode("\n", $tmp);
		}else
		{
			$where = '';
		}

		// dd($where);
		if($this->delete == null) $sql = "SELECT $select";
		else $sql = "DELETE";

		$sql .= "
FROM $table
$where";

		return $sql;

	}
}