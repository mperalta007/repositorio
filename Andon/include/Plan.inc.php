<?php

        /** \brief Clase para el manejo de los Componentes
	*
	* En esta clase se definen los metodos para el manejo de los datos de la base de datos de la tabla
	* <b>"production_plan"</b>.
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		Jul 1, 2013
	*
	* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
	*			m&oacute;dulo <b>Componentes</b>.
	*/
	
class Plan extends PEAR {
    
    
     /**
    *  Obtiene las cantidades por proyecto.
    *
    *   @param $partno	(string)	Numero de parte de el proyecto seleccionado
    *	@param $Lunes	(string)	Dia inicial de la semana para la consulta sql
    *	@param $turnoi 	(string)        Turno en que comienza la el dia para la consulta sql
    *   @param $Domingo	(string)	Dia final de la semana para la consulta sql
    *	@param $turnof 	(string)        Tueno en que termina el ultimo dia de la semana para la consulta sql
    *	@return $res 	(object)        Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
         function getQuantiy($partno,$Lunes,$turnoi,$Domingo,$turnof){
         
            $dbmp =& MDB2::connect(SQLC_DBMP);
            $dbmp->setFetchMode(MDB2_FETCHMODE_ASSOC);
            
            if (PEAR::isError($dbmp)){
                die("Error de conexion : ".$dbmp->getMessage());
                exit;
            }
            
           //  $sel =& $db->query("select partno from product_definition where id_pfr=$projet order by id");
             
           $sql="select sum(quantity),x from (SELECT quantity,date_trunc('hour', date_turno) as x FROM v_envios_turno where mlfbbackflush='".$partno."' and date_turno BETWEEN '$Lunes $turnoi' AND '$Domingo $turnof') as a group by x order by x";
          
           $res =& $dbmp->query($sql);
                     
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
                    $sql = "SELECT * FROM production_plan OFFSET $start LIMIT $limit ".$_SESSION['ordering'];
            }else{
                    $sql = "SELECT * FROM production_plan ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql;
          //  Basic::EventLog("production_plan->getAllRecords: ".$sql);
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
                    $sql = "SELECT * FROM production_plan"
                                    ." WHERE ".$filter." like '%".$content."%' "
                                    ." ORDER BY ".$order
                                    ." ".$_SESSION['ordering']
                                    ." OFFSET $start LIMIT $limit $ordering";
                    $sql2 = "SELECT * FROM production_plan WHERE ".$filter." like '%".$content."%'";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql2;
            //Basic::EventLog("production_plan->getRecordsFiltered: ".$sql);
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

            $sql = "SELECT COUNT(*) AS numRows FROM production_plan";

            if(($filter != null) and ($content != null)){
                    $sql = 	"SELECT COUNT(*) AS numRows "
                            ."FROM production_plan "
                            ."WHERE ".$filter." like '%$content%'";
            }
            //Basic::EventLog("production_plan->getNumRows: ".$sql);
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
                            ."FROM v_production_plan "
                            ."WHERE id = $id";
            //Basic::EventLog("Plan->getRecordByID: ".$sql);
            $row =& $db->queryRow($sql);
            return $row;
    }
    
     /**
    *  Devuelte el registro de la semana de acuerdo al yearpasado.
    *
    *	@param $id	(int)	Identificador del registro para hacer la b&uacute;squeda en la consulta SQL.
    *	@return $row	(array)	Arreglo que contiene los datos del registro resultante de la consulta SQL.
    */

    function &getWeekByYear($year){
            global $db;

            $sql = "select DISTINCT (cw) from v_production_plan where year=$year";
            //Basic::EventLog("Plan->getRecordByID: ".$sql);
            $row =& $db->query($sql);
            return $row;
    }
    /**
    *  Devuelte el registro del year de acuerdo al $id pasado.
    *
    *	@param $id	(int)	Identificador del registro para hacer la b&uacute;squeda en la consulta SQL.
    *	@return $row	(array)	Arreglo que contiene los datos del registro resultante de la consulta SQL.
    */
 function &getYearByID($id){
            global $db;

            $sql = "select DISTINCT (year) from v_production_plan where project=$id";
            //Basic::EventLog("Plan->getRecordByID: ".$sql);
            $row =& $db->query($sql);
            return $row;
    }
    
