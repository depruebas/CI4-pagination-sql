<?php

namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends BaseModel
{

  protected $db;

  function __construct()
  {
    parent::__construct();
  }

  private function GetLimit( $limit)
  {
      return( ($limit == null) ? null : " limit " . $limit);
  }

  public function GetFilmsCount()
  {

  }

  public function GetFilms( $limit = null, $offset = null)
  {
    if ( $limit == null && $offset == null) die("Faltan limites");

    $params_count['query'] = "SELECT count(*) as total FROM film";
    $params_count['params'] = [];
    $rows_count = $this->ExecuteQueryAllResults( $params_count);
      
    $params['query'] = "SELECT film_id, title, release_year, last_update 
                        FROM film order by film_id desc limit ? offset ?";
    $params['params'] = [ $limit, $offset];
    $rows = $this->ExecuteQueryAllResults( $params);

    return( 
      [
        'count' => $rows_count['values'][0]->total,
        'rows' => $rows,
      ]
    );

  }

  public function GetCustomer( $limit = null, $offset = null)
  {
    if ( $limit == null && $offset == null) die("Faltan limites");

    $params_count['query'] = "SELECT count(*) as total FROM customer";
    $params_count['params'] = [];
    $rows_count = $this->ExecuteQueryAllResults( $params_count);
      
    $params['query'] = "SELECT customer_id, first_name, last_name, email, active, create_date  
                        FROM customer order by customer_id desc limit ? offset ?";
    $params['params'] = [ $limit, $offset];
    $rows = $this->ExecuteQueryAllResults( $params);

    return( 
      [
        'count' => $rows_count['values'][0]->total,
        'rows' => $rows,
      ]
    );

  }


}