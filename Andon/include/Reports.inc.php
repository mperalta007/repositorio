<?php
putenv("ORACLE_HOME=/usr/lib/oracle/xe/app/oracle/product/10.2.0/server");
putenv("ORACLE_SID=egpdb");
 /******************************************************************************
 *  MES Self Service 1.x - MES Self-Service - SYSYTEM                          *
 *  Copyright (C) 2013 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Jose Iniguez  (jose.iniguez@continental-corporation.com)           *
 *  Descripcion:                                                               *
 *    Report Functions                                                         *
 *                                                                             *
 *  Modifications                                                              *
 *                                                                             *
 ******************************************************************************/

        /** \brief Clase para el manejo de los usuarios
	*
	* En esta clase se definen los metodos para el manejo de los datos de la base de datos de la tabla
	* <b>"servers"</b>.
	*
	* @author	Jesus Velazquez <jjvema@yahoo.com>
	* @version	1.0
	* @date		May 26, 2009
	*
	* \note 	Para la Versi&oacute;n 1.0 de este sistema, no se ha implementado la funcionalidad de todo el
	*			m&oacute;dulo <b>Reports</b>.
	*/
	
class Report extends PEAR {
 
	/**
	*  Obtiene todos los registros de la tabla paginados.
	*
	*   	@param $start	(int)	Inicio del rango de la p&aacute;gina de datos en la consulta SQL.
	*	@param $limit	(int)	L&iacute;mite del rango de la p&aacute;gina de datos en la consultal SQL.
	*	@param $order 	(string) Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
	*/
	function &getAllRecords($start, $limit, $order = null){
                global $db;
                
                if(!empty($_SESSION['mlfb'])) $subensamble = " AND product IN (".$_SESSION['mlfb'].")";
                else $subensamble = " ";
                
                if($order == null){
                        $sql="SELECT product,process_step,sum(good) AS good, sum(bad) AS bad,
                              CASE WHEN sum(good)=0 THEN 0 
                                   WHEN ((sum(good)-sum(bad))::float / sum(good)*100::float) < 0 THEN 0
                                   ELSE ((sum(good)-sum(bad))::float / sum(good)*100::float) END AS fpy
                              FROM fpy_hourly
                              WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' 
                                    AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":00' $subensamble
                              GROUP BY process_step,product
                              OFFSET $start LIMIT $limit ".$_SESSION['ordering'];
                }else{
                        $sql = "SELECT product,process_step,sum(good) AS good, sum(bad) AS bad,
                                CASE WHEN sum(good)=0 THEN 0 
                                     WHEN ((sum(good)-sum(bad))::float / sum(good)*100::float) < 0 THEN 0
                                     ELSE ((sum(good)-sum(bad))::float / sum(good)*100::float) END AS fpy
                                FROM fpy_hourly
                                WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' 
                                    AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":00' $subensamble
                                GROUP BY process_step,product
                                ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
                }
                $_SESSION['query'] = $sql;
                Basic::EventLog("Reports->getAllRecords: ".$sql);
                $res =& $db->query($sql);
                return $res;
	}
        
        /**
	*  Obtiene todos los registros de la tabla paginados.
	*
	*   	@param $start	(int)	Inicio del rango de la p&aacute;gina de datos en la consulta SQL.
	*	@param $limit	(int)	L&iacute;mite del rango de la p&aacute;gina de datos en la consultal SQL.
	*	@param $order 	(string) Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
	*/
	function &getAllRecordsFailures($start, $limit, $order = null){
              global $db;

              if(!empty($_SESSION['testplan'])) $where_testplan = " AND testplan='".$_SESSION['testplan']."'"; else $where_testplan = "";
              if(!empty($_SESSION['estacion'])) $where_estacion = " AND estacion='".$_SESSION['estacion']."'"; else $where_estacion = "";
              if($order == null){
                   $sql="SELECT * FROM failures_report
                         WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' 
                               AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59'
                               $where_testplan $where_estacion
                         OFFSET $start LIMIT $limit ".$_SESSION['ordering'];
              }else{
                   $sql = "SELECT * FROM failures_report
                           WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' 
                           AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59'
                           $where_testplan $where_estacion
                           ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
              }
              $_SESSION['query'] = $sql;
              Basic::EventLog("Reports->getAllRecordsFailures: ".$sql);
              $res =& $db->query($sql);
              return $res;
	}
        
