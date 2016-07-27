<?php

/******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *   Archivo que contiene la clase de usuarios
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/

putenv("ORACLE_HOME=/home/oracle/oracle/product/10.2.0/db_1");
putenv("TNS_ADMIN=/home/oracle/oracle/product/10.2.0/db_1/network/admin");
putenv("ORACLE_SID=KSSE");

        /** \brief Clase para el manejo de los usuarios
	*
	* En esta clase se definen los metodos para el manejo de los datos de la base de datos de la tabla
	* <b>"apdusers"</b>.
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		May 26, 2009
	*
	* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
	*			m&oacute;dulo <b>APDUsers</b>.
	*/
	
class APDUser extends PEAR {
	/**
	*  Obtiene todos los registros de la tabla paginados.
	*
	*   @param $start	(int)	Inicio del rango de la p&aacute;gina de datos en la consulta SQL.
	*	@param $limit	(int)	L&iacute;mite del rango de la p&aacute;gina de datos en la consultal SQL.
	*	@param $order 	(string) Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
	*/
	function &getAllRecords($start, $limit, $order = null, $date_ini = '2009-01-01 00:00:00', $date_fin = NOW){
		global $db;
	
		if($order == null){
			$sql = "SELECT * FROM apdusers  OFFSET $start LIMIT $limit ".$_SESSION['ordering'];
		}else{
			$sql = "SELECT * FROM apdusers  ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
		}
		$_SESSION['query'] = $sql;
		Basic::EventLog("apdusers->getAllRecords: ".$sql);
		$res =& $db->query($sql);
		return $res;
	}
	
	/**
	*  Obtiene todos registros de la tabla paginados y aplicando un filtro
	*
	*  @param $start		(int) 		Es el inicio de la p&aacute;gina de datos en la consulta SQL
	*	@param $limit		(int) 		Es el limite de los datos p&aacute;ginados en la consultal SQL.
	*	@param $filter		(string)	Nombre del campo para aplicar el filtro en la consulta SQL
	*	@param $content 	(string)	Contenido a filtrar en la conslta SQL.
	*	@param $order		(string) 	Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $res		(object)	Objeto que contiene el arreglo del resultado de la consulta SQL.
	*/

	function &getRecordsFiltered($start, $limit, $filter = null, $content = null, $order = null, $ordering = "", $date_ini = '2009-01-01 00:00:00', $date_fin = NOW){
		global $db;

		if(($filter != null) and ($content != null)){
			$sql = "SELECT * FROM apdusers "
					." WHERE ".$filter." like '%".$content."%' "
					." ORDER BY ".$order
					." ".$_SESSION['ordering']
					." OFFSET $start LIMIT $limit $ordering";
		}
		$_SESSION['query'] = $sql;
		Basic::EventLog("apdusers->getRecordsFiltered: ".$sql);
		$res =& $db->query($sql);
		return $res;
	}
	
	/**
	*  Devuelte el numero de registros de acuerdo a los par&aacute;metros del filtro
	*
	*	@param $filter	(string)	Nombre del campo para aplicar el filtro en la consulta SQL
	*	@param $order	(string)	Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $row['numrows']	(int) 	N&uacute;mero de registros (l&iacute;neas)
	*/
	
	function &getNumRows($filter = null, $content = null, $date_ini = '2009-01-01 00:00:00', $date_fin = NOW){
		global $db;
		global $user;
		
		$sql = "SELECT COUNT(*) AS numRows FROM apdusers";
		
		if(($filter != null) and ($content != null)){
			$sql = 	"SELECT COUNT(*) AS numRows "
				."FROM apdusers "
				."WHERE ".$filter." like '%$content%'";
		}
		Basic::EventLog("apdusers->getNumRows: ".$sql);
		$res =& $db->queryOne($sql);
		return $res;		
	}
	
	/**
	*  Devuelte el registro de acuerdo al $id pasado.
	*
	*	@param $id	(int)	Identificador del registro para hacer la b&uacute;squeda en la consulta SQL.
	*	@return $row	(array)	Arreglo que contiene los datos del registro resultante de la consulta SQL.
	*/
	
	function &getRecordByID($id){
		global $db;
		
		$sql = "SELECT * "
				."FROM apdusers "
				."WHERE id = $id";
		Basic::EventLog("APDUser->getRecordByID: ".$sql);
		$row =& $db->queryRow($sql);
		return $row;
	}
	
	/**
	*  Inserta un nuevo registro en la tabla.
	*
	*	@param $f	(array)		Arreglo que contiene los datos del formulario pasado.
	*	@return $res	(object) 	Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del INSERT.
	*/
	
	function insertNewRecord($f){
		global $db;
		
		$sql= "INSERT INTO apdusers (apd,uid) VALUES ("
				."'".$f['apd']."', "
				."'".$f['uid']."')";
		Basic::EventLog("APDUsers->insertNewRecord: ".$sql);
		$res =& $db->query($sql);
		return $res;
	}
	
	/**
	*  Actualiza un registro de la tabla.
	*
	*	@param $f	(array)		Arreglo que contiene los datos del formulario pasado.
	*	@return $res	(object)	Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del UPDATE.
	*/
	
	function updateRecord($f){
		global $db;
		
		$sql= "UPDATE apdusers SET "
				."apd='".$f['apd']."', "
				."uid='".$f['uid']."' "
				."WHERE id='".$f['id']."'";
		Basic::EventLog("APDUser->updateRecord: ".$sql);
		$res =& $db->query($sql);
		return $res;
	}
	
	/**
	*  Borra un registro de la tabla.
	*
	*	@param $id		(int)	Identificador del registro a ser borrado.
	*	@return $res	(object) Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del DELETE.
	*/
	
