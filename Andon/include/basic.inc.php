<?php

/******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *   Archivo que contiene la clase para el manejo de funciones basicas generales
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/
 
 /** \brief Clase para el manejo de funciones basicas
	*
	* En esta clase se definen los metodos para el manejo de algunas funciones de propositos generales para el sistema
	* <b>"Basic"</b>.
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		May 26, 2009
	*
	*/
    
	class Basic extends PEAR{
    /**
	*  Pone el formato de fecha a formato largo de acuerdo a la localizacion, en este caso es_MX
	*
	*   @param $date	(date)	Fecha
	*	@return $long_date 	(string ) Revuelve un string con la fecha en formato largo.
	*/
    function longDate($date = null){
		if(is_null($date))
			$date = date("Y-m-d H:i:s");
			setlocale (LC_TIME,"es_MX");
		$long_date = str_replace("De","de",ucwords(strftime("%A, %d de %B de %Y",strtotime($date))));
   	return $long_date;
   	}

    /**
	*  Registra todo evento en un archivo de texto
	*
	*   @param $event	(string)	Texto que contiene el mensaje o evento a registrar
	*	@return none
	*/
   	function EventLog($event = null){
      	if(LOG_ENABLED){
        	$date = date(LOG_DATE_FORMAT);
        	setlocale (LC_TIME,"es_MX");
        	$fecha = ucwords(strftime("%a, %b %d %Y %T",strtotime($date)));
        	@($username = $_SESSION['user']->username);
        	$fd = fopen (FILE_LOG,'a+');
        	//$log = $fecha . " - $username - ". $_SERVER["REMOTE_ADDR"] ." - $event \n";
        	$log = $fecha . " - $username - $event \n";
        	fwrite($fd,$log);
        	fclose($fd);
      }
    }
    
    /**
	*  Registra todo evento en un una base de datos
	*
	*   @param $username	(string)	Nombre del usuario 
    *   @param $message	(string)	Texto que contiene el mensaje o evento a registrar
	*	@return none
	*/
  function EventLogDB($message = null){
    global $db;
    global $user;
    
    $sql = "INSERT INTO log (uid,message) VALUES ('".$user->username."','".$message."')";
    Basic::EventLog($sql);
    $res =& $db->query($sql);
  }


    /**
	*  Filtra el contenido  escrito para verificar  que no sea una inyeccion de codigo con las instrucciones de base de datos escenciales
	*
	*   @param $content	(string)	Nombre del usuario 
    *   @param $message	(string)	Texto que contiene el mensaje o evento a registrar
	*	@return flag (bool) Devuelve 1 si coincide con el patron, en todo caso regresa 0
	*/
  function checkContent($content){
    if(substr_count(strtoupper($content), 'DELETE')) return 0;
    if(substr_count(strtoupper($content), 'UPDATE')) return 0;
    if(substr_count(strtoupper($content), 'SELECT')) return 0;
    if(substr_count(strtoupper($content), 'INSERT')) return 0;
    if(substr_count(strtoupper($content), 'ALTER')) return 0;
    if(substr_count(strtoupper($content), 'DROP')) return 0;
    return 1;
  }

    /**
	*  Muestra una tabla con el volcado de un arreglo de cualquier dimension
	*
	*   @param $v	(string)	Arreglo que contiene los datos
    *   @param $flag	(boolean)	0 regresa la salida en formato HTML en una variable, 1 imprime la salida
	*	@return html (string) Devuelve un string con los datos en una tabla en formato HTML
	*/
  function fancy_r(&$v, $flag = 0)
  {
  $html = '
<table align="center" border="1" cellspacing="1" cellpadding="3" bgcolor="#000000" align="center" class="adminlist1">
  <tr>
    <td bgcolor="#eeeeee">Variable</td>
    <td bgcolor="#eeeeee">Type</td>
    <td bgcolor="#eeeeee">Value</td>
  </tr>
';

  $html .= Basic::_fancyrinnerworkings('', $v, 0);

  $html .= "</table>\n";

    if($flag){
      echo $html;
    }else{
      return $html;
    }
  }

    /**
	*  Da formato en una tabla con el volcado de un arreglo de cualquier dimension
	*
    *   @param $name	(string)	nombre del arreglo
	*   @param $val	(string)	Arreglo que contiene los datos
    *   @param $ident	(boolean)	Si se requiere con identacion o no
	*	@return html (string) Devuelve un string con los datos en una tabla en formato HTML
	*/
  function _fancyrinnerworkings($name, &$val, $ident = 0){
    $type = gettype($val);

    if((strlen($name)>0) || !is_array($val)){
      $html = "  <tr>\n";
      $w_name = htmlspecialchars($name);
      if($ident > 0)
        $html .= "    <td bgcolor=\"#ffffff\" style=\"padding-left: {$ident}px\">{$w_name}</td>\n";
      else
        $html .= "    <td bgcolor=\"#ffffff\">{$w_name}</td>\n";

      $w_type = htmlspecialchars($type);
      $html .= "    <td bgcolor=\"#ffffff\">{$w_type}</td>\n";

    switch(strtolower($type))
    {
      case "boolean":
        $display = ($val) ? 'true' : 'false';
        break;
      case "integer":
      case "double":
        $display = $val;
        break;
      case "string":
        $display = htmlspecialchars('"'. addslashes($val) .'"');
        break;
      case "array":
        $display = "<span style=\"font-style: italic; color: #003366\">".
                   sizeof($val)." elements</span>";
        break;
      case "object":
        $display = "<span style=\"font-style: italic; color: #003366\">Class ".
                   htmlspecialchars(get_class($val))."</span>";
        break;
      case "resource":
        $display = "<span style=\"font-style: italic; color: #003366\">".
                   htmlspecialchars(get_resource_type($val))."</span>";
        break;
      case "null":
        $display = "NULL";
        break;
      case "unknown type":
      default:
        $display = htmlspecialchars('"'. addcslashes(strval($val)) .'"');
        break;
    }

    $html .= "    <td bgcolor=\"#ffffff\">{$display}</td>\n";

    $html .= "  </tr>\n";

  }

  if($name === 'GLOBALS')
  {
    $html .= "  <tr>\n    <td colspan=\"3\" bgcolor=\"#ffffff\"><span style=\"font-style: italic; color: #003366\">Recursi&oacute;n</span></td>\n  </tr>\n";
    return $html;
  }

  switch(strtolower($type))
  {
    case "object":
      $iterate = get_object_vars($val);
    case "array":
      if(!@(is_array($iterate)))
        $iterate = &$val;

      foreach($iterate as $k => $v)
      {
        if((!$k) || !in_array($k, array('GLOBALS',
         'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_COOKIE_VARS', 'HTTP_SERVER_VARS',
         'HTTP_ENV_VARS', 'HTTP_POST_FILES', 'HTTP_SESSION_VARS')))
          @($html .= Basic::_fancyrinnerworkings(strval($k), $v, $ident+30));
      }

      break;
  }
  return $html;
}

  /**
   * Redirige a una página y termina la ejecución del script.
   *
   * @static
   * @param $url URL al que se redirige
   * @return void
   */

  function redirect($url)
  {
    @header('Location: ' . $url);
    print "<a href='$url'>$url</a>";
    exit();
  }


     /**
	*  Obtiene el tipo de navegador que se esta utilizando
	*
    *   @param None
	*	@return $browser (string) Devuelve el nombre de navegador utilizado
	*/
    
  function getBrowser(){
	if((ereg("Nav", $_SERVER["HTTP_USER_AGENT"])) || (ereg("Gold",
        $_SERVER["HTTP_USER_AGENT"])) || (ereg("X11",
        $_SERVER["HTTP_USER_AGENT"])) || (ereg("Mozilla",
        $_SERVER["HTTP_USER_AGENT"])) || (ereg("Netscape",
        $_SERVER["HTTP_USER_AGENT"])) AND (!ereg("MSIE",
        $_SERVER["HTTP_USER_AGENT"]) AND (!ereg("Konqueror",
        $_SERVER["HTTP_USER_AGENT"])))) $browser = "Netscape";

        elseif(ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) $browser = "MSIE";
        elseif(ereg("Lynx", $_SERVER["HTTP_USER_AGENT"])) $browser = "Lynx";
        elseif(ereg("Opera", $_SERVER["HTTP_USER_AGENT"])) $browser = "Opera";
        elseif(ereg("Netscape", $_SERVER["HTTP_USER_AGENT"])) $browser = "Netscape";
        elseif(ereg("Konqueror", $_SERVER["HTTP_USER_AGENT"])) $browser = "Konqueror";
        elseif((eregi("bot", $_SERVER["HTTP_USER_AGENT"])) || (ereg("Google", $_SERVER["HTTP_USER_AGENT"])) || (ereg("Slurp",
        $_SERVER["HTTP_USER_AGENT"])) || (ereg("Scooter",
        $_SERVER["HTTP_USER_AGENT"])) || (eregi("Spider",
        $_SERVER["HTTP_USER_AGENT"])) || (eregi("Infoseek",
        $_SERVER["HTTP_USER_AGENT"]))) $browser = "Bot";

	else $browser = "Other";
        return $browser;
    }

    /**
	*  Imprime dos selects multiples para seleccion cruzada
	*
     * 
        *   @param None
	*   @return None 
	*/
    function printJSMultiSelects(){
        echo '
            <script type=\'text/javascript\'>//<![CDATA[
                $(function(){
                    $("#btnLeft").click(function () {
                        var selectedItem = $("#rightValues option:selected");
                        $("#leftValues").append(selectedItem);
                        $("#leftValues option").prop("selected", true);
                    });

                    $("#btnRight").click(function () {
                        var selectedItem = $("#leftValues option:selected");
                        $("#rightValues").append(selectedItem);
                        $("#leftValues option").prop("selected", true);
                        
                    });

                    $("#rightValues").change(function () {
                        var selectedItem = $("#rightValues option:selected");
                        $("#txtRight").val(selectedItem.text());
                    });
                });
            //]]>
            </script>
            
            <script type="text/javascript">
                //Function to add an option to a select box
                
                function addOption(selectId, optionId, txt, val) {
                    var objOption = new Option(txt, val);
                    objOption.id = optionId;
                    document.getElementById(selectId).options.add(objOption);
                }
                
                //Function to clear elements from a select box
                function clearlist(selectId){ 
                        var elem = document.getElementById(selectId);
                        elem.parentNode.removeChild(elem);
                }
        </script>';
    }
    
    /**
    *  Imprime un input text con funcion de autocompletar
    * 
    *   Requiere de un archivo donde exista las funciones de acceso a la base de datos en el mismo nivel
    *   Donde se manda llamar este codigo
    *   NOTA: Utiliza jquery 1.9.1 o posterior y jquery-ui
    *
    *   @param $tagName (string) Nombre del input text
    *   @param $fileName (string)  Nombre del archivo para obtener los datos de la BD
    *   @param size (integer)  Tamaña deñ input text.
    *   @return $html  (string) Devuelve el codigo html de esta seccion
    */
    function prinstAutocompleteInputText($tagName,$fileName = null,$disable = null,$size = 15){
        //
        $html = '
            <script src="/include/js/jquery-ui.js"></script>
            <link rel="stylesheet" href="/css/jquery-ui.css">
            <script>
              $(document).ready(function() {
                $( "#'.$tagName.'" ).autocomplete({
                     source: "'.$fileName.'",
                     minLength: 2    
                });
              });
            $(document).ready(function(){
              $(\'#'.$disable.'\').attr(\'disabled\',true);
              $(\'#'.$tagName.'\').keyup(function(){
                if( $(this).val().length != 0 ){
                   $(\'#'.$disable.'\').attr(\'disabled\', false);
                }
                 else
                   $(\'#'.$disable.'\').attr(\'disabled\',true);
              })
              });
            </script>
            <input type="text" size="'.$size.'" id="'.$tagName.'" name="'.$tagName.'">';
        return $html;
    }
    
    
    /**
    *   Send a email
    * 
    *   Send a email to recipients
    * 
    *   @param $subject (string) Email Subject
    *   @param $recipients (string)  recipients to send email
    *   @param $mailMsg (string)  mail message body
    *   @return none
    */
    
    function sendMail($subject, $recipients, $mailMsg){
            
        $smtpinfo["host"] = "10.218.108.241";
        $smtpinfo["port"] = "25";
        $smtpinfo["auth"] = false;

        $headers["MIME-Version"] = "1.0";
        $headers["Content-type"] = "text/html; charset=iso-8859-1";
        $headers["From"] = "Andon Board System<no-reply@continental-corporation.com>";
        $headers["To"] = $recipients;
        $headers["Subject"] = $subject;

        $mail_object =& Mail::factory("smtp", $smtpinfo);

        $mail_object->send($recipients, $headers, $mailMsg);
        return 'Correo(s) Enviados.';
    }
    
    function mailHead(){
        $mailMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                             <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                        </head>
                        <style>
                            .main-header {
                                font-family: Verdana, Arial, Helvetica, sans-serif;
                                font-size: 14px;
                                font-weight: bold;
                                letter-spacing: 2px;
                                color: #000;
                                white-space: nowrap;
                                padding: 10px;
                                background-color: #FFF;
                                background-position: right top;
                                border-bottom: 1px solid #000000;
                                background: url(http://10.218.108.150:10006/images/header_bg.png);
                            }
                            .main-header2{
                                font-family: Verdana, Arial, Helvetica, sans-serif;
                                font-size: 11px;
                                font-weight: bold;
                                letter-spacing: 2px;
                                color: #000;
                                white-space: nowrap;
                                padding: 10px;
                                background-color: #FFF;
                                background-position: right top;
                                border-bottom: 1px solid #000000;
                                background: url(http://10.218.108.150:10006/images/header_bg.png);
                            }
                            html, body {
                                height: 100%;
                            }

                            .wrapper {
                                min-height: 100%;
                                height: auto !important;
                                height: 100%;
                                margin: 0px auto -3em;
                                alignment-adjust: middle;
                                text-align: center;
                            }
                            .footer {
                                height: -3em;
                                border-top: 1px solid #ccc;
                            }
                        </style>';
        return $mailMsg;
    }
}
?>
