<?php
require_once("../conf.php");
?>
<!DOCTYPE HTML>
<html>
    <title>phpChart - Marker Styles</title>
    <head>
<style type="text/css">
    div.plot {
        margin-bottom: 70px;
        margin-left: 20px;
    }
   
</style>
    </head>
    <body>
        <div><span> </span><span id="info1b"></span></div>

<?php
    



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 1 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $l1 = array(2,5,8,1,9,7);
    $l2 = array(9,13,11);
    $l3 = array(7,6,5,3,2,5);
    $l4 = array(15, 12, 19, 14, 9, 15);
    
    $pc = new C_PhpChartX(array($l1,$l2,$l3,$l4),'chart1');

    $pc->set_legend(array('show'=>true));
    $pc->add_series(array('markerOptions'=>array('style'=>'x')));
    $pc->add_series(array('markerOptions'=>array('style'=>'dash')));
    $pc->add_series(array('markerOptions'=>array('style'=>'plus')));
    $pc->draw(600,300);

   
    ?>

    </body>
</html>