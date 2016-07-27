<?php
 /******************************************************************************
 *  SICE Version 1.0 - Modulos de Alumnos                                      *
 *  Copyright (C) 2006 Jesus Velazquez                                         *
 *  Para Sistemas Aplicados Y Telecomunicaciones S.A.                          *
 *                                                                             *
 *  Author: Jesus Velazquez                                                    *
 *  Descripcion:                                                               *
 *   Modulo diseñado para la consulta y actualizacion de datos de los          *
 *   Alumnos                                                                   *
 *  Modificaciones:                                                            *
 *  Fecha        Autor                   Descripcion                           *
 *  29.Nov.2007  J. Velazquez            Inicio de la programacion             *
 *               <jjvema@yahoo.com>                                            *
 *                                                                             *
 ******************************************************************************/
	include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
	require_once ("xajax.inc.php");

  $xajax = new xajax("server.php");
  $xajax->registerFunction("check_session");
  $xajax->registerFunction("submitLogin");
  $xajax->registerFunction("saveData");
  $xajax->registerFunction("showGrid");
  $xajax->registerFunction("add");
  $xajax->registerFunction("editField");
  $xajax->registerFunction("edit");
  $xajax->registerFunction("delete");
  $xajax->registerFunction("show");
  $xajax->registerFunction("save");
  $xajax->registerFunction("update");
  $xajax->registerFunction("updateField");
  $xajax->registerFunction("email");
	//$xajax->debugOn();

?>
