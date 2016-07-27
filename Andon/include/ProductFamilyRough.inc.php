<?php

 /******************************************************************************
 *  SIPLACE GDL                                              *
 *  Copyright (C) 2013 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                *
 *  Descripcion:                                                               *
 *    Projects Functions                                                           *
 *                                                                             *
 *  Modifications                                                              *
 *                                                                             *
 ******************************************************************************/

        /** \brief Clase para el manejo de los Componentes
	*
	* En esta clase se definen los metodos para el manejo de los datos de la base de datos de la tabla
	* <b>"projects"</b>.
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		Jul 1, 2013
	*
	* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
	*			m&oacute;dulo <b>Componentes</b>.
	*/
	
class Product_Family_Rough extends PEAR {
     
    /**
    *  Obtiene todos los registros de la tabla paginados.
    *
    *   @param $start	(int)	Inicio del rango de la p&aacute;gina de datos en la consulta SQL.
    *	@param $limit	(int)	L&iacute;mite del rango de la p&aacute;gina de datos en la consultal SQL.
    *	@param $order 	(string) Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getAllRecords(){
            global $db;

                    $sql = "SELECT * FROM product_family_rough order by strname";
          
            //Basic::EventLog("projects->getAllRecords: ".$sql);
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
                    $sql = "SELECT * FROM product_family_rough"
                                    ." WHERE ".$filter." like '%".$content."%' "
                                    ." ORDER BY ".$order
                                    ." ".$_SESSION['ordering']
                                    ." OFFSET $start LIMIT $limit $ordering";
                    $sql2 = "SELECT * FROM product_family_rough WHERE ".$filter." like '%".$content."%'";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql2;
            //Basic::EventLog("projects->getRecordsFiltered: ".$sql);
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

            $sql = "SELECT COUNT(*) AS numRows FROM product_family_rough";

            if(($filter != null) and ($content != null)){
                    $sql = 	"SELECT COUNT(*) AS numRows "
                            ."FROM product_family_rough "
                            ."WHERE ".$filter." like '%$content%'";
            }
            //Basic::EventLog("projects->getNumRows: ".$sql);
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

            $sql ="SELECT * FROM v_product_family_rough WHERE id_product_family = $id ORDER BY strname";
            //Basic::EventLog("Projects->getRecordByID: ".$sql);
            $row =& $db->query($sql);
            return $row;
    }
    
    function formAdd(){
        $html = '
                        <!-- No edit the next line -->
                        <form method="post" name="f" id="f">

                        <table border="1" width="100%" class="adminlist">
                        
                        <tr>
                                <td nowrap align="left">Project</td>
                                <td align="left"><input type="text" id="project" name="project" size="45"></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Description</td>
                                <td align="left"><input type="text" id="description" name="description" size="50"></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Business Unit</td>
                        <td>
                                <select id="id_bunit" name="id_bunit">';
                                 
                                 $res = BusinessUnits::getAllRecords(0,5);
                                 
                                 while ($row=$res->fetchRow()){
                                     $html .= '<option value="'.$row['id'].'">'.$row['bu'].'</option>';
                                 }
        $html .= '
				</select>
                         </td>
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
        *  Inserta un nuevo registro en la tabla.
        *
        *       @param $f       (array)         Arreglo que contiene los datos del formulario pasado.
        *       @return $res    (object)        Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del INSERT.
        */

        function insertNewRecord($f){
                global $db;

                $sql= "INSERT INTO product_family_rough (strname,short_name,id_product_family) VALUES ("
                                ."'".$f['project']."', "
                                ."'".$f['description']."', "
                                ."'".$f['id_bunit']."')";
              //  Basic::EventLog("Projects->insertNewRecord: ".$sql);
                //Basic::EventLogDB("Product added agregado - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
                $res =& $db->query($sql);
                return $res;
        }
        
