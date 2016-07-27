<?php

class Line extends PEAR {

    /**
    *  Obtiene todos los registros de la tabla lines.
    *
    */
    function getAllRecords(){
            global $db;

            $sql = "select * from lines_comp order by id";
            $res =& $db->query($sql);
            return $res;
    }
    
    /**
    *  Obtiene la informacion de las lineas.
    *
    *   @param $idlinea	(int)	 Indica el numero de linea.
    *	@return $res 	(object) Objeto que contiene la informacion resultante.
    */
function getInfo($id_line){
    global $db ;

    $fecha = date('Y-m-d');
    $cw= date("W");
    $year=date('Y');
    $dia=date('l', strtotime($fecha));

    $sql = "select sum(prp_$dia) as suma from prp_production_plan where prp_cw=$cw and prp_id_line=$id_line and prp_year=$year";
   // $sql="select sum(pnp_qty) as suma from pnp_production_plan where pnp_cw='$cw' and pnp_date='$current_date' and pnp_id_line='$id_line'";
    $res =& $db->queryOne($sql);
   if(DEBUG==TRUE){
       Basic::EventLog("GetInfo ".$sql);
       
  }
    return $res;
                        
}
 
/**
    *  Obtiene la cantidad por numero de parte de la linea indicada.
    *
    *   @param $idlinea	(int)	 Indica el numero de linea.
    *   @param $partno	(String) Indica el numero de parte a consultar.
    *	@return $res 	(object) Objeto que contiene la informacion resultante.
    */
function getqty($idlinea,$partno){
    global $db;
    
    $sql1 = "select DISTINCT(pp.partno), pp.quantity from v_production_plan pp, v_lines li where  pp.partno=$partno and pp.id_line=$idlinea and pp.id_line=li.id ";
    
    $res2 =& $db->query($sql1);
    
            return $res2;
}

/**
    *  Obtiene la informacion de la linea por numero de parte.
    *
    *   @param $partno	(String) Indica el numero de parte a consultar.
    *	@return $res 	(object) Objeto que contiene la informacion resultante(BU,PARTNO,Unid. Buenas, Unid. Malas).
    */
 function infoLine($partno){
         $conect= new BDOracle();
         
        $current_date_ini = date("Y-m-d H")."0000";
        $current_date_fin = date("Y-m-d H")."5999";
    
        $query="SELECT A.PRODUCT_GROUP AS BU, A.PRODUCT_DEFINITION AS PARTNO,SUM( B.QTY_YIELD) AS BUENAS,SUM(B.QTY_LOSS) AS MALAS FROM T_WIP_JOB A INNER JOIN  "
                . "T_WIP_SUBSET B ON A.JOB=B.JOB WHERE A.PRODUCT_DEFINITION='$partno' AND B.EQUIPMENT='7121407'AND TO_CHAR(B.PROCESS_END, 'YYYY-MM-DD hh24miss')"
                . " BETWEEN  '$current_date_ini' AND '$current_date_fin' group by A.PRODUCT_DEFINITION, A.PRODUCT_GROUP";
      
         $res=$conect->executeqry($query);
      if(DEBUG==TRUE){   Basic::EventLog("InfoLine ".$query);}
          return $res;  
  
 }
 
  function getActiveTurnos($id_line){
    global $db;
    
    $sql = "select * from lnt_line_turno where lnt_line=$id_line ";    
    $res =& $db->query($sql);
    if(DEBUG==TRUE){
        Basic::EventLog("getActiveTurnos ".$sql);
        
    }
            return $res;
}
 
 function getActiveTurnosByTurno($id_line,$turno){
    global $db;
    
    $sql = "select lnt_turno_$turno from lnt_line_turno where lnt_line=$id_line ";    
    $res =& $db->queryOne($sql);
    if(DEBUG==TRUE){
        Basic::EventLog("getActiveTurnos ".$sql);
        
    }
            return $res;
}

function InsertActiveTurnos($id_line){
    global $db;
    
    $sql = "insert into lnt_line_turno (lnt_line,lnt_turno_4,lnt_turno_5,lnt_turno_6,lnt_turno_7) values ($id_line,'active','active','active','active')";
    
    $res =& $db->query($sql);
    if(DEBUG==TRUE){
        Basic::EventLog("InsertActiveTurnos ".$sql);
        
    }
            return $res;
}

