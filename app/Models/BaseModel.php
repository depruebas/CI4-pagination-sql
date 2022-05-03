<?php


namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{

	function __construct()
  {
    parent::__construct();

		$connection_dsn = new \Config\Database();
		$this->db = db_connect( $connection_dsn->GetDBConnection());
  }

  public function MyInsert( $table, $data, $inserted = false)
	{

		$ret_ins = $this->db->table( $table)->insert( $data);

		if ( $inserted)
		{

			$id = $this->db->insertID();

			return ( [
				'id' => $id,
			]);

		}

		return ( $ret_ins);
	}

	public function MyUpdate( $table, $data, $where)
	{
		return( $this->db->table( $table)->update( $data, $where));
	}

	public function MyDelete( $table, $where)
	{
		return( $this->db->table( $table)->delete( $where));
	}

	#
	#
	#

  public function ExecuteQueryResults( $sql)
	{

		$query = $this->db->query( $sql);
    $rows['values'] = $query->getResult();
    $rows['num_rows'] = $query->getNumRows();
    $query->freeResult();

    return ( $rows);
	}

	public function ExecuteQueryAllResults( $params)
	{

		if ( !isset( $params['type'])) $params['type'] = 'object';

		$query = $this->db->query( $params['query'], $params['params']);

		if ( $params['type'] == 'object')
		{
			$rows['values'] = $query->getResult();
		}
		else
		{
			$rows['values'] = $query->getResultArray();
		}

		$rows['num_rows'] = $query->getNumRows();
		$rows['first']= $query->getFirstRow();
		$rows['last']= $query->getLastRow();
		$rows['next']= $query->getNextRow();
		$rows['previous']= $query->getPreviousRow();
		$rows['fieldsCounts'] = $query->getFieldCount();
		$rows['fieldsNames'] = $query->getFieldNames();

    	$query->freeResult();

    	return ( $rows);
	}


	public function ExecuteQueryOneRow( $params)
	{

		if ( !isset( $params['type'])) $params['type'] = 'object';

		$query = $this->db->query( $params['query'], $params['params']);

		if ( $params['type'] == 'object')
		{
			$rows['values'] = $query->getRow();
		}
		else
		{
			$rows['values'] = $query->getRowArray();
		}

		$rows['fieldsCounts'] = $query->getFieldCount();
		$rows['fieldsNames'] = $query->getFieldNames();

    $query->freeResult();

    return ( $rows);

	}

}