        function formEdit($id){

                $projects =& Projects::getRecordByID($id);
                $html = '
                        <!-- No edit the next line -->
                        <form method="post" name="f" id="f">
                        <input type="hidden" id="id" name="id" value="'.$projects['id'].'">

                        <table border="1" width="100%" class="adminlist">
                        <tr>
                                <td nowrap align="left">Project</td>
                                <td align="left"><input type="text" id="project" name="project" size="45" value="'.$projects['project'].'" readonly></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Description</td>
                                <td align="left"><input type="text" id="description" name="description" size="50" value="'.$projects['description'].'"></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Business Unit</td>
                                <td align="left">
                                <select id="id_bunit" name="id_bunit">';
                                 
                                 $res = BusinessUnits::getAllRecords(0,5);
                                 
                                 while ($row=$res->fetchRow()){
                                     if($row['id'] == $projects['id_bunit']){
                                        $html .= '<option value="'.$row['id'].'" selected>'.$row['bu'].'</option>';
                                     }else{
                                        $html .= '<option value="'.$row['id'].'">'.$row['bu'].'</option>'; 
                                     }
                                 }
        $html .= '
				</select>
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
        *  Actualiza un registro de la tabla.
        *
        *       @param $f       (array)         Arreglo que contiene los datos del formulario pasado.
        *       @return $res    (object)        Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del UPDATE.
        */

        function updateRecord($f){
                global $db;

                $sql= "UPDATE projects SET "
                                ."description='".$f['description']."', "
                                ."id_bunit='".$f['id_bunit']."' "
                                ."WHERE id='".$f['id']."'";
              //  Basic::EventLog("Projects->updateRecord: ".$sql);
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

                $sql = "DELETE FROM projects WHERE id = $id";
             //   Basic::EventLog("Projects->deleteRecord: ".$sql);
                //Basic::EventLogDB("Usuario eliminado - UID:".$f['uid'].", Modulo: ".$f['module'].", Permiso: ".$f['perm']);
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
	* 									de lo	while arraycontrario significa que esta editando el registro, por tanto no revisa si la
	*									clave es	repetida.
	*	@return $msg	(string)	Devuelve 0 si todos los datos estan correctos, de lo contrario devuelve el mensaje
	*									correspondiente a la validaci&oacute;n.
	*/
	function checkAllData($f,$new = 0){
		if(empty($f['project'])) return "The field Project does not have to be null";
	 	return 0;
	}
        
        
        /**
	*  imprime un select box con todos los proyectos
	*
	*  En este metodo imprime todos los proyectos en un select list
	*  entradas del formulario.
	*
         *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con los proyectos
         *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione un proyecto
	*	@return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function printSelect($id=0,$execFunction){         
                 
                $arreglo =& self::getRecordbyID($id);
                
                    $html = "<h5>Proyecto</h5>
                    <select id='project' name='project' onChange=\"xajax_$execFunction(document.getElementById('project').value);\">
                    <option value='0'> --Seleccionar--</option>";
                         while ($row=$arreglo->fetchRow()) {
                         $html .= "<option value='".$row['id']."'>".$row['strname']."</option>"; }

                      $html .= "</select>";
             
            //Basic::EventLog("Projects->printSelect: ".$html);
            return $html;
        }
        
        /**
	*  imprime una lista de checkbox con todos los proyectos
	*
	*  En este metodo imprime todos los proyectos en una lista de checkbox
	*  entradas del formulario.
	*
         *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con los proyectos
         *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione un proyecto
	*	@return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function printCheckList($id){
         
                 
                $arreglo =& self::getRecordbyID($id);
                $html="<br><table>";
                 while ($row=$arreglo->fetchRow()) {
                    $html.='<tr><td><input type="checkbox" id="'.$row['id'].'" name="projects[]" value="'.$row['id'].'">'.$row['strname'].'</tr></td>';
           }
             $html.='</table><br>'
                     . 'Select Monitor: <select id="selMonitor" name="selMonitor">'
                     . '<option value="1">1</option>'
                     . '<option value="2">2</option>'
                     . '<option value="3">3</option>'
                     . '<option value="4">4</option>'
                     . '<option value="5">5</option>'
                     . '</select><br><br>'
                     . '<input type="button" value="Continuar" onclick="xajax_getLine(xajax.getFormValues(\'general\'))">';
            //Basic::EventLog("Projects->printSelect: ".$html);
            return $html;
        }
        
        /**
	*  imprime un select box con todos los proyectos
	*
	*  En este metodo imprime todos los proyectos en un select list
	*  entradas del formulario.
	*
	*	@return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function printSelectMultiple($id_project = null){
            if(!$id_project){
                
                $html = '
                
                    <table border="0">
                    <tr>
                        <td>
                            Associated
                            <div>
                                <select id="leftValues" name="leftValues[]" size="10" multiple></select>
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="button" id="btnLeft" value="&lt;&lt;" />
                                <input type="button" id="btnRight" value="&gt;&gt;" />
                            </div>
                        </td>
                        <td>
                            Availables
                            <div>
                                <select id="rightValues" name="rightValues[]" size="10" multiple>  
                                </select>
                                <div>
                                   
                                </div>
                            </div>
                        </td>
                    </tr>
                    </table>';
                
            }
            return $html;
        }
        
        /**
	*  Asociacion de numeros de parte
	*
	*  En este metodo asocial los numeros de parte al proyecto
	*
        *	@param $f	(array)		Arreglo que contiene los datos del formularios procesado.
	*	@return None
	*/
        function associatePartNos($f, $user = null){
            global $db;

            $db->query("DELETE FROM projects_products WHERE id_project = ".$f['project']);
            
            foreach ($f['leftValues'] as $key => $value) {
                $sql= "INSERT INTO projects_products VALUES (".$f['project'].",'$value', '$user')";
                $res =& $db->query($sql);
             //   Basic::EventLog("Projects->associatePartNos: " . $value . " - ".$sql);
            }
            return $res;
        }
}
?>
