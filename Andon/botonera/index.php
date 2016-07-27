
<?php
 include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
 include_once('common.php');
  
 global $user;
 
   Layout::pre_header(); 
  Layout::post_header();  
  Layout::post_header1("Parameters");
   $xajax->printJavascript("/include/");
   
  if(($user->checkPerms("Parameters") == 'Operator')){
      echo '<div class="error">Usted no est&aacute; autorizado a accesar a este m&oacute;dulo</a></div>';
      Layout::footer();
      exit;
  }
echo '<fieldset><center><h3>Registro de Acciones</h3><br>';
 echo '<div style="font-size:1.5em;font-weight: bold">';
 
 $dgr = new C_DataGrid("SELECT * FROM enb_event_botton", "enb_id", "enb_event_botton");
  $dgr->enable_edit("FORM","DR");
  $dgr->set_locale('en');
     

//$dgr->set_dimension(500);
//$dgr->set_col_edit_dimension("strname",30,1);
$dgr->set_theme('ui-lightness');
$dgr->enable_search(TRUE);
$dgr->set_caption("Eventos");
$dgr->set_col_title("enb_date", "Fecha");
$dgr->set_col_title("enb_line", "Linea");
$dgr->set_col_title("enb_team_support", "Equipo");
$dgr->set_col_hidden("enb_id", false);
$dgr->set_col_align("enb_date","center");
$dgr->set_col_align("enb_line","center");
$dgr->set_col_align("enb_team_support","center");
$dgr->display();
 
 
 
 

echo "</div>";


Layout::footer();


