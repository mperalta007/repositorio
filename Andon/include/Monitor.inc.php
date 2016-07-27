<?php
 /******************************************************************************
 *  WLS Version 3.x - WLS SYSYTEM                                              *
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                *
 *  Descripcion:                                                               *
 *    Project Class File                                                       *
 *                                                                             *
 *  Modifications                                                              *
 *                                                                             *
 ******************************************************************************/

/** Clase para el manejo de los productos
*
* En esta clase se definen los metodos para el manejo de los Projectos
*
* @author	Jose Iniguez <jose.iniguez@continental-corporation.com>
* @version	1.0
* @date		Ago 16, 2012
*
* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
*			m&oacute;dulo <b>Monitor</b>.
*/
	
class Monitor extends PEAR {

    /**
	 * <i>integer</i> Auth lifetime in seconds
    *  If this variable is set to 0, auth never expires
    */
      
    function getInfoLine($idline){
        global $db;
        
        $sql = "SELECT * FROM lines WHERE id=$idline";
        //Basic::EventLog("Monitor->getInfoMachine: $sql");
        $res =& $db->queryRow($sql);
        return $res;    
    }
     
     function getUnitsByHour($product,$idline){
        global $db;
        $sql = "SELECT units_hr FROM referencias WHERE producto='$product' AND id_linea = $idline order by fecha_actualizacion desc limit 1";
        //Basic::EventLog("Monitor->getPanelesByShift: $sql");
        $res =& $db->queryOne($sql);
        return $res;
    }
 
    function getPcbsByPanel($partno){
       global $db;
        $sql = "SELECT pcbs_x_panel FROM referencias WHERE producto='$partno' order by id desc limit 1";
       // Basic::EventLog("Monitor->getPanelesByShift: $sql");
        $res =& $db->queryOne($sql);
        return $res; 
    }
      
    function getUnitsInCurrentHour($id_line){
       
        $lines = new Line();
    
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
     $partPass=$lines->getProductionCurrent($host_name['stn_host_name']);     
       
        $current_date_ini = date("H:")."00:00";
        $current_date_fin = date("H:")."59:59";               
      
   
     $qty=$lines->getInfo($id_line);   
     
          $plan=$qty/$horas;           
          $min= date("i");          
          $exp=round(($plan*$min)/60);
                
     while($row=oci_fetch_array($partPass)){
     
          $qty=$row['UNITS']/2;
          $parte=$row['PARTNO'];                
        
             if($exp>$qty){$color="#ff001a";}else{$color="#18dd3f";} 
              
           $html .='
                    <tr class="'.$class.'">
                         <td style="text-align:center;">'.$current_date_ini.' - '.$current_date_fin.'</td>
                         <td style="text-align:center;">'.$parte.'</td>
                         <td style="text-align:center;">'.$exp.'</td>
                         <td style="text-align:center;background-color:'.$color.'">'.$qty.'</td>
                         <td style="text-align:center;"><input type="text" style="width:100%" readonly></td>
                       
                    </tr>'; 
        // self::setUnits($id_line);
       }
        return $html;
             
    
      
       
    }
    
    function setUnits($id_line){
       global $db;
        $lines = new Line();       
     $date = date('m-d-Y H:i:s',strtotime("-1 hour")); 
     $planTotal=$lines->getInfo($id_line);    
  
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
     
     $partPass=$lines->getProduction($host_name['stn_host_name']);
     
      $exp=round($planTotal/$horas); 
     $i=0;
     while($row=oci_fetch_array($partPass)){
          $qty=$row['UNITS']/2;
          $parte=$row['PARTNO'];
             $partes [$i]=$parte;             
             $cantidades [$i]=$qty;
     
        $i++;
          }     
          
          $c=count($partes);
     if($exp==0 || $c==0){
         $esperadas=0;
     }else{
          $esperadas=round($exp/$c);
     }
         for($j=0;$j<$c;$j++) {   
              $sql="insert into unp_units_produced (unp_id_line,unp_partno,unp_produced,unp_expected,unp_hour) values ('$id_line','$partes[$j]','$cantidades[$j]','$esperadas','$date')";
          //     $sql1="update unp_units_produced set unp_expected='$esperadas' where unp_id_line='$id_line' and unp_partno='$partes[$$j]' and unp_hour between '$dateini' and '$datefin' ";
      //   Basic::EventLog("setUnits-> ".$sql);           
        $db->query($sql);
        
          }
          
        
    }
    
  function setUnits_New($id_line){
       global $db;
        $lines = new Line(); 
                
  $line= $lines->getRecordById_line($id_line);     
  $line_name=$line->fetchRow();  
  $name_line=$line_name['sba_pulse_name'];
        
     $date = date('m-d-Y H:i:s',strtotime("-1 hour")); 
     
     $planTotal=$lines->getInfo($id_line);
     
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
$host="ENDCTRL";
$horas=(21.5/4)*$total_turnos;
$bunits="ID";
            break;
        case 4:
$host= "AOI";
$horas=(21/4)*$total_turnos;
$bunits="FE";
            break;
        case 5:
$host="ENDCTRL";
$horas=(21.5/4)*$total_turnos;
$bunits="CV";
            break;
        case 6:
$host= "ICT";
$horas=(21/4)*$total_turnos;
$bunits="FE";
            break;
    }
 
    $exp=round($planTotal/$horas);
    
    $partGood=$lines->getProductionPass_New($name_line,$host);
    while($rowG=oci_fetch_array($partGood)){
      $qtyb[]=$rowG['BUENAS'];           
      $partno[]=$rowG['PARTNO'];
     }         
       
  
      $partFail=$lines->getProductionFail_New($name_line);
       $rowF=oci_fetch_array($partFail);
         $qtym[]=$rowF['MALAS']; 
          
