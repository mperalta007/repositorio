<?php

/******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *   Archivo para el manejo de la impresion de un arregla en una tabla html
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/

function fancy_r(&$v)
{
  $html = '
<table border="0" cellspacing="1" cellpadding="3" bgcolor="#000000" align="center">
  <tr>
    <th bgcolor="#eeeeee">Variable</td>
    <th bgcolor="#eeeeee">Type</td>
    <th bgcolor="#eeeeee">Value</td>
  </tr>
';

  $html .= _fancyrinnerworkings('', $v, 0);

  $html .= "</table>\n";
 return $html;
}

function _fancyrinnerworkings($name, &$val, $ident = 0)
{
  $type = gettype($val);

  if((strlen($name)>0) || !is_array($val))
  {
    @$html .= "  <tr>\n";

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
          $html .= _fancyrinnerworkings(strval($k), $v, $ident+30);
      }

      break;
  }
	return $html;	
}
?>
