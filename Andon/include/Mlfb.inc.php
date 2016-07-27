<?php

/******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *   Archivo que contiene la clase del manejo de MLFBs
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/


        /** \brief Clase para el manejo de los MLFBs
	*
	* En esta clase se definen los metodos para el manejo de los datos de MLFBs
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		May 26, 2009
	*
	* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
	*			m&oacute;dulo <b>Users</b>.
	*/
	
class MLFB extends PEAR {
  
    /**
	*  Obtiene la conexion a la base de datos primaria, dada el nombre
	*
	*   @param $dbname	(string)	Nombre de la base de datos
	*	@return $res 	(object) Objeto que contiene la conexion a la base de datos
	*/
    function only_connect_primary($dbname) {
    $host = "localhost";
    return pg_connect("host=" . $host ." dbname=" . $dbname ." user=fab");
  }

    /**
	*  Obtiene la conexion a la base de datos primaria y ejecuta una sentencia SQL
	*
	*   @param $dbname	(string)	Nombre de la base de datos
    *   @param $sql	(string)	Sentencia SQL a ejecutar
	*	@return $res 	(object) Objeto que contiene el resultado de la consulta
	*/
  function connect_primary($dbname, $sql) {
    $conn = MLFB::only_connect_primary($dbname);
    $result = pg_exec($conn, $sql);
    pg_close($conn);
    return $result;
  }

    /**
	*  Ejecuta una sentencia SQL en la base de datos primaria en la tabla pack
	*
	*   @param $sql	(string)	Texto que contiene la sentencia SQL a ejecutar
	*	@return $res 	(object) Objeto que contiene el resultado de la consulta
	*/
  function connect_primary_pack($sql) {
      Basic::EventLog("MLFB::connect_primary_pack: $sql");
    return MLFB::connect_primary("pack", $sql);
    
  }
  
   /**
	*  Obtiene la conexion a la base de datos secundaria, dada el nombre
	*
	*   @param $dbname	(string)	Nombre de la base de datos
	*	@return $res 	(object) Objeto que contiene la conexion a la base de datos
	*/
  function only_connect_secondary($dbname) {
    $host = "localhost";
    return pg_connect("host=" . $host ." dbname=" . $dbname ." user=fab");
  }

    /**
	*  Obtiene la conexion a la base de datos secundaria y ejecuta una sentencia SQL
	*
	*   @param $dbname	(string)	Nombre de la base de datos
    *   @param $sql	(string)	Sentencia SQL a ejecutar
	*	@return $res 	(object) Objeto que contiene el resultado de la consulta
	*/
  function connect_secondary($dbname, $sql) {
    $conn = only_connect_secondary($dbname);
    $result = pg_exec($conn, $sql);
    pg_close($conn);
    return $result;
  }

    /**
	*  Ejecuta una sentencia SQL en la base de datos secundaria en la tabla pack
	*
	*   @param $sql	(string)	Texto que contiene la sentencia SQL a ejecutar
	*	@return $res 	(object) Objeto que contiene el resultado de la consulta
	*/
  function connect_secondary_pack($sql) {
    return connect_secondary("pack", $sql);
  }
  
  function exec_query($sql){
    $host = "localhost";
    $conn = pg_connect("host=" . $host ." dbname=" . $dbname ." user=fab");
    $result = pg_exec($conn, $sql);
    pg_close($conn);
    return $result;
  }


    /**
	*  Crea una lista desplegable con los perfiles de la base de datos de pack
	*
	*   @param $withBatch	(boolean)	Indica si debe o no pasar el parametro de Batch a la funcion xajax_onChangePerfil de Xajax
	*	@return $res 	($html) Devuelve el string con el codigo HTML de la lista desplegable
	*/
  function getComboDivision(){
    global $db;
    global $user;

    $sql = "SELECT division FROM product_parameters GROUP BY division";
    $arreglo =& $db->query($sql);
    $html = '<select id="division" name="division" onChange="xajax_onChangeDivision(document.getElementById(\'division\').value);return false;">';
    $html .='	<option value="0"> - Seleccione Division - </option>';
    while($row = $arreglo->fetchRow()){
      $html .= "<OPTION VALUE=".$row['division'].">".$row['division']."</option>";
    }
    $html .= '</select>';
    
    return $html;
  }

