<?php
require_once('/var/www/htdocs/vhosts/Andon/include/include.inc.php');


$monitor = new Monitor();

$andon = new Andon();

$res=$andon->getLines();

while($row=$res->fetchRow()){

$monitor->setUnits($row['sba_id']);
//$monitor->setUnits_New($row['sba_id']);

}

//for($i=1;$i<=50;$i++){
//echo "$i<br>";
//DS-ML
//$monitor->setUnits(16);

//Harley davidson pinta
//$monitor->setUnits(30);

//Harley davidson Satellite
//$monitor->setUnits(31);

//Harley davidson Cluster
//$monitor->setUnits(32);

//CVSG L1
//$monitor->setUnits(36);

//CVSG L2
//$monitor->setUnits(37);

//CVSG MEC
//$monitor->setUnits(38);

//Toyota 989A
//$monitor->setUnits(3);

//}

?>
