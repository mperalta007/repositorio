<?php
putenv("ORACLE_HOME=/usr/lib/oracle/xe/app/oracle/product/10.2.0/server");
putenv("ORACLE_SID=mestq");


include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
require_once ('common.php');


//Muestra la lista de proyectos
function getProjects($id_pf=0){
  $project = new Product_Family_Rough();
 // $data = new MDS();
   $objResponse = new xajaxResponse();    
 
if($id_pf==28024){
    $id_pf=28026;
    $objResponse->addAssign("divProject", "innerHTML", $project->printSelect($id_pf,"getLine"));
}if($id_pf==1985){
    $id_pf=1986;
        $objResponse->addAssign("divProject", "innerHTML", $project->printSelect($id_pf,"getLine"));
}if($id_pf==0){
    $objResponse->addAssign("divProject", "innerHTML", "");
}   
   // $objResponse->addAssign("divProject", "innerHTML", $data->printSelectProjects("getLine",$id_pf));
   
    return $objResponse->getXML();
}
//Funcion que sirve para escoger el tipo de modo de visualizacion de las lines
function PrintMode($id_pfr){
   
        $objResponse = new xajaxResponse(); 
        $html="<fieldset style='width:10%'><legend>Mode</legend>
     <input type='button'  value='Singleline' onClick='xajax_PrintAndon($id_pfr)'>
     <input type='button'  value='Multiline' onClick='xajax_PrintAndon($id_pfr)'>
</fieldset>";
       $objResponse->addAssign("divMode", "innerHTML", "$html");
    return $objResponse->getXML();
}
//Obtiene la informacion de la linea 
function getLine($id_pfr){
    $celda = new Line();
    $objResponse = new xajaxResponse();   
  //  $objResponse->addAlert($id_pfr);
    
     $line=$celda->getRecordById($id_pfr);
     
        
     $row=$line->fetchRow();  
     if(!$row['sba_id']){
     $objResponse->addAlert("Proyecto sin datos");
      return $objResponse->getXML();
     }
     $mon=$celda->getMonitor($row['sba_id']);
        //  $mon=$celda->getMonitor($id_pfr);
           $cel=$mon->fetchRow();                  
    if(!$cel['lmt_monitor']){
        $objResponse->addAlert("Proyecto sin datos");
    }else{
           
   $objResponse->addRedirect("/Pizarron/index.php?monitor=".$cel['lmt_monitor']."&x=0");
    }
        
    return $objResponse->getXML();
}
//Esta funcion redirige a la pagina de andon
function PrintAndon($f){
        $objResponse = new xajaxResponse(); 
        $id_pfr=$f['project'];
        $id_line=$f['line'];
        
        $objResponse->addRedirect("/Pizarron/index.php?idline=$id_line&idproject=$id_pfr");
        //$objResponse->addRedirect("/Andon/andon.php?idline=$id_line&idproject=$id_pfr");
        //$objResponse->addScript("xajax_lineinfo('$id_line','$id_pfr')");
       
    return $objResponse->getXML();
}
//funcion para cambiar del valor de la produccion por hora
function cambia_valor($id_line,$plan){
     	$objResponse = new xajaxResponse();
  
        $lines = new Line();   
  
     $hostAll= $lines->getHostNameById($id_line);
     
    while ($host_fail=$hostAll->fetchRow()){         
          $partFail = $lines->getProductionFail($host_fail['stn_host_name']);
          $rowF=oci_fetch_array($partFail);
          $qtym=$qtym+($rowF['MALAS']/2);
    }
      $id_area=$lines->getIdArea($id_line);
    
    $row_t=$lines->getActiveTurnos($id_line);
    
    $row_turnos=$row_t->fetchRow();
    
    $total_turnos=0;
   if($row_turnos['lnt_turno_4']=="active"){
       $total_turnos+=1;
   }
   if($row_turnos['lnt_turno_5']=="active"){
       $total_turnos+=1;
   }
   if($row_turnos['lnt_turno_6']=="active"){
       $total_turnos+=1;
   }
   if($row_turnos['lnt_turno_7']=="active"){
       $total_turnos+=1;
   }
   
    switch ($id_area) {
        case 3:
$host= $lines->getEndCtrlById($id_line);
$horas=(21.5/4)*$total_turnos;
            break;
        case 4:
$host= $lines->getAOIById($id_line);
$horas=(21/4)*$total_turnos;
            break;
        case 5:
$host= $lines->getEndCtrlById($id_line);
$horas=(21.5/4)*$total_turnos;
            break;
        case 6:
$host= $lines->getICTById($id_line);
$horas=(21/4)*$total_turnos;
            break;
    }
    
    
  $host_name=$host->fetchRow();
     
     $partPass=$lines->getProductionPass($host_name['stn_host_name']);
     while($rowP=oci_fetch_array($partPass)){
          $qtyb+=$rowP['BUENAS']/2;
          $partno=$rowP['PARTNO'];
     }
     
   //  $qtyb=$rowP['BUENAS']/2;
    // $partno=$rowP['PARTNO'];   
      $bunit=  split("_", $host_name['stn_host_name']);
 
       $plan_hora=round(($plan/$horas));
       
       $min= date("i");
       $exp=round(($plan_hora*$min)/60);
       
       
                
      if(!$qtyb){$qtyb=0;}
      if(!$qtym){$qtym=0;}
      
       $objResponse->addAssign("celexp","innerHTML",$exp);
       $objResponse->addAssign("celplan","innerHTML",$plan_hora);
       $objResponse->addAssign("celact","innerHTML",$qtyb);
       $objResponse->addAssign("celNOK","innerHTML",$qtym);
       $objResponse->addAssign("celBU","innerHTML","$bunit[0]");
       $objResponse->addAssign("cel01","innerHTML",$partno);
       
      
             $valor=$qtyb-$exp;
             $porcentaje=($qtyb/$exp)*100;
             
              if($valor>0 ) {$valor="+".$valor;}
              $objResponse->addAssign("celcount","innerHTML",$valor);
             // $objResponse->addAssign("cel4","innerHTML",$porcentaje);
              if($porcentaje <98 ){ $objResponse->addAssign("tdv","style.background","#ff001a");$objResponse->addAssign("tablaw","style.color","#ffffff");}
              if($porcentaje >=100 ){ $objResponse->addAssign("tdv","style.background","#18dd3f");$objResponse->addAssign("tablaw","style.color","#000000");}
              if($porcentaje >=98 && $porcentaje <100){$objResponse->addAssign("tdv","style.background","#ffd310");$objResponse->addAssign("tablaw","style.color","#000000");}
            
          //  $objResponse->addScript("setTimeout(xajax_verifica('$qytplan','$qtytotal','$partes','$qty','$i'),9000)");
           $objResponse->addScript("xajax_cambia_turno('$id_line','$plan','$exp')");
           
              return $objResponse->getXML();
	}
