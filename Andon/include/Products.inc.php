<?php
 /******************************************************************************
 *  SIPLACE GDL                                              *
 *  Copyright (C) 2013 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                *
 *  Descripcion:                                                               *
 *    Products Functions                                                           *
 *                                                                             *
 *  Modifications                                                              *
 *                                                                             *
 ******************************************************************************/

        /** \brief Clase para el manejo de los Componentes
	*
	* En esta clase se definen los metodos para el manejo de los datos de la base de datos de la tabla
	* <b>"products"</b>.
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		Jul 1, 2013
	*
	* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
	*			m&oacute;dulo <b>Componentes</b>.
	*/
	
class Products extends PEAR {
     
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
                    $sql = "SELECT * FROM products OFFSET $start LIMIT $limit ".$_SESSION['ordering'];
            }else{
                    $sql = "SELECT * FROM products ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql;
            //Basic::EventLog("products->getAllRecords: ".$sql);
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
                    $sql = "SELECT * FROM products"
                                    ." WHERE ".$filter." like '%".$content."%' "
                                    ." ORDER BY ".$order
                                    ." ".$_SESSION['ordering']
                                    ." OFFSET $start LIMIT $limit $ordering";
                    $sql2 = "SELECT * FROM products WHERE ".$filter." like '%".$content."%'";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql2;
            //Basic::EventLog("products->getRecordsFiltered: ".$sql);
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

            $sql = "SELECT COUNT(*) AS numRows FROM products";

            if(($filter != null) and ($content != null)){
                    $sql = 	"SELECT COUNT(*) AS numRows "
                            ."FROM products "
                            ."WHERE ".$filter." like '%$content%'";
            }
            //Basic::EventLog("products->getNumRows: ".$sql);
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
                            ."FROM products "
                            ."WHERE id = $id";
            //Basic::EventLog("Products->getRecordByID: ".$sql);
            $row =& $db->queryRow($sql);
            return $row;
    }

    function formAdd(){
        $html = '
                        <!-- No edit the next line -->
                        <form method="post" name="f" id="f">

                        <table border="1" width="100%" class="adminlist">
                        <tr>
                                <td nowrap align="left">Part Number</td>
                                <td align="left"><input type="text" id="partno" name="partno" size="15"></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Description</td>
                                <td align="left"><input type="text" id="description" name="description" size="45"></td>
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

     function formEdit($id){

                $products =& Products::getRecordByID($id);
                $html = '
                        <!-- No edit the next line -->
                        <form method="post" name="f" id="f">
                        <input type="hidden" id="id" name="id" value="'.$products['id'].'">

                        <table border="1" width="100%" class="adminlist">
                        <tr>
                                <td nowrap align="left">Part Number</td>
                                <td align="left"><input type="text" id="partno" name="partno" size="15" value="'.$products['partno'].'" readonly></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Type</td>
                                <td align="left"><input type="text" id="description" name="description" size="15" value="'.$products['description'].'"></td>
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

                $sql= "INSERT INTO products (partno,description) VALUES ("
                                ."'".$f['partno']."', "
                                ."'".$f['description']."')";
                Basic::EventLog("Products->insertNewRecord: ".$sql);
                //Basic::EventLogDB("Product added  - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
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

                $sql= "UPDATE products SET "
                                ."description='".$f['description']."' "
                                ."WHERE id='".$f['id']."'";
                Basic::EventLog("Product->updateRecord: ".$sql);
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

                $sql = "DELETE FROM products WHERE id = $id";
                Basic::EventLog("Products->deleteRecord: ".$sql);
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
	*  imprime un multiple list con todos los productos
	*
	*  En este metodo imprime todos los proyectos en un multiple list
	*  entradas del formulario.
	*
	*	@return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function printSelect($id_project = NULL){
            if(!$id_project){
                
                $html = '
                
                    <table border="0">
                    <tr>
                    <td>
                            Enter Material:
                            <div>
                                '.Basic::prinstAutocompleteInputText('matadded','getPartNosFromDB.php','btnadd').'
                                <script type=\'text/javascript\'>document.getElementById(\'vieadded\');</script>
                                <div>
                                   
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="button" id="btnadd" name="btnadd" onClick=\'xajax_addMat(document.getElementById("matadded").value);return false; \' value="Add" />
                                <input type="button" id="btndel" name="btndel" disabled onClick=\'xajax_deleteMat(document.getElementById("leftValues").value);return false; \' value="Del" />
                            </div>
                        </td>
                        <td>
                            Associated
                            <div>
                                <select id="leftValues" name="leftValues[]" size="10" multiple></select>
                            </div>
                        </td>
                    </tr>
                    </table>';
                
            }
            return $html;
        }
        
        /**
	*  getProductsInProjects
	*
	*  En este metodo obtiene todos los productos relacionados a un proyecto
	*
        *      @param $id_project (integer)   Identificador del proyecti
	*      @return $res	(object)	Retorna un objeto con los datos de la consulta ejecutada
	*/
        
        function getProductsInProjects($id_project){
            global $db;

            $sql = "SELECT * FROM projects_products WHERE id_project = $id_project";
            Basic::EventLog("Product->getProductsInProjects: ".$sql);
            $res =& $db->query($sql);
            return $res;
        }
        
        /**
	*  getProductsNotInProjects
	*
	*  En este metodo obtiene todos los productos que no estan relacionados a un proyecto
	*
        *      @param $id_project (integer)   Identificador del proyecti
	*      @return $res	(object)	Retorna un objeto con los datos de la consulta ejecutada
	*/
        
        function getProductsNotInProjects($id_project = null){
            global $db;

            /*$sql = "SELECT * FROM products WHERE id NOT IN (SELECT id_product FROM v_projects_products WHERE id_project = $id_project) ORDER BY partno";
            //Basic::EventLog("Product->getProductsNotInProjects: ".$sql);
            $res =& $db->query($sql);
            return $res;*/
            /*$conn = oci_connect('wip', 'CamLine4gdl', 'mestq');
                if (!$conn) {
                   $e = oci_error();
                   trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                }
                
                $sql = "SELECT DISTINCT(product_definition) FROM t_wip_job";
                Basic::EventLog("Product->getProductsNotInProjects: ".$frtchi);
                $res = oci_parse($conn, $sql);
                oci_execute($res);*/
            
            
                
                 return $res;
        }
        
        /**
	*  imprime un select box con todos los idtypes
	*
	*  En este metodo imprime todos los idtypes en un select list
	*  entradas del formulario.
	*
        *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con los idtypes
        *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione un idtype
	*      @return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function printSelectIdType($Empty = 0){
            global $db;

            $sql = "SELECT * FROM idtypes";
            //Basic::EventLog("Projects->getProductsInProjects: ".$sql);
            $res =& $db->query($sql);
            $html = '<select id="idtype" name="idtype" onChange="xajax_enableSerialsInput(this.value);">
                        <option value="0">Select...</option>';
            if($res){
                while ($row=$res->fetchRow()) {
                    $html .= '<option value="'.$row['idtype'].'">'.$row['idtype'].'</option>';
                }
            }
            $html .= '</select>';
            //Basic::EventLog("Projects->printSelectIdType: ".$html);
            return $html;
        }
        
         /**
	*  imprime un select box con todos los idtypes
	*
	*  En este metodo imprime todos los idtypes en un select list
	*  entradas del formulario.
	*
        *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con los idtypes
        *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione un idtype
	*      @return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function SelectIdTypeTarget($Empty = 0){
            global $db;

            $sql = "SELECT * FROM idtypes";
            //Basic::EventLog("Projects->getProductsInProjects: ".$sql);
            $res =& $db->query($sql);
            $html = '<select id="idtypetarget" name="idtypetarget" disabled>
                        <option value="0">Select...</option>';
            if($res){
                while ($row=$res->fetchRow()) {
                    $html .= '<option value="'.$row['idtype'].'">'.$row['idtype'].'</option>';
                }
            }
            $html .= '</select>';
            //Basic::EventLog("Projects->printSelectIdType: ".$html);
            return $html;
        }
        
         /**
	*  imprime un select box con todos los idtypes
	*
	*  En este metodo imprime todos los idtypes en un select list
	*  entradas del formulario.
	*
        *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con los idtypes
        *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione un idtype
	*      @return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function selectCauses($Empty = 0){
            global $db;

            $sql = "SELECT * FROM event_causes";
            //Basic::EventLog("Projects->getProductsInProjects: ".$sql);
            $res =& $db->query($sql);
            $html = '<select id="why" name="why" disabled>
                        <option value="0">Select...</option>';
            if($res){
                while ($row=$res->fetchRow()) {
                    $html .= '<option value="'.$row['motivo'].'">'.$row['motivo'].'</option>';
                }
            }
            $html .= '</select>';
            //Basic::EventLog("Projects->printSelectIdType: ".$html);
            return $html;
        }
}
?>
