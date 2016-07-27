<?php
 /******************************************************************************
 *  SIPLACE GDL                                              *
 *  Copyright (C) 2015 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Miguel Peralta                                *
 *  Descripcion:                                                               *
 *    Projects Functions                                                           *
 *                                                                             *
 *  Modifications                                                              *
 *                                                                             *
 ******************************************************************************/

        /** \brief Clase para el andon board
	*
	* En esta clase se definen los metodos para el manejo de los eventos
	* <b>Andon"</b>.
	*
	* @author	Miguel Peralta
	* @version	1.0
	* @date		Jul 1, 2015
	*
	*/
	
class Event extends PEAR {
     
    /**
    *  Obtiene registros de la tabla evl_events_lines.
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getEventActives(){
            global $db;

        $sql = "select * from evl_events_lines where evl_status <> 'Terminado'";                       
        if(DEBUG==false){  Basic::EventLog("getEventActives--->>: ".$sql);}
            $res =& $db->query($sql);
          
            return $res;
    }
    
    /**
    *  Obtiene registros de la tabla lvt_level_time.
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getTimeLevel($level,$id_area){
            global $db;
        $sql = "select lvt_level_$level from lvt_level_time where lvt_id_area =$id_area";                       
        if(DEBUG==false){  Basic::EventLog("getTimeLevel--->>: ".$sql);}
            $res =& $db->queryOne($sql);
          
            return $res;
    }
    
       /**
    *  Obtiene registros de la tabla scu_scal_users.
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getSolucionador($id_event){
            global $db;

        $sql = "select * from evu_event_user where evu_id_event=$id_event";                       
        if(DEBUG==false){  Basic::EventLog("getDestinatario--->>: ".$sql);}
            $res =& $db->query($sql);
          
            return $res;
    }
    
     /**
    *  Obtiene registros de la tabla scu_scal_users.
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getDestinatario($level,$id_area){
            global $db;

        $sql = "select scu_tel from scu_scal_users where scu_id_area=$id_area and scu_id_rango=$level";                       
        if(DEBUG==false){  Basic::EventLog("getDestinatario--->>: ".$sql);}
            $res =& $db->queryOne($sql);
          
            return $res;
    }
    
     /**
    *  Obtiene registros de la tabla scu_scal_users.
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &updateLevel($level,$id_event){
            global $db;

        $sql = "UPDATE evl_events_lines set evl_level='$level' where evl_id=$id_event ";                       
        if(DEBUG==false){  Basic::EventLog("updateLevel--->>: ".$sql);}
            $res =& $db->query($sql);
          
            return $res;
    }
    
}

?>
