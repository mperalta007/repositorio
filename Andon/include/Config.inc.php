<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author jvelazqu
 */

/** \brief Clase para el manejo de las configuraciones del sistema
*
* En esta clase se definen los metodos para el manejo de las configuraciones del sistema de la base de datos de la tabla
* <b>"sys_config"</b>.
*
* @author	Jesus Velazquez <jesus.velazquez@continental-corporation.com>
* @version	1.0
* @date		Apr 28, 2014
*
* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
*		m&oacute;dulo <b>Componentes</b>.
*/
class Config extends PEAR {
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
                    $sql = "SELECT * FROM sys_config OFFSET $start LIMIT $limit ".$_SESSION['ordering'];
            }else{
                    $sql = "SELECT * FROM sys_config ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql;
            //Basic::EventLog("Config->getAllRecords: ".$sql);
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
                    $sql = "SELECT * FROM sys_config"
                                    ." WHERE ".$filter." like '%".$content."%' "
                                    ." ORDER BY ".$order
                                    ." ".$_SESSION['ordering']
                                    ." OFFSET $start LIMIT $limit $ordering";
                    $sql2 = "SELECT * FROM sys_config WHERE ".$filter." like '%".$content."%'";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql2;
            //Basic::EventLog("Config->getRecordsFiltered: ".$sql);
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

            $sql = "SELECT COUNT(*) AS numRows FROM sys_config";

            if(($filter != null) and ($content != null)){
                    $sql = 	"SELECT COUNT(*) AS numRows "
                            ."FROM sys_config "
                            ."WHERE ".$filter." like '%$content%'";
            }
            //Basic::EventLog("Config->getNumRows: ".$sql);
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
                            ."FROM sys_config "
                            ."WHERE id = $id";
            //Basic::EventLog("Config->getRecordByID: ".$sql);
            $row =& $db->queryRow($sql);
            return $row;
    }

    function formAdd(){
        $html = '
        <form id="login" name="login">
        <table width="520" border="0" cellspacing="0" cellpadding="0" align="center" class="loginbox">
        <tr>          
          <td>
            <div class="loginbox">
            <table width="50%" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>
              <td align="right" style="white-space: nowrap">
                <label >Username:</label>
              </td>
              <td>
                <input type="text" name="username" id="username" style="width: 150px" />
              </td>
            </tr>
            <tr>
              <td align="right" style="white-space: nowrap">
                <label >Password:</label>
              </td>
              <td>
                <input type="password" name="password" id="password" style="width: 150px" />
              </td>
            </tr>
            <tr>
              <td colspan="2" align="right">
                <input type="button" name="enter" value="Enter" onClick="xajax_submitLogin(xajax.getFormValues(\'login\'));return false;">
              </td>
            </tr>
            </table>
          </div>
          </td>
        </tr>
        </table>
        </form>     ';

                return $html;
        }

     function formEdit($id){

                $sys_config =& Config::getRecordByID($id);
                $html = '
                        <!-- No edit the next line -->
                        <form method="post" name="f" id="f">
                        <input type="hidden" id="id" name="id" value="'.$sys_config['id'].'">

                        <table border="1" width="100%" class="adminlist">
                        <tr>
                                <td nowrap align="left">Part Number</td>
                                <td align="left"><input type="text" id="partno" name="partno" size="15" value="'.$sys_config['partno'].'" readonly></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Type</td>
                                <td align="left"><input type="text" id="description" name="description" size="15" value="'.$sys_config['description'].'"></td>
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
        *  Inserta un nuevo registro en la tabla.
        *
        *       @param $f       (array)         Arreglo que contiene los datos del formulario pasado.
        *       @return $res    (object)        Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del INSERT.
        */

        function insertNewRecord($f){
                global $db;

                $sql= "INSERT INTO sys_config (partno,description) VALUES ("
                                ."'".$f['partno']."', "
                                ."'".$f['description']."')";
                Basic::EventLog("Config->insertNewRecord: ".$sql);
                //Basic::EventLogDB("Config added  - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
                $res =& $db->query($sql);
                return $res;
        }

        /**
        *  Actualiza un registro de la tabla.
        *
        *       @param $f       (array)         Arreglo que contiene los datos del formulario pasado.
        *       @return $res    (object)        Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del UPDATE.
        */

        function updateRecord($f){
                global $db;

                $sql= "UPDATE sys_config SET "
                                ."description='".$f['description']."' "
                                ."WHERE id='".$f['id']."'";
                Basic::EventLog("insertNewRecord->updateRecord: ".$sql);
                //Basic::EventLogDB("Usuario modificado - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
                $res =& $db->query($sql);
                return $res;
        }

    /**
        *  Borra un registro de la tabla.
        *
        *       @param $id              (int)   Identificador del registro a ser borrado.
        *       @return $res    (object) Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del DELETE.
        */

        function deleteRecord($id){
                global $db;

                $sql = "DELETE FROM sys_config WHERE id = $id";
                Basic::EventLog("Config->deleteRecord: ".$sql);
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
                //Basic::EventLog("Product->updateField: ".$sql);
                $res =& $db->query($sql);
                return $res;

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
		if(empty($f['partno'])) return "The field Part No does not have to be null";
                if(empty($f['description'])) return "The field Type does not have to be null";
	 	return 0;
	}

    /**
    *  Obtiene el valor de un parametros
    *
    * @param $table ($parameter) Parametros para extraer sy valor
    * @return $res (string) Devuelve el valor del parametros
    */
        function getParameterValue($parameter){

                global $db;

                $sql = "SELECT value FROM sys_config WHERE parameter = '$parameter'";
                //Basic::EventLog("Config->getParameterValue: ".$sql);
                $res =& $db->queryOne($sql);
                return $res;

        }
}

?>
