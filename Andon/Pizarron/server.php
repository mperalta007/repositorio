<?php


include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');

require_once ('common.php');

function email($name,$f,$id,$line){
     $objResponse = new xajaxResponse();  
     $andon = new Andon();
     
    if($name != "Activado"){
     if($f['cause']==""){
         $objResponse->addAlert("Selecciona la causa");
          return $objResponse->getXML();
     }
     if($f['color']==""){
         $objResponse->addAlert("Selecciona el color");
          return $objResponse->getXML();
     }
    }
 switch ($f['color']) {
         case "Red":
        $message="Paro en linea $line requiere su soporte inmediato";
            break;
         case "Yellow":
        $message="La linea $line requiere su soporte";
            break;
         case "Blue":
        $message="Mensaje de linea $line";
            break;
    }

switch ($name){
     case "Mantenimiento":
         
        $andon->updateStatusLine($line, $f['cause'],$f['color']);
         
        $objResponse->addAssign("manto", "className", "btn1h");
        $objResponse->addAssign("manto", "value", "Activado");
        $andon->setSupport($line, $name);       
        $res= Basic::sendMail("Soporte Linea: $line","5213318622758@mensajeria.telcel.com",$message);
        $objResponse->addAlert($res);
        break;
    
     case "Procesos":
          $andon->updateStatusLine($line, $f['cause'],$f['color']);
         $objResponse->addAssign("procesos", "className", "btn1h");
         $objResponse->addAssign("procesos", "value", "Activado");
          $andon->setSupport($line, $name);
       $res= Basic::sendMail("Soporte Linea: $line","5213318622758@mensajeria.telcel.com",$message);
        $objResponse->addAlert($res);
        break;
     case "Calidad":
           $andon->updateStatusLine($line, $f['cause'],$f['color']);
         $objResponse->addAssign("calidad", "className", "btn1h");
         $objResponse->addAssign("calidad", "value", "Activado");
          $andon->setSupport($line, $name);
       $res= Basic::sendMail("Soporte Linea: $line","5213318626316@mensajeria.telcel.com",$message);
        $objResponse->addAlert($res);
        break;
     case "Materialistas":
           $andon->updateStatusLine($line, $f['cause'],$f['color']);
         $objResponse->addAssign("mate", "className", "btn1h");
         $objResponse->addAssign("mate", "value", "Activado");
          $andon->setSupport($line, $name);
        $res= Basic::sendMail("Soporte Linea: $line","5213316170423@mensajeria.telcel.com",$message);
        $objResponse->addAlert($res);
        break;
     case "FM":
           $andon->updateStatusLine($line, $f['cause'],$f['color']);
         $objResponse->addAssign("fm", "className", "btn1h");
         $objResponse->addAssign("fm", "value", "Activado");
          $andon->setSupport($line, $name);
       $res= Basic::sendMail("Soporte Linea: $line","5213318626316@mensajeria.telcel.com",$message);
        $objResponse->addAlert($res);
        break;
     case "IHM":
          $andon->updateStatusLine($line, $f['cause'],$f['color']);
         $objResponse->addAssign("ihm", "className", "btn1h");
         $objResponse->addAssign("ihm", "value", "Activado");
          $andon->setSupport($line, $name);
     $res= Basic::sendMail("Soporte Linea: $line","5213318626316@mensajeria.telcel.com",$message);
        $objResponse->addAlert($res);
        break;
     case "Control de Produccion":
          $andon->updateStatusLine($line, $f['cause']);
         $objResponse->addAssign("control", "className", "btn1h");
         $objResponse->addAssign("control", "value", "Activado");
          $andon->setSupport($line, $name);
        $res= Basic::sendMail("Soporte Linea: $line","5213314111616@mensajeria.telcel.com",$message);
        $objResponse->addAlert($message." ".$line);
        break;
     case "Produccion":
         $andon->updateStatusLine($line, $f['cause'],$f['color']);
         $objResponse->addAssign("prod", "className", "btn1h");
         $objResponse->addAssign("prod", "value", "Activado");
          $andon->setSupport($line, $name);
        $res= Basic::sendMail("Soporte Linea: $line","5213318457546@mensajeria.telcel.com",$message);
        $objResponse->addAlert($res);
        break;
     case "IT":
         $andon->updateStatusLine($line, $f['cause'],$f['color']);
         $objResponse->addAssign("it", "className", "btn1h");
         $objResponse->addAssign("it", "value", "Activado");
         $andon->setSupport($line, $name);
       $res= Basic::sendMail("Soporte Linea: $line","5213318626316@mensajeria.telcel.com",$message);
        $objResponse->addAlert($res);
        break;
     case "Activado":
        
             $html = Table::Top("Ingresa tu Numero de Personal");  // <-- Set the title for your form.
             $html .= Andon::formAddNum($id,$line);  // <-- Change by your method
   // End edit zone
             $html .= Table::Footer();             
             $objResponse->addAssign("formDiv", "style.visibility", "visible");
             $objResponse->addAssign("formDiv", "innerHTML", $html);
          
         break;
}
    return $objResponse->getXML();
}
function mostrar($id,$id_proj,$id_line){
     $objResponse = new xajaxResponse();
     
     switch ($id){
         case 0:
             $andon = new Andon();

$responsable=$andon->getDaysById($id_line,"responsable");
$extension=$andon->getDaysById($id_line,"ext");
$dias=$andon->getDaysById($id_line,"day");
$meta=$andon->getDaysById($id_line,"meta");
$logro=$andon->getDaysById($id_line,"logro");
        
        $resp = $responsable->fetchRow();
        $ext = $extension->fetchRow();
        $day = $dias->fetchRow();
        $metas = $meta->fetchRow();
        $logros = $logro->fetchRow();
        
             $html=' <table border="0" style=" width: 100%;height: 100%">
                      <tr style=" height: 10%">
                            <td style=" background-color: #FFFFFF; width: 70%">
                                <table >
                                 <tr>
                                 <td style=" width: 40%;"><input type="text" id="resp" value="'.$resp['lnp_value'].'" onblur="xajax_update(document.getElementById(\'resp\').value,'.$id_line.',1)" name="resp"   style=" width: 100%;text-align: center;font-size: .5em" ></td>
                                 <td style=" width: 20%"><input type="text" id="ext" name="ext" value="'.$ext['lnp_value'].'" onblur="xajax_update(document.getElementById(\'ext\').value,'.$id_line.',\'2\')"  style=" width: 100%;text-align: center;font-size: .5em"></td>
                                 <td style=" width: 20%"><input type="text" value="'.date('d / m').'" readonly="true" style=" width: 100%;text-align: center;font-size: .5em"></td>
                             </tr>
                             <tr style=" text-align: center">
                                 <td><label style="font-size: .5em; font-weight: bold">Responsable</label></td>
                                 <td><label style="font-size: .5em; font-weight: bold">Ext</label></td>
                                 <td><label style="font-size: .5em; font-weight: bold">Fecha D&iacute;a / Mes</label></td>
                             </tr>
                                </table>
                            </td>
                                <td></td>
                              </tr>
                               <tr style=" text-align: center">
                                 <td style=" width: 70%">
                                     <input type="text" name="day" id="day" value="'.$day['lnp_value'].'" onblur="xajax_update(document.getElementById(\'day\').value,'.$id_line.',3)"  
                                            style=" width: 100% ;height: 80%;text-align: center;font-size: 2em;font-weight: bold;';
                                            if($day['lnp_value'] >= $metas['lnp_value']) {$html.="color:#18dd3f";}
                                            else {$html.="color:#ff001a";} 
                                            $html.='" >
                                     <label style=" font-size:.8em; font-weight:bold">Dias sin rechazo del cliente</label><br>
                                     <label style=" font-size:.5em; font-weight:bold">Days whithout customer reject</label>
                                 </td>
                                 <td style=" width: 30%">
                                     <table style="width: 100%;height: 100%;text-align: center" border="0">
                               <tr>
                                   <td style="width: 100%;height: 50%"><input type="text" name="logro" value="'.$logros['lnp_value'].'" onblur="xajax_update(document.getElementById(\'logro\').value,'.$id_line.',\'4\')" id="logro"  
                                                                              style=" width: 100%;height: 70%;text-align: center;font-size: 2em;font-weight: bold;';
                                            if($logros['lnp_value'] >= $metas['lnp_value']) {$html.="color:#18dd3f";}else {$html.="color:#ff001a";} 
                                            $html.='" >
                                  <br><label style=" font-size:.5em">Mejor Logro</label><br><label style=" font-size: .5em">Best Archievement</label></td>
                               </tr>
                                <tr>
                                    <td style="width: 100%;height: 50%"><input type="text" name="meta" id="meta" value="'.$metas['lnp_value'].'" onblur="xajax_update(document.getElementById(\'meta\').value,'.$id_line.',\'5\')"  style=" width: 100%;height: 70%;text-align: center;font-size: 2em;font-weight: bold" >
                                 <br><label style=" font-size: .5em">Meta</label><br><label style="font-size: .5em; font-weight: bold">Target</label></td>
                                </tr>
                              </table>
                                 </td>
                                    </tr>
                        </table>';
      $objResponse->addAssign("days", "innerHTML", $html);        
     return $objResponse->getXML();
     
         case 1:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/jidoka/jidoka.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'jidoka\','.$id_proj.','.$id_line.')"></div>';
             $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 2:
             $andon = new Andon();
            
             $name=$andon->getNameById($id_line);
             $name_line=$name->fetchRow();
            //$res=$andon->getPlanCWNew($id_line);
                                 
                            $plannew=$andon->getPPlan($id_line);
                            
                               $cw=  date("W");
                                 
                                $lunes=$andon->getCumplimiento($id_line,$cw,"Monday");
                                $martes=$andon->getCumplimiento($id_line,$cw,"Tuesday");
                                $miercoles=$andon->getCumplimiento($id_line,$cw,"Wednesday");
                                $juevez=$andon->getCumplimiento($id_line,$cw,"Thursday");
                                $viernes=$andon->getCumplimiento($id_line,$cw,"Friday");
                                $sabado=$andon->getCumplimiento($id_line,$cw,"Saturday");
                                $domingo=$andon->getCumplimiento($id_line,$cw,"Sunday");
                                
                                $rowl = $lunes->fetchAll();
                                $rowm = $martes->fetchAll();
                                $rowx = $miercoles->fetchAll();
                                $rowj = $juevez->fetchAll();
                                $rowv = $viernes->fetchAll();
                                $rows = $sabado->fetchAll();
                                $rowd = $domingo->fetchAll();
                                
             
             
          //  $objResponse->addAlert($row[0]['cto_monday']);
           //  echo fancy_r($row);
             $html=' <div style="width: 100%;">
                                                        <center>
                                                               <table border="1" style="margin: 0 auto;text-align: left;font-size:1.2em;width: 98%;height: 70%;font-weight: bold;table-layout: fixed" >
                                                                   <tr style=" height: 10%">
                                                                                                                              
                                                               <td>Semana: '.$cw.'</td>                                                                                                                              
                                                                <td colspan="7">Cumplimiento-Linea: '.$name_line['sba_name'].'</td>
                                                                
                                                            </tr>
                             <tr style=" height: 10%; background-color: #FB9D00">
                                <th style="width: 20%" >Desempe&ntilde;o</th>
                                <th style="width: 10%">Lunes</th>
                                <th style="width: 10%">Martes</th>
                                <th style="width: 10%">Miercoles</th>
                                <th style="width: 10%">Jueves</th>
                                <th style="width: 10%">Viernes</th>
                                <th style="width: 10%">Sabado</th>
                                <th style="width: 10%">Domingo</th>
                            </tr>
                             <tr style=" height: 20%">
                                <td style="width: 20%;background-color: #FB9D00">4to/6to</td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowl[$i]['cto_shift']=="4" || $rowl[$i]['cto_shift']=="6"){ $html.=$rowl[$i]['cto_qty'];}} $html.='" type="text" name="i1" id="i1" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowm[$i]['cto_shift']=="4" || $rowm[$i]['cto_shift']=="6"){ $html.=$rowm[$i]['cto_qty'];}} $html.='" type="text" name="i2" id="i2" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowx[$i]['cto_shift']=="4" || $rowx[$i]['cto_shift']=="6"){ $html.=$rowx[$i]['cto_qty'];}} $html.='" type="text" name="i3" id="i3" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowj[$i]['cto_shift']=="4" || $rowj[$i]['cto_shift']=="6"){ $html.=$rowj[$i]['cto_qty'];}} $html.='" type="text" name="i4" id="i4" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowv[$i]['cto_shift']=="4" || $rowv[$i]['cto_shift']=="6"){ $html.=$rowv[$i]['cto_qty'];}} $html.='" type="text" name="i5" id="i5" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rows[$i]['cto_shift']=="4" || $rows[$i]['cto_shift']=="6"){ $html.=$rows[$i]['cto_qty'];}} $html.='" type="text" name="i6" id="i6" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowd[$i]['cto_shift']=="4" || $rowd[$i]['cto_shift']=="6"){ $html.=$rowd[$i]['cto_qty'];}} $html.='" type="text" name="i7" id="i7" maxlength="3" class="inputcum" readonly></div></td>
                               
                            </tr>
                             <tr style=" height: 20%">
                                <td style="width: 20%;background-color: #FB9D00">5to/7mo</td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowl[$i]['cto_shift']=="5" || $rowl[$i]['cto_shift']=="7"){ $html.=$rowl[$i]['cto_qty'];}} $html.='" type="text" name="i8" id="i8" maxlength="3" class="inputcum"   readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowm[$i]['cto_shift']=="5" || $rowm[$i]['cto_shift']=="7"){ $html.=$rowm[$i]['cto_qty'];}} $html.='" type="text" name="i9" id="i9" maxlength="3" class="inputcum"   readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowx[$i]['cto_shift']=="5" || $rowx[$i]['cto_shift']=="7"){ $html.=$rowx[$i]['cto_qty'];}} $html.='" type="text" name="i10" id="i10" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowj[$i]['cto_shift']=="5" || $rowj[$i]['cto_shift']=="7"){ $html.=$rowj[$i]['cto_qty'];}} $html.='" type="text" name="i11" id="i11" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowv[$i]['cto_shift']=="5" || $rowv[$i]['cto_shift']=="7"){ $html.=$rowv[$i]['cto_qty'];}} $html.='" type="text" name="i12" id="i12" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rows[$i]['cto_shift']=="5" || $rows[$i]['cto_shift']=="7"){ $html.=$rows[$i]['cto_qty'];}} $html.='" type="text" name="i13" id="i13" maxlength="3" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="';for($i=0;$i<=1;$i++){if($rowd[$i]['cto_shift']=="5" || $rowd[$i]['cto_shift']=="7"){ $html.=$rowd[$i]['cto_qty'];}} $html.='" type="text" name="i14" id="i14" maxlength="3" class="inputcum" readonly></div></td>
                               </tr>
                             <tr style=" height: 20%">
                                <td style="width: 20%;background-color: #FB9D00">Real</td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.($rowl[0]['cto_qty']+$rowl[1]['cto_qty']).'" type="text" name="i15" id="i15"  class="inputcum" readonly style="';if( ($rowl[0]['cto_qty'] + $rowl[1]['cto_qty']) >= $plannew['lunes']){$html.="color:#18dd3f";}else {$html.= "color:#ff001a";} $html.= '"></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.($rowm[0]['cto_qty']+$rowm[1]['cto_qty']).'" type="text" name="i16" id="i16"  class="inputcum" readonly style="';if( ($rowm[0]['cto_qty'] + $rowm[1]['cto_qty']) >= $plannew['martes']) {$html.= "color:#18dd3f";}else {$html.= "color:#ff001a";}$html.= '"></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.($rowx[0]['cto_qty']+$rowx[1]['cto_qty']).'" type="text" name="i17" id="i17"  class="inputcum" readonly style="';if( ($rowx[0]['cto_qty'] + $rowx[1]['cto_qty']) >= $plannew['miercoles']) {$html.= "color:#18dd3f";}else {$html.= "color:#ff001a";}$html.= '"></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.($rowj[0]['cto_qty']+$rowj[1]['cto_qty']).'" type="text" name="i18" id="i18"  class="inputcum" readonly style="';if( ($rowj[0]['cto_qty'] + $rowj[1]['cto_qty']) >= $plannew['jueves']) {$html.= "color:#18dd3f";}else {$html.= "color:#ff001a";}$html.= '"></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.($rowv[0]['cto_qty']+$rowv[1]['cto_qty']).'" type="text" name="i19" id="i19"  class="inputcum" readonly style="';if( ($rowv[0]['cto_qty'] + $rowv[1]['cto_qty']) >= $plannew['viernes']) {$html.= "color:#18dd3f";}else {$html.= "color:#ff001a";}$html.= '"></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.($rows[0]['cto_qty']+$rows[1]['cto_qty']).'" type="text" name="i20" id="i20"  class="inputcum" readonly style="';if( ($rows[0]['cto_qty'] + $rows[1]['cto_qty']) >= $plannew['sabado']) {$html.= "color:#18dd3f";}else {$html.= "color:#ff001a";}$html.= '"></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.($rowd[0]['cto_qty']+$rowd[1]['cto_qty']).'" type="text" name="i21" id="i21"  class="inputcum" readonly style="';if( ($rowd[0]['cto_qty'] + $rowd[1]['cto_qty']) >= $plannew['domingo']) {$html.= "color:#18dd3f";}else {$html.= "color:#ff001a";}$html.= '"></div></td>
                            </tr>
                             <tr style=" height: 20%">
                                <td style="width: 20%;background-color: #FB9D00">Plan</td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.$plannew['lunes'].'" type="text" name="i22" id="i22" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.$plannew['martes'].'" type="text" name="i23" id="i23" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.$plannew['miercoles'].'"  type="text" name="i24" id="i24" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.$plannew['jueves'].'" type="text" name="i25" id="i25" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.$plannew['viernes'].'" type="text" name="i26" id="i26" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.$plannew['sabado'].'" type="text" name="i27" id="i27" class="inputcum" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="'.$plannew['domingo'].'" type="text" name="i28" id="i28" class="inputcum" readonly></div></td>
                            </tr>
                                                        </table>
                                                        </center>
                                                     
                                                    </div>';
             $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 3:
            $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/calidad/calidad.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
            $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'calidad\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
            break;
         case 4:
              $andon = new Andon();
             $plan=$andon->getActionPlan($id_line);
             $row = $plan->fetchAll();
             
             $html='<form name="Aplan" id="Aplan"><div style="width: 98%;height: 98%;" >
                                                        <label style="font-weight: bold;font-size: 1.5em;padding-left:20px">Plan de Acci&oacute;n</label>
                                                        <label style="font-weight: bold;font-size: 1em">Action plan</label> 
                                                        <center><form id="actions">
                                                        <table  border="1" class="table_plan" style="margin: 0 auto;text-align: center;font-size:1em;width: 98%;height:90%;font-weight: bold;table-layout: fixed" >
                                                             
                                                            <tr style="width: 20%;background-color: #FB9D00;color: #FFFFFF">
                                                                <th style="width: 3%"  >Ref. Nr</th>
                                                                <th style="width: 30%" >Issue</th>
                                                                <th style="width: 30%" >Action</th>
                                                                <th style="width: 20%" >Responsible</th>
                                                                <th style="width: 10%" >Due Date</th>
                                                                <th style="width: 7%"  >Status</th>                                                            
                                                            </tr>';
                                                              
                                                            for($i=0;$i<=11;$i++){
                                                                $x=$i+1;
                                                                
                                                                if($row[$i]['acp_statusa']){$clase1="activo";}else{$clase1="pasivo";}
                                                                if($row[$i]['acp_statusb']){$clase2="activo";}else{$clase2="pasivo";}
                                                                if($row[$i]['acp_statusc']){$clase3="activo";}else{$clase3="pasivo";}
                                                                if($row[$i]['acp_statusd']){$clase4="activo";}else{$clase4="pasivo";}
                
                                                                                 $html.='
                                                                <tr>
                                                                <td style="width: 10%;"><div style=" width: 100%;height:100%"><input id="row'.$i.'" name="row'.$i.'" style=" width: 100%;height:100%;font-size: 1em; border: none;" type="text" width="100%" value="'.$x.'" readonly></div></td>
                                                                <td style="width: 10%;"><div style=" width: 100%;height:100%"><input id="issue'.$i.'" name="issue'.$i.'" style=" width: 100%;height:100%;font-size: .7em; border: none;" type="text" width="100%" value="'.utf8_decode($row[$i]['acp_issue']).'" ></div></td>
                                                                <td style="width: 10%;"><div style=" width: 100%;height:100%"><input id="action'.$i.'" name="action'.$i.'" style=" width: 100%;height:100%;font-size: .7em; border: none;" type="text" width="100%" value="'.utf8_decode($row[$i]['acp_action']).'" ></div></td>
                                                                <td style="width: 10%;"><div style=" width: 100%;height:100%"><input id="resp'.$i.'" name="resp'.$i.'" style=" width: 100%;height:100%;font-size: 1em; border: none;" type="text" width="100%" value="'.$row[$i]['acp_responsable'].'" ></div></td>
                                                                <td style="width: 10%;"><div style=" width: 100%;height:100%"><input type="text"  readonly name="dd'.$i.'" id="dd'.$i.'" onclick="displayCalendar(document.forms[0].dd'.$i.',\'yyyy-mm-dd \',this)" style=" width:100%;height:100%;font-size: 1em; border: none;cursor:pointer" value="'.$row[$i]['acp_due_date'].'" ></div></td>
                                                                <td style="width: 10%;">
                                                                <table border="1" >
                                                                <tr>
                                                                <td><input class="'.$clase1.'" id="tdP'.$i.'" name="tdP'.$i.'" onclick="xajax_statusChange(1,'.$i.',xajax.getFormValues(\'Aplan\'),'.$id_line.')" value="P" readonly></td><td><input class="'.$clase2.'" id="tdD'.$i.'" name="tdD'.$i.'" onclick="xajax_statusChange(2,'.$i.',xajax.getFormValues(\'Aplan\'),'.$id_line.')"  value="D" readonly></td>
                                                                </tr>
                                                                <tr>
                                                                <td ><input class="'.$clase3.'" id="tdC'.$i.'" name="tdC'.$i.'" onclick="xajax_statusChange(3,'.$i.',xajax.getFormValues(\'Aplan\'),'.$id_line.')"  value="C"  readonly></td><td><input class="'.$clase4.'" id="tdA'.$i.'" name="tdA'.$i.'" onclick="xajax_statusChange(4,'.$i.',xajax.getFormValues(\'Aplan\'),'.$id_line.')"  value="A"  readonly></td>
                                                                </tr>
                                                                </table>
                                                                </td>
                                                                <td><img style="cursor:pointer" src="/images/delete.png" onclick="xajax_Delete('.$row[$i]['acp_id'].','.$id_line.')">
                                                               
                                                                </td>
                                                            </tr> ';
                                                                
                                                            }
                                                            
                                                           
                                                        $html.=' 
                                                        </table>
                                                        </form>
                                                        </center>
                                                        <table style=" font-size: 1em; width: 100%">
                                                            <tr>
                                                                <td>Legend:</td>
                                                                <td>1. Plan (Problema identificado y analizado)</td>
                                                                <td>2. Do (Implementaci&oacute;n)</td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>3. Check (Resultado y medici&oacute;n comparado con el esperado)</td>
                                                                <td >4. Act (Soluci&oacute;n completamente implementada)</td>
                                                            </tr>
                                                        </table>
                                                    </div></form>';
                                                        $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 5:
            // $objResponse->addAlert("$id_line");
             $html='<iframe src="scrap.php?tipo=SCRAP&id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>';
            // $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'scrap\','.$id_proj.','.$id_line.')"></div>';
             $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 6:
              $html='<iframe src="grafica.php?tipo=BTS&id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>';
            // $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'bts\','.$id_proj.','.$id_line.')"></div>';
           $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 7:
             $html='<iframe src="grafica.php?tipo=OEE&id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>';
            // $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'oee\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 8:
              $html='<iframe src="grafica.php?tipo=FPY&id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>';
            // $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'fpy\','.$id_proj.','.$id_line.')"></div>';
             $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 9:
             $html='<iframe src="arrastre.php?id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>';
             $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;          
         case 10:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/5s/5s.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'5s\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 11:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/opl/opl.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'opl\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 12:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/fuguai/fuguai.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'fuguai\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 13:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/tpm/tpm.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'tpm\','.$id_proj.','.$id_line.')"></div>';
             $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 14:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/lpa/lpa.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'lpa\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 15:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/pokayokes/pokayokes.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'pokayokes\','.$id_proj.','.$id_line.')"></div>';
             $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 16:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/matrix/matrix.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'matrix\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 17:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/ead/ead.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'ead\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 18:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/obc/obc.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'obc\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 19:
            $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/cliente/cliente.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
            $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'cliente\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 20:
             $html=' <br><br><div style="width:1123px; height:660px;font-size: 1.5em;overflow:auto"><center>
                      <form id="jidoka" name="jidoka">
                      <table border="1" style=" height:450px;900px;">
                          <tr style=" background-color: #d0d0d0;font-size:1em; text-align:center">
                              <td colspan="5">
                                  Lider de l&iacute;nea
                              </td>
                               <td colspan="3">
                                  Responsable(operador, mantenimiento, procesos)
                              </td>
                               <td colspan="2">
                                   L&iacute;der de l&iacute;nea
                              </td>
                               <td colspan="4">
                                   Ingeniero de Calidad o T&eacute;cnico de Calidad
                              </td>
                          </tr>
                            <tr  style=" font-size:.6em; text-align:center">
                            <td  style="width:30px">Fecha y hora</td>
                            <td  style=" background-color: #f1ef6a;width:30px">Turno</td>
                            <td  style="width:30px">Problema/Defecto<br>Que? Como?<br>(N&uacute;mero de PRR s&oacute;lo para productos GM)</td> 
                            <td  style=" background-color: #f1ef6a;width:30px">Estaci&oacute;n</td>
                            <td  style="width:30px">Cu&aacute;ntos</td>
                            <td  style=" background-color: #f1ef6a;width:30px">Causa Raiz</td>
                            <td  style="width:30px">Acci&oacute;n correctiva y/o contenci&oacute;n</td>
                            <td  style="width:30px">Responsable (quien ejecuta la acci&oacute;n)</td>
                            <td  style="background-color: #f1ef6a;width:30px">Nombre y firma de lider de linea</td>
                            <td  style="background-color: #f1ef6a;width:30px">Fecha y hora (acci&oacute;n realizada)</td>
                            <td  style="width:30px">Tipo de evento</td>   
                            <td  style="width:30px">Documento a actualizar (si aplica)</td> 
                            <td  style="width:30px">Fecha de modificaci&oacute;n de docuemento</td> 
                            <td  style="width:30px">Status de modificaci&oacute;n de documento (Abierto / Cerrado)</td> 
                            <td  style="width:30px">Acci&oacute;n</td> 
                          </tr>';
                                $andon = new Andon();
                                $i=1;
                            $array=$andon->getFormatJidokaById($id_line);
                           while($row = $array->fetchRow()){           
                            $html.='
                            <tr>     
                            <td>                            
<input id="datel'.$i.'" name="datel'.$i.'" type="text"  style=" border: none;cursor:pointer" value="'.$row['fjk_date_ini'].'">
                            <table>
                            <tr>
                            <td style="width:60%"><input id="datel'.$i.'" name="datel'.$i.'" type="text"  style="cursor:pointer" readonly onclick="displayCalendar(document.forms[0].datelnew,\'yyyy-mm-dd\',this)"></td>
                            <td style="width:20%"><select id="selhnew" name="selhnew" ><option>H</option>';
                          for($x=0;$x<24;$x++){
                              if($x<10){
                                  $h="0".$x;
                              }else{$h="$x";}
                            $html.='<option value="'.$h.'">'.$h.'</option>';
                          }
                           $html.=' </select></td>
                            <td style="width:20%"><select id="selminnew" name="selminnew" ><option>m</option>';
                          for($x=0;$x<60;$x++){
                              if($x<10){
                                  $h="0".$x;
                              }else{$h="$x";}
                              
                            $html.='<option value="'.$h.'">'.$h.'</option>';
                          }
                           $html.=' </select></td>
                            </tr>
                            </table>   

</td>
                            <td  style=" background-color: #f1ef6a"><select id="sels'.$i.'" name="sels'.$i.'">';                               
                            

                            if($row['fjk_shift']!=4){  $html.='<option value="4">4</option>';}else{$html.='<option value="4" selected>4</option>';}
                            if($row['fjk_shift']!=5){  $html.='<option value="5">5</option>';}else{$html.='<option value="5" selected>5</option>';}
                            if($row['fjk_shift']!=6){  $html.='<option value="6">6</option>';}else{$html.='<option value="6" selected>6</option>';}
                            if($row['fjk_shift']!=7){  $html.='<option value="7">7</option>';}else{$html.='<option value="7" selected>7</option>';}
                            
                              $html.='</select></td>
                            <td>
                                 <textarea id="textp'.$i.'" name="textp'.$i.'" rows="7" cols="40" >'.$row['fjk_problem'].'</textarea>
                            </td> 
                            <td style=" background-color: #f1ef6a">
                                 <input id="inpute'.$i.'" name="inpute'.$i.'"  type="text" style="background-color:#f1ef6a" value="'.$row['fjk_station'].'">
                            </td>
                            <td>
                                 <input id="inputc'.$i.'" name="inputc'.$i.'" type="text" onKeyPress="return soloNumeros(event)" value="'.$row['fjk_count'].'">
                            </td>
                            <td style=" background-color: #f1ef6a">
                                 <textarea id="textc'.$i.'" name="textc'.$i.'" rows="7" cols="40" style="background-color:#f1ef6a">'.$row['fjk_root_cause'].'</textarea>                                                                                            
                            </td>
                            <td>
                                 <textarea id="texta'.$i.'" name="texta'.$i.'" rows="7" cols="40" >'.$row['fjk_corrective_action'].'</textarea>
                            </td>
                            <td>
                                 <input id="inputr'.$i.'" name="inputr'.$i.'" type="text"  value="'.$row['fjk_responsible'].'">
                            </td>
                            <td style=" background-color: #f1ef6a">
                                 <input id="inputn'.$i.'" name="inputn'.$i.'" type="text" style="background-color:#f1ef6a" value="'.$row['fjk_leader_name'].'">
                            </td>
                            <td style=" background-color: #f1ef6a">
                                  <input id="dateh'.$i.'" name="dateh'.$i.'" type="text" style=" border: none;cursor:pointer;background-color:#f1ef6a" value="'.$row['fjk_date_fin'].'">
                            </td>
                            <td >
                               <table border="0" style="width:100%;height:98%;font-size:.8em">
                                    <tr>
                                       <td> Producci&oacute;n  </td>';
                              
                                        if($row['fjk_event_type']!="Produccion"){  $html.='<td><input type="checkbox" name="chekType'.$i.'" value="Produccion" ></td>';}else{$html.='<td><input type="checkbox" name="chekType'.$i.'" value="Produccion" checked></td>';}
                                                                               
                                  $html.='</tr>
                                    <tr>
                                       <td>0KM</td>';
                                  
                                       if($row['fjk_event_type']!="0km"){  $html.='<td><input type="checkbox" name="chekType'.$i.'" value="0km" ></td>';}else{$html.='<td><input type="checkbox" name="chekType'.$i.'" value="0km" checked></td>';}
                                 
                                       $html.='</tr>
                                    <tr>
                                       <td>Garant&iacute;as</td>';
                                       
                                       if($row['fjk_event_type']!="Garantias"){  $html.='<td><input type="checkbox" name="chekType'.$i.'" value="Garantias" ></td>';}else{$html.='<td><input type="checkbox" name="chekType'.$i.'" value="Garantias" checked></td>';}
                                  
                                       $html.='</tr>
                               </table>
                            </td>   
                            <td>
                              <table border="0" style="width:100%;height:98%;font-size:.5em">
                                    <tr>
                                       <td> CP  </td>';
                                       $doctos=explode(" ",$row['fjk_document']);
                                       $vala="";$valb="";$valc="";$vald="";$vale="";
                                       foreach ($doctos as $doc) {
                                           
                                           if($doc=="CP"){$vala="checked";}
                                           if($doc=="AMEF"){$valb="checked";}
                                           if($doc=="LPA"){$valc="checked";}
                                           if($doc=="LP"){$vald="checked";}
                                           if($doc=="Pokayoke"){$vale="checked";}
                                           
                                       }
                                       
                                      $html.='<td><input type="checkbox"  name="chekDoc'.$i.'[]" value="CP" '.$vala.'></td>
                                    </tr>
                                    <tr>
                                       <td>AMEF</td>
                                       <td><input type="checkbox"  name="chekDoc'.$i.'[]" value="AMEF" '.$valb.'></td>
                                    </tr>
                                    <tr>
                                       <td>LPA</td>
                                       <td><input type="checkbox" name="chekDoc'.$i.'[]" value="LPA" '.$valc.'></td>
                                    </tr>
                                     <tr>
                                       <td>Lecci&oacute;n aprendida</td>
                                       <td><input type="checkbox"  name="chekDoc'.$i.'[]" value="LP" '.$vald.'></td>
                                    </tr>
                                     <tr>
                                       <td>Pokayoke</td>
                                       <td><input type="checkbox"  name="chekDoc'.$i.'[]" value="Pokayoke" '.$vale.'></td>
                                    </tr>
                                   
                               </table>
                            </td> 
                            <td><input type="date" style=" border: none;cursor:pointer;" id="datem'.$i.'" name="datem'.$i.'" value="'.$row['fjk_date_document_modif'].'"></td> 
                            <td>
                            <select onchange="xajax_saveFJ(xajax.getFormValues(\'jidoka\'),'.$i.','.$id_line.')" id="selm'.$i.'" name="selm'.$i.'"><option value="0">Seleccionar</option>';
                             
                            if($row['fjk_document_status_modif']!="Abierto"){  $html.='<option value="Abierto">Abierto</option>';}else{$html.='<option value="Abierto" selected>Abierto</option>';}
                            if($row['fjk_document_status_modif']!="Cerrado"){  $html.='<option value="Cerrado">Cerrado</option>';}else{$html.='<option value="Cerrado" selected>Cerrado</option>';}
                                                              
                            $html.='</select>
                            </td>
                            <td><input type="button" value="Actualizar" onclick="xajax_saveFJ(xajax.getFormValues(\'jidoka\'),'.$i.','.$id_line.')"></td>
                             </tr>        
                           ';
                            $i++;                            
                            }
                          $html.='
                            <tr>     
                            <td>
                            <table>
                            <tr>
                            <td style="width:60%"><input id="datelnew" name="datelnew" type="text"  style="cursor:pointer" readonly onclick="displayCalendar(document.forms[0].datelnew,\'yyyy-mm-dd\',this)"></td>
                            <td style="width:20%"><select id="selhnew" name="selhnew" ><option>H</option>';
                          for($x=0;$x<24;$x++){
                              if($x<10){
                                  $h="0".$x;
                              }else{$h="$x";}
                            $html.='<option value="'.$h.'">'.$h.'</option>';
                          }
                           $html.=' </select></td>
                            <td style="width:20%"><select id="selminnew" name="selminnew" ><option>m</option>';
                          for($x=0;$x<60;$x++){
                              if($x<10){
                                  $h="0".$x;
                              }else{$h="$x";}
                              
                            $html.='<option value="'.$h.'">'.$h.'</option>';
                          }
                           $html.=' </select></td>
                            </tr>
                            </table>                       
                            </td>
                            <td style=" background-color: #f1ef6a"><select id="selsnew" name="selsnew">
                            <option value="0">Seleccionar</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            
                            </select></td>
                            <td>
                                 <textarea id="textpnew" name="textpnew" rows="7" cols="40" ></textarea>
                            </td> 
                            <td style=" background-color: #f1ef6a">
                                 <input id="inputenew" name="inputenew"  type="text" style="background-color:#f1ef6a" >
                            </td>
                            <td>
                                 <input id="inputcnew" name="inputcnew" type="text" onKeyPress="return soloNumeros(event)" >
                            </td>
                            <td style=" background-color: #f1ef6a">
                                 <textarea id="textcnew" name="textcnew" rows="7" cols="40" style="background-color:#f1ef6a"></textarea>                                                                                            
                            </td>
                            <td>
                                 <textarea id="textanew" name="textanew" rows="7" cols="40" ></textarea>
                            </td>
                            <td>
                                 <input id="inputrnew" name="inputrnew" type="text" >
                            </td>
                            <td style=" background-color: #f1ef6a">
                                 <input id="inputnnew" name="inputnnew" type="text" style="background-color:#f1ef6a" >
                            </td>
                            <td style=" background-color: #f1ef6a">
                             <table>
                            <tr>
                            <td style="width:60%"><input id="datehnew" name="datehnew" type="date"  style="cursor:pointer" style="background-color:#f1ef6a" ></td>
                            <td style="width:20%"><select id="selh2new" name="selh2new" style="background-color:#f1ef6a"><option>H</option>';
                          for($x=0;$x<24;$x++){
                              if($x<10){
                                  $h="0".$x;
                              }else{$h="$x";}
                            $html.='<option value="'.$h.'">'.$h.'</option>';
                          }
                           $html.=' </select></td>
                            <td style="width:20%"><select id="selmi2new" name="selmi2new" style="background-color:#f1ef6a" ><option>:m</option>';
                          for($x=0;$x<60;$x++){
                              if($x<10){
                                  $h="0".$x;
                              }else{$h="$x";}
                            $html.='<option value="'.$h.'">'.$h.'</option>';
                          }
                           $html.=' </select></td>
                            </tr>
                            </table>  
                            </td>
                            <td >
                               <table border="0" style="width:100%;height:98%;font-size:.8em">
                                    <tr><td>Producci&oacute;n</td><td><input type="checkbox" name="chekTypenew" value="Produccion" ></td></tr>
                                    <tr><td>0KM</td><td><input type="checkbox" name="chekTypenew" value="0km" ></td></tr>
                                    <tr><td>Garant&iacute;as</td><td><input type="checkbox" name="chekTypenew" value="Garantias" ></td></tr>
                               </table>
                            </td>   
                            <td>
                              <table border="0" style="width:100%;height:98%;font-size:.5em">
                                    <tr><td>CP</td><td><input type="checkbox"  name="chekDocnew[]" value="CP"></td></tr>
                                    <tr><td>AMEF</td><td><input type="checkbox"  name="chekDocnew[]" value="AMEF" ></td></tr>
                                    <tr><td>LPA</td><td><input type="checkbox" name="chekDocnew[]" value="LPA" ></td></tr>
                                     <tr><td>Lecci&oacute;n aprendida</td><td><input type="checkbox" name="chekDocnew[]" value="LP" ></td></tr>
                                     <tr><td>Pokayoke</td><td><input type="checkbox"  name="chekDocnew[]" value="Pokayoke" ></td></tr>
                                   
                               </table>
                            </td> 
                            <td><input type="date" style=" border: none;cursor:pointer;" id="datemnew" name="datemnew" ></td> 
                            <td><select id="selmnew" name="selmnew">
                            <option value="0">Seleccionar</option>
                            <option value="Abierto">Abierto</option>
                            <option value="Cerrado">Cerrado</option>
                            </select>
                            </td>
                            <td><input type="button" value="Guardar" onclick="xajax_saveFJ(xajax.getFormValues(\'jidoka\'),'.$id_line.')"></td>
                             </tr> ';
            $html.='</table></form>
              </div></center>';
            $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 21:
            $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/piloto/piloto.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
            $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'piloto\','.$id_proj.','.$id_line.')"></div>';
            $objResponse->addAssign("boton", "style.visibility", "visible");
            break;
         case 22:
             $html='<iframe src="/doctos/'.$id_proj.'/'.$id_line.'/critparo/critparo.pdf" width="100%" height="100%" frameborder="0" ></iframe>';
             $html2='<div style="padding-left:10px"><input type="button" class="btn" name="pdf" id="pdf" value="Cargar nuevo pdf" onclick="xajax_uploadPdf(\'critparo\','.$id_proj.','.$id_line.')"></div>';
             $objResponse->addAssign("boton", "style.visibility", "visible");
             break;
         case 23:
             $html="<iframe src='/Andon/andon.php?idline=$id_line&idproject=$id_proj' width='100%' height='100%' frameborder='0' ></iframe>";
             $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 24:
             $html="<iframe src='/horaxhora/index.php?idline=$id_line&idproject=$id_proj' width='100%' height='100%' frameborder='0' ></iframe>";
             $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
         case 25:
             $html="<iframe src='/pulse/index.php?idline=$id_line&idproject=$id_proj' width='100%' height='100%' frameborder='0' ></iframe>";
             $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
          case 26:
             $html="<iframe src='/Pizarron/plan.php?id_line=$id_line&idproject=$id_proj' width='100%' height='100%' frameborder='0' ></iframe>";
             $objResponse->addAssign("boton", "style.visibility", "hidden");
             break;
     }
    
     $objResponse->addAssign("div_iframe", "innerHTML", $html);
     $objResponse->addAssign("boton", "innerHTML", $html2);
     
     return $objResponse->getXML();
}
function login($text,$id){
   // Edit zone
   
   $html = Table::Top($text);  // <-- Set the title for your form.
   $html .= Andon::formAdd($id);  // <-- Change by your method
   // End edit zone
  $html .= Table::Footer();
   $objResponse = new xajaxResponse();
   $objResponse->addAssign("formDiv", "style.visibility", "visible");
   $objResponse->addAssign("formDiv", "innerHTML", $html);

   return $objResponse->getXML();
}
function CertLogin($id,$id_line){
   // Edit zone
   
   $html = Table::Top("Login");  // <-- Set the title for your form.
   $html .= Andon::formLogin($id,$id_line);  // <-- Change by your method
   // End edit zone
  $html .= Table::Footer();
   $objResponse = new xajaxResponse();
   $objResponse->addAssign("formDiv", "style.visibility", "visible");
   $objResponse->addAssign("formDiv", "innerHTML", $html);

   return $objResponse->getXML();
}
function validarUid($id,$line,$f){
    $andon= new Andon();
        
   $objResponse = new xajaxResponse();
   $ui=$andon->getuid($f['uid']);
   $row=$ui->fetchRow();
   if(!$row['personnel']){
       $objResponse->addAlert("Numero de Personal no existe!");
       $objResponse->addScript("document.getElementById('uid').value='';");
   }else{
       if($id==1){
            $objResponse->addAssign("manto", "value", "Mantenimiento");
            $andon->DelSupport($line, "Mantenimiento");             
            $objResponse->addAssign("manto", "className", "btn1");  
             $andon->updateStatusLine($line, "","");
         }
       if($id==2){
             $objResponse->addAssign("procesos", "value", "Procesos");
             $andon->DelSupport($line, "Procesos");             
             $objResponse->addAssign("procesos", "className", "btn1");
             $andon->updateStatusLine($line, "","");
         }
         if($id==3){
             $objResponse->addAssign("calidad", "value", "Calidad");
             $andon->DelSupport($line, "Calidad");             
             $objResponse->addAssign("calidad", "className", "btn1");  
             $andon->updateStatusLine($line, "","");
         }
         if($id==4){
             $objResponse->addAssign("mate", "value", "Materialistas");
             $andon->DelSupport($line, "Materialistas");             
             $objResponse->addAssign("mate", "className", "btn1");  
             $andon->updateStatusLine($line, "","");
         }
         if($id==5){
             $objResponse->addAssign("fm", "value", "FM");
             $andon->DelSupport($line, "FM");             
             $objResponse->addAssign("fm", "className", "btn1");  
             $andon->updateStatusLine($line, "","");
         }
         if($id==6){
             $objResponse->addAssign("ihm", "value", "IHM");
             $andon->DelSupport($line, "IHM");             
             $objResponse->addAssign("ihm", "className", "btn1");  
             $andon->updateStatusLine($line, "","");
         }
         if($id==7){
             $objResponse->addAssign("control", "value", "Control de Produccion");
             $andon->DelSupport($line, "Control de Produccion");             
             $objResponse->addAssign("control", "className", "btn1");  
             $andon->updateStatusLine($line, "","");
         }
         if($id==8){
             $objResponse->addAssign("prod", "value", "Produccion");
             $andon->DelSupport($line, "Produccion");             
             $objResponse->addAssign("prod", "className", "btn1"); 
            $andon->updateStatusLine($line, "","");
         }
         if($id==9){
             $objResponse->addAssign("it", "value", "IT");
             $andon->DelSupport($line, "IT");             
             $objResponse->addAssign("it", "className", "btn1");  
             $andon->updateStatusLine($line, "","");
         }
         
         $objResponse->addScript("document.getElementById('uid').value='';");
            
        $objResponse->addAssign("formDiv", "style.visibility","hidden");
      
   }
   
   return $objResponse->getXML();
}
function submitLogin($f,$id){
    global $user;
    $objResponse = new xajaxResponse();
      
    if(empty($f['username'])){ 
      $objResponse->addAlert("Ingrese su username");
      $objResponse->addScript("document.getElementById('username').focus();");
      return $objResponse->getXML();
    } 
    if(empty($f['password'])) { 
      $objResponse->addAlert("Ingrese su password");
      $objResponse->addScript("document.getElementById('password').focus();");
      return $objResponse->getXML();
    } 

    if(!Basic::checkContent($f['username'])){
      Basic::EventLog("Intento ingresar Sentencia SQL en el username: ".$f['username']);
      return $objResponse->getXML();
    }
    if(!Basic::checkContent($f['password'])) {
      Basic::EventLog("Intento ingresar Sentencia SQL en el password: ".$f['password']);
      return $objResponse->getXML();
    }

    session_start(); // Import value from auth.php->Url Path

     $url = $_SESSION["var"];
    if($user->loginOk($f['username'],$f['password'])){
         $perm = $user->checkPerms('Andon');
         
        switch ($id){
            case 1:
              if($perm == "QualityEngineer" | $perm == "Administrator"){
                      
        $objResponse->addAssign("resp", "disabled", false);
        $objResponse->addAssign("ext", "disabled", false);
        $objResponse->addAssign("day", "disabled", false);
        $objResponse->addAssign("logro", "disabled", false);
        $objResponse->addAssign("meta", "disabled", false);
        
        $objResponse->addScript("document.getElementById('username').value='';");
        $objResponse->addScript("document.getElementById('password').value='';");
        
        $objResponse->addAssign("formDiv", "style.visibility","hidden");}
        else {
         $objResponse->addAlert("No Tiene Permisos para realizar esta accion");
         $objResponse->addScript("document.getElementById('username').value='';");
         $objResponse->addScript("document.getElementById('password').value='';");
        }
          break;
          
          case 2:
              if($perm == "Manufacture" | $perm == "Administrator"){
                      
                  for($i=0;$i<=28;$i++){
                      $objResponse->addAssign("i$i", "disabled", false);
                  }
                
        $objResponse->addScript("document.getElementById('username').value='';");
        $objResponse->addScript("document.getElementById('password').value='';");
        
        $objResponse->addAssign("formDiv", "style.visibility","hidden");}
        else {$objResponse->addAlert("No Tiene Permisos para realizar esta accion");}
          break;
         case 3:
              if($perm == "Manufacture" | $perm == "Administrator"){
                      
                  for($i=0;$i<=11;$i++){
                      $objResponse->addAssign("issue$i", "disabled", false);
                      $objResponse->addAssign("action$i", "disabled", false);
                      $objResponse->addAssign("resp$i", "disabled", false);
                      $objResponse->addAssign("status$i", "disabled", false);
                      $objResponse->addAssign("tdP$i", "disabled", false);
                      $objResponse->addAssign("tdD$i", "disabled", false);
                      $objResponse->addAssign("tdA$i", "disabled", false);
                      $objResponse->addAssign("tdC$i", "disabled", false);
                  }
                
        $objResponse->addScript("document.getElementById('username').value='';");
        $objResponse->addScript("document.getElementById('password').value='';");
        
        $objResponse->addAssign("formDiv", "style.visibility","hidden");}
        else {
            $objResponse->addAlert("No Tiene Permisos para realizar esta accion");
            $objResponse->addScript("document.getElementById('username').value='';");
           $objResponse->addScript("document.getElementById('password').value='';");
        }
         $objResponse->addAssign("formDiv", "innerHTML", "");
          break;
          
        
        }
              
      
          //$objResponse->addScript('window.location = "'. $url .'"');
    }else{
      $objResponse->addAlert("Error: Ingrese sus datos correctamente");
      $objResponse->addAssign("username","value","");
      $objResponse->addAssign("password","value","");
      $objResponse->addScript("document.getElementById('username').focus();");
    }
    
    return $objResponse->getXML();
   }
