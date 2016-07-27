<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
	require_once ("xajax.inc.php");

  $xajax = new xajax("server.php");
   $xajax->registerFunction("getProjects");
   $xajax->registerFunction("PrintMode");
   $xajax->registerFunction("PrintAndon");
   $xajax->registerFunction("cambia_turno");
   $xajax->registerFunction("cambia_valor");
   $xajax->registerFunction("lineinfo");
   $xajax->registerFunction("verifica");
   $xajax->registerFunction("getLine");
   