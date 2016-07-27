<?php
 /******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *    logout page                                                             
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/

	include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
	include_once('common.php');
        
	Layout::pre_header();
	$xajax->printJavascript("/include/");
	Layout::post_header();
	Basic::EventLog("Logout: ".$user->username);
        session_destroy();
        header("Location: /");
	Layout::footer();
?>