function update($f,$id_line,$n){
    $andon= new Andon();
        
   $objResponse = new xajaxResponse();
    
   switch ($n){
    case 1:
     $day=$andon->getDaysById($id_line, "responsable");
      $row=$day->fetchRow();
      if(!$row['lnp_name']){
     $andon->setDays($id_line, "responsable",$f);
       }else{
       $andon->updateDays($id_line, "responsable",$f);}
   break;
    case 2:
        $day=$andon->getDaysById($id_line, "ext");
      $row=$day->fetchRow();
      if(!$row['lnp_name']){
     $andon->setDays($id_line, "ext",$f);
       }else{
       $andon->updateDays($id_line, "ext",$f);}
  
   break;
    case 3:
   $day=$andon->getDaysById($id_line, "day");
      $row=$day->fetchRow();
      if(!$row['lnp_name']){
     $andon->setDays($id_line, "day",$f);
       }else{
       $andon->updateDays($id_line, "day",$f);}
        $objResponse->addScript("xajax_mostrar(0,0,'$id_line')");
   break;
    case 4:
   $day=$andon->getDaysById($id_line, "logro");
      $row=$day->fetchRow();
      if(!$row['lnp_name']){
     $andon->setDays($id_line, "logro",$f);
       }else{
       $andon->updateDays($id_line, "logro",$f);}
       
        $objResponse->addScript("xajax_mostrar(0,0,'$id_line')");
   break;
    case 5:
   $day=$andon->getDaysById($id_line, "meta");
      $row=$day->fetchRow();
      if(!$row['lnp_name']){
     $andon->setDays($id_line, "meta",$f);
       }else{
       $andon->updateDays($id_line, "meta",$f);}
   break;
   
   }
  
   return $objResponse->getXML();
}
function uploadPdf($pdf,$id_pfr,$id_line){
    $objResponse = new xajaxResponse();
    $html="<iframe src='/Pizarron/documents.php?pdf=$pdf&id_project=$id_pfr&idline=$id_line' width='100%' height='100%' frameborder='0' ></iframe>";
    $objResponse->addAssign("div_iframe", "innerHTML", $html);
    return $objResponse->getXML();
}
function setCumplimiento($id_line,$parameter,$dia,$valor){
    $objResponse = new xajaxResponse();
    $andon=new Andon();
    
   // $objResponse->addAlert("$id_pfr,$parameter,$dia,$valor");
   $param= $andon->getCumParameter($id_line, $parameter);
   $row=$param->fetchRow(); 
   //$objResponse->addAlert($row['cto_parameter']);
   if(!($row['cto_parameter'])){
       $andon->setCumplimiento($id_line, $parameter, $dia, $valor);
       $objResponse->addScript("xajax_mostrar(2,0,'$id_line')");
      
   }
   else{
       $andon->updateCumplimiento($id_line, $parameter, $dia, $valor);
        $objResponse->addScript("xajax_mostrar('2',0,'$id_line')");
   }
   
   
     return $objResponse->getXML();
}
function saveAction($f, $id_line,$x){
     $objResponse = new xajaxResponse();
     $andon = new Andon();
     $andon->setActionPlan($f["issue$x"], $f["action$x"], $f["resp$x"], $f["dd$x"], $f["status$x"], $id_line, $f["row$x"]);
     //$objResponse->addAlert($f['issue1']);
     
     return $objResponse->getXML();
}
function certificar($f,$id,$id_line){
    global $user;
    $objResponse = new xajaxResponse();
      
    if(empty($f['username'])){ 
      $objResponse->addAlert("Ingrese su username");
      $objResponse->addScript("document.getElementById('username').focus();");
      return $objResponse->getXML();
    } 
    if(empty($f['password'])) { 
      $objResponse->addAlert("Ingrese su password");
      $objResponse->addScript("document.getElementById('password').focus();");
      return $objResponse->getXML();
    } 

    if(!Basic::checkContent($f['username'])){
      Basic::EventLog("Intento ingresar Sentencia SQL en el username: ".$f['username']);
      return $objResponse->getXML();
    }
    if(!Basic::checkContent($f['password'])) {
      Basic::EventLog("Intento ingresar Sentencia SQL en el password: ".$f['password']);
      return $objResponse->getXML();
    }

    session_start(); // Import value from auth.php->Url Path

    if($user->loginOk($f['username'],$f['password'])){
         $perm = $user->checkPerms('Andon');
   
        if($perm == "AdminCBS" | $perm == "Administrator"){
                      
             $html = Table::Top("Certificacion");  // <-- Set the title for your form.
             $html .= Andon::formAddCert($id,$id_line);  // <-- Change by your method
   // End edit zone
             $html .= Table::Footer();             
             $objResponse->addAssign("formDiv", "style.visibility", "visible");
             $objResponse->addAssign("formDiv", "innerHTML", $html);
        
        $objResponse->addScript("document.getElementById('username').value='';");
        $objResponse->addScript("document.getElementById('password').value='';");
        
       }
        else {
            $objResponse->addAlert("No Tiene Permisos para realizar esta accion");
            $objResponse->addScript("document.getElementById('username').value='';");
            $objResponse->addScript("document.getElementById('password').value='';");
        }
         
          //$objResponse->addScript('window.location = "'. $url .'"');
    }else{
      $objResponse->addAlert("Error: Ingrese sus datos correctamente");
      $objResponse->addAssign("username","value","");
      $objResponse->addAssign("password","value","");
      $objResponse->addScript("document.getElementById('username').focus();");
    }
 
     
     return $objResponse->getXML();
}
function InsertCert($f,$id,$id_line){
    $andon = new Andon();
     $objResponse = new xajaxResponse();
           $hoy= $f['date'];   
           $meto=$f['meto'];
           $firma=$f['firma'];
           
           $param=$andon->getCertification($id_line,  $id);
           $row=$param->fetchAll();
              // $objResponse->addAlert($f['selCert']);
    switch ($f['selCert']){
         case 0:           
            $objResponse->addAssign("contDiv$id", "className", "blanc");
                       
            if(!$row[0]['lnp_name']){
            $andon->setCertification($id_line,"certification", "blanc", $id);}
            else{
                $andon->updateCertification($id_line, "certification", "blanc", $id);
            }     
            $meto=" ";
            $firma=" ";
            break;
        case 1:           
             $objResponse->addAssign("contDiv$id", "className", "bronce");
                       
            if(!$row[0]['lnp_name']){
            $andon->setCertification($id_line,"certification", "bronce", $id);}
            else{
                $andon->updateCertification($id_line, "certification", "bronce", $id);
            }
            
            break;
        case 2:
            
             $objResponse->addAssign("contDiv$id", "className", "silver");
            
            if(!$row[0]['lnp_name']){
            $andon->setCertification($id_line,"certification", "silver", $id);}
            else{
                $andon->updateCertification($id_line, "certification", "silver", $id);
            }
             
            break;
        case 3:
            
             $objResponse->addAssign("contDiv$id", "className", "gold");
            if(!$row[0]['lnp_name']){
            $andon->setCertification($id_line,"certification", "gold", $id);}
            else{
                $andon->updateCertification($id_line, "certification", "gold", $id);
            }
             
            
            break;
    }
             $objResponse->addAssign("meto$id", "innerHTML", $meto);
             $objResponse->addAssign("firma$id", "innerHTML", $firma);
             $objResponse->addAssign("da$id", "innerHTML", $hoy);
             
              if(!$row[1]['lnp_name']){
              $andon->setCertification($id_line,"metodologia", $meto, $id);}
            else{
                $andon->updateCertification($id_line, "metodologia", $meto, $id);
            }
             
              if(!$row[2]['lnp_name']){
               $andon->setCertification($id_line,"firma", $firma, $id);}
            else{
                $andon->updateCertification($id_line, "firma", $firma, $id);
            }
            
             if(!$row[3]['lnp_name']){
               $andon->setCertification($id_line,"fecha", $hoy, $id);}
            else{
                $andon->updateCertification($id_line, "fecha", $hoy, $id);
            }
             
             $objResponse->addAssign("formDiv", "style.visibility", "hidden");
            // $objResponse->addAssign("formDiv", "innerHTML", $html);
     
     return $objResponse->getXML();
}
function stop($monitor){
    
    $objResponse = new xajaxResponse();
   
    $celda = new Line();
    
    $arreglo=$celda->getSubareaByMonitor($monitor);
    
 $html='<select id="selmon" style=" font-size:1.8em; font-weight: bold;padding-left: 20px;cursor: pointer" onchange="xajax_Redirect(document.getElementById(\'selmon\').value,\''.$monitor.'\',\'true\')">'
         . '<option>Seleccionar Linea</option>';
    $x=0;
    while($row=$arreglo->fetchrow())
                {$html.='<option value="'.$x.'">'.$row['name'].'</option>'; $x++;}
           
            $html.="</select>";
    
    $objResponse->addAssign("titulo", "innerHTML", $html);
    
    return $objResponse->getXML();
}
function statusChange($id,$i,$f,$id_line){
    $objResponse = new xajaxResponse();
   $andon = new Andon();
   
    $issue=$f['issue'.$i];
    $action=$f['action'.$i];
    $responsable=$f['resp'.$i];
    $due_date=$f['dd'.$i];
   
    switch ($id) {
        case 1:
          $objResponse->addAssign("tdP$i", "className", "activo");            
            $status=$f['tdP'.$i];
            $andon->setActionPlan(trim($issue), $action, $responsable, $due_date, $status, $id_line);
         break;
      case 2:
          $objResponse->addAssign("tdD$i", "className", "activo");           
           $status=$f['tdD'.$i];
           $andon->updateActionPlan($id_line,trim($issue),$status,"statusb");
         break;
      case 3:
          $objResponse->addAssign("tdC$i", "className", "activo");  
           $status=$f['tdC'.$i];
           $andon->updateActionPlan($id_line,trim($issue),$status,"statusc");
         break;
      case 4:
          $objResponse->addAssign("tdA$i", "className", "activo");   
           $status=$f['tdA'.$i];
           $andon->updateActionPlan($id_line,trim($issue),$status,"statusd");
         break;
    }
    
 
    return $objResponse->getXML();
}
function Delete($acp_id,$id_line){
    
    $objResponse = new xajaxResponse();
    $andon = new Andon();
    
    $andon->DeleteActionPlan($acp_id);
    
    $objResponse->addScript("xajax_mostrar('4',0,'$id_line')");
    
    return $objResponse->getXML();
}
function saveFJ($f,$id_line){
     $objResponse = new xajaxResponse();
    $andon = new Andon();    
    
   //  $datel=$f['datehnew']." ".$f['selh2new'].":".$f['selmi2new']; 
   //  $objResponse->addAlert("$datel $sels $textp $inpute $inputc $textc $texta $inputr $inputn $dateh $chekType $datem $selm".$checkDoc);
    $andon->setFormatJidoka($f, $id_line);
     return $objResponse->getXML();
}
function updateFJ($f,$i,$id_line){
     $objResponse = new xajaxResponse();
    $andon = new Andon();    
    $andon->setFormatJidoka($f, $i, $id_line);
     return $objResponse->getXML();
}
function Redirect($x,$monitor,$stop){
    
    $objResponse = new xajaxResponse();
   // $objResponse->addAlert("$monitor ".$x);
    
    if($stop == "true"){    
    $objResponse->addRedirect("/Pizarron/index.php?monitor=$monitor&x=$x&stop=true"); 
   
    }else
        {
        $objResponse->addRedirect("/Pizarron/index.php?monitor=$monitor&x=$x&stop=false");
        }
        
    return $objResponse->getXML();
}
function showAlertColor(){
     $objResponse = new xajaxResponse();    
        
             $objResponse->addAssign("DivColors", "style.visibility", "visible");
             //$objResponse->addAssign("divEqp", "style.visibility", "hidden");      
    
     return $objResponse->getXML();
}
function showButtons(){
     $objResponse = new xajaxResponse();    
        
             $objResponse->addAssign("DivButtons", "style.visibility", "visible");
            // $objResponse->addAssign("DivColors", "style.visibility", "hidden");      
    
     return $objResponse->getXML();
}
function showColor($field_name,$id_line){
     $objResponse = new xajaxResponse();    
        
             $html = Table::Top("");  // <-- Set the title for your form.
             $html .= Andon::formChangeColor($field_name,$id_line);  // <-- Change by your method
   // End edit zone
             $html .= Table::Footer();    
              $objResponse->addAssign("formDiv", "innerHTML", $html);
             $objResponse->addAssign("formDiv", "style.visibility", "visible");
            
    
     return $objResponse->getXML();
}
function changeColor($field_name,$color,$id_line){
     $objResponse = new xajaxResponse();
     $pyramid = new Andon();
        //   $objResponse->addAlert($field_name.$color);
      
      $pyramid->updatePyramid($field_name, $color,$id_line);  
     $objResponse->addRedirect("arrastre.php?id_line=$id_line");
     
     return $objResponse->getXML();
}
function savePyramid($f,$id_line){
     $objResponse = new xajaxResponse();
    $andon = new Andon();   
    $day=$f['date'];
    $problem=$f['issue'];
    if(!$day ||  !$problem){
    $objResponse->addAlert("No puedes dejar campos vacios !!");
    return $objResponse->getXML();
    }
        $andon->InsertPyramidProblem($id_line, $day, $problem);
      $objResponse->addRedirect("arrastre.php?id_line=$id_line");
     return $objResponse->getXML();
}
function saveGrafica($dia,$value,$id_line,$type,$turno){
     $objResponse = new xajaxResponse();
     $andon = new Andon();   
         
     $res=$andon->getGraphByID($id_line, $type,$turno); 
     
     if($res['gph_1'] != ""){
         $andon->updateGraph($id_line, $type,$dia, $value,$turno);
     }else{$andon->insertGraph($id_line, $type, $value,$turno);         
     }
     if($type == "SCRAP"){
         $objResponse->addRedirect("scrap.php?tipo=$type&id_line=$id_line");
          return $objResponse->getXML();
     }
     $objResponse->addRedirect("grafica.php?tipo=$type&id_line=$id_line");
   
     return $objResponse->getXML();
}