    /**
	*  Crea una lista desplegable con los mlfbs de la base de datos de pack
	*
	*   @param $perfil	(string)	Nombre del perfil para ser filtrada la consulta SQL
	*	@return $res 	($html) Devuelve el string con el codigo HTML de la lista desplegable
	*/
  function getComboMLFBs($perfil){
    $sql = "SELECT product_id FROM product_parameters WHERE parameter_value = '$perfil' ORDER BY product_id";
    $result = connect_secondary_pack($sql);
    $html = '<select id="mlfb" name="mlfb" onChange="xajax_onChangeMLFB(document.getElementById(\'perfil\').value,document.getElementById(\'mlfb\').value);return false;">';
    $html .= '<option value="0"> - Selecciones MLFB - </option>';
    if (pg_numrows($result) > 0) {
      for ($i = 0; $i < pg_numrows($result); $i++) {
        $registro = pg_fetch_array($result, $i);
        $html .= "<OPTION VALUE=".$registro[0].">".$registro[0]."</option>";
      }
    }
    $html .= '</select>';
    return $html;
  }
  
  /**
	*  Obtiene todos los MLFBs sus parametros dado un perfil
	*
	*   @param $perfil	(boolean)	Nombre del perfil para ser filtrada la consulta SQL
    *   @param $withBatch	(boolean)	Indica si debe mostrar la columna de Batch o no
	*	@return $res 	($html) Devuelve el string con el codigo HTML de la lista desplegable
	*/
  function getMLFBsList($perfil,$withBatch){
    $sql = "SELECT product_id FROM product_parameters
WHERE product_id NOT IN (
  SELECT product_id FROM product_parameters 
  WHERE product_id IN 
   (SELECT product_id FROM product_parameters WHERE parameter_value = '$perfil' GROUP BY product_id ORDER BY product_id) 
  AND parameter = 'MlfbInactive')
AND product_id IN (SELECT product_id FROM product_parameters WHERE parameter_value = '$perfil' GROUP BY product_id ORDER BY product_id)
GROUP BY product_id ORDER BY product_id";
    $result = connect_secondary_pack($sql);
    $html = '<center><fieldset><table class="adminlist">';
    if($withBatch)
        $html .= '<tr><th width="10">No.</th><th  width="10">Activo</th><th>MLFB</th><th>MLFB Backflush</th><th>No de APD</th><th>Impresora</th><th>Batch</th><th width="10">Editar</th></tr>';
    else
        $html .= '<tr><th width="10">No.</th><th  width="10">Activo</th><th>MLFB</th><th>MLFB Backflush</th><th>No de APD</th><th>Impresora</th><th width="10">Editar</th></tr>';
    if (pg_numrows($result) > 0) {
      for ($i = 0; $i < pg_numrows($result); $i++) {
        $registro = pg_fetch_array($result, $i);
        $result2 = connect_secondary_pack("SELECT * FROM product_parameters WHERE product_id = '".$registro[0]."' UNION SELECT * FROM product_parameters WHERE product_id = '$perfil' ORDER BY parameter");
        if (pg_numrows($result2) > 0) {
          $Backflush = 0;

          $box_check = 0;
          $MlfbStation = "";
          $idx_comment = "";
          $PackagingType = "";
          $count_idx1 = "";
          $MlfbBackflush = "";
          $StatusBackflush = "";
          $APDNo = "";
          $PrinterSAP = "";
          $Batch="";

          for ($ii = 0; $ii < pg_numrows($result2); $ii++) {
            $registro2 = pg_fetch_array($result2, $ii);
            $mlfb = $registro[0];
            if($registro2[2] == 'APDNo' ){	        $APDNo = utf8_decode($registro2[3]);}
            if($registro2[2] == 'Backflush' ){	$Backflush = $registro2[3];}
            if($registro2[2] == 'MlfbBackflush' ){	$MlfbBackflush = $registro2[3];}
            if($registro2[2] == 'idx_comment' ){	$idx_comment = $registro2[3];}
            if($registro2[2] == 'PrinterSAP' ){	$PrinterSAP = $registro2[3];}
            if($registro2[2] == 'count_idx1'){	$count_idx1 = $registro2[3];}
            if($registro2[2] == 'box_check'){       $box_check = $registro2[3];}
            if($registro2[2] == 'MlfbStation'){	$MlfbStation = $registro2[3];}
            if($registro2[2] == 'BatchID'){	$Batch = $registro2[3];}
          }
          $html .= '<tr id="tr'.$mlfb.'">';
          $html .= '<td bgcolor="#CCCCCC" align="center">'.($i+1)."</td>";
          if($Backflush){
            $html .= '<td id="td-'.$mlfb.'-bkf" align="center"><input type="checkbox" id="'.$mlfb.'" checked value="1" onClick="xajax_activeMLFB(\''.$mlfb.'\',this.checked);"></td>';
          }else{
           
            if(strlen($MlfbBackflush) == 0){
              $html .= '<td id="td-'.$mlfb.'-bkf" align="center"><input type="checkbox" disabled id="'.$mlfb.'" value="0" onClick="xajax_activeMLFB(\''.$mlfb.'\',this.checked);"></td>';
            }else{
              $html .= '<td id="td-'.$mlfb.'-bkf" align="center"><input type="checkbox" id="'.$mlfb.'" value="0" onClick="xajax_activeMLFB(\''.$mlfb.'\',this.checked);"></td>';
            }
          }
          $html .= "<td id=\"td-$mlfb\">$mlfb</td>";
          $html .= "<td id=\"td-$mlfb-MlfbBackflush\">$MlfbBackflush</td>";
          $html .= "<td id=\"td-$mlfb-APDNo\">$APDNo</td>";
          $html .= "<td id=\"td-$mlfb-PrinterSAP\">$PrinterSAP</td>";
          if($withBatch) $html .= "<td id=\"td-$mlfb-Batch\">$Batch</td>";
          $html .= '<td align="center"><img src="/images/edit.png" onClick="xajax_editRecord(\''.$mlfb.'\',\''.$MlfbBackflush.'\',\''.$APDNo.'\',\''.$PrinterSAP.'\',\''.$Backflush.'\',\''.$Batch.'\',\''.$withBatch.'\');"></a></td>';
          $html .= "</tr>\n";
        }
      }
    }
    $html .= "</table></fieldset>";
//    Basic::EventLog($html);
    return $html;
  }

