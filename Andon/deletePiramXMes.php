<?php
require_once('/var/www/htdocs/vhosts/Andon/include/include.inc.php');

$andon = new Andon();

$andon->DeletePyramid();

$res=$andon->getLines();
while($row=$res->fetchRow()){

    $andon->InsertColors($row['sba_id']);
  
}
