<?php
require_once('/var/www/htdocs/vhosts/Andon/include/include.inc.php');

$andon = new Andon();

$res=$andon->getLines();

while($row=$res->fetchRow()){

    $day= date('j')-1;
    $file_name="triangulo".$day;
  
$andon->updatePyramid($file_name, "00FF00", $row['sba_id']);

}