       $c=count($partno);
     if($exp==0 || $c==0){
         $esperadas=0;
     }else{
          $esperadas=round($exp/$c);
     }
         for($j=0;$j<$c;$j++) {   
              $sql="insert into unp_units_produced_new (unp_line,unp_partno,unp_good_produced,unp_fail_produced,unp_expected,unp_hour) values ('$id_line','$partno[$j]','$qtyb[$j]','$qtym[$j]','$esperadas','$date')";
          //     $sql1="update unp_units_produced set unp_expected='$esperadas' where unp_id_line='$id_line' and unp_partno='$partes[$$j]' and unp_hour between '$dateini' and '$datefin' ";
         Basic::EventLog("setUnits-> ".$sql);           
        $db->query($sql);
        
          }
          
        
    }
    
    function getUnitProduced($id_line,$partno){
        global $db;
        $hora=  date("Y-m-d H");
       $sql="select * from unp_units_produced where unp_id_line='$id_line' and unp_partno='$partno' and unp_hour between '$hora:00:00' and '$hora:59:59' ";
      // Basic::EventLog("getUnits-> ".$sql);           
        $res=& $db->query($sql);  
        return $res;
    }
    
    function updateUnitProduced($id_line,$partno,$hora,$causa){
        global $db;
       $dia= date("Y-m-d");
       $sql="update unp_units_produced set unp_cause='$causa' where unp_id_line='$id_line' and unp_partno='$partno' and unp_hour between '$dia $hora:00:00' and '$dia $hora:59:59' ";
      // Basic::EventLog("getUnits-> ".$sql);           
        $res=& $db->query($sql);  
        return $res;
    }
    function getUnitAllProduced($id_line){
        global $db;
         $hactual=  date("His");
      //  Basic::EventLog("hola");
        if($hactual<"070000")
        {
        $current_date_ini= date("Y-m-d ", strtotime("-1 day"))."190000"; 
        $current_date_fin= date("Y-m-d ")."065999"; 
        }
         if($hactual>="190000"){
        $current_date_ini= date("Y-m-d ")."190000"; 
        $current_date_fin= date("Y-m-d ", strtotime("+1 day"))."065999";  
         }
         if($hactual >="070000" && $hactual <"190000"){
        $current_date_ini = date("Y-m-d ")."070000";
        $current_date_fin = date("Y-m-d ")."185999";
         }
       $sql="select * from unp_units_produced where unp_id_line='$id_line' and unp_hour between '$current_date_ini' and '$current_date_fin' order by unp_hour asc ";
      //  Basic::EventLog("getUnits-> ".$sql);           
        $res=& $db->query($sql);  
        return $res;
    }
    
    function getUnitsInShift($id_line){
           $lines = new Line();
        
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
     $partPass=$lines->getProductionShift($host_name['stn_host_name']);
      $html ='
                    <tr class="'.$class.'">
                         <td style="text-align:center;"></td>
                         <td style="text-align:center;"></td>
                         <td style="text-align:center;"></td>
                         <td style="text-align:center;"></td>
                         <td style="text-align:center;"></td>
                       
                    </tr>'; 
     while($row=oci_fetch_array($partPass)){
        
          $qty=$row['UNITS']/2;
          $parte=$row['PARTNO'];
          $fecha=$row['FECHA'];
          
          $plan=1000;
          $min= date("i");
          $exp=round(($plan*$min)/60);
          
         // $exp=round ($plan/12);
          // $expect=  round($qty);
       // $current_date_ini = date("H:")."00";
       // $current_date_fin = date("H:")."59";
              
          if($exp>$qty){$color="#ff001a";}else{$color="#18dd3f";}
          
           $html .='
                    <tr class="'.$class.'">
                         <td style="text-align:center;">'.$fecha.':00:00 - '.$fecha.':59:59</td>
                         <td style="text-align:center;">'.$parte.'</td>
                         <td style="text-align:center;">'.$exp.'</td>
                         <td style="text-align:center;background-color:'.$color.'">'.$qty.'</td>
                         <td style="text-align:center;"><input type="text" style="width:100%"></td>
                    </tr>'; 
          //$partes=$partes.$parte[1].",";
           //Basic::EventLog("HTML-> ".$html);
     }
                     
        return $html;
    }
    function getUnitsByShift($id_line){
          
       $arreglo =& self::getUnitAllProduced($id_line);
               $i=0;
        while( $rowline =$arreglo->fetchRow()){
         
    $partno=$rowline['unp_partno'];
    $expect=$rowline['unp_expected'];
    $qty=$rowline['unp_produced'];
    $hour=$rowline['unp_hour'];
    $causa=$rowline['unp_cause'];
    
    $hora=  split("[' ':]", $hour);
    
     if($expect>$qty){$color="#ff001a";}else{$color="#18dd3f";} 
   
   
           $html .='
                    <tr  class="'.$class.'">
                         <td id="hora'.$i.'" name="hora'.$i.'" style="text-align:center;"><label>'.$hora[1].':00:00 - '.$hora[1].':59:59</td>
                         <td style="text-align:center;">'.$partno.'</td>
                         <td style="text-align:center;">'.$expect.'</td>
                         <td style="text-align:center;background-color:'.$color.'">'.$qty.'</td>
                         <td style="text-align:center;">
                         <input id="causa'.$i.'" name="causa'.$i.'" style="width:100%;height:100%;" onblur="xajax_saveCausa(document.getElementById(\'causa'.$i.'\').value,\''.$partno.'\',\''.$id_line.'\',\''.$hora[1].'\')" value="'.$causa.'"></td>
                       
                    </tr>'; 
           $i++;
        }
      //   Basic::EventLog("lO Q SE MOSTRARA".$html);
        return $html;
    }
  
}
?>