    /**
	*  Obtiene todos los MLFBs sus parametros dado un numero de APD
	*
	*   @param $apd	(string)	Nombre del perfil para ser filtrada la consulta SQL
	*	@return $res 	($html) Devuelve el string con el codigo HTML de la lista desplegable
	*/
    function getInfoFromPackAPD($apd){
        //$sql = "SELECT product_id FROM product_parameters WHERE parameter = 'APDNo' AND parameter_value = '$apd' ORDER BY product_id";
        $sql = "SELECT product_id FROM product_parameters
WHERE product_id NOT IN (
  SELECT product_id FROM product_parameters 
  WHERE product_id IN 
   (SELECT product_id FROM product_parameters WHERE parameter = 'APDNo' AND parameter_value = '$apd' GROUP BY product_id ORDER BY product_id) 
  AND parameter = 'MlfbInactive')
AND product_id IN (SELECT product_id FROM product_parameters WHERE parameter = 'APDNo' AND parameter_value = '$apd' GROUP BY product_id ORDER BY product_id)
GROUP BY product_id ORDER BY product_id";
        $result = MLFB::connect_primary_pack($sql);
        
        $html = '
        <fieldset>
				<center>
				<table class="adminlist">
				<tr>
                    <th width="10">No.</th>
					<th>MLFB</th>
					<th>Descripci&oacute;n</th>
					<th>Tipo de Empaque</th>
					<th>Cantidad Unidades</th>
					<th>MLFB Backflush</th>
					<th>Status</th>
					<th>No de APD</th>
					<th>Impresora</th>
				</tr>';
             /*
        if($withBatch)
            $html .= '<tr><th width="10">No.</th><th  width="10">Activo</th><th>MLFB</th><th>MLFB Backflush</th><th>No de APD</th><th>Impresora</th><th>Batch</th></tr>';
        else
            $html .= '<tr><th width="10">No.</th><th  width="10">Activo</th><th>MLFB</th><th>MLFB Backflush</th><th>No de APD</th><th>Impresora</th></tr>';
        */
        if (pg_numrows($result) > 0) {
        for ($i = 0; $i < pg_numrows($result); $i++) {
            $registro = pg_fetch_array($result, $i);
            $sql2 = "SELECT * FROM product_parameters WHERE product_id = '".$registro[0]."' UNION SELECT * FROM product_parameters WHERE product_id = (SELECT parameter_value FROM product_parameters WHERE product_id = 'A2C53371209G-PalletR' AND parameter = 'Profile') ORDER BY parameter";
            
            $result2 = connect_secondary_pack($sql2);
            if (pg_numrows($result2) > 0) {
                $Backflush = 0;
                $box_check = 0;
                $MlfbStation = "";
                $idx_comment = "";
                $PackagingType = "";
                $count_idx1 = "";
                $MlfbBackflush = "";
                $StatusBackflush = "";
                $APDNo = "";
                $PrinterSAP = "";
                $Batch="";
            for ($ii = 0; $ii < pg_numrows($result2); $ii++) {
                $registro2 = pg_fetch_array($result2, $ii);
                $mlfb = $registro[0];
                if($registro2[2] == 'APDNo' ){	        $APDNo = utf8_decode($registro2[3]);}
                if($registro2[2] == 'Backflush' ){	$Backflush = $registro2[3];}
                if($registro2[2] == 'MlfbBackflush' ){	$MlfbBackflush = $registro2[3];}
                if($registro2[2] == 'idx_comment' ){	$idx_comment = $registro2[3];}
                if($registro2[2] == 'PrinterSAP' ){	$PrinterSAP = $registro2[3];}
                if($registro2[2] == 'count_idx1'){	$count_idx1 = $registro2[3];}
                if($registro2[2] == 'box_check'){       $box_check = $registro2[3];}
                if($registro2[2] == 'BatchID'){	$Batch = $registro2[3];}
            }
            $html .= '<tr id="tr'.$mlfb.'">';
            $html .= '<td bgcolor="#CCCCCC" align="center">'.($i+1)."</td>";
            $html .= "<td id=\"td-$mlfb\">$mlfb</td>";
            $html .= "<td id=\"td-$idx_comment\">$idx_comment</td>";
            if($box_check)
                $html .= "<td id=\"td-tarima\">Tarima</td>";
            else
                $html .= "<td id=\"td-caja\">Caja</td>";
            $html .= "<td id=\"td-$count_idx1\">$count_idx1</td>";
            $html .= "<td id=\"td-$mlfb-MlfbBackflush\">$MlfbBackflush</td>";
            if($Backflush){
                $html .= '<td id="td-'.$mlfb.'-bkf" align="center"><input type="checkbox" id="'.$mlfb.'" checked value="1" disabled onClick="xajax_activeMLFB(\''.$mlfb.'\',this.checked);"></td>';
            }else{
                $html .= '<td id="td-'.$mlfb.'-bkf" align="center"><input type="checkbox" id="'.$mlfb.'" value="0" disabled onClick="xajax_activeMLFB(\''.$mlfb.'\',this.checked);"></td>';
            }
            $html .= "<td id=\"td-$mlfb-APDNo\">$APDNo</td>";
            $html .= "<td id=\"td-$mlfb-PrinterSAP\">$PrinterSAP</td>";
            
            if($withBatch) $html .= "<td id=\"td-$mlfb-Batch\">$Batch</td>";
            $html .= "</tr>\n";
        }
      }
    }
    $html .= "</table></fieldset>";

    //Basic::EventLog($html);
    return $html;
    }
    
