<?php
 /******************************************************************************
 *  WLS Version 3.x - WLS SYSYTEM                                              *
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                *
 *  Descripcion:                                                               *
 *    User Functions                                                           *
 *                                                                             *
 *  Modifications                                                              *
 *                                                                             *
 ******************************************************************************/

        /** \brief Clase para el manejo de los usuarios
	*
	* En esta clase se definen los metodos para el manejo de los datos de la base de datos de la tabla
	* <b>"users"</b>.
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		May 26, 2009
	*
	* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
	*			m&oacute;dulo <b>Users</b>.
	*/
	
class User extends PEAR {
     
    /**
	 * <i>integer</i> Auth lifetime in seconds
    *  If this variable is set to 0, auth never expires
    */
    var $expire = 0;

    
    /**
	 * <i>bool</i> Has the auth session expired?
    *  If this variable is set to 0, auth never expires
    */
    var $expired = false;

    /**
	 *  <i>integer</i> Maximum idletime in seconds
     *
     * The difference to $expire is, that the idletime gets
     * refreshed each time checkAuth() is called. If this
     * variable is set to 0, idletime is never checked.
    */
    var $idle = 0;

    /**
	 *  <i>bool</i> Is the maximum idletime over?
    */
    var $idled = false;

    /**
     * <i>string</i> Current authentication status
     */
    var $status = '';

    /**
     * <i>string</i> Auth session-array name
     */
    var $_sessionName = '_AndOn';

    /**
     * <i>array</i> Holds a reference to the session auth variable
     */
    var $session;

    /**
     * <i>array</i> Holds a reference to the global server variable
     */
    var $server;

    /**
     * <i>object</i> PEAR::Log object
     */
    var $logged = 0;

    /**
     * Whether to enable logging of behaviour
     *
     * @var boolean
     */
    var $enableLogging = false;

    /**
     * <i>string</i> Identificador del empleado
     */
    var $username = "";
    /**
     * <i>string</i> Nombre del usuario
     */
    var $fullName = "";

    /**
     * <i>string</i> Numero de personal del empleado
     */
    var $personnel = "";
    
    /**
     * <i>string</i> Cuenta de correo del empleado
     */
    var $email = "";
    
    /**
    **
     * <i>string</i> Nivel de persmisos
     */
    var $perm = "";
    
    /**
    *  Invoca al contructor de PEAR y limpia variables
    *
    * @param none
    * @return none
    */
  
  function User(){
    
    $this->PEAR();
    $this->username = '';
  }

  /**
  *  Verifica que sea un usuario valido para el sistema
  *
  * @param $usuario (string) Nombre de usuario.
  * @param $clave (string) Clave de Usuario en formato MD5
  * @return $res (bool) Devuelve 1 si el usuario es valido, de lo contrario devuelve 0.
  */
  
  function loginOk($username,$password){

    global $user;

    
    $ldaprdn  = "$username@cw01.contiwan.com";
    $ldappass = "$password";
    if(!$ldapconn = ldap_connect(AD_SERVER_PRIMARY,AD_SERVER_PORT)) return false;

    if ($ldapconn) {
      $ldapbind = @(ldap_bind($ldapconn, $ldaprdn, $ldappass));
      if ($ldapbind) {
        $this->logged = true;
        $this->username = $username;
        ldap_close($ldapconn);
        # Connecting to employees database to get user data
        $db =& MDB2::connect(SQLC_USERS);
        $db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        //Basic::EventLog("users->loginOk: ".$db);
        if (PEAR::isError($db)){
           die("Error de conexion : ".$db->getMessage());
           exit;
        }
        $sql = "SELECT * FROM info WHERE uid = '$username'";
        $row =& $db->queryRow($sql);
        $this->username = $username;
        $this->fullName = $row['fullname'];
        $this->email = $row['email'];
        $this->personnel = $row['personnel'];
        return true;
      } else {
        ldap_close($ldapconn);
        return false;
      }
    }
  }

    /**
    *  Valida si la sesion de usuario es valida y esta activa
    *
    * @return boolean  Whether or not the user is authenticated.
    */
    
    function checkAuth(){
      if(($GLOBALS['user']->logged)) {
        $GLOBALS['expire'] = TIME_OUT;
        return true;
      }else{
        return false;
      }
    }
    
   /**
   * Checa si el usuario cuenta con los permisos indicados.
   *
   * Devuelve <code>true</code> si el usuario esta ingresado y si cuenta
   * con los todos permisos indicados. En caso contrario devuelve <code>false</code>.
   *
   * @param variable $... Permisos requeridos.
   * @return boolean
   * @since 1.0
   */