 function updateActiveTurnos($id_line,$turno,$status){
    global $db;
    
    $sql = "update  lnt_line_turno set lnt_$turno='$status' where lnt_line=$id_line ";    
    $res =& $db->query($sql);
    if(DEBUG==TRUE){
        Basic::EventLog("getActiveTurnos ".$sql);
        
    }
            return $res;
}
 function getEndCtrlById($id_line){
    global $db;
    
    $sql = "select stn_host_name from stn_station where stn_sba_id=$id_line and stn_host_name like '%ENDCTRL%'";
    
    $res =& $db->query($sql);
    if(DEBUG==TRUE){ Basic::EventLog("getEndCtrlById ".$sql);}
            return $res;
}

 function getAOIById($id_line){
    global $db;

    $sql = "select stn_host_name from stn_station where stn_sba_id=$id_line and stn_host_name like '%AOI%'";

    $res =& $db->query($sql);
    if(DEBUG==TRUE){ Basic::EventLog("getAOIByIDLine ".$sql);}
            return $res;
}
 function getICTById($id_line){
    global $db;

    $sql = "select stn_host_name from stn_station where stn_sba_id=$id_line and stn_host_name like '%ICT%'";

    $res =& $db->query($sql);
    if(DEBUG==TRUE){ Basic::EventLog("getAOIByIDLine ".$sql);}
            return $res;
}
 function getHostNameById($id_line){
    global $db;
    
    $sql = "select stn_host_name from stn_station where stn_sba_id=$id_line";
    
    $res =& $db->query($sql);
   if(DEBUG==TRUE){  Basic::EventLog("getHostNameById ".$sql);}
            return $res;
}
  function getProductionPass($host_name){
         $conect= new BDOracle();
         
        $current_date_ini = date("d/m/Y H").":00:00";
        $current_date_fin = date("d/m/Y H").":59:59";
    
        $query="select sum(usr_data_001) as BUENAS, usr_string_010 as PARTNO from t_etm_ct_logtable 
                where ru_id = (select ru_id from t_fl_ru_properties where ru_name = '$host_name') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi.ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi.ss') group by usr_string_010";
      
         $res=$conect->executeqry($query);
       if(DEBUG==TRUE){   Basic::EventLog("getProductionPass ".$query);}
          return $res;  
  
 }
 
  function getProduction($host_name){
         $conect= new BDOracle();
         
        $new_date= date("d/m/Y H",strtotime("-1 hour")); 
        
        $current_date_ini =$new_date.":00:00";
        $current_date_fin =$new_date.":59:59";
    
        $query="select sum(usr_data_001) as UNITS,  usr_string_010 as PARTNO from t_etm_ct_logtable 
                where ru_id = (select ru_id from t_fl_ru_properties where ru_name = '$host_name') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi.ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi.ss')  group by usr_string_010";
     
         $res=$conect->executeqry($query);
      if(DEBUG==TRUE){ 
          Basic::EventLog("getProductionTotalByHour".$query);
         }
          return $res;  
  
 }
  function getProductionCurrent($host_name){
         $conect= new BDOracle();
         
        $fecha = date('d/m/Y H');
        //$new_date= strtotime ( '-1 hour' , strtotime ( $fecha )); 
        
        $current_date_ini =$fecha.":00:00";
        $current_date_fin =$fecha.":59:59";
    
        $query="select sum(usr_data_001) as UNITS,  usr_string_010 as PARTNO from t_etm_ct_logtable 
                where ru_id = (select ru_id from t_fl_ru_properties where ru_name = '$host_name') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi.ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi.ss') group by usr_string_010";
      
         $res=$conect->executeqry($query);
     if(DEBUG==TRUE){ 
          Basic::EventLog("getProductionCurrent ".$query);
          
      }
          return $res;  
  
 }
 
   function getProductionShift($host_name){
       $conect= new BDOracle();
       $hactual=  date("His");
        
        if($hactual<"070000")
        {
        $current_date_ini= date("d/m/Y ", strtotime("-1 day"))."19:00:00"; 
        $current_date_fin= date("d/m/Y ")."06:59:59"; 
        }
         if($hactual>="190000"){
        $current_date_ini= date("d/m/Y ")."19:00:00"; 
        $current_date_fin= date("d/m/Y ", strtotime("+1 day"))."06:59:59";  
         }
         if($hactual >="070000" && $hactual <"190000"){
        $current_date_ini = date("d/m/Y ")."07:00:00";
        $current_date_fin = date("d/m/Y ")."18:59:59";
         }
              
        $query="select sum(usr_data_000) as UNITS, usr_string_010 AS PARTNO, TO_CHAR(receive_time,'hh24') as FECHA from t_etm_ct_logtable 
                where ru_id = (select ru_id from t_fl_ru_properties where ru_name = '$host_name') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi:ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi:ss') 
                group by usr_string_010, TO_CHAR(receive_time,'hh24') order by FECHA asc";
     
         $res=$conect->executeqry($query);
        if(DEBUG==TRUE){ 
            Basic::EventLog("getProductionFailByShift-> ".$query);
            
        }
          return $res;  
  
 }
 
