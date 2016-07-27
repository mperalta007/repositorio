<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');

require_once ('common.php');

	function check_session(){
		
		$objResponse = new xajaxResponse();
		if (!isset($_SESSION)){
			$objResponse->addRedirect("/logout.php");
		}else{
			$interval = TIMEOUT * 60 * 1000 + 1000;
			$objResponse->addAlert($interval);
			$objResponse->addScript("setInterval('xajax_check_session()',$interval);");
		}
		return $objResponse->getXML();
	}

  function submitLogin($f){
    global $user;
    $objResponse = new xajaxResponse();

    

     $url = $f['var'];
     
    Basic::EventLog("Ingresando: ".strtolower($f['username']));
    if(empty($f['username'])){ 
      $objResponse->addAlert("Ingrese su UID");
      $objResponse->addScript("document.getElementById('username').focus();");
      return $objResponse->getXML();
    } 
    if(empty($f['password'])) { 
      $objResponse->addAlert("Ingrese su password");
      $objResponse->addScript("document.getElementById('password').focus();");
      return $objResponse->getXML();
    } 

    if(!Basic::checkContent($f['username'])){
      Basic::EventLog("Intento ingresar Sentencia SQL en el username: ".$f['username']);
      return $objResponse->getXML();
    }
    if(!Basic::checkContent($f['password'])) {
      Basic::EventLog("Intento ingresar Sentencia SQL en el password: ".$f['password']);
      return $objResponse->getXML();
    }

    if($user->loginOk(strtolower($f['username']),$f['password'])){
     if ($url == NULL){
            $objResponse->addScript('window.location = "/base/"');
        }else{
            $objResponse->addScript('window.location = "'. $url .'" ');
        }
    }else{
      $objResponse->addAlert("Error: Ingrese sus datos correctamente");
      $objResponse->addAssign("username","value","");
      $objResponse->addAssign("password","value","");
      $objResponse->addScript("document.getElementById('username').focus();");
    }
    
    return $objResponse->getXML();
   }
  
$xajax->processRequests();

?>
