<?php 
include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
include_once('common.php'); 
$xajax->printJavascript("/include/");
$pyramid = new Andon();
$id_line=$_GET['id_line'];

$arreglo=$pyramid->getCoordenadas();
$colores=$pyramid->getColorsPyramid($id_line);


?>
<link type="text/css" rel="stylesheet" href="/css/dhtmlgoodies_calendar.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="/include/js/dhtmlgoodies_calendar.js"></script>
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
<link type="text/css" rel="stylesheet" href="/css/pizzaron_style.css">
<script type="text/javascript" src="/include/js/stickytooltip.js">
</script>
<link rel="stylesheet" type="text/css" href="/css/stickytooltip.css" />

<center>
       <div class="map" style="display: block; position: relative; padding: 0px; width: 932px; height: 605px;">
           <img src="/images/piramide2.png" class="map maphilighted" usemap="#simple" align="center"
     style="opacity: 0; position: absolute; left: 0px; top: 0px; padding: 0px; border: 0px;"></div>
  <map name="simple">
<?php 
$x=1;
while($row=$arreglo->fetchRow()){
    
   echo' <area id="'.$row['prc_name'].'" shape="poly" coords="'.$row['prc_coord_dos'].'" onclick="xajax_showColor(\''.$row['prc_name'].'\',\''.$id_line.'\')"
          data-maphilight=\'{"stroke":false,"fillColor":"'.$colores['ltc_triangulo'.$x].'","fillOpacity":0.6,"alwaysOn":true}\'>';
$x++;
   
}
 ?>
  </map>
    <div id="formDiv"  class="formDiv"></div><br>
    <form id="pyramid">
      <div>
          <table border='1' style="width: 400px;height: 100px" class="adminlist">
                  <tr style="height: 10px">
                          <th>D&iacute;a</th>
                          <th>Problema</th>
                          <?php 
                          $res=$pyramid->getPyramidProblem($id_line);
                          while($row=$res->fetchRow()){                          
                echo '</tr>
                  <tr style="height: 10px">
                  <td><input type="text"  value="'.$row['pdp_day'].'"  readonly></td>
                  <td><input type="text"  value="'.$row['pdp_problem'].'" style="width: 300px" readonly></td>
                  </tr>';
                          }
                           echo '</tr>
                  <tr style="height: 10px">
                  <td><input type="text" id="date" name="date"  onclick="displayCalendar(document.forms[0].date,\'yyyy-mm-dd\',this)"></td>
                  <td><input type="text" id="issue" name="issue"  style="width: 300px" ></td>
                  <td><input type="button" value="Guardar" onclick="xajax_savePyramid(xajax.getFormValues(\'pyramid\'),'.$id_line.')"></td>
                  </tr>';
                  ?>
                  </tr>
          </table>
      </div>
    </form>
</center>


