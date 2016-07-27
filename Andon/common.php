<?php
/******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *    Initial page                                                             
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/

 
	include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
	require_once ("xajax.inc.php");

  $xajax = new xajax("server.php");
  $xajax->registerFunction("check_session");
  $xajax->registerFunction("submitLogin");
  $xajax->registerFunction("changeLanguage");
  //$xajax->debugOn();

?>
