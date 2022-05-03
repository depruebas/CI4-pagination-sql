<?php

	function debug( $var)
	{

		$debug = debug_backtrace();
		echo "<pre>";
		echo $debug[0]['file']." ".$debug[0]['line']."<br><br>";
		print_r($var);
		echo "</pre>";
		echo "<br>";

	}


	function MesNumberToWord( $mes)
	{

		switch ( $mes)
		{
			case '1': $mes_texto = "Enero"; break;
  		case '2': $mes_texto = "Febrero"; break;
			case '3': $mes_texto = "Marzo";  break;
			case '4': $mes_texto = "Abril";	break;
			case '5': $mes_texto = "Mayo"; break;
			case '6': $mes_texto = "Junio"; break;
			case '7': $mes_texto = "Julio"; break;
			case '8': $mes_texto = "Agosto";	break;
			case '9': $mes_texto = "Septiembre"; break;
			case '10': $mes_texto = "Octubre"; break;
			case '11': $mes_texto = "Noviembre"; break;
			case '12': $mes_texto = "Diciembre"; break;
		}

		return ( $mes_texto);

	}