    /**
    *  Devuelte el registro de acuerdo al # de semana pasado.
    *
    *	@param $id	(int)	Identificador del registro para hacer la b&uacute;squeda en la consulta SQL.
    *	@return $row	(array)	Arreglo que contiene los datos del registro resultante de la consulta SQL.
    */
 function &getProductionByCW($cw){
            global $db;

            $sql = "select day, day_shift_qty, night_shift_qty, quantity from v_production_plan where cw=$cw ORDER BY day";
            //Basic::EventLog("Plan->getRecordByID: ".$sql);
            $row =& $db->query($sql);
            return $row;
    }
    
    function formAdd($divName = "grid"){
        $html = '
                        <!-- No edit the next line -->
                        <form method="post" name="f" id="f">

                        <table border="1" width="100%" class="adminlist">
                        <tr>
                                <td nowrap align="left">Sub Ensamble</td>
                                <td align="left"><input type="text" id="partno" name="partno" size="15"></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Cantidad</td>
                                <td align="left"><input type="text" id="quantity" name="quantity" size="10"></td>
                        </tr>
                        <tr>
                                <td colspan="2" align="center"><button id="submitButton" onClick=\'xajax_save(xajax.getFormValues("f"),\''.$divName.'\');return false;\'>Continue</button></td>
                        </tr>
                        </table>
                        </form>
                        * Obligatory fields
                        ';
        //Basic::EventLog($html);
                return $html;
        }