   function getProductionFail($host_name){
         $conect= new BDOracle();
         
        $current_date_ini = date("d/m/Y H").":00:00";
        $current_date_fin = date("d/m/Y H").":59:59";
    
        $query="select sum(usr_data_002) as MALAS from t_etm_ct_logtable 
                where ru_id = (select ru_id from t_fl_ru_properties where ru_name = '$host_name') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi.ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi.ss')";
      
         $res=$conect->executeqry($query);
       if(DEBUG==TRUE){ 
           Basic::EventLog("getProductionFail ".$query);
           
   }
          return $res;  
  
 }
 function getProductionFailByShift($host_name){
         $conect= new BDOracle();
        $hactual=  date("His");
        
        if($hactual<"070000")
        {
        $current_date_ini= date("d/m/Y ", strtotime("-1 day"))."19:00:00"; 
        $current_date_fin= date("d/m/Y ")."06:59:59"; 
        }
         if($hactual>="190000"){
        $current_date_ini= date("d/m/Y ")."19:00:00"; 
        $current_date_fin= date("d/m/Y ", strtotime("+1 day"))."06:59:59";  
         }
         if($hactual >="070000" && $hactual <"190000"){
        $current_date_ini = date("d/m/Y ")."07:00:00";
        $current_date_fin = date("d/m/Y ")."18:59:59";
         }
              
        $query="select sum(usr_data_002) as MALAS from t_etm_ct_logtable 
                where ru_id = (select ru_id from t_fl_ru_properties where ru_name = '$host_name') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi.ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi.ss')";
     
         $res=$conect->executeqry($query);
        if(DEBUG==TRUE){ 
            Basic::EventLog("getProductionFailByShift-> ".$query);
            
        }
          return $res;  
  
 }
 
 function getProductionPAssByShift($host_name){
         $conect= new BDOracle();
        $hactual=  date("His");
        
        if($hactual<"070000")
        {
        $current_date_ini= date("d/m/Y ", strtotime("-1 day"))."19:00:00"; 
        $current_date_fin= date("d/m/Y ")."06:59:59"; 
        }
         if($hactual>="190000"){
        $current_date_ini= date("d/m/Y ")."19:00:00"; 
        $current_date_fin= date("d/m/Y ", strtotime("+1 day"))."06:59:59";  
         }
         if($hactual >="070000" && $hactual <"190000"){
        $current_date_ini = date("d/m/Y ")."07:00:00";
        $current_date_fin = date("d/m/Y ")."18:59:59";
         }
              
        $query="select sum(usr_data_001) as BUENAS from t_etm_ct_logtable 
                where ru_id = (select ru_id from t_fl_ru_properties where ru_name = '$host_name') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi.ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi.ss') ";
     
         $res=$conect->executeqry($query);
        if(DEBUG==TRUE){  Basic::EventLog("getProductionFailByShift-> ".$query);}
          return $res;  
  
 }
 /**
    *  Obtiene la informacion de la linea por numero de parte.
    *BDOraclePulse
    *   @param $partno	(String) Indica el numero de parte a consultar.
    *	@return $res 	(object) Objeto que contiene la informacion resultante(BU,PARTNO,Unid. Buenas, Unid. Malas).
    */
 function infoLineByShift($partno){
         $conect= new BDOracle();
        $hactual=  date("His");
        
        if($hactual<"070000")
        {
        $current_date_ini= date("Y-m-d ", strtotime("-1 day"))."190000"; 
        $current_date_fin= date("Y-m-d ")."065999"; 
        }
         if($hactual>="190000"){
        $current_date_ini= date("Y-m-d ")."190000"; 
        $current_date_fin= date("Y-m-d ", strtotime("+1 day"))."065999";  
         }
         if($hactual >="070000" && $hactual <"190000"){
        $current_date_ini = date("Y-m-d ")."070000";
        $current_date_fin = date("Y-m-d ")."185999";
         }
              
        $query="SELECT A.PRODUCT_GROUP AS BU, A.PRODUCT_DEFINITION AS PARTNO,SUM( B.QTY_YIELD) AS BUENAS,SUM(B.QTY_LOSS) AS MALAS FROM T_WIP_JOB A INNER JOIN  "
                . "T_WIP_SUBSET B ON A.JOB=B.JOB WHERE A.PRODUCT_DEFINITION='$partno' AND B.EQUIPMENT='7121407'AND TO_CHAR(B.PROCESS_END, 'YYYY-MM-DD hh24miss')"
                . " BETWEEN  '$current_date_ini' AND '$current_date_fin' group by A.PRODUCT_DEFINITION, A.PRODUCT_GROUP";
     
         $res=$conect->executeqry($query);
     if(DEBUG==TRUE){     Basic::EventLog("InfoLineByShift-> ".$query);}
          return $res;  
  
 }
 