    /**
	*  Muestra el formulario para editar los parametros de un MLFB
	*
	*   @param $mlfb	(string)	MLFB de empaque
    *   @param $MlfbBackflush	(string)	MLFB registrado en SAP
    *   @param $APDNo	(string)	Numero de APD
    *   @param $PrinterSAP	(string)	Impresora donde se imprime el vale de almacen
    *   @param $Backflush	(boolean)	Bandera para habilitar o deshabilitar el MLFB para BKF automatico
    *   @param $Batch	(string)	Batch ID
    *   @param $withBatch	(boolean)	Indica si debe o no llevar batch
	*	@return $res 	($html) Devuelve el string con el codigo HTML de la lista desplegable
	*/
  function formEdit($mlfb = null ,$MlfbBackflush = null ,$APDNo = null ,$PrinterSAP = null ,$Backflush = null , $Batch = null, $withBatch = 0){
    $html = '
      <form method="post" name="f" id="f">
        <table border="0" width="98%" >
	<tr>
         <td align="right">Activado</td><td align="left">';
    if($Backflush){
	$html .= '<input type="checkbox" name="Backflush" checked value="'.$Backflush.'">';
    }else{
        $html .= '<input type="checkbox" name="Backflush" value="0">';
    }
     $html .= '
	</td>
        </td>
        </tr>
        <tr>
         <td align="right">MLFB Empaque</td><td align="left">
          <input type="text" size="20" value="'.$mlfb.'" name="mlfb" readonly>
        </td>
        </td>
        </tr>
        <tr>
         <td align="right">MLFB SAP</td><td>
          <input type="text" size="20" value="'.$MlfbBackflush.'" name="MlfbBackflush"></td>
        </td>
        </tr>
        <tr>
         <td align="right">No. APD</td><td><input type="text" size="20" value="'.$APDNo.'" name="APDNo"></td>
        </td>
        </tr>';
        if($withBatch){
            $html .= '
                <tr>
                    <td align="right">Batch</td>
                    <td><input type="text" size="20" value="'.$Batch.'" name="Batch"></td>
                </tr>';
        }
        $html .= '
        <tr>
         <td align="right">Impresora SAP</td><td>';
         
         $sql = "SELECT * FROM printers ORDER BY printer";
    $result = MLFB::connect_primary("backflush",$sql);
    $html .= '<SELECT ID="PrinterSAP" NAME="PrinterSAP">';
    if (pg_numrows($result) > 0) {
    for ($i = 0; $i < pg_numrows($result); $i++) {
      $registro = pg_fetch_array($result, $i);
        if($registro[0] == $PrinterSAP){
            $html .= '<OPTION VALUE="'.$registro[0].'" SELECTED>'.$registro[0].' - '.$registro[1].'</OPTION>';
        }else{
            $html .= '<OPTION VALUE="'.$registro[0].'">'.$registro[0].' - '.$registro[1].'</OPTION>';
        }
    }
  }
  $html .= '</SELECT>
         
         </td>
        </td>
        </tr>
        <tr>
         <td colspan="2" align="right">
            <button id="submitButton" onClick=\'xajax_saveData(xajax.getFormValues("f"));return false;\'>Aceptar</button>&nbsp;
            <button onClick=\'javascript:document.getElementById("formDiv").style.visibility="hidden";document.getElementById("generalTable").style.filter="alpha(opacity=100)";return false;\'>Cancelar</button>
        </td>
        </tr>
        </table>
      </form>
    ';
    return $html;
  }
  
