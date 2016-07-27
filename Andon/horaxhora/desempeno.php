<?php 

  include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
  include_once('common.php');
?>
<html>
   <head>
         <?php $xajax->printJavascript("/include/");?> 
	<title>Monitor Hora x Hora</title>
	<meta http-equiv="Content-Language" content="es-mx">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="refresh" content="120">
        <link href="/css/style_monitor.css" type="text/css" rel="stylesheet" />
       
   </head>

<body>
  <?php
  $monitor = new Monitor();
  $hora_actual = date("H");
//  $hora_actual = "7";
  if($hora_actual>=7 and $hora_actual <19){
     $fecha_turno = date("Y-m-d"); // Today
     $dateIni = "$fecha_turno 07:00:00";
     $dateFin = "$fecha_turno $hora_actual:59:59.999";
  }
 if($hora_actual>=19 and $hora_actual <24){
     $fecha_turno = date("Y-m-d"); // Today
     $dateIni = "$fecha_turno 19:00:00";
     $dateFin = "$fecha_turno $hora_actual:59:59.999";
 }
 if($hora_actual>=0 and $hora_actual <7){
     $fecha_turno = date('Y-m-d', strtotime('-1 day')); // Yesterday
     $today = date("Y-m-d"); // Today
     $yesterday = $fecha_turno;
     $dateIni = "$yesterday 19:00:00";
     $dateFin = "$today $hora_actual:59:59.999";
 }
 
 echo '<table width="99%;"  align="center" border="0" class="adminlist" id="tablehxh" name="tablehxh">';
 //$Monitor = new Monitor();
 
 $htmlLastHour= '    <tr>
                        <th>Hora</th>
                        <th>No. Parte</th>
                        <th>Esperadas</th>
                        <th>Producidas<br>(PCBs/hr)</th>
                        <th>Causa</th>
                        
                    </tr> ';
 

//$htmlLastHour.= $monitor->getUnitsInShift($_GET['idline']); 
$htmlLastHour.= $monitor->getUnitsByShift($_GET['idline']); 
$htmCurrentHour.= $monitor->getUnitsInCurrentHour($_GET['idline']);
echo  $htmlLastHour.$htmCurrentHour;      

echo '              
                    </table>
       </center>
   </body>
</html>';

?>