 /**
    *  Obtiene los registros de la linea segun el id de linea.
    *
    *   @param $id_pfr	(int)	 Indica el id del proyecto.
    *	@return $res 	(object) Objeto que contiene la informacion resultante.
    */
function getRecordById($id_pfr){
    global $db;
    
    $sql = "select * from v_project_subarea where id=$id_pfr";
    
    $res =& $db->query($sql);
    
            return $res;
}

function getRecordById_line($id_line){
    global $db;
    
    $sql = "select * from sba_subarea where sba_id=$id_line";
    
    $res =& $db->query($sql);
    if(DEBUG==TRUE){ Basic::EventLog("getRecordById_line-> ".$sql);}
            return $res;
}

function gById_line($id_line){
    global $db;
    
    $sql = "select * from project_subarea where id_sbarea=$id_line";
    
    $res =& $db->query($sql);
    if(DEBUG==TRUE){ Basic::EventLog("getRecordById_line-> ".$sql);}
            return $res;
}
 /**
    *  Pinta la tabla inferior para el andon segun el tipo.
    *
    *   @param $id_pfr	(int)	 Indica el id de proyecto.
    *	@param $mode 	(string) Indica el modo en que se despelgara la informacion (singleline,multiline).
    *	@return $html 	(object) Objeto que contiene la tabla que se desplegara en pantalla.
    */
function printtabla($id_line,$mode=NULL){
       
    switch ($mode){
        case "singleline":
        $arreglo =& self::getRecordById_line($id_line); 
            $html= '<table border="1" class="estableonly" ><tr>';
            
                $row=$arreglo->fetchRow();
                     
                     switch ($row['sba_status_color']){
                         case "Red":
                             $class="tdrojo";
                             break;
                         case "Yellow":
                             $class="tdamarillo";
                             break;
                         case "Blue":
                             $class="tdazul";
                             break;
                         case "":
                             $class="tdverder";
                             break;
                     }
                     
            $html.= "<td class='$class'>".$row['sba_status']."</br>".$row['sba_name']."</td>";
            $html.= "</tr></table>";
    
    return $html;
    
    
    case "multiline":
        
         $arreglo =& self::getAllRecords();
          $grey = true;
 
$html= ' <table border="1" class="estable" ><tr>';

                   while($va_tupla=$arreglo->fetchrow()){                      
                      if($va_tupla['atributo']=="")
                     if($grey){
                      $html.= "<td id='cuad".$va_tupla['id']."'class='tdazul' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
                      $grey=false;
                     }else { $html.= "<td id='cuad".$va_tupla['id']."'class='tdverder' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>"; $grey=true; }
                     
                 if($va_tupla['atributo']=="E")
                      $html.= "<td id='cuad".$va_tupla['id']."'class='tdrojo' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
                 
                 if($va_tupla['atributo']=="M")
                      $html.= "<td id='cuad".$va_tupla['id']."'class='tdamarillo' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
    
                 if($va_tupla['atributo']=="C")
                      $html.= "<td id='cuad".$va_tupla['id']."'class='tdamarillo' onclick='xajax_lineinfo(".$va_tupla['id'].")'> ".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
           }
    
    $html.= "</tr></table>";
    return $html;
    
    }   
       }
       
/**
	*  imprime un select box con todos las lineas
	*
	*  En este metodo imprime todas las lineas en un select list
	*  entradas del formulario.
	*
         *      @param $id_pfr (integer)   Identificador del proyecto para desplegar sus lineas
         *      @param $execFunction (string)   Nombre de la funcion de Xajax que se ejecutara cuando se seleccione una linea
	*	@return $html	(string)	Retorna el codigo HTML con el select completo
	*/
        function printSelect($id_pfr=0,$execFunction){
         
                 
                $arreglo =& self::getRecordbyID($id_pfr);
                
                    $html = "<h5>Select Line</h5>
                    <select id='line' name='line' onChange=\"xajax_$execFunction(xajax.getFormValues('general'));\">
                    <option value='0'> --Select--</option>";
                         while ($row=$arreglo->fetchRow()) {
                         $html .= "<option value='".$row['sba_id']."'>".$row['sba_name']."</option>"; }

                      $html .= "</select>";
             
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
                $html="<table><tr>";
                 while ($row=$arreglo->fetchRow()) {
                    $html.='<td><input type="checkbox" id="'.$row['id'].'" name="projects[]" value="'.$row['id'].'">'.$row['strname'].'</td>';
           }
             $html.='</tr></table>';
         
            return $html;
        }
        
