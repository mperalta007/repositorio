<?php
 include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
 include_once('common.php');  
 global $user;
// 
 session_start(); // Import value from Url Path
    $_SESSION["var"] = $_SERVER["REQUEST_URI"];
  
 $usuario = new User();
  if(!$usuario->checkAuth()){
    header("Location:/login.php?var=".$_SESSION['var']);}
    
  Layout::pre_header(); 
  Layout::post_header();  
  Layout::post_header1("Parameters");
   $xajax->printJavascript("/include/");
    
     if(($usuario->checkPerms("Andon") != 'Administrator')){
      echo '<div class="error">Usted no est&aacute; autorizado a accesar a este m&oacute;dulo</a></div>';
      Layout::footer();
      exit;
  }
  
echo '<fieldset><center><h3>Administraci&oacute;n</h3><br>';
 echo '<div style="font-size:1.5em;font-weight: bold">';
 
 $dgr = new C_DataGrid("SELECT * FROM stn_station", "stn_id", "stn_station");
  $dgr->enable_edit("INLINE","CRD");
  $dgr->set_locale('es');
     

//$dgr->set_dimension(500);
$dgr->set_col_edit_dimension("stn_host_name",30,1);
$dgr->set_theme('ui-lightness');
$dgr->enable_search(TRUE);
$dgr->set_caption("Estaciones de cada linea");
$dgr->set_col_title("stn_host_name", "Nombre de la estacion");
$dgr->set_col_title("stn_sba_id", "Linea");
$dgr->set_col_hidden("stn_id", false);
$dgr->set_col_hidden("stn_name", false);
$dgr->set_col_align("stn_host_name","center");
$dgr->set_col_align("stn_sba_id","center");
//$dgr->set_multiselect(true);
$dgr-> set_col_edittype("stn_sba_id", "select", "select sba_id,sba_name from sba_subarea order by sba_name");


$ondobleclick=<<<ONDBLCLICKROW
function(status,rowid){ 
        $('#stn_station').editRow(rowid, true); 
          
      }
ONDBLCLICKROW;

$dgr->add_event("jqGridDblClickRow", $ondobleclick);

$dgr->display();
 
echo "</div>";


Layout::footer();