  function checkPerms($module = null)
  {
    global $db;

    $sql = "SELECT perm FROM users WHERE uid = '".$_SESSION['user']->username."' AND module = '$module'";
     Basic::EventLog("users->checkPerms: ".$sql);
    $res = $db->queryOne($sql);
    if (PEAR::isError($res)) {
        die($res->getMessage());
    }
    Basic::EventLog("users->checkPerms: ".$res);
    $this->perm = $res;
    
    return $res;
  }

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
			$sql = "SELECT * FROM users  OFFSET $start LIMIT $limit ".$_SESSION['ordering'];
		}else{
			$sql = "SELECT * FROM users  ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
		}
		$_SESSION['query'] = $sql;
		
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
			$sql = "SELECT * FROM users "
					." WHERE ".$filter." like '%".$content."%' "
					." ORDER BY ".$order
					." ".$_SESSION['ordering']
					." OFFSET $start LIMIT $limit $ordering";
		}
		$_SESSION['query'] = $sql;
		//Basic::EventLog("users->getRecordsFiltered: ".$sql);
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
		
		$sql = "SELECT COUNT(*) AS numRows FROM users";
		
		if(($filter != null) and ($content != null)){
			$sql = 	"SELECT COUNT(*) AS numRows "
				."FROM users "
				."WHERE ".$filter." like '%$content%'";
		}
		//Basic::EventLog("users->getNumRows: ".$sql);
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
				."FROM users "
				."WHERE id = $id";
		//Basic::EventLog("User->getRecordByID: ".$sql);
		$row =& $db->queryRow($sql);
		return $row;
	}
	// putenv("ORACLE_HOME=/home/oracle/oracle/product/10.2.0/db_1");
