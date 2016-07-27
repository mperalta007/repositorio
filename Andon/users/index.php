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
  include_once('common.php');

  global $user;
  
   session_start(); // Import value from Url Path
    $_SESSION["var"] = $_SERVER["REQUEST_URI"];
  
 $usuario = new User();
  if(!$usuario->checkAuth()){
    header("Location:/login.php?var=".$_SESSION['var']);}
    
  
  Layout::pre_header();
  $xajax->printJavascript("/include/");
   Layout::post_header();
  Layout::post_header1();
  
  echo "<center><h3>Administracion de Usuarios</h3><br><br>";
 
      $dg = new C_DataGrid("select * from users", "id", "users");
      $dg->set_theme('ui-lightness');
      $dg->enable_edit("INLINE","CRU");
      $dg->set_col_hidden('id');
      $dg->set_col_title('uid', 'UID');
      $dg->set_col_title('module', 'MODULO');
      $dg->set_col_title('perm', 'PERMISO');
      $dg->set_col_title('language', 'LENGUAJE');
    //  $dg->enable_columnchooser(true);
      $dg->set_locale('es');
      $dg->set_query_filter("module='Andon'");
     // $dg->set_col_edittype("uid", "autocomplete", "select DISTINCT(uid),uid from v_usersmod");
      $dg -> set_col_edittype("module", "select", "Andon:Andon");
      $dg->set_col_edittype("perm", "select", "Administrator:Administrator;AdminCBS:AdminCBS");
      $dg->set_col_edittype("language", "select", "Spanish:Spanish;English:English");
     // $dg->enable_advanced_search(true);
     //$dg->add_column('enable', array('name'=>'enable', 'index'=>'enable', 'width'=>'30', 'align'=>'center', 'sortable'=>false, 
     //'editable'=>true,'formatter'=>'checkbox'), 'Enable');
     //$dg->set_col_frozen('uid');
     //$dg->add_column("actions", array('name'=>'actions','index'=>'actions', 'width'=>'80','formatter'=>'actions','formatoptions'=>array('keys'=>true, 'editbutton'=>true, 'delbutton'=>true)),'Actions');
      $dg->enable_export('EXCEL');
      //$dg->set_col_property('uid', array('classes'=>'comppk'));
   //   $dg->set_conditional_value("uid", "=='uidj9298'", array("TCellStyle"=>"celda"));
     // $dg -> set_row_color('yellow', 'blue', 'lightgray');
   //$dg->enable_search(true);
         $dg->set_caption("Usuarios");
       //  $dg->set_grid_property('align=center');
//echo fancy_r($user);
  // echo '<div >'.$dg -> display();
   echo "<div style='text-align: center'>".$dg->display();
   echo"</center></div>";
  

  Layout::footer();
?>
