<?php 
include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
include_once('common.php'); ?>

<html>
<head>
 
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache,mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    
    <title><?php echo TITLE;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php 
$xajax->printJavascript("/include/"); 

$celda = new Line();
$monitor=$_GET['monitor'];
$x=$_GET['x'];
$stop=$_GET['stop'];

if(!$stop){$stop="false";}

$display=$celda->getMonitorByMonitor($monitor);
$result=$display->fetchAll();

$c=(count($result))-1;

if($x<$c){$y=$x+1;}else{$y=0;}

if($stop != "true"){
header("Refresh: 360; url=/Pizarron/index.php?monitor=$monitor&x=$y");
} else{header("Refresh: 3600; url=/Pizarron/index.php?monitor=$monitor&x=$y");} 

$id_line=$result[$x]['lmt_line'];

$andon = new Andon();


//$andon->insertCumplimiento($id_line);
$proj=$celda->gById_line($id_line);
$name=$andon->getNameById($id_line);
$responsable=$andon->getDaysById($id_line,"responsable");
$extension=$andon->getDaysById($id_line,"ext");
$dias=$andon->getDaysById($id_line,"day");
$meta=$andon->getDaysById($id_line,"meta");
$logro=$andon->getDaysById($id_line,"logro");
        
        $project=$proj->fetchRow();
        $id_project=$project['id_project'];
        $name_line=$name->fetchRow();
        $resp = $responsable->fetchRow();
        $ext = $extension->fetchRow();
        $day = $dias->fetchRow();
        $metas = $meta->fetchRow();
        $logros = $logro->fetchRow();
       
            $param1=$andon->getCertification($id_line, "1");
           $rowx1=$param1->fetchAll();           
           if(!$rowx1[0]['lnp_value']){$clase1="blanc";}else{$clase1=$rowx1[0]['lnp_value'];}
        
            $param2=$andon->getCertification($id_line, "2");
           $rowx2=$param2->fetchAll();
           if(!$rowx2[0]['lnp_value']){$clase2="blanc";}else{$clase2=$rowx2[0]['lnp_value'];}
         
            $param3=$andon->getCertification($id_line, "3");
           $rowx3=$param3->fetchAll();
           if(!$rowx3[0]['lnp_value']){$clase3="blanc";}else{$clase3=$rowx3[0]['lnp_value'];}
           
           $param4=$andon->getCertification($id_line,  "4");
           $rowx4=$param4->fetchAll();
           if(!$rowx4[0]['lnp_value']){$clase4="blanc";}else{$clase4=$rowx4[0]['lnp_value'];}
           
            $param5=$andon->getCertification($id_line, "5");
           $rowx5=$param5->fetchAll();
           if(!$rowx5[0]['lnp_value']){$clase5="blanc";}else{$clase5=$rowx5[0]['lnp_value'];}     
       
?>
<link type="text/css" rel="stylesheet" href="/css/pizzaron_style.css">
<link type="text/css" rel="stylesheet" href="/css/buttons.css">
<link type="text/css" rel="stylesheet" href="/css/dhtmlgoodies_calendar.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="/include/js/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="/include/js/stickytooltip.js">
</script>
<link rel="stylesheet" type="text/css" href="/css/stickytooltip.css" />
<script type="text/javascript" src="/include/js/jquery.min.js"></script>
<script type="text/javascript" src="/include/js/jquery.maphilight.js"></script>
    <script type="text/javascript">$(function() {
        $('.map').maphilight();
        $('#squidheadlink').mouseover(function(e) {
            $('#squidhead').mouseover();
        }).mouseout(function(e) {
            $('#squidhead').mouseout();
        }).click(function(e) { e.preventDefault(); });
    });</script>
<SCRIPT LANGUAGE="JavaScript">
  <!--
   
function soloNumeros(e,valorCampo){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789.";
    especiales = [8,37,39,46];

    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        }
    }

    if( (letras.indexOf(tecla)==-1 && !tecla_especial)
    || (tecla=="." && valorCampo.indexOf(tecla)!=-1) ){
    
        return false;
}
}
 //-->
  </SCRIPT> 
  
  <script type="text/javascript" src="/include/js/jquery-1-4-2-min.js"></script>
  <script type="text/javascript">
//<![CDATA[
var j = jQuery.noConflict();
j(function (){
j(".botonera").hover(function(){
j(".botonera").stop(true, false).animate({left:"0"},"medium");
},function(){
j(".botonera").stop(true, false).animate({left:"-1305px"},"medium");
},500);
return false;
});


//]]>
</script>
<script type="text/javascript"> 
function checkboxActivo(turno)
{
 var idline="<?php echo $id_line; ?>";     
  if (document.getElementById(turno).checked)
  {
   alert('Activado');  
   xajax_active(idline,turno,'active');
  }
  else{
      alert('Desactivado');      
      xajax_active(idline,turno,'inactive');
  }
 
}
</script>
</head>
<body class="pizzaron"  >       
<div style="width:100%;height: 100%;">
<table class="table_general" border="0">
<tr >
<td style="width: 40%;" ><div style="width: 100%" id="titulo"><label style=" font-size:2em; font-weight: bold;padding-left: 20px;cursor: pointer" onclick="xajax_stop(<?php echo $monitor; ?>)" ><?php echo $name_line['sba_name'];?></label></div></td>
<td style="width: 20%;"><div style="width: 100%" id="divReanudar"><?php if($stop=="true") {echo '<input type="button" value="Reanudar" onclick="xajax_Redirect('.$y.','.$monitor.',\'false\')">'; }?></div></td>
<td style="width: 40%;"><div style="text-align: right;"><a href="http://10.218.108.243:98/Andon/"><img src="/images/contilogo.png" style="width: 20%;padding-right: 20px"></a></div></td>