        /**
	*  Obtiene todos los registros de la tabla paginados.
	*
	*   	@param $start	(int)	Inicio del rango de la p&aacute;gina de datos en la consulta SQL.
	*	@param $limit	(int)	L&iacute;mite del rango de la p&aacute;gina de datos en la consultal SQL.
	*	@param $order 	(string) Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
	*/
	function &getAllRecordsParetoFailures($start, $limit, $order = null){
              global $db;

              if(!empty($_SESSION['testplan'])) $where_testplan = " AND testplan='".$_SESSION['testplan']."'"; else $where_testplan = "";
              if(!empty($_SESSION['estacion'])) $where_estacion = " AND estacion='".$_SESSION['estacion']."'"; else $where_estacion = "";
              if(!empty($_SESSION['mlfb'])) $subensamble = " AND testplan_group IN (".$_SESSION['mlfb'].")"; else $subensamble = " ";
                
              if($order == null){
                   $sql="SELECT * 
                         FROM (SELECT descripcion, count(*) AS ct FROM failures_report 
                               WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' 
                               AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59'
                               $where_testplan $where_estacion $subensamble GROUP BY 1 ORDER BY 1) a
                         OFFSET $start LIMIT $limit ".$_SESSION['ordering'];
              }else{
                   $sql = "SELECT * 
                           FROM (SELECT descripcion, count(*) AS ct FROM failures_report 
                                 WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' 
                                 AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59'
                                 $where_testplan $where_estacion $subensamble GROUP BY 1 ORDER BY 1) a
                           ORDER BY $order ".$_SESSION['ordering']." OFFSET $start LIMIT $limit ";
              }
              $_SESSION['query'] = $sql;
              Basic::EventLog("Reports->getAllRecordsParetoFailures: ".$sql);
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

	function &getRecordsFiltered($start, $limit, $filter = null, $content = null, $order = null, $ordering = ""){
                global $db;

                if(!empty($_SESSION['mlfb'])) $subensamble = " AND product IN (".$_SESSION['mlfb'].")";
                else $subensamble = " ";
                if(($filter != null) and ($content != null)){
                      $sql = "SELECT product,process_step,sum(good) AS good, sum(bad) AS bad,
                              CASE WHEN sum(good)=0 THEN 0 
                                   WHEN ((sum(good)-sum(bad))::float / sum(good)*100::float) < 0 THEN 0
                                   ELSE ((sum(good)-sum(bad))::float / sum(good)*100::float) END AS fpy
                              FROM fpy_hourly
                              WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' "
                             ." AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":00' $subensamble "
                             ." AND UPPER(".$filter.") LIKE UPPER('%".$content."%') "
                             ." GROUP BY process_step,product "
                             ." ORDER BY ".$order." ".$_SESSION['ordering']
                             ." OFFSET $start LIMIT $limit $ordering";
                }
 
                $_SESSION['query'] = $sql;
                Basic::EventLog("Reports->getRecordsFiltered: ".$sql);
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

	function &getRecordsFilteredFailures($start, $limit, $filter = null, $content = null, $order = null, $ordering = ""){
                global $db;
                
                if(!empty($_SESSION['testplan'])) $where_testplan = " AND testplan='".$_SESSION['testplan']."'"; else $where_testplan = "";
                if(!empty($_SESSION['estacion'])) $where_estacion = " AND estacion='".$_SESSION['estacion']."'"; else $where_estacion = "";
                
                if(($filter != null) and ($content != null)){
                      $sql = "SELECT * FROM failures_report
                              WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' 
                              AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59' "
                             ." $where_testplan $where_estacion"
                             ." AND UPPER(".$filter.") LIKE UPPER('%".$content."%') "
                             ." ORDER BY ".$order." ".$_SESSION['ordering']
                             ." OFFSET $start LIMIT $limit $ordering";
                }
                $_SESSION['query'] = $sql;
                Basic::EventLog("Reports->getRecordsFilteredFailures: ".$sql);
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

	function &getRecordsFilteredParetoFailures($start, $limit, $filter = null, $content = null, $order = null, $ordering = ""){
                global $db;
                                
                if(!empty($_SESSION['testplan'])) $where_testplan = " AND testplan='".$_SESSION['testplan']."'"; else $where_testplan = "";
                if(!empty($_SESSION['estacion'])) $where_estacion = " AND estacion='".$_SESSION['estacion']."'"; else $where_estacion = "";
                if(!empty($_SESSION['mlfb'])) $subensamble = " AND testplan_group IN (".$_SESSION['mlfb'].")"; else $subensamble = " ";
                
                if(($filter != null) and ($content != null)){
                      $sql = "SELECT * 
                              FROM (SELECT descripcion, count(*) AS ct FROM failures_report
                                    WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' 
                                    AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59' 
                                    $where_testplan $where_estacion $subensamble GROUP BY 1 ORDER BY 1) a"
                           ." WHERE UPPER(".$filter.") LIKE UPPER('%".$content."%') "
                           ." ORDER BY ".$order." ".$_SESSION['ordering']
                           ." OFFSET $start LIMIT $limit $ordering";
                }
                $_SESSION['query'] = $sql;
                Basic::EventLog("Reports->getRecordsFilteredParetoFailures: ".$sql);
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
	
	function &getNumRows($filter = null, $content = null){
		global $db;
                
                if(!empty($_SESSION['mlfb'])) $subensamble = " AND product IN (".$_SESSION['mlfb'].")";
                else $subensamble = " ";
                $sql = "SELECT COUNT(*) AS numRows FROM ( SELECT COUNT(*) FROM fpy_hourly "
		       ."WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' "
                       ."AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":00' $subensamble 
                        GROUP BY process_step,product) a";

                if(($filter != null) and ($content != null)){
                    $sql = "SELECT COUNT(*) AS numRows FROM ("
                          ."SELECT COUNT(*) FROM fpy_hourly "
                          ."WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' "
                          ."AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":00' $subensamble "
                          ."AND UPPER(".$filter.") LIKE UPPER('%$content%')
                            GROUP BY process_step,product) a";
                }
                Basic::EventLog("Reports->getNumRows: ".$sql);
                $res =& $db->queryOne($sql);
                return $res;
	}
        
        /**
	*  Devuelte el numero de registros de acuerdo a los par&aacute;metros del filtro
	*
	*	@param $filter	(string)	Nombre del campo para aplicar el filtro en la consulta SQL
	*	@param $order	(string)	Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $row['numrows']	(int) 	N&uacute;mero de registros (l&iacute;neas)
	*/
	
	function &getNumRowsFailures($filter = null, $content = null){
		global $db;
                                
                if(!empty($_SESSION['testplan'])) $where_testplan = " AND testplan='".$_SESSION['testplan']."'"; else $where_testplan = "";
                if(!empty($_SESSION['estacion'])) $where_estacion = " AND estacion='".$_SESSION['estacion']."'"; else $where_estacion = "";
                
                $sql = "SELECT COUNT(*) AS numRows FROM failures_report "
                      ."WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' "
                      ."AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59' "
                      ."$where_testplan $where_estacion ";

                if(($filter != null) and ($content != null)){
                    $sql = "SELECT COUNT(*) AS numRows "
                          ."FROM failures_report "
                          ."WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' "
                          ."AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59' "
                          ."$where_testplan $where_estacion "
                          ."AND UPPER(".$filter.") LIKE UPPER('%$content%')";
                }
                Basic::EventLog("Reports->getNumRowsFailures: ".$sql);
                $res =& $db->queryOne($sql);
                return $res;
	}
        
        /**
	*  Devuelte el numero de registros de acuerdo a los par&aacute;metros del filtro
	*
	*	@param $filter	(string)	Nombre del campo para aplicar el filtro en la consulta SQL
	*	@param $order	(string)	Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $row['numrows']	(int) 	N&uacute;mero de registros (l&iacute;neas)
	*/
	
	function &getNumRowsParetoFailures($filter = null, $content = null){
		global $db;
                                
                if(!empty($_SESSION['testplan'])) $where_testplan = " AND testplan='".$_SESSION['testplan']."'"; else $where_testplan = "";
                if(!empty($_SESSION['estacion'])) $where_estacion = " AND estacion='".$_SESSION['estacion']."'"; else $where_estacion = "";
                if(!empty($_SESSION['mlfb'])) $subensamble = " AND testplan_group IN (".$_SESSION['mlfb'].")"; else $subensamble = " ";
                                
                $sql = "SELECT COUNT(*) FROM (SELECT descripcion, count(*) AS ct FROM failures_report "
                      ."WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' "
                      ."AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59' "
                      ."$where_testplan $where_estacion $subensamble GROUP BY 1 ORDER BY 1) a";

                if(($filter != null) and ($content != null)){
                    $sql = "SELECT COUNT(*) FROM (SELECT descripcion, count(*) AS ct FROM failures_report "
                          ."WHERE fecha BETWEEN '".$_SESSION['fecha_desde']." ".$_SESSION['hora_desde'].":".$_SESSION['minuto_desde'].":00' "
                          ."AND '".$_SESSION['fecha_hasta']." ".$_SESSION['hora_hasta'].":".$_SESSION['minuto_hasta'].":59' "
                          ."$where_testplan $where_estacion $subensamble GROUP BY 1 ORDER BY 1) a "
                          ."WHERE UPPER(".$filter.") LIKE UPPER('%$content%')";
                }
                Basic::EventLog("Reports->getNumRowsParetoFailures: ".$sql);
                $res =& $db->queryOne($sql);
                return $res;
	}
}
?>
