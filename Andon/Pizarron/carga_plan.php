<?php 

include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
include_once('common.php');
  $id_line=$_GET['idline'];
?>
<html>
   <head>
        <?php $xajax->printJavascript("/include/");?> 
	<title>Carga del Plan de Produci&oacute;n</title>
	<meta http-equiv="Content-Language" content="es-mx">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="/css/style_monitor.css" type="text/css" rel="stylesheet" />
       
   </head>

<body>
  <?php
 
$cw= date('W');
  
echo '<center><br><br><select id="selcw" onchange="xajax_showTable(this.value,'.$id_line.')"><option value="0">Semana</option>';
$cw_ini=$cw-3;
if($cw_ini<1){$cw_ini=1;}
$cw_fin = $cw+3;
if($cw_fin >53){$cw_fin=53;}

for($j=$cw_ini;$j<=$cw_fin;$j++){
echo '<option value="'.$j.'">'.$j.'</option>';
}

echo '</select><br><br>
<div id="divTable" ></div><br><br>
<div id="divTextArea" style="visibility:hidden">
<textarea style="width:400px" id="plantextArea"></textarea>
<input type="button" value="Cargar" onclick="xajax_saveMasivePlan(document.getElementById(\'plantextArea\').value,'.$id_line.',document.getElementById(\'selcw\').value)">
</div>
</center>
</body>
</html>';
?>

