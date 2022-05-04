<?php

namespace App\Controllers;

use App\Libraries\CustomPaging;

class HomeController extends BaseController
{

  public function index()
  {

    $options = [
      'title' => 'All records from films',
    ];

    return renderView('ly_index', 'web/index', $options, []);

  }

  public function custom()
  {

    $paging = new CustomPaging(); 
    $paging_parsed = $paging->GetPagingData( $this->request->getUri());
  
    $refer_uri = $paging_parsed['path'];
    $limit = (int) $paging_parsed['query_string'][0];
    $offset = (int) $paging_parsed['query_string'][1];
    $actual_page = (int) $paging_parsed['query_string'][2];
    
    # Obtenemos los registros de la base de datos paginados
    $rows =  $this->pagesModel->GetFilms( $limit,$offset);

    # Obtenemos el numero de páginas
    $pages = ceil($rows['count'] / $limit);

    $data = [
      'rows' => $rows['rows'],
      'total' => $rows['count'],
      'obj' => $paging,
      'paging' => [
        'refer_uri' => $refer_uri,
        'total_pages' => $pages,
        'actual_page' => $actual_page,
        'increase' => 3,
        'decrese' => 3,
        'offset' => $offset,
        'limit' => $limit,
      ]
    ];

    $options = [
      'title' => 'Ejemplo de paginación con MySql - tabla film',
    ];

    return renderView('ly_index', 'web/list-custom', $options, $data);

  }

  public function otherparam()
  {
    # Instanciamos la clase de paginación y llamamos al metodo que
    # parsea y analiza la url que viene en el siguiente formato:
    # 
    #     http://paginacion.local/list-custom?page=10-20-3
    #
    # Lo que va detras del ? es la sevuencia de paginación que se traducen 
    # en 10 (limit) 20(offset) 3(pagina actual)
    $paging = new CustomPaging(); 
    $paging_parsed = $paging->GetPagingData( $this->request->getUri());

    $refer_uri = $paging_parsed['path'];
    $limit = (int) $paging_parsed['query_string'][0];
    $offset = (int) $paging_parsed['query_string'][1];
    $actual_page = (int) $paging_parsed['query_string'][2];
    
    # Obtenemos los registros de la base de datos ya paginados, solo obtenemos
    # el número que hemos pedido en Limit y la pagina en que estamos con el offset
    $rows =  $this->pagesModel->GetCustomer( $limit, $offset);

    # Obtenemos el numero de páginas, esto nos va bien para saber cuando llegamos
    # al final y deshabilitar los botones siguiente y último
    $pages = ceil($rows['count'] / $limit);

    $data = [
      'rows' => $rows['rows'],
      'total' => $rows['count'],
      'paging' => [
        'refer_uri' => $refer_uri,
        'total_pages' => $pages,
        'actual_page' => $actual_page,
        'increase' => 3,
        'decrese' => 3,
        'offset' => $offset,
        'limit' => $limit,
      ]
    ];

    $options = [
      'title' => 'Ejemplo de paginación con MySql - Tabla customer',
    ];

    return renderView('ly_index', 'web/list-custom-other', $options, $data);
  }

}