	function deleteRecord($id){
		global $db;
	
		$sql = "DELETE FROM apdusers WHERE id = $id";
		Basic::EventLog("APDUser->deleteRecord: ".$sql);
		$res =& $db->query($sql);
		return $res;
	}

     /**
    *  Actualiza un campo de una tabla dado el criterio
    *
    * @param $table (string) Nombre de la tabla
    * @param $field (string)  Nombre del campo de la tabla a editar
    * @param $value (string)  Contenido con el cual se actualizara el campo
    * @param $id (string)  Identificador unico del registro en la tabla
    * @return $res (bool) Devuelve el resultado de la ejecucion de la consulta
    */
	function updateField($table,$field,$value,$id){

		global $db;
	
		$sql = "UPDATE $table SET $field='$value' WHERE id='$id'";
		Basic::EventLog("APDUser->updateField: ".$sql);
		$res =& $db->query($sql);
		return $res;
		
	}

/**
	*  Obtiene todos los numeros de APD.
	*
	*	@return $res	(object) Devuelve un arreglo con todos los numeros de APD
	*/
	
	function getAllAPD(){
		global $db;
	
		$sql = "SELECT apd FROM apdusers";
		Basic::EventLog("APDUsers->getAllAPD: ".$sql);
		$res =& $db->query($sql);
		return $res;
	}
	
	/**
	*  Imprime la forma para agregar un nuevo registro sobre el DIV identificado por "formDiv".
	*
	*	@param ninguno
	*	@return $html	(string) Devuelve una cadena de caracteres que contiene la forma para insertar 
	*							un nuevo registro.
	*/
	
	function formAdd(){
	$html = '
			<!-- No edit the next line -->
			<form method="post" name="f" id="f">
			
			<table border="1" width="100%" class="adminlist">
			<tr>
				<td nowrap align="left">No, de APD*</td>
				<td align="left">
				<input type="text" id="apd" name="apd" size="5">
				</td>
			</tr>
			<tr>
				<td nowrap align="left">UID*</td>
				<td align="left"><input type="text" id="uid" name="uid" size="15"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><button id="submitButton" onClick=\'xajax_save(xajax.getFormValues("f"));return false;\'>Continue</button></td>
			</tr>
			</table>
			</form>
			* Obligatory fields
			';
		
		return $html;
		/*
				$arreglo = APDUser::getAllAPD();
				while($row = $arreglo->fetchRow()){
					$html .= '<option value="'.$row['apd'].'">'.$row['apd'].'</option>';
				}*/
	}
	
	/**
	*  Imprime la forma para editar un nuevo registro sobre el DIV identificado por "formDiv".
	*
	*	@param $id		(int)		Identificador del registro a ser editado.
	*	@return $html	(string) Devuelve una cadena de caracteres que contiene la forma con los datos 
	*									a extraidos de la base de datos para ser editados 
	*/
	
	function formEdit($id){
		
		$apdusers =& APDUser::getRecordByID($id);
		$html = '
			<!-- No edit the next line -->
			<form method="post" name="f" id="f">
			<input type="hidden" id="id" name="id" value="'.$apdusers['id'].'">
			
			<table border="1" width="100%" class="adminlist">
			<tr>
				<td nowrap align="left">No, de APD*</td>
				<td align="left">
				<input type="text" id="apd" name="apd" size="5" value="'.$apdusers['apd'].'">
				</td>
			</tr>
			<tr>
				<td nowrap align="left">UID*</td>
				<td align="left"><input type="text" id="uid" name="uid" size="15" value="'.$apdusers['uid'].'"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><button id="submitButton" onClick=\'xajax_update(xajax.getFormValues("f"));return false;\'>Continue</button></td>
			</tr>
			</table>
			</form>
			* Obligatory fields
			';
		
		return $html;
	}
	
	/**
	*  Muestra todos los datos de un registro sobre el DIV identificado por "formDiv".
	*
	*	@param $id		(int)		Identificador del registro a ser mostrado.
	*	@return $html	(string) Devuelve una cadena de caracteres que contiene una tabla con los datos 
	*									a extraidos de la base de datos para ser mostrados 
	*/
	function showRecord($id){
			$apdusers =& apdusers::getRecordByID($id);
		$html = '
				<table border="0" width="100%" cellpading="1">
				<tr>
					<td nowrap align="left" width="10%">Last Name:</td>
					<td align="left">'.$apdusers['lastname'].'</td>
				</tr>
				<tr>
					<td nowrap align="left">First Name:</td>
					<td align="left">'.$apdusers['firstname'].'</td>
				</tr>
				<tr>
					<td nowrap align="left">E-Mail:</td>
					<td align="left">'.$apdusers['email'].'</td>
				</tr>
				<tr>
					<td nowrap align="left">Origin:</td>
					<td align="left">'.$apdusers['origin'].'</td>
				</tr>
				</table>';

		return $html;

	}
	
	/**
	*  Verifica si los datos de la forma enviados son correctos de acuerdo a cada validaci&oacute;n en particular.
	*
	*  En este metodo es necesario que sea revisado para hacer las validaciones correspondientes a cada una de las
	*  entradas del formulario.
	*
	*	@param $f	(array)		Arreglo que contiene los datos del formularios procesado.
	*	@param $new	(boolean)	Si recibe el valor de 1 significa que la acci&oacute;n es insertar un nuevo registro,
	* 									de lo	contrario significa que esta editando el registro, por tanto no revisa si la
	*									clave es	repetida.
	*	@return $msg	(string)	Devuelve 0 si todos los datos estan correctos, de lo contrario devuelve el mensaje
	*									correspondiente a la validaci&oacute;n.
	*/
	function checkAllData($f,$new = 0){
		if(empty($f['uid'])) return "The field UID does not have to be null";
	 	return 0;
	}

}
?>