function showPPlan($id_project,$id_line,$fecha,$columna){
     $objResponse = new xajaxResponse();
        $html="<iframe src='/Pizarron/plan.php?id_line=$id_line&idproject=$id_project&fecha=$fecha&columna=$columna' width='100%' height='100%' frameborder='0' ></iframe>";
        $objResponse->addAssign("boton", "style.visibility", "hidden");
     $objResponse->addAssign("div_iframe", "innerHTML", $html);       
     return $objResponse->getXML();
}
    
function cargarPlan($id_line){
    $objResponse = new xajaxResponse();
    $html="<iframe src='/Pizarron/carga_plan.php?idline=$id_line' width='100%' height='100%' frameborder='0' ></iframe>";
     $objResponse->addAssign("div_iframe", "innerHTML", $html);
    return $objResponse->getXML();
}
   
function showTable($cw,$id_line) {
     
     $objResponse = new xajaxResponse();    
    $andon = new Andon();
    $res=$andon->getPlanCWByIdLine($id_line, $cw);
  //  $objResponse->addAlert($cw.$id_line); 
    
    $html='<form id="form1" name="form1">
<table style="width:500px" class="adminlist">
    <tr>
       <th>MLFB</th>
       <th>Lunes</th>
       <th>Martes</th>
       <th>Miercoles</th>   
       <th>Jueves</th>
       <th>Viernes</th>
       <th>Sabado</th> 
       <th>Domingo</th>            
    </tr>';
  $x=1;
  while($row=$res->fetchRow()){       
        
   $html.= '<tr >
        <td  style="width:20%;"><input type="text" id="strmlfb'.$x.'" name="strmlfb'.$x.'" value="'.$row['prp_mlfb'].'"></td>'
           . '<td  style="width:10%;"><input type="text" id="strmonday'.$x.'" name="strmonday'.$x.'" value="'.$row['prp_monday'].'"></td>'
           . '<td  style="width:10%;"><input type="text" id="strtuesday'.$x.'" name="strtuesday'.$x.'" value="'.$row['prp_tuesday'].'"></td>'
           . '<td  style="width:10%;"><input type="text" id="strwednesday'.$x.'" name="strwednesday'.$x.'" value="'.$row['prp_wednesday'].'"></td>'
           . '<td  style="width:10%;"><input type="text" id="strthursday'.$x.'" name="strthursday'.$x.'" value="'.$row['prp_thursday'].'"></td>'
           . '<td  style="width:10%;"><input type="text" id="strfriday'.$x.'" name="strfriday'.$x.'" value="'.$row['prp_friday'].'"></td>'
           . '<td  style="width:10%;"><input type="text" id="strsaturday'.$x.'" name="strsaturday'.$x.'" value="'.$row['prp_saturday'].'"></td>'
           . '<td  style="width:10%;"><input type="text" id="strsunday'.$x.'" name="strsunday'.$x.'" value="'.$row['prp_sunday'].'"></td>'
           . '<td><input type="button" value="Update" onclick="xajax_updateRow(xajax.getFormValues(\'form1\'),'.$x.','.$row['prp_id'].','.$id_line.','.$cw.')"></td>'
           . '<td><input type="button" value="Delete" onclick="xajax_deleteRow('.$row['prp_id'].','.$id_line.','.$cw.')"></td></tr>'; 
  $x++;   
  } 
$html.= '<tr >
              <td  style="width:20%;"><input type="text" id="strmlfb" name="strmlfb"></td>'
           . '<td  style="width:10%;"><input type="text" id="strmonday" name="strmonday"></td>'
           . '<td  style="width:10%;"><input type="text" id="strtuesday" name="strtuesday"></td>'
           . '<td  style="width:10%;"><input type="text" id="strwednesday" name="strwednesday"></td>'
           . '<td  style="width:10%;"><input type="text" id="strthursday" name="strthursday"></td>'
           . '<td  style="width:10%;"><input type="text" id="strfriday" name="strfriday"></td>'
           . '<td  style="width:10%;"><input type="text" id="strsaturday" name="strsaturday"></td>'
           . '<td  style="width:10%;"><input type="text" id="strsunday" name="strsunday"></td>'
           . '<td  style="width:10%;"><input type="button" value="Save" onclick="xajax_saveRow(xajax.getFormValues(\'form1\'),'.$id_line.','.$cw.')"></td></tr>'; 

$html.= '</table></form>'; 

                     
     $objResponse->addAssign('divTable', 'innerHTML', $html);
     $objResponse->addAssign('divTable', 'style.visibility', 'visible');
    $objResponse->addAssign('divTextArea', 'style.visibility', 'visible');
     
     return $objResponse->getXML();
}