         /**
    *  Envia registros a la tabla lmt_line_monitor.
    *
    *   @param $id_line	(int)	Identificador de la linea
    *   @param $monitor	(int)	Identificador del proyecto
    *	@param $id_pfr	(int)   Numero del monitor donde se veran las lineas seleccionadas;
    */
      function &setMonitor($id_line,$monitor,$id_pfr){
         global $db;
             if($id_line){
             $sql = "insert into lmt_line_monitor (lmt_line,lmt_monitor,lmt_project) values ('$id_line','$monitor','$id_pfr')";                    
         if(DEBUG==TRUE){    Basic::EventLog("setMonitor--->>: ".$sql);}
            $db->query($sql);
           }
             
    }
         /**
    *  Obtiene registros a la tabla lmt_line_monitor por monitor
    *
    *   @param $monitor	(int)	Identificador del monitor
    *	@return $res	(object)  Objeto con el resultado de la ejecucion del query;
    */
      function &getMonitorByMonitor($monitor){
         global $db;
            
             $sql = "select * from lmt_line_monitor where lmt_monitor='$monitor'";                    
         if(DEBUG==TRUE){ 
             Basic::EventLog("getMonitorByMonitor--->>: ".$sql);
             
         }
           $res=& $db->query($sql);           
           return $res;
           
             
      }
      
            /**
    *  Obtiene registros a la vista lmt_line_monitor con subarea por monitor
    *
    *   @param $monitor	(int)	Identificador del monitor
    *	@return $res	(object)  Objeto con el resultado de la ejecucion del query;
    */
      function &getSubareaByMonitor($monitor){
         global $db;
            
             $sql = "select a.sba_name as name, a.sba_id as id_line from sba_subarea a,lmt_line_monitor b where b.lmt_line=a.sba_id and b.lmt_monitor='$monitor' order by id_line";                    
        if(DEBUG==TRUE){   Basic::EventLog("getMonitorByMonitor--->>: ".$sql);}
           $res=& $db->query($sql);
           
           return $res;
           
             
      }
    
         /**
    *  Obtiene registros a la tabla lmt_line_monitor por id de linea.
    *
    *   @param $id_line	(int)	Identificador de la linea
    *	@return $res	(object)  Objeto con el resultado de la ejecucion del query;
    */
      function &getMonitor($id_line){
         global $db;
             if($id_line){
             $sql = "select * from lmt_line_monitor where lmt_line='$id_line'";                    
        if(DEBUG==TRUE){    Basic::EventLog("getMonitor--->>: ".$sql);}
           $res=& $db->query($sql);
           
           return $res;
           }
             
    }
    
       function &getIdArea($id_line){
         global $db;
             
             $sql = "select ara_area_id from sba_subarea where sba_id='$id_line'";                    
        if(DEBUG==TRUE){    Basic::EventLog("getIdArea--->>: ".$sql);}
           $res=& $db->queryOne($sql);
           
           return $res;
                        
    }
         /**
    *  Actualiza registros a la tabla lmt_line_monitor.
    *
    *   @param $id_line	(int)	Identificador de la linea
    *	@param $monitor	(int)   Numero del monitor donde se veran las lineas seleccionadas;
    */
      function &UpdateMonitor($id_line,$monitor){
         global $db;
             if($id_line){
             $sql = "update lmt_line_monitor set lmt_monitor='$monitor' where lmt='$id_line'";                    
        if(DEBUG==TRUE){    Basic::EventLog("UpdateMonitor--->>: ".$sql);}
            $db->query($sql);
           }
             
    }
    