  /**
	*  Ejecuta las sentencias SQL para actualizar o insertar registros de parametros de MLFBs
	*
	*   @param $f	(array)	Arreglo que contiene los campos y valores del formulario que se envia
	*	@return None
	*/
    
  function UpdateRecord($f){
    
      $sql = "SELECT * FROM product_parameters WHERE product_id = '".$f['mlfb']."' AND parameter = 'Backflush'";
      $result = MLFB::connect_primary_pack($sql);
      if (pg_numrows($result) > 0) {
        $sql_Backflush = "UPDATE product_parameters SET parameter_value='1' WHERE product_id = '".$f['mlfb']."' AND parameter = 'Backflush'";
        $sql_MlfbBackflush = "UPDATE product_parameters SET parameter_value='".$f['MlfbBackflush']."' WHERE product_id = '".$f['mlfb']."' AND parameter = 'MlfbBackflush'";
        $sql_APDNo = "UPDATE product_parameters SET parameter_value='".$f['APDNo']."' WHERE product_id = '".$f['mlfb']."' AND parameter = 'APDNo'";
        $sql_Printer = "UPDATE product_parameters SET parameter_value='".$f['PrinterSAP']."' WHERE product_id = '".$f['mlfb']."' AND parameter = 'PrinterSAP'";
        $sql_Batch = "UPDATE product_parameters SET parameter_value='".$f['Batch']."' WHERE product_id = '".$f['mlfb']."' AND parameter = 'BatchID'";
      }else{
        $sql_Backflush = "INSERT INTO product_parameters VALUES ('".$f['mlfb']."','A','Backflush','1');";
        $sql_MlfbBackflush = "INSERT INTO product_parameters VALUES ('".$f['mlfb']."','A','MlfbBackflush','".$f['MlfbBackflush']."');";
        $sql_APDNo = "INSERT INTO product_parameters VALUES ('".$f['mlfb']."','A','APDNo','".$f['APDNo']."');";
        $sql_Printer = "INSERT INTO product_parameters VALUES ('".$f['mlfb']."','A','PrinterSAP','".$f['PrinterSAP']."');";
        $sql_Batch = "INSERT INTO product_parameters VALUES ('".$f['mlfb']."','A','BatchID','".$f['Batch']."');";
      }
      $result = MLFB::connect_primary_pack($sql_Backflush);
      $result = MLFB::connect_primary_pack($sql_MlfbBackflush);
      $result = MLFB::connect_primary_pack($sql_APDNo);
      $result = MLFB::connect_primary_pack($sql_Printer);
      $result = MLFB::connect_primary_pack($sql_Batch);
  }
  
