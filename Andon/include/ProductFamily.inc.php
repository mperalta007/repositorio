<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 /** \brief Clase para el manejo en general de los Product Familiy
	*
	* En esta clase se definen los metodos para el manejo de los datos de la base de datos de la tabla
	* <b>"product_family"</b>.
	*
	* @author	Miguel Peralta
	* @version	1.0
	* @date		Dic 19, 2014
	*
	* 
	*/
class ProductFamily extends PEAR  {

    /**
    *  Obtiene todos los registros de la tabla product_family.
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    *   
    */
 function &getAllRecords(){
            global $db;
           
                    $sql = "SELECT * FROM v_product_family";
                           
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql;
            //Basic::EventLog("projects->getAllRecords: ".$sql);
            $res =& $db->query($sql);
            return $res;
    }

        /**
	*  imprime un select box con las familias de productos
	*
	*  En este metodo imprime todas las familias de productos en un select list
	*  	*
         *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con las familias
         *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione una division
	*	@return $html	(string)	Retorna el codigo HTML con el select completo
	*/
function printSelect($execFunction=null,$id ){
    
                $arreglo =& self::getRecordbyID($id);
                
                    $html = "<br><h5>Select Product Family</h5><br>
                    <select id='pfamily' name='pfamily' onChange=\"xajax_$execFunction(document.getElementById('pfamily').value);\">
                    <option value='0'> -- None --</option>";
                    while ($row=$arreglo->fetchRow()) {
                     $html .= "<option value='".$row['id']."'>".$row['strname']."</option>"; }

                      $html .= "</select>";
 return $html;
    
}

	/**
	*  Devuelte el registro de acuerdo al $id pasado.
	*
	*	@param $id	(int)	Identificador del registro para hacer la b&uacute;squeda en la consulta SQL.
	*	@return $res	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
	*/
	
	function &getRecordByID($id){
		global $db;
		
		$sql = "SELECT id,strname FROM v_product_family WHERE id_business_unit = $id ORDER BY id";
		//Basic::EventLog("User->getRecordByID: ".$sql);
		$res =& $db->query($sql);
		return $res;
	}
	
	/**
	*  Inserta un nuevo registro en la tabla.
	*
	*	@param $f	(array)		Arreglo que contiene los datos del formulario pasado.
	*	@return $res	(object) 	Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del INSERT.
	*/
	
	function insertNewRecord($f){
		global $db;
		
		$sql= "";
		Basic::EventLog("->insertNewRecord: ".$sql);
	        Basic::EventLogDB();
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
		
		$sql= "";
		Basic::EventLog();
		//Basic::EventLogDB("Usuario modificado - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
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
	
		$sql = "";
		Basic::EventLog();
		//Basic::EventLogDB("Usuario eliminado - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
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
				<td nowrap align="left">UID*</td>
				<td align="left"><input type="text" id="uid" name="uid" size="15"></td>
			</tr>
			<tr>
				<td nowrap align="left">Modulo*</td>
				<td align="left">
				<select id="module" name="module">';
                                 $res = Modules::getAllRecords(0,100,'strmodule');
                                 
                                 while ($row=$res->fetchRow()){
                                     $html .= '<option value="'.$row['strmodule'].'">'.$row['strmodule'].'</option>';
                                 }
        $html .= '
				</select>
				</td>
			</tr>
			<tr>
				<td nowrap align="left">Permiso*</td>
				<td align="left">
				<select id="perm" name="perm">';
                                 $res = Perms::getAllRecords(0,100,'strperm');
                                 
                                 while ($row=$res->fetchRow()){
                                     $html .= '<option value="'.$row['strperm'].'">'.$row['strperm'].'</option>';
                                 }
        $html .= '
				</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><button id="submitButton" onClick=\'xajax_save(xajax.getFormValues("f"));return false;\'>Continue</button></td>
			</tr>
			</table>
			</form>
			* Obligatory fields
			';
		
		return $html;
	}
	
	/**
	*  Imprime la forma para editar un nuevo registro sobre el DIV identificado por "formDiv".
	*
	*	@param $id		(int)		Identificador del registro a ser editado.
	*	@return $html	(string) Devuelve una cadena de caracteres que contiene la forma con los datos 
	*									a extraidos de la base de datos para ser editados 
	*/
	
	function formEdit($id){
		
		$users =& user::getRecordByID($id);
		$html = '
			<!-- No edit the next line -->
			<form method="post" name="f" id="f">
			<input type="hidden" id="id" name="id" value="'.$users['id'].'">
			
			<table border="1" width="100%" class="adminlist">
			<tr>
				<td nowrap align="left">UID*</td>
				<td align="left"><input type="text" id="uid" name="uid" size="15" value="'.$users['uid'].'"></td>
			</tr>
			<tr>
				<td nowrap align="left">Modulo*</td>
				<td align="left">
				<select id="module" name="module">';
                                $res = Modules::getAllRecords(0,100);
                                 
                                 while ($row=$res->fetchRow()){
                                     $html .= '<option value="'.$row['strmodule'].'">'.$row['strmodule'].'</option>';
                                 }
                $html .= '	</select>
				</td>
			</tr>
			<tr>
				<td nowrap align="left">Permiso*</td>
				<td align="left">
				<select id="perm" name="perm">';
                                 $res = Perms::getAllRecords(0,100);
                                 
                                 while ($row=$res->fetchRow()){
                                     $html .= '<option value="'.$row['strperm'].'">'.$row['strperm'].'</option>';
                                 }
        $html .= '</select>
				</td>
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
			$users =& users::getRecordByID($id);
		$html = '
				<table border="0" width="100%" cellpading="1">
				<tr>
					<td nowrap align="left" width="10%">Last Name:</td>
					<td align="left">'.$users['lastname'].'</td>
				</tr>
				<tr>
					<td nowrap align="left">First Name:</td>
					<td align="left">'.$users['firstname'].'</td>
				</tr>
				<tr>
					<td nowrap align="left">E-Mail:</td>
					<td align="left">'.$users['email'].'</td>
				</tr>
				<tr>
					<td nowrap align="left">Origin:</td>
					<td align="left">'.$users['origin'].'</td>
				</tr>
				</table>';

		return $html;

	}
	


}
