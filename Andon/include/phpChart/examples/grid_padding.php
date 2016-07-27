<?php
require_once("../conf.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>phpChart - Grid Padding Example</title>
        <style type="text/css">
            .jqplot-target {
                border: 1px solid red;
                margin-left: 20px;
                margin-top: 20px;
                width: 400px;
                height: 300px;
            }
        </style>
    </head>
    <body>
        <div><span> </span><span id="info1b"></span></div>

<?php
    

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 1a Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $pc = new C_PhpChartX(array(array(1,2,1)),'chart1a');
    
    $pc->set_title(array('text'=>'Sample Grid Padding'));
    $pc->draw(360,300);

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 2 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $pc = new C_PhpChartX(array(array(1,2,1)),'chart2');
    
    $pc->set_title(array('text'=>'Sample Grid Padding'));
    $pc->set_grid_padding(array('top'=>null,'right'=>0,'bottom'=>62,'left'=>0));
    $pc->draw(360,300);
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 3 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $pc = new C_PhpChartX(array(array(1,2,1)),'chart3');
    
    $pc->set_title(array('text'=>'Sample Grid Padding'));
    $pc->set_grid_padding(array('right'=>60));
    $pc->draw(360,300);

    ?>

    </body>
</html>