// putenv("TNS_ADMIN=/home/oracle/oracle/product/10.2.0/db_1/network/admin");
// putenv("ORACLE_SID=KSSE");
	/**
	*  Inserta un nuevo registro en la tabla.
	*
	*	@param $f	(array)		Arreglo que contiene los datos del formulario pasado.
	*	@return $res	(object) 	Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del INSERT.
	*/
	
	function insertNewRecord($f){
		global $db;
		
		$sql= "INSERT INTO users (uid,module,perm) VALUES ("
				."'".$f['uid']."', "
				."'".$f['module']."', "
				."'".$f['perm']."')";
		Basic::EventLog("Users->insertNewRecord: ".$sql);
		//Basic::EventLogDB("Usuario agregado - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
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
		
		$sql= "UPDATE users SET "
				."uid='".$f['uid']."', "
				."module='".$f['module']."', "
				."perm='".$f['perm']."' "
				."WHERE id='".$f['id']."'";
		Basic::EventLog("User->updateRecord: ".$sql);
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
	
		$sql = "DELETE FROM users WHERE id = $id";
		Basic::EventLog("User->deleteRecord: ".$sql);
		//Basic::EventLogDB("Usuario eliminado - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
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
		//Basic::EventLog("User->updateField: ".$sql);
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
        
        /**
	*  imprime un select box con todos los proyectos
	*
	*  En este metodo imprime todos los usuarios en un select list
	*  entradas del formulario.
	*
	*	@return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function printSelect($uid = null){
            if(!$uid){
                $html = "Select Project<br><select id='uid' name='uid'  onChange=\"xajax_selectProducts(document.getElementById('uid').value);\">
                    <option value='0'> -- None --</option>
                    </select>";
            }else{
                global $db;
	
		$arreglo =& $db->query("SELECT DISTINCT(uid) FROM users WHERE perm = 'QualityEngineer' ORDER BY uid");
                    
                $html = "Select UID<br>
                    <select id='uid' name='uid' onChange=\"xajax_selectUsers(document.getElementById('uid').value);\">
                    <option value='0'> -- None --</option>";
                    while ($row=$arreglo->fetchRow()) {
                        $html .= "<option value='".$row['uid']."'>".$row['uid']."</option>";
                    }
                    
                $html .= "</select>";
            }
            //Basic::EventLog("User->printSelect: ".$html);
            return $html;
        }
        
    /**
	*  Informacion del empleado
	*
	*  En este metodo obtiene la información de empleado dad
	*  entradas del formulario.
	*
        *	@param $uid	(string)	UID del empleado
	*	@return $row	(array)     Retorna un areglo con la informacion del empleado
	*/
        function getEmployeeInfo($uid){
            $db =& MDB2::connect(SQLC_USERS);
            $db->setFetchMode(MDB2_FETCHMODE_ASSOC);
            
            if (PEAR::isError($db)){
                die("Error de conexion : ".$db->getMessage());
                exit;
            }
            $sql = "SELECT * FROM info WHERE uid = '$uid'";
            Basic::EventLog("User->getEmployeeInfo: ".$sql);
            $row =& $db->queryRow($sql);
            return $row;
        }
        
        
        function getProjectsInUsers($uid){
            global $db;

            $sql = "SELECT * FROM v_users_projects WHERE uid = '$uid' ORDER BY project";
            //Basic::EventLog("User->getProjectsInUsers: ".$sql);
            $res =& $db->query($sql);
            return $res;
        }
        
        function getProjectsNotInUsers($uid){
            global $db;

            $sql = "SELECT * FROM projects WHERE id NOT IN (SELECT id_project FROM v_users_projects WHERE uid = '$uid') ORDER BY project";
            //Basic::EventLog("User->getProjectsNotInUsers: ".$sql);
            $res =& $db->query($sql);
            return $res;
        }
        
        /**
	*  Asociacion de numeros de parte
	*
	*  En este metodo asocial los numeros de parte al proyecto
	*
        *	@param $f	(array)		Arreglo que contiene los datos del formularios procesado.
	*	@return None
	*/
        function associateProjects($f, $user){
            global $db;

            if($f['newUid']) $f['uid'] = $f['newUid'];
            
            $db->query("DELETE FROM users_projects WHERE uid = '".$f['uid']."'");
            
            foreach ($f['leftValues'] as $key => $value) {
                $sql= "INSERT INTO users_projects VALUES ('".$f['uid']."',$value, '$user')";
                Basic::EventLog("Projects->associatePartNos: ".$sql);
                $res =& $db->query($sql);
            }
            return $res;
        }
        
        /**
	*  Verificacion de UID
	*
	*  En este metodo verifica si existe un usuario en la table users y en la BD de empleados
	*  entradas del formulario.
	*
        *	@param $uid	(string)	UID del empleado
	*	@return $res->numRows();	(integer)     Retorna la cantidad de registros encontrados
	*/
        function checkUID($uid, $criterial = null){
            global $db;
            if($criterial){
                $sql = "SELECT * FROM users WHERE uid = '$uid' $criterial";
            }else{
                $sql = "SELECT * FROM users WHERE uid = '$uid'";
            }
            Basic::EventLog("User->createUID: ".$sql);
            $res =& $db->query($sql);
            
            return $res->numRows();
        }
        
    /**
	*  Informacion del empleado
	*
	*  En este metodo obtiene la información de empleado dad
	*  entradas del formulario.
	*
        *	@param $uid	(string)	UID del empleado
	*	@return $row	(array)     Retorna un areglo con la informacion del empleado
	*/
        function userInfo($uid = null, $user = null){
            $db =& MDB2::connect(SQLC_USERS);
            $db->setFetchMode(MDB2_FETCHMODE_ASSOC);

            if (PEAR::isError($db)){
                die("Error de conexion : ".$db->getMessage());
                exit;
            }
            if ( $user == null ) {
            $sql = "SELECT * FROM info WHERE uid = '$uid'";
            }else if ( $uid == null ) {
                $sql = "SELECT * FROM info WHERE fullname = '$user'";
            }
            
            //Basic::EventLog("User->userInfo: ".$sql);
            $row =& $db->queryRow($sql);
            return $row;
        }
        
    /**
	*  Informacion del empleado
	*
	*  En este metodo obtiene la información de empleado dad
	*  entradas del formulario.
	*
        *	@param $oid	(string)    Id_Event
	*	@return $senders	(array)     Return emails from users into id_event 
	*/    
        function sendMail($oid){
    
            $userauth = Authorizer::getUserByID($oid);
              while ( $rows = $userauth->fetchRow() ){
                 $userInfo = User::userInfo($rows['uid']);
                     if( Authorizer::checkAuth($oid, $rows['uid']) == 't' || ( Authorizer::checkAuth($oid, $rows['uid']) == 'f' )  ){
                          if ( Authorizer::statusUserAuth($oid, $rows['uid']) == 0 ){
                              $senders .= strtolower($userInfo['email'] . ', ');
                          }
                     }
              }
    
            return $senders;
        }
    
    /**
	*  Informacion del empleado
	*
	*  En este metodo obtiene la información de empleado dad
	*  entradas del formulario.
	*
        *	@param $senders	(string)	UID del empleado
        *       @param (string) $message Receive email content.
	*/
        
        function eMail($senders, $message){
            
        $smtpinfo["host"] = "10.218.108.241";
        $smtpinfo["port"] = "25";
        $smtpinfo["auth"] = false;

        $recipients = $senders;


        $headers["MIME-Version"] = "1.0";
        $headers["Content-type"] = "text/html; charset=iso-8859-1";
        $headers["From"] = "PDN MES Self Service<no-reply@continental-corporation.com>";
        $headers["To"] = $recipients;
        $header["Cc"] = $recipients;
        $headers["Subject"] = "Authorization: Movement Units";

        $mail_object =& Mail::factory("smtp", $smtpinfo);

        $mail_object->send($recipients, $headers, $message);
         return 'Correo(s) Enviados.';
        }
        
}
?>
