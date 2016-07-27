<?php
require_once('/var/www/htdocs/vhosts/Andon/include/include.inc.php');

$andon   = new Andon();
$lines = new Line();
$res=$andon->getLines();

while($row=$res->fetchRow()){

$lines->InsertActiveTurnos($row['sba_id']);

}
?>