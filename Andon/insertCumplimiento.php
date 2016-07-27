<?php
require_once('/var/www/htdocs/vhosts/Andon/include/include.inc.php');

$andon   = new Andon();
$res=$andon->getLines();

while($row=$res->fetchRow()){

$andon->insertCumplimiento($row['sba_id']);

}
?>
