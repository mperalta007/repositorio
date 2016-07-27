<?php
require_once('/var/www/htdocs/vhosts/Andon/include/include.inc.php');

$andon = new Andon();
$res=$andon->getLines();

while($row=$res->fetchRow()){

$dias=$andon->getDaysById($row['sba_id'],"day");
$logros=$andon->getDaysById($row['sba_id'],"logro"); 

        while($day = $dias->fetchRow()){
        $logro = $logros->fetchRow();  
        
        $diaActual=$day['lnp_value'];        
        $diaNew=$diaActual+1;        
        $logroActual=$logro['lnp_value']; 
        
        if($diaNew > $logroActual){$logroNew=$diaNew;}else{$logroNew=$logroActual;}
        
         $andon->updateDays($row['sba_id'], "day",$diaNew);
         $andon->updateDays($row['sba_id'], "logro",$logroNew);
        }
}
