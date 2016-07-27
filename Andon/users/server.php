<?php

/******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *   Modulo de  Administracion de Usuarios
 *                                                                             
 *  Modifications                                                              
 *                                                                             
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
   
function createGrid($start = 0, $limit = 1, $filter = null, $content = null, $order = null, $divName = "grid", $ordering = ""){

	$_SESSION['ordering'] = $ordering;
	
	if(($filter == null) or ($content == null)){
		
		$numRows =& User::getNumRows();
		$arreglo =& User::getAllRecords($start,$limit,$order);
	}else{
		
		$numRows =& User::getNumRows($filter, $content);
		$arreglo =& User::getRecordsFiltered($start, $limit, $filter, $content, $order);	
	}

	// Editable zone

	// Databse Table: fields
	$fields = array();
	$fields[] = 'uid';
	$fields[] = 'module';
	$fields[] = 'perm';
	

	// HTML table: Headers showed
	$headers = array();
	$headers[] = "UID";
	$headers[] = "Modulo";
	$headers[] = "Permiso";

	// HTML table: hearders attributes
	$attribsHeader = array();
	$attribsHeader[] = 'nowrap width="20%"';
	$attribsHeader[] = 'nowrap width="60%"';
	$attribsHeader[] = 'nowrap width="20%"';
	
	// HTML Table: columns attributes
	$attribsCols = array();
	$attribsCols[] = 'nowrap style="text-align: left"';
	$attribsCols[] = 'nowrap style="text-align: left"';
	$attribsCols[] = 'nowrap style="text-align: left"';
	
	// HTML Table: If you want ascendent and descendent ordering, set the Header Events.
	$eventHeader = array();
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","uid","'.$divName.'","ORDERING");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","module","'.$divName.'","ORDERING");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","perm","'.$divName.'","ORDERING");return false;\'';
	
	// Select Box: fields table.
	$fieldsFromSearch = array();
	$fieldsFromSearch[] = 'uid';
	$fieldsFromSearch[] = 'module';
	$fieldsFromSearch[] = 'perm';
	
	// Selecct Box: Labels showed on search select box.
	$fieldsFromSearchShowAs = array();
	$fieldsFromSearchShowAs[] = "UID";
	$fieldsFromSearchShowAs[] = "Module";
	$fieldsFromSearchShowAs[] = "Permiso";
	
	// Create object whit 5 cols and all data arrays set before.
	$table = new ScrollTable(4,$start,$limit,$filter,$numRows,$content,$order);
	$table->setHeader('title',$headers,$attribsHeader,$eventHeader,1,1);
	$table->setAttribsCols($attribsCols);
	$table->addRowSearch("users",$fieldsFromSearch,$fieldsFromSearchShowAs,1);
	
	//while ($arreglo->fetchInto($row)) {
	while($row = $arreglo->fetchRow()){
	// Change here by the name of fields of its database table
		
		$rowc = array();
		$rowc[] = $row['id'];
		$rowc[] = $row['uid'];
		$rowc[] = $row['module'];
		$rowc[] = $row['perm'];
		
		$table->addRow("user",$rowc,1,1,$divName,$fields);
 	}
 	
 	// End Editable Zone
 	
 	$html = $table->render();
// 	$html .= $_SESSION['query'];
 	return $html;
}

function showGrid($start = 0, $limit = 1,$filter = null, $content = null, $order = null, $divName = "grid", $ordering = ""){
	$objResponse = new xajaxResponse();
    $html = createGrid($start, $limit,$filter, $content, $order, $divName, $ordering);
	$objResponse->addAssign($divName, "innerHTML", $html);
	return $objResponse->getXML();
}

function add($table_DB){
   // Edit zone
	$html = Table::Top("Adding Record");  // <-- Set the title for your form.
   $html .= User::formAdd();  // <-- Change by your method
   // End edit zone
   $html .= Table::Footer();
	$objResponse = new xajaxResponse();
	$objResponse->addAssign("formDiv", "style.visibility", "visible");
	$objResponse->addAssign("formDiv", "innerHTML", $html);
	
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
	$html = Table::Top("Editing Record"); 	// <-- Set the title for your form.
   $html .= User::formEdit($id); 			// <-- Change by your method
   $html .= Table::Footer();
   	// End edit zone
	$objResponse = new xajaxResponse();
	$objResponse->addAssign("generalTable", "style.filter", "alpha(opacity=50)");
	//$objResponse->addAssign("generalTable", "style.visibility", "hidden");
	$objResponse->addAssign("formDiv", "style.visibility", "visible");
	
	$objResponse->addAssign("formDiv", "innerHTML", $html);
	return $objResponse->getXML();
}

function delete($id = null, $table_DB = null){
	User::deleteRecord($id); 				// <-- Change by your method
	$html = createGrid(0,ROWSXPAGE,'','','id');
	$objResponse = new xajaxResponse();
	$objResponse->addAssign("grid", "innerHTML", $html);
	$objResponse->addAssign("msgZone", "innerHTML", "Record Deleted"); // <-- Change by your leyend
	return $objResponse->getXML();
}

function show($id = null){
	if($id != null){
	$html = Table::Top("Show Record"); 			// <-- Set the title for your form.
   $html .= User::showRecord($id); 		// <-- Change by your method
   $html .= Table::Footer();
   $objResponse = new xajaxResponse();
   $objResponse->addAssign("formDiv", "style.visibility", "visible");
	$objResponse->addAssign("formDiv", "innerHTML", $html);	
	return $objResponse->getXML();
	}
}

function save($f){
	$objResponse = new xajaxResponse();
	$message = User::checkAllData($f,1); // <-- Change by your method
	if(!$message){
		$respOk = User::insertNewRecord($f); // <-- Change by your method
		if($respOk){
			$html = createGrid(0,ROWSXPAGE);
			$objResponse->addAssign("grid", "innerHTML", $html);
			$objResponse->addAssign("msgZone", "innerHTML", "A record has been added");
			$objResponse->addAssign("formDiv", "style.visibility", "hidden");
		}else{
			$objResponse->addAssign("msgZone", "innerHTML", "The record could not be added");
		}
	}else{
		$objResponse->addAlert($message);
	}
	return $objResponse->getXML();
	
}

function update($f){
    global $user;
    
	$objResponse = new xajaxResponse();
	$message = User::checkAllData($f); // <-- Change by your method
	if(!$message){
		$respOk = User::updateRecord($f); // <-- Change by your method
		if($respOk){
			$html = createGrid(0,ROWSXPAGE);
			$objResponse->addAssign("grid", "innerHTML", $html);
			$objResponse->addAssign("msgZone", "innerHTML", "A record has been updated");
			$objResponse->addAssign("formDiv", "style.visibility", "hidden");
			$objResponse->addAlert("El registro se ha actualizado");
		}else{
			$objResponse->addAssign("msgZone", "innerHTML", "The record could not be updated");
		}
	}else{
		$objResponse->addAlert($message);
	}
	$objResponse->addAssign("generalTable", "style.filter", "alpha(opacity=100)");
	return $objResponse->getXML();
}

function updateField($table, $field, $cell, $value, $id){
	$objResponse = new xajaxResponse();
	$objResponse->addAssign($cell, "innerHTML", $value);
	User::updateField($table,$field,$value,$id);
	return $objResponse->getXML();
}

function selectbydate($date_ini, $date_fin){
	$objResponse = new xajaxResponse();
	if(!strlen($date_ini)){
		$objResponse->addAlert("Por favor, proporcione una fecha de inicio correctamente");
		$objResponse->addScript("document.getElementById('date_ini').focus();");
		return $objResponse->getXML();
	}
	if(!strlen($date_fin)){
		$objResponse->addAlert("Por favor, proporcione una fecha de fin correctamente");
		$objResponse->addScript("document.getElementById('date_fin').focus();");
		return $objResponse->getXML();
	}
	$_SESSION['date_ini'] = $date_ini;
	$_SESSION['date_fin'] = $date_fin;
	
	$objResponse->loadXML(showGrid(0,ROWSXPAGE,'','','date_reci','grid','DESC'));
	return $objResponse->getXML();
}

function unsetall(){
		$objResponse = new xajaxResponse();
		unset($_SESSION['date_ini']);
		unset($_SESSION['date_fin']);
		$objResponse->loadXML(showGrid(0,ROWSXPAGE,'','','date_reci','grid','DESC'));
		return $objResponse->getXML();
}

function checkSAPstatus(){
		$objResponse = new xajaxResponse();
		$fh = fopen("/tmp/.sap_connector", 'r');
		$theData = fread($fh, 1);
		fclose($fh);
		if($theData == "0"){
			$objResponse->addAssign("message", "innerHTML", '<div class="error"><a href="/backflush/monitor/">SAP Connection failed</a></div>');
		}else{
			$objResponse->addAssign("message", "innerHTML", '<div class="success">SAP Connection OK</div>');
		}
		
		return $objResponse->getXML();
}



$xajax->processRequests();

?>
