<?php 

namespace App\Libraries;

Class CustomPaging
{

  public function GetPagingData( $request = null, $data = [])
  {

    $query =  $request->getQuery();

    if ( $query == '')
    {
      $page_params = explode ( "-", "10-0-1");
    }
    else
    {
      $page = explode("=", $query);
      $page_params = explode( "-", $page[1]);
    }

    return (
      [
        'path' => $request->getPath(),
        'query_string' => $page_params
      ]
    ); 

  }

  public function GetPagination( $data = [])
  {

    $html_pagination = "";

    # Calculamos los links de la página anterior y la siguiente
    $anterior = "/" . $data['refer_uri'] . "/?page=" . $data['limit'] . "-" . ($data['offset'] -  $data['limit']) . "-" . ($data['actual_page'] - 1);
    $siguiente = "/" . $data['refer_uri'] . "/?page=" . $data['limit'] . "-" . ($data['offset'] +  $data['limit']) . "-" . ($data['actual_page'] + 1);

    # Calculamos la ultima y la primera
    $primera = "/" . $data['refer_uri'] . "/?page=" . $data['limit'] . "-0-1";
    $ultima = "/" . $data['refer_uri'] . "/?page=" . $data['limit'] . "-" . (($data['total_pages'] * $data['limit']) - $data['limit']) . "-" . $data['total_pages'];

    # Ponemos los dos primeros botones de Anterior y Primera
    if ( $data['actual_page'] == 1)
    {
      $html_pagination .= '<li class="page-item disabled"><a class="page-link" href="#">Primera</a></li>';
      $html_pagination .= '<li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>';
    }
    else
    {
      $html_pagination .= '<li class="page-item"><a class="page-link" href="'.$primera.'">Primera</a></li>';
      $html_pagination .= '<li class="page-item"><a class="page-link" href="'.$anterior.'">Anterior</a></li>';
    }

    # Calculamos el offset que descuenta hacia atras ... 1 2 3 y siempre tiene que ser un valor positivo
    $offset = abs(($data['limit']  * $data['decrese']) - $data['offset']);

    $decrease = $data['actual_page'] - $data['decrese'];
    if ( $decrease <= 0) $decrease = 1;
    $j = $data['decrese'];
    for ( $ii = $decrease; $ii <  $data['actual_page'] ; $ii++, $j--)
    {
      if ( $ii == 1)
      {
        $offset = 0;
      }

      if ( $ii > 0)
      {
        $html_pagination .= '<li class="page-item">
          <a class="page-link" href="/' . $data['refer_uri'] . "/?page=" . $data['limit'] . '-' . $offset . '-' . $ii . '">' . $ii . '</a>
        </li>';
        $offset += 10;
      }
      
      if ( $ii < 0) break;
    }
    
    $html_pagination .= '<li class="page-item disabled">
        <a class="page-link" href="/' . $data['refer_uri'] . "/?page=" . $data['limit'].'-'.$offset.'-'.$data['actual_page'].'">'.$data['actual_page'].'</a>
      </li>';
      
    $offset = $data['offset'];
    $increase = $data['actual_page'] + $data['increase'];
    for( $i = $data['actual_page'] + 1; $i <= ($increase); $i++)
    {

      if ( $i > $data['total_pages']) break;

      $offset += 10;
      $html_pagination .= '<li class="page-item">
        <a class="page-link" href="/' . $data['refer_uri'] . "/?page=" . $data['limit'].'-'.$offset.'-'.$i.'">'.$i.'</a>
      </li>';
     
    }
            
    if ( $data['actual_page'] == $data['total_pages'])
    {
      $html_pagination .= '<li class="page-item disabled"><a class="page-link" href="#">Siguiente</a></li>';
      $html_pagination .= '<li class="page-item disabled"><a class="page-link" href="#">Última</a></li>';
    }
    else
    {
      $html_pagination .= '<li class="page-item"><a class="page-link" href="'.$siguiente.'">Siguiente</a></li>';
      $html_pagination .= '<li class="page-item"><a class="page-link" href="'.$ultima.'">Última</a></li>';
    }

    return ( $html_pagination);
  }

}