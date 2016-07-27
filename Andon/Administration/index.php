
<?php
 include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
 include_once('common.php');
  
 global $user;
  $data = new MDS();
  
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
 
 $dgr = new C_DataGrid("SELECT * FROM lmt_line_monitor", "lmt_id", "lmt_line_monitor");
  $dgr->enable_edit("FORM","CRD");
  $dgr->set_locale('es');
     

//$dgr->set_dimension(500);
//$dgr->set_col_edit_dimension("strname",30,1);
$dgr->set_theme('ui-lightness');
$dgr->enable_search(TRUE);
$dgr->set_caption("Lines Monitor");
$dgr->set_col_title("lmt_line", "Linea");
$dgr->set_col_title("lmt_monitor", "Monitor");
$dgr->set_col_hidden("lmt_id", false);
$dgr->set_col_align("lmt_line","center");
$dgr->set_col_align("lmt_monitor","center");

$dgr-> set_col_edittype("lmt_line", "select", "select sba_id,sba_name from sba_subarea");


$ondobleclick=<<<ONDBLCLICKROW
function(status,rowid){ 
        $('#lmt_line_monitor').editRow(rowid, true); 
          
      }
ONDBLCLICKROW;

$dgr->add_event("jqGridDblClickRow", $ondobleclick);

$dgr->display();
 
 
 
 

echo "</div>";


Layout::footer();


