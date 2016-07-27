<?php
include_once('/var/www/htdocs/vhosts/Andon/include/include.inc.php');
$event = new Event();
$line = new Line();

$resEvents=$event->getEventActives();

while($rowEvents=$resEvents->fetchRow()){
    
   $status=$rowEvents['evl_status'];
   
   if($status != 'Terminado'){
       
   $id_area=$rowEvents['evl_area'];
   $id_line=$rowEvents['evl_line'];
   $time_ini=$rowEvents['evl_datetime'];
   $level=$rowEvents['evl_level'];
   $id_event=$rowEvents['evl_id'];

   if($level+1 <= 5){
   
   $resSubArea=$line->getRecordById_line($id_line);
   $rowSubArea=$resSubArea->fetchRow();
   
   $resLevel=$event->getTimeLevel($level+1, $id_area);
   
 $time_fin=date('Y-m-d H:i:s');
   
$fecha1 = new DateTime($time_fin);
$fecha2 = new DateTime($time_ini);
$fecha = $fecha1->diff($fecha2);
 //printf('%d años, %d meses, %d días, %d horas, %d minutos', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);

$hora_trans_en_minutos = ($fecha->h * 60 ) + $fecha->i;

$hora = "$resLevel";
list($horas, $minutos) = explode(':', $hora);
$hora_en_minutos = ($horas * 60 ) + $minutos;

if($hora_trans_en_minutos > $hora_en_minutos){
    $message="Problema sin resolver en linea: ".$rowSubArea['sba_name'];
    
    if($status == 'En Proceso'){
        
     // $resSol=$event->getSolucionador($id_event);
     // $rowSol=$resSol->fetchRow();
      $message="Problema en Proceso de solucion";
        
    }
   
   $resTel=$event->getDestinatario($level+1, $id_area);
    
   $res= Basic::sendMail("Soporte","\\5213318626316@mensajeria.telcel.com","Mensaje enviado");
   echo "Soporte "."\\5213318626316@mensajeria.telcel.com ".$message." ".$level." ";
    if($level+1 < 5){
   $event->updateLevel($level+1, $id_event);
    }
}
echo $hora_trans_en_minutos. " vs  ". $hora_en_minutos;

   }else {
       
       echo "EL limite de aprovadores se a terminado";
       
   }
   
   }
 // $res= Basic::sendMail("Soporte","\\5213318626316@mensajeria.telcel.com","HOLA");  
}

