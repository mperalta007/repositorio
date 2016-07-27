<?php
 /******************************************************************************
 *  WLS Version 3.x - WLS SYSYTEM                                              *
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                *
 *  Descripcion:                                                               *
 *    Modules Server File                                                       *
 *                                                                             *
 *  Modifications                                                              *
 *                                                                             *
 ******************************************************************************/
include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');

require_once ('common.php');

function check_session(){
            global $db;
            $objResponse = new xajaxResponse();
            if (!isset($_SESSION)){
                    $objResponse->addRedirect("/logout.php");
            }else{
                    $interval = TIMEOUT * 60 * 1000 + 1000;
                    //$objResponse->addAssign("reloj","innerHTML", date("H:i:s"));
                    $objResponse->addScript("setTimeout('xajax_check_session()',$interval);");
            }
            return $objResponse->getXML();
    }
function submitLogin($f){
    global $login;
    $objResponse = new xajaxResponse();

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

    if($login->loginOk($f['username'],$f['password'])){
      $objResponse->addAlert("Bienvenido ".$login->fullName);
    }else{
      $objResponse->addAlert("Error: Ingrese sus datos correctamente");
      $objResponse->addAssign("username","value","");
      $objResponse->addAssign("password","value","");
      $objResponse->addScript("document.getElementById('username').focus();");
    }
    
    return $objResponse->getXML();
   }
function add($table_DB){
   // Edit zone
   $html = Table::Top("Adding Module");  // <-- Set the title for your form.
   $html .= Modules::formAdd();  // <-- Change by your method
   // End edit zone
   $html .= Table::Footer();
   $objResponse = new xajaxResponse();
   $objResponse->addAssign("formDiv", "style.visibility", "visible");
   $objResponse->addAssign("formDiv", "innerHTML", $html);

   return $objResponse->getXML();
}
function save($f){
    $objResponse = new xajaxResponse();
    $message = Modules::checkAllData($f,1); // <-- Change by your method
    if(!$message){
        $respOk = Modules::insertNewRecord($f); // <-- Change by your method
        if($respOk) $objResponse->addAlert("The module has been added successfully");
        else $objResponse->addAlert("Error, The module could not be added");

        $objResponse->addScript("document.location=location.href");
    }else $objResponse->addAlert($message);

    return $objResponse->getXML();

}
function editField($table, $field, $cell, $value, $id){
	$objResponse = new xajaxResponse();

	$html =' <input type="text" id="input'.$cell.'" value="'.$value.'" size="'.(strlen($value)+5).'"'
			.' onBlur="xajax_updateField(\''.$table.'\',\''.$field.'\',\''.$cell.'\',document.getElementById(\'input'.$cell.'\').value,\''.$id.'\');"'
			.' style="background-color: #CCCCCC; border: 1px solid #666666;">';
	$objResponse->addAssign($cell, "innerHTML", $html);
	$objResponse->addScript("document.getElementById('input$cell').focus();");
	return $objResponse->getXML();
}
function edit($id = null, $table_DB = null){
    // Edit zone
    $html = Table::Top("Editing Module"); 	// <-- Set the title for your form.
    $html .= Modules::formEdit($id); 			// <-- Change by your method
    $html .= Table::Footer();
    // End edit zone
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("formDiv", "style.visibility", "visible");
    $objResponse->addAssign("formDiv", "innerHTML", $html);

    return $objResponse->getXML();
}
function update($f){
    $objResponse = new xajaxResponse();
    $message = Modules::checkAllData($f); // <-- Change by your method
    if(!$message){
        $respOk = Modules::updateRecord($f); // <-- Change by your method
        if($respOk) $objResponse->addAlert("The module has been modified successfully");
        else $objResponse->addAlert("Error, The module could not be modified");
        
        $objResponse->addScript("document.location=location.href");
    }else $objResponse->addAlert($message);
    
    return $objResponse->getXML();
}
function delete($id = null, $table_DB = null){
    $objResponse = new xajaxResponse();
    $res = Modules::deleteRecord($id);  // <-- Change by your method
    if($res) $objResponse->addScript("window.location=\"/modules/\"");
    else $objResponse->addAssign("msgZone", "innerHTML", "Error, The module could not be deleted");

    return $objResponse->getXML();
}
function updateField($table, $field, $cell, $value, $id){
	$objResponse = new xajaxResponse();
	$objResponse->addAssign($cell, "innerHTML", $value);
	Modules::updateField($table,$field,$value,$id);
	return $objResponse->getXML();
}
function saveCausa($cause,$partno,$id_line,$hora){
    $units = new Monitor();
	$objResponse = new xajaxResponse();	   
        
      //  $objResponse->addAlert("$cause,$partno,$id_line,$hora");
        $units->updateUnitProduced($id_line, $partno, $hora, $cause);
	return $objResponse->getXML();
}

$xajax->processRequests();

?>