//Funcion para cambiar el valor por turno
function cambia_turno($id_line,$plan,$exp_hora){
    $lines = new Line(); 
    $andon = new Andon();
    
    $today = date('Y-m-d');
    
	$objResponse = new xajaxResponse();
             
    $hostAll= $lines->getHostNameById($id_line);
     
    while ($host_fail=$hostAll->fetchRow()){         
          $partFail = $lines->getProductionFailByShift($host_fail['stn_host_name']);
          $rowF=oci_fetch_array($partFail);
         //  $objResponse->addAlert($host_fail['stn_host_name']."  ".$rowF['MALAS']);
          $qtym=$qtym+$rowF['MALAS']/2;
    }
    
      $id_area=$lines->getIdArea($id_line);
    
    switch ($id_area) {
        case 3:
$host= $lines->getEndCtrlById($id_line);
         
            break;
        case 4:
$host= $lines->getAOIById($id_line);
         
            break;
        case 5:
$host= $lines->getEndCtrlById($id_line);
           
            break;
        case 6:
$host= $lines->getICTById($id_line);
           
            break;
    }

	$host_name=$host->fetchRow();
     
     $partPass=$lines->getProductionPAssByShift($host_name['stn_host_name']);
      
     $rowP=oci_fetch_array($partPass);
     
      $qtyb=$rowP['BUENAS']/2;
      //$objResponse->addAlert($host_name['stn_host_name']."  ".$qtyb);
      
      if(!$qtyb){$qtyb=0;}
      if(!$qtym){$qtym=0;}
               
     $shifts= $andon->getShiftsByDay($today);
     $count_shifts=0;
     
     while($shift=$shifts->fetchRow()){
             $status_shift=$lines->getActiveTurnosByTurno($id_line, $shift['turno']) ;
             if($status_shift == "active"){$count_shifts+=1;}
     }
     
         
       $plan_hora=round(($plan/$count_shifts));   
       $hora=  date("H");
	       
	  switch ($hora) {
           case $hora<7:
                 $hora=$hora+5;
               break;
            case $hora >7 && $hora <19:
                $hora=$hora-7;
               break;
            case $hora >19:
                 $hora=$hora-19;
               break;
            case $hora ==7:
                 $hora=(date('i'))/60;
               break;
       }
	
	$exp=round(($plan_hora*$hora)/11);
       
             $objResponse->addAssign("celn1","innerHTML",$plan_hora);
             $objResponse->addAssign("celn2","innerHTML",$exp+$exp_hora);
             $objResponse->addAssign("celn4","innerHTML",$qtyb);
             $objResponse->addAssign("celn5","innerHTML",$qtym);
             
              $valor=$qtyb-($exp+$exp_hora);
             
              if($valor>0 ) {$valor1="+".$valor;}
            
              else {$valor1=$valor;}
              $objResponse->addAssign("celn3","innerHTML",$valor1);
             
              if($valor<0) { $objResponse->addAssign("tablax","style.color","#ff001a");$objResponse->addAssign("celn3","style.color","#ff001a");}
              if($valor==0){ $objResponse->addAssign("tablax","style.color","#ffffff");$objResponse->addAssign("celn3","style.color","#ffffff");}
              if($valor>0) { $objResponse->addAssign("tablax","style.color","#18dd3f");$objResponse->addAssign("celn3","style.color","#18dd3f");}
           
              return $objResponse->getXML();
	}