    /**
    * Obtiene los registros de la tabla T_ANL_HIERARCH_ADM.
    *
    *   @param $id_line	(int)	Identificador de la linea
    *	@param $monitor	(int)   Numero del monitor donde se veran las lineas seleccionadas;
    */
     function getC_keyByName($name){
         $conection= new BDOracle();
                         
        $query="SELECT ROOT_C_KEY,C_KEY  FROM T_ANL_HIERARCH_ADM WHERE NODE_NAME='$name' AND ROWNUM = 1 ORDER BY C_KEY ASC";
     $res=$conection->executeqry($query);
      
      if(DEBUG==TRUE){ Basic::EventLog("getC_keyByName".$query);}
        
          return $res;  
 }
 
 function getById_line($id_line){
    global $db;
    
    $sql = "select * from v_project_subarea where sba_id=$id_line";
    
    $res =& $db->query($sql);
    
            return $res;
}

   function getPlanByIdLine($id_line,$fecha){
            global $db;
      // $hoy=date('Y-m-d');
       $sql = "select pnp_partno as pro_product,pnp_qty as pro_quantity from pnp_production_plan where pnp_date='$fecha 07:00:00' and pnp_id_line =$id_line";
           Basic::EventLog("Plan->getPlanByIdLine: ".$sql);
            $res =& $db->query($sql);
            return $res;
    }
    
    function getRealByIdLine($id_line,$fecha){
            global $db;

 $tomorrow1 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
$tomorrow = date ( 'Y-m-d' , $tomorrow1); 

       $sql = "select a.unp_partno as partno,sum(a.unp_produced) as qty 
              from  unp_units_produced a 
              where unp_hour between '$fecha 07:00:00' and '$tomorrow 07:00:00' and unp_id_line=$id_line 
              group by a.unp_partno";
           Basic::EventLog("Real->getRealByIdLine: ".$sql);
            $res =& $db->query($sql);
            return $res;
    }
  function getPlanByIdLineNew($id_line,$columna){
            global $db;
       $cw=  date("W");
       $year=  date('Y');
       $sql = "select prp_mlfb as pro_product, $columna as pro_quantity
               from prp_production_plan 
               where prp_year=$year and prp_cw=$cw and prp_id_line=$id_line and $columna !=0";
           Basic::EventLog("Plan->getPlanByIdLine: ".$sql);
            $res =& $db->query($sql);
            return $res;
}

  //Funcion obtiene las unidades pasadas de una hora anterior
  function getProductionPass_New($host_name,$host){
         $conect= new BDOracle();
         
       $new_date= date("d/m/Y H",strtotime("-1 hour")); 
        
        $current_date_ini =$new_date.":00:00";
        $current_date_fin =$new_date.":59:59";
    
        $query="select sum(usr_data_001) as BUENAS, usr_string_010 as PARTNO from t_etm_ct_logtable 
                where ru_id in (select RU_ID from t_fl_ru_properties where PARENT_RU_NAME='$host_name' and RU_NAME like '%$host%') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi.ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi.ss')and state_type='A' group by usr_string_010";
      
         $res=$conect->executeqry($query);
       if(DEBUG==true){   Basic::EventLog("getProductionPass ".$query);}
          return $res;  
  
 }
 
 #Funcion para obtener las unidades fallas de una hora anterior
 function getProductionFail_New($host_name){
         $conect= new BDOracle();
         
        $new_date= date("d/m/Y H",strtotime("-1 hour")); 
        
        $current_date_ini =$new_date.":00:00";
        $current_date_fin =$new_date.":59:59";
    
        $query="select sum(usr_data_002) as MALAS from t_etm_ct_logtable 
                where ru_id in (select RU_ID from t_fl_ru_properties where PARENT_RU_NAME='$host_name') 
                and receive_time between to_date('$current_date_ini','DD/MM/YYYY hh24:mi.ss') 
                and to_date('$current_date_fin','DD/MM/YYYY hh24:mi.ss')and state_type='A'";
      
         $res=$conect->executeqry($query);
       if(DEBUG==true){   Basic::EventLog("getProductionFail ".$query);}
          return $res;  
  
 }

}        

        
