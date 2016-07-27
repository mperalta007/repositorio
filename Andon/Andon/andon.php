
<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
include_once('common.php');
include 'funciones.php';
$idproject=$_GET['idproject'];
$id_line=$_GET['idline'];

//$mode=$_GET[mode];
header("Refresh: 120; url=/horaxhora/index.php?idline=$id_line&idproject=$idproject");
?>
<html>
<head>
    
    <?php $xajax->printJavascript("/include/");?> 
    
    <script language="JavaScript" src="/include/js/scripts.js"> </script>
    
<link rel='stylesheet' href='/css/style.css'>
        </head>
        <body >
            <div style="height:91%;width: 100%"> 
       <?php
       
encabezado("Inicio","#000000","Usuario");

       $frm = new Formulario();
        
$formulario = $frm->openform("form1","post","usuario","estilo","nada","#000000");
$formulario.= "<div class='isResizable1' align='center'><table border='0' class='tablapr1' align='center' ><tr><td style='border:none' > ".
$frm ->addLabel("BU ", "#FB9D00 ","c56").$frm ->addLabel("","#ffffff","celBU")."</td><td >".
$frm ->addLabel(" Shift ","#FB9D00","cels").$frm ->addLabel("","#ffffff","celShift")."</td><td >".
$frm ->addLabel(" Line ","#FB9D00","c57").$frm ->addLabel("","#ffffff","celLine"). "</td></TR></table> <table border='0'class='tablapr'><TR><td width=15% > ";
$formulario.= $frm->addLabel("Product ", "#FB9D00","cel00")."</td><td colspan='2' class='tdnegro2' >";
$formulario.="<marquee direction='left' id='celpart' name='celpart' onclick='this.start();'  scrolldelay='100' bgcolor='#0000' behavior='slide' scrollamount='20'><span >".
$frm ->addLabel("$partes","#ffffff","cel01")."</span></marquee> ".
$frm ->addLabel(" ","#ffffff","cel03")."</td><td width=20% style='border:solid #FB9D00; text-align:center' >";
$formulario.= $frm ->addLabel("KPI", "#FB9D00","c58")."</td></tr><tr ><td style='border-bottom: none; border-top:solid #FB9D00'>";
$formulario.=$frm->addLabel(' Plan ','#FB9D00',"c59")." </td><td name='tdv' id='tdv'width=30% style='border:solid #FB9D00'rowspan='4'><table id='tablaw' name='tablaw'  class='tablatd1' ><tr><td width=25%>".
$frm->addLabel("0",'','celplan')."</td><td width=75% colspan='2'></td></tr><tr><td>".
$frm->addLabel("0",'','celexp')."</td><td colspan='2' rowspan='2' class='tdverde1' style='font-size:5em'>".
$frm->addLabel('0','','celcount')."</td></tr><tr><td>".
$frm->addLabel('0','','celact')."</td><td colspan='2'></td></tr><tr><td>".
$frm->addLabel('0','','celNOK')."</td><td></td><td colspan='2' style='text-align:rigth; font-size:2em'>Hour</td></tr>";
$formulario.=" </table></td><td width=30% name='tdn' id='tdn' style='border:solid #FB9D00;' rowspan='4' ><table id='tablax' name='tablax' class='tablatd'><tr><td width=25%>".
$frm->addLabel('0','','celn1')."</td><td width=75% colspan='2'></td></tr><tr><td>".
$frm->addLabel('0','','celn2')."</td><td id='celnn' name='celnn' colspan='2' rowspan='2' class='tdnegro1' style='font-size:5em'>".
$frm->addLabel('0','','celn3')."</td></tr><tr><td>".
$frm->addLabel('0','','celn4')."</td><td colspan='2'></td></tr><tr><td>".
$frm->addLabel('0','','celn5')."</td><td></td><td colspan='2' style='text-align:rigth; font-size:2em;'>Shift</td></tr>";
$formulario.=" </table></td><td style='border:solid #FB9D00; font-size:1em; text-align:center' rowspan='4'>";
$formulario.=$frm->addLabel('FPY </br>SCRAP </br> OTHER ','#ffffff','kpi')." </td></tr><tr><td style='border-top: none; border-bottom: none'>";
$formulario.=$frm->addLabel(' Expect ','#FB9D00','idexp')." </td></tr><tr><td style='border-top:none; border-bottom: none'>";
$formulario.=$frm->addLabel(" Actual ", "#FB9D00",'idact')."</td></tr><tr><td style='border-top: none' >";
$formulario.=$frm->addLabel(' NOK ','#FB9D00','idnok')." </td></tr></table>";
$formulario .= $frm->closeform();

 echo $formulario;
       
    ?>
            <div class='div2'><?php
             $celda = new Line();
        
            echo $celda->printtabla($id_line,"singleline");  
                    ?></div></div></div>

</body>
<script type="text/javascript"> 
        
    var idline="<?php echo $id_line;?>";
   
    xajax_lineinfo(idline);
   function change(){ xajax_lineinfo(idline); }
   
       setInterval(change, 500000);  
       
    </script>
</html>
