<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
require_once ('common.php');

function alert($auth){
    $objResponse  = new xajaxResponse();
    $objResponse->addAlert("$auth");
    
    return $objResponse->getXML(); 
}

$xajax->processRequests();