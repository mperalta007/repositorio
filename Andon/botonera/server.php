<?php
putenv("ORACLE_HOME=/usr/lib/oracle/xe/app/oracle/product/10.2.0/server");
putenv("ORACLE_SID=mestq");
include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
require_once ('common.php');

$xajax->processRequests();