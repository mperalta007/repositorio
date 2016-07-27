
<!DOCTYPE HTML>
<html>

<head>
    
        <?php
require_once("../include/phpChart/conf.php");
include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
include_once('common.php');
  $xajax->printJavascript("/include/");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<table style=" width:98%; height: 90%" border="0">
    <tr><td>
<?php
$andon = new Andon();
$tipo=$_GET['tipo'];
$id_line=$_GET['id_line'];

$hora=date('His');
        if($hora < '190000' && $hora > '070000'){$turno="DIA";}
        else {$turno ="NOCHE"; }
        
$row=$andon->getGraphByID($id_line, $tipo,$turno);   
 
$s1 = array($row['gph_1'], $row['gph_2'], $row['gph_3'], $row['gph_4'], $row['gph_5'],$row['gph_6'], $row['gph_7'], $row['gph_8'], $row['gph_9'], $row['gph_10']
,$row['gph_11'], $row['gph_12'], $row['gph_13'], $row['gph_14'], $row['gph_15'],$row['gph_16'], $row['gph_17'], $row['gph_18'], $row['gph_19'], $row['gph_20']
,$row['gph_21'], $row['gph_22'], $row['gph_23'], $row['gph_24'], $row['gph_25'],$row['gph_26'], $row['gph_27'], $row['gph_28'], $row['gph_29'], $row['gph_30'],$row['gph_31']);

$l2= array($row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta']
        ,$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta']
        ,$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta'],$row['gph_meta']
         );


    $pc = new C_PhpChartX(array($s1,$l2),'chart2');
    $pc->add_plugins(array('canvasTextRenderer'),true);
    $pc->set_title(array('text'=>"$tipo $turno"));
    $pc->add_series(array('renderer'=>'plugin::BarRenderer'));
    $pc->set_series_color(array('#6666cc', '#000000'));
    
    $pc->set_axes_default(array(
			'tickRenderer'=>'plugin::CanvasAxisTickRenderer',
			'tickOptions'=>array('angle'=>0)));
    
    $pc->set_axes(array(
        'xaxis'=>array('renderer'=>'plugin::CategoryAxisRenderer'),
        'x2axis'=>array('renderer'=>'plugin::CategoryAxisRenderer')
        
    ));
    $pc->set_yaxes(array(
	'yaxis' => array(
		'borderWidth'=>0,
		'borderColor'=>'#ffffff', 
		'min'=>0, 
		'max'=>1, 
                'numberTicks'=>11,
                'tickOptions'=>array('formatString'=>'%#.1f%%'),
		'labelRenderer'=>'plugin::CanvasAxisLabelRenderer',
		'label'=>'Porcentaje')
			));
    $pc->set_grid(array(
	'background'=>'lightyellow', 
	'borderWidth'=>0, 
	'borderColor'=>'#000000', 
	'shadow'=>true, 
	'shadowWidth'=>10, 
	'shadowOffset'=>3, 
	'shadowDepth'=>3, 
	'shadowColor'=>'rgba(230, 230, 230, 0.07)'
	));
    
$pc->set_animate(true);
    $pc->draw(800,500);   

?>
        </td></tr><tr><td>
            Tabla de Valores
<table style=" width: 100%; font-size: 12px" border="1">
    <tr style=" background-color: #FB9D00">
    <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th>
    <th>17</th><th>18</th><th>19</th><th>20</th><th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th><th>31</th>
    <tr>
        <?php 
              
       for($i=1;$i<=31;$i++){
           $columa="gph_$i";
            echo "<td style='width:30px;'><input type='text' id='gph".$i."' value='".$row['gph_'.$i]."' style='width: 100%;' maxlength='3' onblur='xajax_saveGrafica(\"$columa\",this.value,$id_line,\"$tipo\",\"$turno\")'></td>";
       }
        
        ?>
        
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td>Meta:<input type="text" id="meta" style=" width:100px;text-align: center" value="<?php echo $row['gph_meta'];?>" onblur="xajax_saveGrafica('gph_meta',this.value,<?php echo $id_line; ?>, <?php echo "'$tipo'"; ?>,<?php echo "'$turno'"; ?>)"></td>
    </tr>
</table>
</html>
