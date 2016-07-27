<?php 
 /******************************************************************************
 *                                  
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
  include_once('common.php');
$var=$_GET['var'];
  Layout::pre_header();
  $xajax->printJavascript("/include/");
   Layout::post_header('onLoad="document.login.username.focus()"');
   session_destroy();
  Layout::login_form($var);
  Layout::footer();
?>
