
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
<div style="width: 100px;">
<table style=" width:100%; height:100%" border="0">
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
   // $pc->set_title(array('text'=>$tipo));
    $pc->add_series(array('renderer'=>'plugin::BarRenderer'));
    $pc->set_series_color(array('#6666cc', '#000000'));
    
    $pc->set_axes_default(array(
			'tickRenderer'=>'plugin::CanvasAxisTickRenderer',
			'tickOptions'=>array('angle'=>0)));
    
    $pc->set_axes(array(
        'xaxis'=>array('renderer'=>'plugin::CategoryAxisRenderer'),
        'x2axis'=>array('renderer'=>'plugin::CategoryAxisRenderer'),
        'yaxis'=>array('autoscale'=>true),
        'y2axis'=>array('autoscale'=>true)
       
    ));
    $pc->set_yaxes(array(
	'yaxis' => array(
		'borderWidth'=>0,
		'borderColor'=>'#ffffff', 
		'autoscale'=>true, 
		'min'=>0, 
		'max'=>100, 
		'numberTicks'=>11,
                'tickOptions'=>array('formatString'=>''),
		'labelRenderer'=>'plugin::CanvasAxisLabelRenderer',
		)
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
    $pc->draw(110,110);   

?>
        </td></tr>
</table>
</div>
</html>