//Funcion que verifica 
function verifica($qty1,$qty2,$partes,$qty,$i){
	$objResponse = new xajaxResponse();
                // $objResponse->addAlert("hola");
              if($qty1==$qty2 ) {
                  $i=$i+1;
                           $objResponse->addScript("xajax_cambia_valor('$partes','$qty','$i')");
                  }else
                      {   
                      $objResponse->addScript("xajax_cambia_valor('$partes','$qty','$i')");
                      }
                      
              return $objResponse->getXML();
	}
//Fucnion para obtener la informacion de la linea
function lineinfo($id_line){
  $lines = new Line();   
  $andon = new Andon();
  $objResponse = new xajaxResponse();
    
    $qty=$lines->getInfo($id_line);
                  
        $turno1 = "07:00";
        $turno2 = "19:00";
    
      if ( date("H:i") >= $turno1 && date("H:i") < $turno2) {$day = date('Y-m-d')." 07:00:00";}
      if ( date("H:i") >= $turno2 ) {$day = date('Y-m-d')." 19:00:00";}
      if ( date("H:i") < $turno1) {$day = date("Y-m-d ", strtotime("-1 day"))." 19:00:00";}
         
      $arreglo= $andon->getShift($day,'dateini');
      $row=$arreglo->fetchRow();
      
      $shift=$row['turno'];
      
     $status_shift=$lines->getActiveTurnosByTurno($id_line,$shift) ;
             if($status_shift != "active"){  $qty=0; $shift="No Active";}           
             
       // $qtyplan= round($qty/21.5);
      //  $min= date("i");
       // $exp=round(($qtyplan*$min)/60);
          
          
 $name=$andon->getNameById($id_line);
 $name_line=$name->fetchRow();
 
     //  $objResponse->addAssign("celplan","innerHTML",$qtyplan);
   //    $objResponse->addAssign("cel01","innerHTML",$partes);
     //  $objResponse->addAssign("celexp","innerHTML",$exp);
     
  $objResponse->addScript("xajax_cambia_valor('$id_line','$qty')");
 
  $objResponse->addAssign("celLine","innerHTML",$name_line['sba_name']);
  $objResponse->addAssign("celShift","innerHTML",$shift);
 
 // $objResponse->addAlert("Pruebas");
        
  for ($i=1;$i<=16;$i++){
      if($i==$id_line){ $objResponse->addAssign("cuad".$id_line,"style.width","7%");  
     }
  else{  $objResponse->addAssign("cuad".$i,"style.width","5%");}
  }         
       /*if($id_pfr) {     
       $objResponse->addRedirect("/Pizarron/index.php?partes=$partes&qty=$qty&line=$line&shift=$shift&idline=$id_line&idproject=$id_pfr");}*/
  return $objResponse->getXML();       
    }  

$xajax->processRequests();