</tr>
<tr style="height: 95%;">
<td style="width: 40%; height:90%" >
        <div style=" overflow-y: auto; height: 100%">
          <table border="0" style=" table-layout: fixed" >
<tr style=" height: 40%">
<td style="width: 40%;">
          <table style="width: 100%;height: 80%; table-layout: fixed; " CELLPADDING=10 CELLSPACING=0 border="0" border="1" >

              <tr style=" height: 25%">
                <td style="width:45%; height: 25%">
                   <center>Dias sin rechazo</center>
                   <div id="days" class="days"  >
                            
                   <table border="0" style=" width: 100%;height: 100%">
                      <tr style=" height: 10%">
                            <td style=" background-color: #FFFFFF; width: 70%">
                                <table >
                                 <tr>
                                 <td style=" width: 40%;"><input type="text" id="resp" value="<?php echo $resp['lnp_value'];?>" onblur="xajax_update(document.getElementById('resp').value,<?php echo $id_line;?>,'1')" name="resp"   style=" width: 100%;text-align: center;font-size: .5em" ></td>
                                 <td style=" width: 20%"><input type="text" id="ext" name="ext" value="<?php echo $ext['lnp_value'];?>" onblur="xajax_update(document.getElementById('ext').value,<?php echo $id_line;?>,'2')"  style=" width: 100%;text-align: center;font-size: .5em"></td>
                                 <td style=" width: 20%"><input type="text" value="<?php echo date('d / m');  ?>" readonly="true" style=" width: 100%;text-align: center;font-size: .5em"></td>
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
                                     <input type="text" name="day" id="day" value="<?php echo $day['lnp_value'];?>" onKeyPress="return soloNumeros(event)" onblur="xajax_update(document.getElementById('day').value,<?php echo $id_line;?>,'3')"  
                                            style=" width: 100% ;height: 80%;text-align: center;font-size: 2em;font-weight: bold;
                                            <?php if($day['lnp_value'] >= $metas['lnp_value']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?> " >
                                     <label style=" font-size:.8em; font-weight:bold">Dias sin rechazo del cliente</label><br>
                                     <label style=" font-size:.5em; font-weight:bold">Days whithout customer reject</label>
                                 </td>
                                 <td style=" width: 30%">
                                     <table style="width: 100%;height: 100%;text-align: center" border="0">
                               <tr>
                                   <td style="width: 100%;height: 50%"><input type="text" name="logro" value="<?php echo $logros['lnp_value'];?>" onKeyPress="return soloNumeros(event)" onblur="xajax_update(document.getElementById('logro').value,<?php echo $id_line;?>,'4')" id="logro"  
                                                                              style=" width: 100%;height: 70%;text-align: center;font-size: 2em;font-weight: bold;<?php if($logros['lnp_value'] >= $metas['lnp_value']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?>" >
                                  <br><label style=" font-size:.5em">Mejor Logro</label><br><label style=" font-size: .5em">Best Archievement</label></td>
                               </tr>
                                <tr>
                                    <td style="width: 100%;height: 50%"><input type="text" name="meta" id="meta" value="<?php echo $metas['lnp_value'];?>" onKeyPress="return soloNumeros(event)" onblur="xajax_update(document.getElementById('meta').value,<?php echo $id_line;?>,'5')"  style=" width: 100%;height: 70%;text-align: center;font-size: 2em;font-weight: bold" >
                                 <br><label style=" font-size: .5em">Meta</label><br><label style="font-size: .5em; font-weight: bold">Target</label></td>
                                </tr>
                              </table>
                                 </td>
                                    </tr>
                        </table>
                          
                        </div>

                 
              <div id="formDiv"  class="formDiv"></div>
                </td>
                <td style="width: 55%;cursor: pointer" onclick="xajax_mostrar(1,<?php echo $id_project; ?>,<?php echo $id_line; ?>)"  >
                  <div  style="height: 98%;" >
                      <center >Path Jidoka
                          
                          <br>
                          <table style=" width: 70%; text-align: center;font-size: .5em" border='0'>
                          <tr>
                             <td>
                          <center><div class="triangulo"><br>
                            <!--<input type="text" value="Gerente" style=" background-color: #ff0033">-->
                                  Gerente
                              </div></center>
                             </td>
                             <td></td>
                             <td rowspan="5"><img src="/images/flecha.png"></td>
                          </tr>
                          <tr>
                              <td>
                              <center><div class="trapecio1">Jefe de Grupo</div></center>
                              </td>
                              <td>
                                  max. 1h
                                  overall:5h
                              </td>
                             
                          </tr>
                          <tr>
                             <td>
                              <center><div class="trapecio2">Coordinador</div></center>
                             </td>
                               <td>
                                  max. 2h
                                  overall:4h
                              </td>
                             
                          </tr>
                          <tr>
                          <td>
                              <center><div class="trapecio3">Supervisor de Area</div></center>
                          </td>
                            <td>
                                  max. 1h
                                  overall:2h
                              </td>
                           
                          </tr>
                          <tr>
                          <td>
                              <center><div class="trapecio4">Supervisor</div></center>
                          </td>
                            <td>
                                  max. 1h
                              </td>
                             
                          </tr>
                          </table>
                       
                      
                      </center></div></td>
            </tr>
            <tr style=" height: 25%">
                <td colspan="2" >
                    <div style="width: 100%;" >
                        <center>
                               <table class="table_plan" border="1" style="margin: 0 auto;text-align: left;font-size:.8em;width: 98%;height: 100%;font-weight: bold;table-layout: fixed" >
                                   <tr style=" height: 10%;cursor: pointer" onclick="xajax_mostrar(2,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">
                                <?php                                
                                $cw=  date("W");
                                $andon1 = new Andon();
                                $lines = new Line();
                                
                               $array_shift= $lines->getActiveTurnos($id_line);
                               
                               $status_shift=$array_shift->fetchRow();
                               
                               if($status_shift['lnt_turno_4']=="active"){$cheked_4="checked";}else{$cheked_4="";}
                               if($status_shift['lnt_turno_5']=="active"){$cheked_5="checked";}else{$cheked_5="";}
                               if($status_shift['lnt_turno_6']=="active"){$cheked_6="checked";}else{$cheked_6="";}
                               if($status_shift['lnt_turno_7']=="active"){$cheked_7="checked";}else{$cheked_7="";}
                                
                                 $resdades=$andon1->getDaysByCW($cw);
                                 $z=0;
                                 while($dates=$resdades->fetchRow()){                                     
                                     $fechas [$z]=$dates['dateini'];
                                     $z++;
                                 }
                                   $lunesfecha=$fechas[0];
                                   $martesfecha=$fechas[1];   
                                   $miercolesfecha=$fechas[2];
                                   $juevesfecha=$fechas[3];
                                   $viernesfecha=$fechas[4];
                                   $sabadofecha=$fechas[5];
                                   $domingofecha=$fechas[6];
                               //    $nuevafecha = strtotime ( '+1 day' , strtotime ( $fechas[6] ) ) ;
                               //    $domingofecha = date ( 'Y-m-d' , $nuevafecha ); 
                                 
                                 $plannew=$andon1->getPPlan($id_line);
                                    
                                
                                $lunes=$andon1->getCumplimiento($id_line,$cw,"Monday");
                                $martes=$andon1->getCumplimiento($id_line,$cw,"Tuesday");
                                $miercoles=$andon1->getCumplimiento($id_line,$cw,"Wednesday");
                                $juevez=$andon1->getCumplimiento($id_line,$cw,"Thursday");
                                $viernes=$andon1->getCumplimiento($id_line,$cw,"Friday");
                                $sabado=$andon1->getCumplimiento($id_line,$cw,"Saturday");
                                $domingo=$andon1->getCumplimiento($id_line,$cw,"Sunday");
                            
                            
                                
                                $rowl = $lunes->fetchAll();
                                $rowm = $martes->fetchAll();
                                $rowx = $miercoles->fetchAll();
                                $rowj = $juevez->fetchAll();
                                $rowv = $viernes->fetchAll();
                                $rows = $sabado->fetchAll();
                                $rowd = $domingo->fetchAll();                              
                              
                                echo "<td>Semana: $cw</td>"; ?>
                                     
                                <td colspan="7">Cumplimiento-Linea: <?php echo $name_line['sba_name'];?></td>

                            </tr>
                             <tr style=" height: 10%; background-color: #FB9D00">
                                <th style="width: 20%">Turnos</th>
                                <th style="width: 10%">Lunes</th>
                                <th style="width: 10%">Martes</th>
                                <th style="width: 10%">Miercoles</th>
                                <th style="width: 10%">Jueves</th>
                                <th style="width: 10%">Viernes</th>
                                <th style="width: 10%">Sabado</th>
                                <th style="width: 10%">Domingo</th>
<!--                                <th style="width: 20%">Turnos</th>
                                <th style="width: 10%">Lunes<br><input type="checkbox" onclick="checkboxActivo('lunes_cm')" id="lunes_cm" ></th>
                                <th style="width: 10%">Martes <input type="checkbox" onclick="checkboxActivo('martes_cm')" id="martes_cm" ></th>
                                <th style="width: 10%">Miercoles <input type="checkbox" onclick="checkboxActivo('miercoles_cm')" id="miercoles_cm"  ></th>
                                <th style="width: 10%">Jueves <input type="checkbox" onclick="checkboxActivo('jueves_cm')" id="jueves_cm" ></th>
                                <th style="width: 10%">Viernes <input type="checkbox" onclick="checkboxActivo('viernes_cm')" id="viernes_cm" ></th>
                                <th style="width: 10%">Sabado <input type="checkbox" onclick="checkboxActivo('sabado_cm')" id="sabado_cm"  ></th>
                                <th style="width: 10%">Domingo <input type="checkbox" onclick="checkboxActivo('domingo_cm')" id="domingo_cm"  ></th>-->
                            </tr>
                             <tr style=" height: 20%">
                                 <td style="width: 20%;background-color: #FB9D00">4<input type="checkbox" onclick="checkboxActivo('turno_4')" id="turno_4" <?php echo $cheked_4 ?> >6<input type="checkbox" onclick="checkboxActivo('turno_6')" id="turno_6" <?php echo $cheked_6 ?> ></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowl[$i]['cto_shift']=="4" || $rowl[$i]['cto_shift']=="6"){ echo $rowl[$i]['cto_qty'];}} ?>" type="text" name="1" id="1" class="inputcuml" readonly ></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowm[$i]['cto_shift']=="4" || $rowm[$i]['cto_shift']=="6"){ echo $rowm[$i]['cto_qty'];}} ?>" type="text" name="2" id="2" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowx[$i]['cto_shift']=="4" || $rowx[$i]['cto_shift']=="6"){ echo $rowx[$i]['cto_qty'];}} ?>" type="text" name="3" id="3" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowj[$i]['cto_shift']=="4" || $rowj[$i]['cto_shift']=="6"){ echo $rowj[$i]['cto_qty'];}} ?>" type="text" name="4" id="4" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowv[$i]['cto_shift']=="4" || $rowv[$i]['cto_shift']=="6"){ echo $rowv[$i]['cto_qty'];}} ?>" type="text" name="5" id="5" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rows[$i]['cto_shift']=="4" || $rows[$i]['cto_shift']=="6"){ echo $rows[$i]['cto_qty'];}} ?>" type="text" name="6" id="6" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowd[$i]['cto_shift']=="4" || $rowd[$i]['cto_shift']=="6"){ echo $rowd[$i]['cto_qty'];}} ?>" type="text" name="7" id="7" class="inputcuml" readonly></div></td>
                               
                            </tr>
                             <tr style=" height: 20%">
                                <td style="width: 20%;background-color: #FB9D00">5<input type="checkbox" onclick="checkboxActivo('turno_5')" id="turno_5" <?php echo $cheked_5 ?>>7<input type="checkbox" onclick="checkboxActivo('turno_7')" id="turno_7" <?php echo $cheked_7 ?>></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowl[$i]['cto_shift']=="5" || $rowl[$i]['cto_shift']=="7"){ echo $rowl[$i]['cto_qty'];}} ?>" type="text" name="8" id="8" class="inputcuml" readonly ></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowm[$i]['cto_shift']=="5" || $rowm[$i]['cto_shift']=="7"){ echo $rowm[$i]['cto_qty'];}} ?>" type="text" name="9" id="9" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowx[$i]['cto_shift']=="5" || $rowx[$i]['cto_shift']=="7"){ echo $rowx[$i]['cto_qty'];}} ?>" type="text" name="10" id="10" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowj[$i]['cto_shift']=="5" || $rowj[$i]['cto_shift']=="7"){ echo $rowj[$i]['cto_qty'];}} ?>" type="text" name="11" id="11" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowv[$i]['cto_shift']=="5" || $rowv[$i]['cto_shift']=="7"){ echo $rowv[$i]['cto_qty'];}} ?>" type="text" name="12" id="12" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rows[$i]['cto_shift']=="5" || $rows[$i]['cto_shift']=="7"){ echo $rows[$i]['cto_qty'];}} ?>" type="text" name="13" id="13" class="inputcuml" readonly></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php for($i=0;$i<=1;$i++){if($rowd[$i]['cto_shift']=="5" || $rowd[$i]['cto_shift']=="7"){ echo $rowd[$i]['cto_qty'];}} ?>" type="text" name="14" id="14" class="inputcuml" readonly></div></td>
                            </tr>
                             <tr style=" height: 20%">
                                <td style="width: 20%;background-color: #FB9D00">Real</td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo ($rowl[0]['cto_qty'] + $rowl[1]['cto_qty']) ; ?> " name="21" id="21" type="text" class="inputcuml" readonly style="<?php if( ($rowl[0]['cto_qty'] + $rowl[1]['cto_qty']) >= $plannew['lunes']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?>"</div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo ($rowm[0]['cto_qty'] + $rowm[1]['cto_qty']) ; ?> " name="22" id="22" type="text" class="inputcuml" readonly style="<?php if( ($rowm[0]['cto_qty'] + $rowm[1]['cto_qty']) >= $plannew['martes']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?>"</div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo ($rowx[0]['cto_qty'] + $rowx[1]['cto_qty']) ; ?> " name="23" id="23" type="text" class="inputcuml" readonly style="<?php if( ($rowx[0]['cto_qty'] + $rowx[1]['cto_qty']) >= $plannew['miercoles']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?>"</div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo ($rowj[0]['cto_qty'] + $rowj[1]['cto_qty']) ; ?> " name="24" id="24" type="text" class="inputcuml" readonly style="<?php if( ($rowj[0]['cto_qty'] + $rowj[1]['cto_qty']) >= $plannew['jueves']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?>"</div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo ($rowv[0]['cto_qty'] + $rowv[1]['cto_qty']) ; ?> " name="25" id="25" type="text" class="inputcuml" readonly style="<?php if( ($rowv[0]['cto_qty'] + $rowv[1]['cto_qty']) >= $plannew['viernes']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?>"</div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo ($rows[0]['cto_qty'] + $rows[1]['cto_qty']) ; ?> " name="26" id="26" type="text" class="inputcuml" readonly style="<?php if( ($rows[0]['cto_qty'] + $rows[1]['cto_qty']) >= $plannew['sabado']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?>"</div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo ($rowd[0]['cto_qty'] + $rowd[1]['cto_qty']) ; ?> " name="27" id="27" type="text" class="inputcuml" readonly style="<?php if( ($rowd[0]['cto_qty'] + $rowd[1]['cto_qty']) >= $plannew['domingo']) {echo "color:#18dd3f";}else {echo "color:#ff001a";} ?>"</div></td>
                            </tr>
                             <tr style=" height: 20%">
                                 <td style="width: 20%;background-color: #FB9D00;cursor: pointer" onclick="xajax_cargarPlan(<?php echo $id_line;?>)">Plan</td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo $plannew['lunes'] ; ?> " name="31" id="31" type="text" class="inputcuml" maxlength="3" readonly="true" style="cursor: pointer" 
                                                                                          onclick="xajax_showPPlan(<?php echo $id_project;?>,<?php echo $id_line;?>,'<?php echo $lunesfecha; ?>','prp_monday')" ></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo $plannew['martes'] ; ?> "name="32" id="32" type="text" class="inputcuml" maxlength="3" readonly="true" style="cursor: pointer"
                                                                                          onclick="xajax_showPPlan(<?php echo $id_project;?>,<?php echo $id_line;?>,'<?php echo $martesfecha; ?>','prp_tuesday')" ></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo $plannew['miercoles'] ; ?> "name="33" id="33" type="text" class="inputcuml" maxlength="3" readonly="true" style="cursor: pointer"
                                                                                          onclick="xajax_showPPlan(<?php echo $id_project;?>,<?php echo $id_line;?>,'<?php echo $miercolesfecha; ?>','prp_wednesday')" ></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo $plannew['jueves'] ; ?> "name="34" id="34" type="text" class="inputcuml" maxlength="3" readonly="true" style="cursor: pointer" 
                                                                                          onclick="xajax_showPPlan(<?php echo $id_project;?>,<?php echo $id_line;?>,'<?php echo $juevesfecha; ?>','prp_thursday')" ></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo $plannew['viernes'] ; ?> "name="35" id="35" type="text" class="inputcuml" maxlength="3" readonly="true" style="cursor: pointer" 
                                                                                          onclick="xajax_showPPlan(<?php echo $id_project;?>,<?php echo $id_line;?>,'<?php echo $viernesfecha; ?>','prp_friday')"></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo $plannew['sabado'] ; ?> "name="36" id="36" type="text" class="inputcuml" maxlength="3" readonly="true" style="cursor: pointer" 
                                                                                          onclick="xajax_showPPlan(<?php echo $id_project;?>,<?php echo $id_line;?>,'<?php echo $sabadofecha; ?>','prp_saturday')"></div></td>
                                <td style="width: 10%;"><div style=" width: 100%;"><input value="<?php echo $plannew['domingo'] ; ?> "name="37" id="37" type="text" class="inputcuml" maxlength="3" readonly="true" style="cursor: pointer" 
                                                                                          onclick="xajax_showPPlan(<?php echo $id_project;?>,<?php echo $id_line;?>,'<?php echo $domingofecha; ?>','prp_sunday')"></div></td>
                            </tr>
                        </table>
                        </center>

                    </div>
                </td>
            </tr>
            <tr >
                <td style="width: 50%" ><div style="height: 90%;float: top;cursor: pointer" onclick="xajax_mostrar(3,<?php echo $id_project; ?>,<?php echo $id_line; ?>)"><center>Alerta Q<embed src="<?php echo "/doctos/$id_project/$id_line/calidad/"."calidad.pdf" ?>" style=" width: 98%;height:100%"  ></center></div></td>
                <td style="width: 50%;cursor: pointer" onclick="xajax_mostrar(4,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">
                    <?php 
             $andon2 = new Andon();
             $plan=$andon2->getActionPlan($id_line);
             $row = $plan->fetchAll();
                    ?>
                    <div style="width: 98%;height: 98%;"><center>Listado de Acciones<br></center>
                        <label style="font-weight: bold;font-size: 1em">Plan de Acción</label>
                        <label style="font-weight: bold;font-size: .5em">Action plan</label> 
                        <center>
                            <table  border="1" class="table_plan" style="margin: 0 auto;text-align: left;font-size:.5em;width: 98%;font-weight: bold;table-layout: fixed" >

                             <tr style="width: 20%;background-color: #FB9D00;color: #FFFFFF;">
                                <th style="width: 10%;text-align: center">Ref. Nr</th>
                                <th style="width: 20%;text-align: center">Issue</th>
                                <th style="width: 15%;text-align: center">Action</th>
                                <th style="width: 25%;text-align: center">Responsible</th>
                                <th style="width: 15%;text-align: center">Due Date</th>
                                <th style="width: 15%;text-align: center">Status</th>
                            </tr>
                            <?php 
                                                            for($i=0;$i<=3;$i++){
                                                                $x=$i+1;
                                                                
                                                                if($row[$i]['acp_statusa']){$claxe1="activo";}else{$claxe1="pasivo";}
                                                                if($row[$i]['acp_statusb']){$claxe2="activo";}else{$claxe2="pasivo";}
                                                                if($row[$i]['acp_statusc']){$claxe3="activo";}else{$claxe3="pasivo";}
                                                                if($row[$i]['acp_statusd']){$claxe4="activo";}else{$claxe4="pasivo";}
                                                               echo ' <tr>
                                                                <td style="width: 10%;"><div style=" width: 100%;"><input id="rowa'.$i.'" name="rowa'.$i.'" style=" width: 100%;font-size: 1em; border: none;" type="text" width="100%" value="'.$x.'" readonly></div></td>
                                                                <td style="width: 10%;"><div style=" width: 100%;"><input id="issuea'.$i.'" name="issuea'.$i.'" style=" width: 100%;font-size: .7em; border: none;" type="text" width="100%" value="'.$row[$i]['acp_issue'].'" readonly></div></td>
                                                                <td style="width: 10%;"><div style=" width: 100%;"><input id="actiona'.$i.'" name="actiona'.$i.'" style=" width: 100%;font-size: .7em; border: none;" type="text" width="100%" value="'.$row[$i]['acp_action'].'" readonly></div></td>
                                                                <td style="width: 10%;"><div style=" width: 100%;"><input id="respa'.$i.'" name="respa'.$i.'" style=" width: 100%;font-size: 1em; border: none;" type="text" width="100%" value="'.$row[$i]['acp_responsable'].'" readonly></div></td>
                                                                <td style="width: 10%;"><div style=" width: 100%;"><input readonly name="dda'.$i.'" id="dda'.$i.'" style=" width: 100%;font-size: 1em; border: none;" type="text" value="'.$row[$i]['acp_due_date'].'" ></div></td>
                                                               <td style="width: 10%;">
                                                                <table border="1" class="circulo">
                                                                <tr>
                                                                <td><input class="'.$claxe1.'" id="tP'.$i.'" name="tP'.$i.'" value="P" readonly></td><td><input class="'.$claxe2.'" id="tD'.$i.'" name="tD'.$i.'"  value="D"  readonly></td>
                                                                </tr>
                                                                <tr>
                                                                <td ><input class="'.$claxe3.'" id="tC'.$i.'" name="tC'.$i.'"  value="C"  readonly></td><td><input class="'.$claxe4.'" id="tA'.$i.'" name="tA'.$i.'"  value="A"  readonly></td>
                                                                </tr>
                                                                </table>
                                                                </td>
                                                               
                                                            </tr> ';
                                                                
                                                            } ?>
                                                         
                        </table>
                        </center>
                        <table style=" font-size: .2em; width: 100%">
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
                    </div>
                </td>
            </tr>
       </table>
      </td>
</tr>
<tr style=" height: 60%">
    <td> 
    <table style=" width: 100%;height: 100%;table-layout: fixed" border="0"  >

        <tr>
        <td style="width: 20%;cursor: pointer" onclick="xajax_mostrar(5,<?php echo $id_project; ?>,<?php echo $id_line; ?>)"><center>SCRAP<div style=""> <?php echo'<iframe src="scrapmin.php?tipo=SCRAP&id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>'; ?></div></center></td>
        <td style="width: 20%;cursor: pointer" onclick="xajax_mostrar(6,<?php echo $id_project; ?>,<?php echo $id_line; ?>)"><center>BTS<div style=""> <?php echo'<iframe src="graficamin.php?tipo=BTS&id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>'; ?></div></center></td>
        <td style="width: 20%;cursor: pointer" onclick="xajax_mostrar(7,<?php echo $id_project; ?>,<?php echo $id_line; ?>)"><center>OEE<div style=""> <?php echo'<iframe src="graficamin.php?tipo=OEE&id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>'; ?></div></center></td>
        <td style="width: 20%;cursor: pointer" onclick="xajax_mostrar(8,<?php echo $id_project; ?>,<?php echo $id_line; ?>)"><center>FPY<div style=""> <?php echo'<iframe src="graficamin.php?tipo=FPY&id_line='.$id_line.'" width="100%" height="100%" frameborder="0" ></iframe>'; ?></div></center></td>
    <td style="width: 20%;cursor: pointer" onclick="xajax_mostrar(9,<?php echo $id_project; ?>,<?php echo $id_line; ?>)"><center>PIRAMIDE<BR><BR>
         <div class="map" style="display: block; position: relative; padding: 0px; width: 932px; height: 605px;">
          <img src="/images/piramide.png" class="map maphilighted" usemap="#simple" align="center"
               style="opacity: 0; position: absolute; left: 0px; top: 0px; padding: 0px; border: 0px;"></div>
        <map name="simple">
                <?php 
$pyramid = new Andon();

$arreglo=$pyramid->getCoordenadas();
$colores=$pyramid->getColorsPyramid($id_line);

$x=1;
while($row=$arreglo->fetchRow()){    
   echo' <area id="'.$row['prc_name'].'" shape="poly" coords="'.$row['prc_coord'].'" 
          data-maphilight=\'{"stroke":false,"fillColor":"'.$colores['ltc_triangulo'.$x].'","fillOpacity":0.6,"alwaysOn":true}\'>';
$x++;
   
}
 ?>
        </map>            
        </center></td>
        </tr>

         <tr>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(10,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">5S's</label><embed src="<?php echo "/doctos/$id_project/$id_line/5s/5s.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf" ></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(11,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">KAYZEN/OPL</label><embed src="<?php echo "/doctos/$id_project/$id_line/opl/opl.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(12,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">FUGUAI</label><embed src="<?php echo "/doctos/$id_project/$id_line/fuguai/fuguai.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(13,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">TPM</label><embed src="<?php echo "/doctos/$id_project/$id_line/tpm/tpm.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(14,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">LPA</label><embed src="<?php echo "/doctos/$id_project/$id_line/lpa/lpa.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
       </tr>

         <tr>         
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(15,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">POKAYOKES</label><embed src="<?php echo "/doctos/$id_project/$id_line/pokayokes/pokayokes.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(16,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">MATRIX</label><embed src="<?php echo "/doctos/$id_project/$id_line/matrix/matrix.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(17,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">EAD</label><embed src="<?php echo "/doctos/$id_project/$id_line/ead/ead.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(18,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">OBC</label><embed src="<?php echo "/doctos/$id_project/$id_line/obc/obc.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(19,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">CLIENTE</label><embed src="<?php echo "/doctos/$id_project/$id_line/cliente/cliente.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
        </tr> 
         
          <tr>
              <td style="width: 20%;cursor: pointer" onclick="xajax_mostrar(20,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">
          <center>FORMATO JIDOKA<div style=" font-size: .5em"> Línea:<?php echo $name_line['sba_name']; ?>
                      <table border="1" style=" font-size: .5em">
                          <tr style=" background-color: #d0d0d0">
                              <td colspan="5">
                                  Lider de l&iacute;nea
                              </td>
                               <td>
                                  Responsable(operador, mantenimiento, procesos)
                              </td>
                               <td>
                                   L&iacute;der de l&iacute;nea
                              </td>
                               <td>
                                   Ingeniero de Calidad o T&eacute;cnico de Calidad
                              </td>
                          </tr>
                          <tr>
                            <td>Fecha y hora</td>
                            <td style=" background-color: #f1ef6a">Turno</td>
                            <td>Problema/Defecto<br>¿Que? ¿Como?<br>(N&uacute;mero de PRR s&oacute;lo para productos GM)</td> 
                            <td  style=" background-color: #f1ef6a">Estaci&oacute;n</td>
                            <td>¿Cu&aacute;ntos?</td>
                            <td  style=" background-color: #f1ef6a">Causa Raiz</td>
                            <td >Accion correctiva y/o contencion</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                                
                          </tr>
                      </table>
              </div></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(21,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">PILOTO 4M'S</label><embed src="<?php echo "/doctos/$id_project/$id_line/piloto/piloto.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
              <td style="width: 20%;" ><center><label style="cursor: pointer;" onclick="xajax_mostrar(22,<?php echo $id_project; ?>,<?php echo $id_line; ?>)">CRITERIO DE PARO</label><embed src="<?php echo "/doctos/$id_project/$id_line/critparo/critparo.pdf" ?>" style=" width: 98%;height: 98%" type="application/pdf"></center></td>
        <td style="width: 20%;"><center><div><label style="cursor: pointer" onclick="xajax_mostrar(23,<?php echo $id_project;?>,<?php echo $id_line;?>)">ANDON</label>
            <br><BR><label style="cursor: pointer" onclick="xajax_mostrar(24,<?php echo $id_project;?>,<?php echo $id_line;?>)">HORA X HORA</label>
            <br><br><label style="cursor: pointer" onclick="xajax_mostrar(25,<?php echo $id_project;?>,<?php echo $id_line;?>)">PULSE</label>
            </div></center></td>
       <td style=" width: 20%"></td>       
         </tr>
         
    </table>        
            </td>
        </tr>
    </table>
    </div>

</td>
<td style="height: 92%" colspan="2"><table style="width: 100%; height: 100%" border="0">
        <tr style=" height:12%; width: 100%">
            <td  >
                <div class="certification1"></div>
                        <div class="certification2">
                            <table style="text-align: center; font-weight: bold;width: 100%;height: 100%;font-size: .7em;font-family: Arial" border="0">
                                <tr>
                            <td style=" width: 20%">5S</td>
                            <td style=" width: 20%">Jidoka</td>
                            <td style=" width: 20%">Standard Work</td>
                            <td style=" width: 20%">Total Productive<br> Maintenance</td>
                            <td style=" width: 20%">Visual Management</td>
                        </tr>
                        <tr>
            
                            <td><center><div id="contDiv1" class="<?php echo $clase1;?>" onclick="xajax_CertLogin(1,<?php echo $id_line;?>)"><br><br><br><br><br>
                                    
                            <table cellspacing="0"  border="0" style=" font-size:.6em; border-collapse: collapse;">
                                <tr><td id="meto1" colspan="2"><?php echo $rowx1[1]['lnp_value'];?></td></tr>
                                <tr><td id="da1"><?php echo $rowx1[3]['lnp_value'];?></td><td id="firma1"><?php echo $rowx1[2]['lnp_value'];?></td></tr>
                            </table>
                                    
                            </div></center></td>
                            <td><center><div id="contDiv2" class="<?php echo $clase2;?>" onclick="xajax_CertLogin(2,<?php echo $id_line;?>)"><br><br><br><br><br>
                            <table cellspacing="0"  border="0" style=" font-size:.2em; border-collapse: collapse;">
                                <tr><td id="meto2" colspan="2"><?php echo $rowx2[1]['lnp_value'];?></td></tr>
                                <tr><td id="da2"><?php echo $rowx2[3]['lnp_value'];?></td><td id="firma2"><?php echo $rowx2[2]['lnp_value'];?></td></tr>
                            </table>
                                </div></center></td>
                            <td><center><div id="contDiv3" class="<?php echo $clase3;?>" onclick="xajax_CertLogin(3,<?php echo $id_line;?>)"><br><br><br><br><br>
                            <table cellspacing="0"  border="0" style=" font-size:.2em; border-collapse: collapse;">
                                <tr><td id="meto3" colspan="2"><?php echo $rowx3[1]['lnp_value'];?></td></tr>
                                <tr><td id="da3"><?php echo $rowx3[3]['lnp_value'];?></td><td id="firma3"><?php echo $rowx3[2]['lnp_value'];?></td></tr>
                            </table>
                                </div></center></td>
                            <td><center><div id="contDiv4" class="<?php echo $clase4;?>" onclick="xajax_CertLogin(4,<?php echo $id_line;?>)"><br><br><br><br><br>
                            <table cellspacing="0"  border="0" style=" font-size:.2em; border-collapse: collapse;">
                                <tr><td id="meto4" colspan="2"><?php echo $rowx4[1]['lnp_value'];?></td></tr>
                                <tr><td id="da4"><?php echo $rowx4[3]['lnp_value'];?></td><td id="firma4"><?php echo $rowx4[2]['lnp_value'];?></td></tr>
                            </table>
                                </div></center></td>
                            <td><center><div id="contDiv5" class="<?php echo $clase5;?>" onclick="xajax_CertLogin(5,<?php echo $id_line;?>)"><br><br><br><br><br>
                            <table cellspacing="0"  border="0" style=" font-size:.2em; border-collapse: collapse;">
                                <tr><td id="meto5" colspan="2"><?php echo $rowx5[1]['lnp_value'];?></td></tr>
                                <tr><td id="da5"><?php echo $rowx5[3]['lnp_value'];?></td><td id="firma5"><?php echo $rowx5[2]['lnp_value'];?></td></tr>
                            </table>
                                </div></center></td>
                        </tr>
                              <tr>
                            <td style=" width: 20%;font-size: .7em">(Blanc)=CBS method to be implemented</td>
                            <td style=" width: 20%;font-size: .7em">Bronze= Base implementation according to standards</td>
                            <td style=" width: 20%;font-size: .7em">Silver= Continuous Implement over time </td>
                            <td colspan="2" style=" width: 20%;font-size: .7em">Gold = Proven sustainability and published Best Practice</td>
                            
                        </tr>
                    </table>
                        </div>
        
            </td>

        </tr>
        <tr style="height: 80%">
                    <td>
                        <div class="div_iframe" id="div_iframe">
                            <div id="andon">
                              <iframe src="<?php echo "/Andon/andon.php?idline=$id_line&idproject=$id_project"; ?>" width="100%" height="100%" frameborder="0" ></iframe>
                            </div>
        
    </div>  
                    </td>
        </tr>
    </table>

</td>
</tr>

</table>
</div>
    <div class="boton" id="boton" style=" visibility: hidden"> </div>
    <div class="botonera" id="botonera" ><form id="botones" name="botones">
      <div style="padding-left:10px">
     <?php 
     
     $sup1=$andon->getSupport($name_line['sba_name'], "Mantenimiento");
     $rows1=$sup1->fetchRow();
     if(!$rows1['enb_id']){$class1="btn1"; $value1="Mantenimiento";}else{$class1="btn1h";$value1="Activado";}
     
     $sup2=$andon->getSupport($name_line['sba_name'], "Procesos");
     $rows2=$sup2->fetchRow();
     if(!$rows2['enb_id']){$class2="btn1"; $value2="Procesos";}else{$class2="btn1h";$value2="Activado";}
     
     $sup3=$andon->getSupport($name_line['sba_name'], "Calidad");
     $rows3=$sup3->fetchRow();
     if(!$rows3['enb_id']){$class3="btn1"; $value3="Calidad";}else{$class3="btn1h";$value3="Activado";}
     
     $sup4=$andon->getSupport($name_line['sba_name'], "Materialistas");
     $rows4=$sup4->fetchRow();
     if(!$rows4['enb_id']){$class4="btn1"; $value4="Materialistas";}else{$class4="btn1h";$value4="Activado";}
     
     $sup5=$andon->getSupport($name_line['sba_name'], "FM");
     $rows5=$sup5->fetchRow();
     if(!$rows5['enb_id']){$class5="btn1"; $value5="FM";}else{$class5="btn1h";$value5="Activado";}
     
     $sup6=$andon->getSupport($name_line['sba_name'], "IHM");
     $rows6=$sup6->fetchRow();
     if(!$rows6['enb_id']){$class6="btn1"; $value6="IHM";}else{$class6="btn1h";$value6="Activado";}
     
     $sup7=$andon->getSupport($name_line['sba_name'], "Control de Produccion");
     $rows7=$sup7->fetchRow();
     if(!$rows7['enb_id']){$class7="btn1"; $value7="Control de Produccion";}else{$class7="btn1h";$value7="Activado";}
     
     $sup8=$andon->getSupport($name_line['sba_name'], "Produccion");
     $rows8=$sup8->fetchRow();
     if(!$rows8['enb_id']){$class8="btn1"; $value8="Produccion";}else{$class8="btn1h";$value8="Activado";}
     
      $sup9=$andon->getSupport($name_line['sba_name'], "IT");
     $rows9=$sup9->fetchRow();
     if(!$rows9['enb_id']){$class9="btn1"; $value9="IT";}else{$class9="btn1h";$value9="Activado";}
    
     ?> <center>
         <table border="0"><tr>
                 <td><label style="font-weight: bold;">Causa:</label></td>
                 <td> <div id="divEqp" style=" text-align: center;color: #003147;">
         <input type="radio" id="radio1" name="cause" value="Q" onclick="xajax_showAlertColor()"><label style=" font-size: 1em">Calidad</label>
         <input type="radio" id="radio2" name="cause" value="E" onclick="xajax_showAlertColor()"><label style=" font-size: 1em">Equipo</label>
         <input type="radio" id="radio3" name="cause" value="M" onclick="xajax_showAlertColor()"><label style=" font-size: 1em">Material</label>
         <input type="radio" id="radio4" name="cause" value="C" onclick="xajax_showAlertColor()"><label style=" font-size: 1em">Cambio</label>
                 </div>
                 </td>
                 <td><br><label style="font-weight: bold;">Luz indicativa:</label></td>
             <td><br><div id="DivColors">
         <input type="radio" id="color1" name="color" value="Red" ><label style=" font-size: 1em; background-color: red">Rojo</label>
         <input type="radio" id="color2" name="color" value="Yellow" ><label style=" font-size: 1em; background-color: yellow">Amarillo</label>
         <input type="radio" id="color2" name="color" value="Blue" ><label style=" font-size: 1em; background-color: blue">Azul</label>
                 </div></td></tr></table></center>
          <table style=" width: 100%"><tr><td>  <div id="DivButtons" style=" visibility: visible">
         <input type="button" class="<?php echo $class1;?>" name="manto" id="manto" value="<?php echo $value1;?>"  onclick="xajax_email(document.getElementById('manto').value,xajax.getFormValues('botones'),1,'<?php echo $name_line['sba_name'];?>')">
         <input type="button" class="<?php echo $class2;?>" name="procesos" id="procesos" value="<?php echo $value2;?>" onclick="xajax_email(document.getElementById('procesos').value,xajax.getFormValues('botones'),2,'<?php echo $name_line['sba_name'];?>')">
         <input type="button" class="<?php echo $class3;?>" name="calidad" id="calidad" value="<?php echo $value3;?>" onclick="xajax_email(document.getElementById('calidad').value,xajax.getFormValues('botones'),3,'<?php echo $name_line['sba_name'];?>')">
         <input type="button" class="<?php echo $class4;?>" name="mate" id="mate" value="<?php echo $value4;?>" onclick="xajax_email(document.getElementById('mate').value,xajax.getFormValues('botones'),4,'<?php echo $name_line['sba_name'];?>')">
         <input type="button" class="<?php echo $class5;?>" name="fm" id="fm" value="<?php echo $value5;?>" onclick="xajax_email(document.getElementById('fm').value,xajax.getFormValues('botones'),5,'<?php echo $name_line['sba_name'];?>')">
         <input type="button" class="<?php echo $class6;?>" name="ihm" id="ihm" value="<?php echo $value6;?>" onclick="xajax_email(document.getElementById('ihm').value,xajax.getFormValues('botones'),6,'<?php echo $name_line['sba_name'];?>')">
         <input type="button" class="<?php echo $class7;?>" name="control" id="control" value="<?php echo $value7;?>" onclick="xajax_email(document.getElementById('control').value,xajax.getFormValues('botones'),7,'<?php echo $name_line['sba_name'];?>')">
         <input type="button" class="<?php echo $class8;?>" name="prod" id="prod" value="<?php echo $value8;?>" onclick="xajax_email(document.getElementById('prod').value,xajax.getFormValues('botones'),8,'<?php echo $name_line['sba_name'];?>')">
         <input type="button" class="<?php echo $class9;?>" name="it" id="it" value="<?php echo $value9;?>" onclick="xajax_email(document.getElementById('it').value,xajax.getFormValues('botones'),9,'<?php echo $name_line['sba_name'];?>')">
         
                      </div></td><td><label style="float: right; font-weight: bold;">Botonera</label></td></tr></table>
      </div>
      </form>
    </div>
       
</body>
</html>