function saveRow($f,$id_line,$cw){
    $objResponse = new xajaxResponse();
   $andon = new Andon();
   $andon->insertPlan($f, $id_line, $cw);
   $objResponse->addScript("xajax_showTable($cw,$id_line)");
    return $objResponse->getXML();
}

function saveMasivePlan($plan,$id_line,$cw){
    $objResponse = new xajaxResponse();
   $andon = new Andon();
        $partes=preg_split("/[\r\n]+/",$plan);
        for($i=0;$i<count($partes);$i++){
 if(strlen($partes[$i])){
 list($partNo,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo) = explode("\t",$partes[$i]);
       $andon->insertMasivePlan($partNo,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$id_line,$cw);
        }
                }
  $objResponse->addScript("xajax_showTable($cw,$id_line)");
   $objResponse->addScript("document.getElementById('plantextArea').value='';");
    return $objResponse->getXML();
}

function updateRow($f,$i,$id,$id_line,$cw){
    $objResponse = new xajaxResponse();
   $andon = new Andon();
   $andon->updatePPlan($f, $i, $id);
   $objResponse->addScript("xajax_showTable($cw,$id_line)");
    return $objResponse->getXML();
}
function deleteRow($id,$id_line,$cw){
    $objResponse = new xajaxResponse();
   $andon = new Andon();
   $andon->deletePPlan($id);
   $objResponse->addScript("xajax_showTable($cw,$id_line)");
    return $objResponse->getXML();
}

function active($id_line,$turno,$status){
    $objResponse = new xajaxResponse();
    //$objResponse->addalert($status);
  //  $objResponse->addScript("document.getElemetById('turno_4')");
   $lines = new Line();   
   $lines->updateActiveTurnos($id_line, $turno, $status);
   
    return $objResponse->getXML();
}
$xajax->processRequests();

?>