    function formEdit($id){

                $production_plan =& Plan::getRecordByID($id);
                $html = '
                        <!-- No edit the next line -->
                        <form method="post" name="f" id="f">
                        <input type="hidden" id="id" name="id" value="'.$production_plan['id'].'">

                        <table border="1" width="100%" class="adminlist">
                        <tr>
                                <td nowrap align="left">Part Number</td>
                                <td align="left"><input type="text" id="partno" name="partno" size="15" value="'.$production_plan['partno'].'" readonly></td>
                        </tr>
                        <tr>
                                <td nowrap align="left">Type</td>
                                <td align="left"><input type="text" id="description" name="description" size="15" value="'.$production_plan['description'].'"></td>
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

    function insertNewRecord($partno,$quantity,$cw,$dttime){
                global $db;
                
                $sql= "INSERT INTO production_plan (partno,quantity,cw,dttime) VALUES ('".$partno."',".$quantity.",".$cw.",'".$dttime."')";
               // Basic::EventLog("Plan->insertNewRecord: ".$sql);
                
                //Basic::EventLogDB("Product added  - Subensamble:".$f['partno'].", Cantidad: ".$f['quantity']);
                
                $res = $db->query($sql);
                return $res;
        }

        /**
        *  Actualiza un registro de la tabla.
        *
        *       @param $f       (array)         Arreglo que contiene los datos del formulario pasado.
        *       @return $res    (object)        Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del UPDATE.
        */

    function updateRecord($table,$field,$value,$id){
                global $db;

                $sql= "UPDATE $table SET "
                                ."$field='$value' "
                                ."WHERE id=$id";
             //   Basic::EventLog("Product->updateRecord: ".$sql);
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

                $sql = "DELETE FROM production_plan WHERE id = $id";
               // Basic::EventLog("Plan->deleteRecord: ".$sql);
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
                if(empty($f['quantity'])) return "The field Type does not have to be null";
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
	*  getPlanInProjects
	*
	*  En este metodo obtiene todos los productos relacionados a un proyecto
	*
        *      @param $id_project (integer)   Identificador del proyecti
	*      @return $res	(object)	Retorna un objeto con los datos de la consulta ejecutada
	*/
        
        function getPlanInProjects($id_project){
            global $db;

            $sql = "SELECT * FROM v_projects_production_plan WHERE id_project = $id_project";
          //  Basic::EventLog("Product->getPlanInProjects: ".$sql);
            $res =& $db->query($sql);
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
            //Basic::EventLog("Projects->getPlanInProjects: ".$sql);
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
            //Basic::EventLog("Projects->getPlanInProjects: ".$sql);
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
            //Basic::EventLog("Projects->getPlanInProjects: ".$sql);
            $res =& $db->query($sql);
            $html = '<select id="why" name="why" disabled>  /**
	*  getPlanNotInProjects
	*
	*  En este metodo obtiene todos los productos que no estan relacionados a un proyecto
	*
        *      @param $id_project (integer)   Identificador del proyecti
	*      @return $res	(object)	Retorna un objeto con los datos de la consulta ejecutada
	*/
        
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
        
        /**
    *  Obtiene todos los registros de la tabla paginados.
    *
    *   @param $day	(int)	Day of week
    */
    function &getAllRecordsByday($day){
        global $db;

        $sql = "SELECT * FROM v_production_plan";
            
      //  Basic::EventLog("production_plan->getAllRecordsByday: ".$sql);
        $res =& $db->query($sql);
        return $res;
    }
    
    function printTable($dayName, $dayOfWeek, $cw = NULL, $year = NULL){
        
        
        if(!$cw){
            $cw = date("W");
        }
        
        if(!$year){
            $year = date("Y");
        }
        
        $timestamp=mktime(0, 0, 0, 1, 1, $year);
        $timestamp+=$cw*7*24*60*60;
        
        $ultimoDia=$timestamp-(date("w", mktime(0, 0, 0, 1, 1, $year))*24*60*60);
        $primerDia=$ultimoDia-86400*(date('N',$ultimoDia)-1);
        
        
        $currentDayOfWeek = date("w");
        
        $day = date('Y-m-d', strtotime('+'.($dayOfWeek-1).' day',strtotime(date("Y-m-d",$primerDia))));
        
        
        $tableName = 't'.$dayName;
        $html = '

            <input type="hidden" id="cw" name="cw" value="'.$cw.'">
	    <table width="100%" border="0">
                <tr>
		   <td align="left" width="33%">Fecha: '.$day.'</td>
		   <td align="center" width="33%" style="font-size: 200%;"> Semana '.$cw.'</td>
                   <td align="right"  width="33%">&nbsp;
                      &nbsp;<!-- <button onClick="xajax_updateQty(\''.$dayName.'\',\''.$dayOfWeek.'\',\''.$cw.'\',\''.$day.'\');">Agregar registro</button> -->
                   </td>
                
                <tr>
		   <td align="left" width="100%" colspan="3">
                      Producto <input type="text" id="'.$dayName.'partno" name="'.$dayName.'partno" size="20">
                      Cantidad <input type="text" id="'.$dayName.'quantity" name="'.$dayName.'quantity" size="5">
                      <button onClick="xajax_addRecord(document.getElementById(\''.$dayName.'partno\').value,document.getElementById(\''.$dayName.'quantity\').value,\''.$cw.'\',\''.$day.'\',\''.$dayName.'\',\''.$dayOfWeek.'\');">Agregar registro</button>
                   </td>
		</tr>      
                   </td>
                </tr>
                </table>
            <table cellpadding="0" cellspacing="0" border="0" id="'.$tableName.'" class="adminlist" width="98%">
            <thead>
                <tr>
                        <th nowrap width="30%" class="ROH">Proyecto</th>
                        <th nowrap width="10%" class="ROH">Sub Ensamble</th>
                        <th nowrap width="5%" class="ROH">Cantidad</th>
                        <th nowrap width="5%" class="ROH">Tiempo<br>Hora</th>
                        <th nowrap width="5%" class="ROH">Piezas<br>Hora</th>
                        <th nowrap width="5%" class="ROH">Turno<br>Dia</th>
                        <th nowrap width="5%" class="ROH">Total<br>Turno Dia</th>
                        <th nowrap width="5%" class="ROH">Turno<br>Noche</th>
                        <th nowrap width="5%" class="ROH">Total<br>Turno noche</th>
                        <th nowrap width="5%" class="ROH">Gran<br>Total</th>
                        <th nowrap width="5%" class="ROH">Pieza<br>1er lado</th>
                        <th nowrap width="5%" class="ROH">Tiempo<br>Muerto</th>
                        <th nowrap width="5%" class="ROH">Tiempo<br>Real</th>
			<th nowrap width="5%" class="ROH">Eliminar</th>
                </tr>
                </thead>';
         
         $arreglo =& Plan::getRecordByDayAndWeek($cw,$day);
         $x = 0;
            while ($row=$arreglo->fetchRow()) {

               $rowName = $tableName."_".$x;
               $html .= '
                <tr id="'.$rowName.'" class="row1">
                    <td id="'.$rowName.'_0">'.$row[''].'</td>
                    <td id="'.$rowName.'_1">
                        <input type="hidden" id="id_'.$rowName.'" name="id_'.$rowName.'" value="'.$row['id'].'">
                        <!-- <input type="text" id="partno_'.$rowName.'" name="partno_'.$rowName.'" style="border: 0px solid; background-color: transparent;" value="'.$row['partno'].'" onBlur="xajax_checkPartNo(\''.$rowName.'_2\',getElementById(\'partno_'.$rowName.'\').value,\''.$row['id'].'\');"> -->
                        '.$row['partno'].'    
                    </td>
                    <td id="'.$rowName.'_2">
                        <input type="text" id="qty_'.$rowName.'" name="qty_'.$rowName.'" style="border: 0px solid; background-color: transparent;" size="5" value="'.$row['quantity'].'" onBlur="xajax_updateQty(getElementById(\'qty_'.$rowName.'\').value,\''.$row['id'].'\');">
                    </td>
                    <td id="'.$rowName.'_3">'.$row[''].'</td>
                    <td id="'.$rowName.'_4">'.$row[''].'</td>
                    <td id="'.$rowName.'_5">'.$row[''].'</td>
                    <td id="'.$rowName.'_6">'.$row[''].'</td>
                    <td id="'.$rowName.'_7">'.$row[''].'</td>
                    <td id="'.$rowName.'_8">'.$row[''].'</td>
                    <td id="'.$rowName.'_9">'.$row[''].'</td>
                    <td id="'.$rowName.'_10">'.$row[''].'</td>
                    <td id="'.$rowName.'_11">'.$row[''].'</td>
                    <td id="'.$rowName.'_12">'.$row[''].'</td>
		    <td id="'.$rowName.'_13" align="center"><img src="/images/trash.png" border="0" onClick="var parent = $(this).parents().get(1); $(parent).remove(); xajax_deleteRecord(\''.$row['id'].'\');"></td>
                </tr>';
                $x++;
            }
         $html .= '</table>
            ';
           return $html;
        }
        
        
   function getRecordByDayAndWeek($cw,$day){
       global $db;

       $sql = "SELECT * FROM production_plan WHERE cw = $cw AND dttime = '$day' ORDER BY id";
            
      // Basic::EventLog("production_plan->getAllRecords: ".$sql);
       $res =& $db->query($sql);
       return $res;
   }
   
      /**
	*  imprime un select box con todos los year
	*
	*  En este metodo imprime todos los year en un select list
	*  entradas del formulario.
	*
        *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con los year
        *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione un idtype
	*      @return $html	(string)	Retorna el codigo HTML con el select completo
	*/
  function printSelectYear($execFunction=null,$id ){
    
 
                $arreglo =& self::getYearbyID($id);
                
                    $html = "<br><h5>Select Year</h5><br>
                    <select id='year' name='year' onChange=\"xajax_$execFunction(document.getElementById('year').value);\">
                    <option value='0'> --Select--</option>";
                         while ($row=$arreglo->fetchRow()) {
                             
                   $html .= "<option value='".$row['year']."'>".$row['year']."</option>"; }

                      $html .= "</select>";
 return $html;
    
}

   /**
	*  imprime un select box con todas las semanas
	*
	*  En este metodo imprime todas las semanas en un select list
	*  entradas del formulario.
	*
        *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con las semanas
        *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione un idtype
	*      @return $html	(string)	Retorna el codigo HTML con el select completo
	*/
  function printSelectWeek($execFunction=null,$year ){
    
 
                $arreglo =& self::getWeekbyYear($year);
                
                    $html = "<br><h5>Select Week</h5><br>
                    <select id='cw' name='cw' onChange=\"xajax_$execFunction(document.getElementById('cw').value);\">
                    <option value='0'> --Select--</option>";
                         while ($row=$arreglo->fetchRow()) {
                             
                   $html .= "<option value='".$row['cw']."'>".$row['cw']."</option>"; }

                      $html .= "</select>";
 return $html;
    
}
   
}
?>
