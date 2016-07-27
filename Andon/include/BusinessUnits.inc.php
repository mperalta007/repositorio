<?php
 /******************************************************************************
 *  MES Self Service                                              *
 *  Copyright (C) 2013 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                *
 *  Descripcion:                                                               *
 *    BusinessUnits Functions                                                           *
 *                                                                             *
 *  Modifications                                                              *
 *                                                                             *
 ******************************************************************************/

        /** \brief Clase para el manejo de los Componentes
	*
	* En esta clase se definen los metodos para el manejo de los datos de la base de datos de la tabla
	* <b>"bunits"</b>.
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		Jul 1, 2013
	*
	* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
	*			m&oacute;dulo <b>Componentes</b>.
	*/
	
class BusinessUnits extends PEAR {
     
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
                    $sql = "SELECT * FROM bunits OFFSET $start LIMIT $limit ";
            }else{
                    $sql = "SELECT * FROM bunits ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql;
            Basic::EventLog("bunits->getAllRecords: ".$sql);
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
                    $sql = "SELECT * FROM bunits"
                                    ." WHERE ".$filter." like '%".$content."%' "
                                    ." ORDER BY ".$order
                                    ." ".$_SESSION['ordering']
                                    ." OFFSET $start LIMIT $limit $ordering";
                    $sql2 = "SELECT * FROM bunits WHERE ".$filter." like '%".$content."%'";
            }
            $_SESSION['query'] = $sql;
            $_SESSION['query2Excel'] = $sql2;
            //Basic::EventLog("bunits->getRecordsFiltered: ".$sql);
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

            $sql = "SELECT COUNT(*) AS numRows FROM bunits";

            if(($filter != null) and ($content != null)){
                    $sql = 	"SELECT COUNT(*) AS numRows "
                            ."FROM bunits "
                            ."WHERE ".$filter." like '%$content%'";
            }
            //Basic::EventLog("bunits->getNumRows: ".$sql);
            $res =& $db->queryOne($sql);
            return $res;		
    }    
        /**
	*  imprime un select box con las Business Unit correspondientes al id de la division que recive
	*
	*  En este metodo imprime  las Business unit en un select list
	*  	*
         *      @param $Empty (boolean)   0 = Imprime el select vacio, 1 imprime el select con las BU
         *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione una division
	*	@return $html	(string)	Retorna el codigo HTML con el select completo
	*/
function printSelect($id, $execFunction=null){
     
                $arreglo = self::getRecordByID($id);
          
            
                    $html = "<h5>Divisi&oacute;n</h5>
                    <select id='bunits' name='bunits' onChange=\"xajax_$execFunction(document.getElementById('bunits').value);\">
                    <option value='0'> --Seleccionar--</option>";
                          while ($row=$arreglo->fetchRow()) {
                        $html .= "<option value='".$row['id']."'>".$row['alias']."</option>"; }
                   $html .= "</select>";
 return $html;
    }
    /**
    *  Devuelte el registro de acuerdo al $id pasado.
    *
    *	@param $id	(int)	Identificador del registro para hacer la b&uacute;squeda en la consulta SQL.
    *	@return $res	(array)	Arreglo que contiene los datos del registro resultante de la consulta SQL.
    */

    function &getRecordByID($id){
            global $db;
            $sql = "SELECT * FROM v_business_unit WHERE id_division = $id ORDER BY id";
            //Basic::EventLog("BusinessUnits->getRecordByID: ".$sql);
            $res =& $db->query($sql);
            return $res;
    }
    
    function formAdd(){
        $html = '
                        <!-- No edit the next line -->
                        <form method="post" name="f" id="f">

                        <table border="1" width="100%" class="adminlist">
                        <tr>
                                <td nowrap align="left">Proyecto</td>
                                <td align="left"><input type="text" id="strproject" name="strproject" size="15"></td>
                        </tr>
                        <select id="id_bu" name="id_bu">';
                                 $res = BusinessUnits::getAllRecords(0,100);
                                 
                                 while ($row=$res->fetchRow()){
                                     $html .= '<option value="'.$row['id'].'">'.$row['bu'].'</option>';
                                 }
        $html .= '
				</select>
                        <tr>
                                <td colspan="2" align="center"><button id="submitButton" onClick=\'xajax_save(xajax.getFormValues("f"));return false;\'>Continue</button></td>
                        </tr>
                        </table>
                        </form>
                        * Obligatory fields
                        ';

                return $html;
        }
}
?>
