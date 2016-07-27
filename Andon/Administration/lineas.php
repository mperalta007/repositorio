
<?php
 include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
 include_once('common.php');
  
 global $user;
  $data = new MDS();
   Layout::pre_header(); 
  Layout::post_header();  
  Layout::post_header1("Parameters");
   $xajax->printJavascript("/include/");
   
  if(($user->checkPerms("Parameters") == 'Operator')){
      echo '<div class="error">Usted no est&aacute; autorizado a accesar a este m&oacute;dulo</a></div>';
      Layout::footer();
      exit;
  }
echo '<fieldset><center><h3>Administraci&oacute;n</h3><br>';
 echo '<div style="font-size:1.5em;font-weight: bold">';
 
 $dgr = new C_DataGrid("SELECT * FROM spm_subarea_prod_family", "spm_id", "spm_subarea_prod_family");
  $dgr->enable_edit("FORM","CRD");
  $dgr->set_locale('es');
     

//$dgr->set_dimension(500);
//$dgr->set_col_edit_dimension("strname",30,1);
$dgr->set_theme('ui-lightness');
//$dgr->enable_search(TRUE);
$dgr->set_caption("Product Family vs SubArea");
$dgr->set_col_title("spm_id_sub_area", "SubArea");
$dgr->set_col_title("spm_id_product_family", "Product Family");
$dgr->set_col_hidden("spm_id", false);
$dgr->set_col_align("spm_id_sub_area","center");
$dgr->set_col_align("spm_id_product_family","center");
//$dgr->set_multiselect(true);
$res=$data->getAllProjects();
while($row=$res->fetchRow()){
    $id=$row['pf_id'];
    $name=$row['pf_name'];
    $html.="$id:$name;";
}
$dgr-> set_col_edittype("spm_id_sub_area", "select", "select sba_id,sba_name from sba_subarea");
$dgr-> set_col_edittype("spm_id_product_family", "select", "$html");


$ondobleclick=<<<ONDBLCLICKROW
function(status,rowid){ 
        $('#spm_subarea_prod_family').editRow(rowid, true); 
          
      }
ONDBLCLICKROW;

$dgr->add_event("jqGridDblClickRow", $ondobleclick);

$dgr->display();
 
 
 
 

echo "</div>";


Layout::footer();


