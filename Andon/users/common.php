<?php

/******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *   Modulo de  Administracion de Usuarios
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/
 
	include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
	require_once ("xajax.inc.php");

  $xajax = new xajax("server.php");

  $xajax->registerFunction("showGrid");
  $xajax->registerFunction("add");
  $xajax->registerFunction("edit");
  $xajax->registerFunction("show");
  $xajax->registerFunction("delete");
  $xajax->registerFunction("save");
  $xajax->registerFunction("update");
  $xajax->registerFunction("editField");
  $xajax->registerFunction("updateField");
  $xajax->registerFunction("selectbydate");
  $xajax->registerFunction("unsetall");
  $xajax->registerFunction("checkSAPstatus");

//$xajax->debugOn();

?>