  /**
	*  Habilita o deshabilita el MLFB para backflush automatico
	*
	*   @param $mlfb	(string)	MLFB de empaque
    *   @param $active	(booelan)	1 Activar, 0 Desactivar
	*	@return None
	*/
  function toActivateMLFB($mlfb,$active){
    if($active){
      $sql = "UPDATE product_parameters SET parameter_value='1' WHERE product_id = '$mlfb' AND parameter = 'Backflush'";
    }else{
      $sql = "UPDATE product_parameters SET parameter_value='0' WHERE product_id = '$mlfb' AND parameter = 'Backflush'";
    }
    $result = MLFB::connect_primary_pack($sql);
  }
    
    function getComboAPDNo(){
    	global $user;
        //$sql = "select parameter_value from product_parameters where parameter = 'APDNo' GROUP BY parameter_value ORDER BY parameter_value";
        $sql = "SELECT apd FROM apdusers WHERE uid = '".$user->username."'";
        //$result = MLFB::connect_primary_pack($sql);
        $result = MLFB::connect_primary("backflush",$sql);
        $html = '<select id="APDNo" name="APDNo" onChange="xajax_onChangeAPDNo(document.getElementById(\'APDNo\').value);return false;">';
        $html .='	<option value="0"> - Seleccione APD - </option>';
        if (pg_numrows($result) > 0) {
            for ($i = 0; $i < pg_numrows($result); $i++) {
                $registro = pg_fetch_array($result, $i);
                $html .= "<OPTION VALUE=".$registro[0].">".$registro[0]."</option>";
            }
        }
        $html .= '</select>';
        return $html;
    }
  
   /**
	*  Obtiene la lista de impresoras dados el numoro de APD
	*
	*   @param $APDNo	(string)	Numero de APD
    *   @param $active	(booelan)	1 Activar, 0 Desactivar
	*	@return $html (String) Devuelve el string  HTML de la lista desplegable con las impresoras
	*/
    
    function getPrinterListByAPDNo($APDNo){
        $html = 'Impresora
        <SELECT ID="PrinterSAP" NAME="PrinterSAP">';
        $sql = "SELECT * FROM printers ORDER BY printer";
        $result = MLFB::connect_primary("backflush",$sql);
        if (pg_numrows($result) > 0) {
            for ($i = 0; $i < pg_numrows($result); $i++) {
                $registro = pg_fetch_array($result, $i);
                $html .= '<OPTION VALUE="'.$registro[0].'">'.$registro[0].' - '.$registro[1].'</OPTION>';
            }
        }
        $html .= '</SELECT>';
        return $html;
    }
    
    /**
	*  Actuliza la impresosa dado el numero de APD
	*
	*   @param $APDNo	(string)	Numero de APD
    *   @param $PrinterSAP	(booelan)	Nombre de la impresora
	*	@return $res (boolean) Devuelve 1 si se realizo la actualizacion, en todo caso regresa 0
	*/
    function changePrinterByAPDNo($APDNo,$PrinterSAP){
        
        $sql = "UPDATE product_parameters set parameter_value = '$PrinterSAP' WHERE product_id in (SELECT product_id FROM product_parameters WHERE parameter = 'APDNo' AND parameter_value = '$APDNo') AND parameter = 'PrinterSAP'";
        $result = MLFB::connect_primary_pack($sql);
        if($result) return 1; else return 0;
    }
    
   
    
}
?>
