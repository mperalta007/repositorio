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
	* En esta clase se definen los metodos para el manejo de los datos de andon
	* <b>Andon"</b>.
	*
	* @author	Miguel Peralta
	* @version	1.0
	* @date		Jul 1, 2015
	*
	*/
	
class Andon extends PEAR {
     
    /**
    *  Obtiene registros de la tabla sba_subarea.
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getNameById($id_line){
            global $db;

        $sql = "select sba_name from sba_subarea where sba_id=$id_line";                       
        if(DEBUG==TRUE){  Basic::EventLog("get days--->>: ".$sql);}
            $res =& $db->query($sql);
          
            return $res;
    }
    
    /**
    *  Obtiene registros de la tabla lnp_line_parameters.
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
    *	@param $name	(String)	Nombre del valor que se desea buscar en la tabla ubicado en la columna de lnp_name
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    
    function &getDaysById($id_line,$name){
            global $db;

        $sql = "select * from lnp_line_parameters"
                . " where lnp_id_line=$id_line and lnp_name='$name'";
                       
            if(DEBUG==TRUE){ Basic::EventLog("get days--->>: ".$sql);}
            $res =& $db->query($sql);
          
            return $res;
    }
    
    /**
    *  Inserta registros de la tabla lnp_line_parameters.
    *
    *   @param $id_line	(int)	Identificador de la Linea 
    *	@param $name	(String)	Nombre del valor que se desea insertar en la columna de lnp_name
    *  	@param $valor	(String)	Nombre del valor que se desea insertar en la columna de lnp_value
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &setDays($id_line,$name,$valor){
         global $db;

        $sql = "insert into lnp_line_parameters (lnp_value,lnp_name,lnp_id_line) values ('$valor','$name',$id_line)";
                    
        if(DEBUG==TRUE){  Basic::EventLog("setDays--->>: ".$sql);}
            $res =& $db->query($sql);
    }
    
     /**
    *  Actualiza registros de la tabla lnp_line_parameters.
    *
    *   @param $id_line	(int)	Identificador de la Linea 
    *	@param $name	(String)	Nombre del valor que se desea buscar en la columna de lnp_name
    *  	@param $valor	(String)	Nombre del valor que se desea actualizar en la columna de lnp_value
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &updateDays($id_line,$name,$valor){
         global $db;

        $sql = "UPDATE lnp_line_parameters set lnp_value='$valor'  WHERE lnp_name='$name' and lnp_id_line=$id_line";
                       
         if(DEBUG==TRUE){  Basic::EventLog("updateDays--->>: ".$sql);}
            $res =& $db->query($sql);
    }
    
     /**
    *  Actualiza registros de la tabla cto_cumplimiento.
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
    *	@param $parameter (String)	Nombre del parametro que se desea buscar en la columna de cto_parameter
    *  	@param $dia	(String)	Nombre del dia que se desea actualizar en la columna de lnp_dia
    *  	@param $valor	(String)	Nombre del valor que se desea actualizar en la columna de lnp_dia
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &updateCumplimiento($id_line,$parameter,$dia,$valor){
         global $db;
        $cw= date("W");
        $sql = "UPDATE cto_cumplimiento
               set cto_$dia='$valor'
               WHERE cto_id_line='$id_line' and cto_week=$cw and cto_parameter='$parameter'";
                      
        if(DEBUG==TRUE){  Basic::EventLog("updateCumplimiento--->>: ".$sql);}
            $res =& $db->query($sql);
    }
    
     /**
    *  Obtiene registros de la tabla cto_cumplimiento pasando como parametro el id linea mas el parametro a buscar.
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
    *	@param $parameter (String)	Nombre del parametro que se desea buscar en la columna de cto_parameter
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getCumParameter($id_line,$parameter){
         global $db;
        $cw= date("W");
        $sql = "select * from cto_cumplimiento
                WHERE cto_id_line='$id_line' and cto_week=$cw and cto_parameter='$parameter' ";
                       
       if(DEBUG==TRUE){  Basic::EventLog("getCumParameter--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     /**
    *  Obtiene registros de la tabla cto_cumplimiento indicando id de linea, semana, dia y turno(opcional).
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
    *	@param $cw (String)	Numero de semana que se desea buscar
    *  	@param $day	(String)	Nombre del dia que 
    *  	@param $turno	(String)	Numero de turno a buscar
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getCumplimiento($id_line,$cw,$day,$turno=NULL){
         global $db;
       if(!$turno){
        $sql = "select * from cto_cumplimiento
       WHERE cto_id_line='$id_line' and cto_week='$cw' and cto_day='$day' order by cto_id asc";}
       else {
            $sql = "select * from cto_cumplimiento
       WHERE cto_id_line='$id_line' and cto_week='$cw' and cto_day='$day' and cto_shift='$turno' order by cto_id asc";
       }
                       
         if(DEBUG==TRUE){ 
              Basic::EventLog("getCumplimiento--->>: ".$sql);
              
         }
            $res =& $db->query($sql);
            
            return $res;
    }
     /**
    *  Obtiene registros de la tabla pro_production_plan indicando id de linea y semana
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
   
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getPlanCW($id_line){
         global $dbc;
         $cw=  date("W");
       $sql="select sum(pro_quantity)as suma ,pro_dttime as fecha from pro_production_plan  where pro_id_line=$id_line and pro_cw=$cw group by pro_dttime ORDER BY pro_dttime";                       
          if(DEBUG==TRUE){  Basic::EventLog("getPlanCW--->>: ".$sql);}
            $res =& $dbc->query($sql);
            
            return $res;
    }
    
     /**
    *  Obtiene registros de la tabla pro_production_plan indicando id de linea y semana
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
   
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getPlanCWNew($id_line){
         global $db;
         $cw=  date("W");
       $sql="select sum(pnp_qty)as suma ,pnp_date as fecha from pnp_production_plan  where pnp_id_line=$id_line and pnp_cw=$cw group by pnp_date ORDER BY pnp_date";                       
          if(DEBUG==TRUE){  Basic::EventLog("getPlanCW--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
      /**
    *  Obtiene registros de la tabla pro_production_plan indicando id de linea y semana
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
   
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getPlanCWByIdLine($id_line,$cw){
         global $db;
       $sql="select * from prp_production_plan  where prp_id_line=$id_line and prp_cw=$cw order by prp_mlfb";                       
          if(DEBUG==TRUE){
              Basic::EventLog("getPlanCWByIdLine--->>: ".$sql);
              
          }
            $res =& $db->query($sql);
            
            return $res;
    }
      /**
    *  Obtiene dias de la semana de la tabla turnos indicando semana
    *
    *   @param $cw	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
   
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getDaysByCW($cw){
         global $db;
       $year=date('Y');
       $sql="select dateini::timestamp::date from turnos where year=$year and cw=$cw and turno in ('4','6')";                       
          if(DEBUG==TRUE){  Basic::EventLog("getDaysByCW--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     /**
    *  Obtiene registros de la tabla turnos pasando como parametro el dia mas el nombre de la columna.
    *
    *   @param $today (String)	Valor del parametro
    *	@param $param (String)	Nombre de la columna a comparar
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getShift($today,$param){
         global $db;
         
        $sql = "select * from turnos where $param = '$today'";
                       
          if(DEBUG==TRUE){ 
              Basic::EventLog("getShift--->>: ".$sql);
              
          }
            $res =& $db->query($sql);
            
            return $res;
    }
     function &getShiftsByDay($fecha){
         global $db;      
        $sql = "select turno from turnos where dateini between '$fecha 00:00:00' and '$fecha 23:00:00'";
                       
          if(DEBUG==TRUE){ 
              Basic::EventLog("getShiftsByDay--->>: ".$sql);              
          }
            $res =& $db->query($sql);
            
            return $res;
    }
      function   getUnitAllProduced($id_line){
        global $db;
         $hactual=  date("His");
    
         if($hactual>="190000"){
        $current_date_ini= date("Y-m-d ")."07:00:00"; 
        $current_date_fin= date("Y-m-d ")."18:59:59.999";  
         }
         if($hactual >="070000" && $hactual <"190000"){
        $current_date_ini = date("Y-m-d ", strtotime("-1 day"))."19:00:00";
        $current_date_fin = date("Y-m-d ")."06:59:59.999";
         }
       $sql="select sum(unp_good_produced) as units from unp_units_produced_new where unp_line='$id_line' and unp_hour between '$current_date_ini' and '$current_date_fin' ";
     if(DEBUG==TRUE){  
         Basic::EventLog("getUnits-> ".$sql);     
         }     
        $res=& $db->query($sql);  
        return $res;
    }
    
     /**
    *  Insertar registros de la tabla cto_cumplimiento pasando como parametro el id de linea.
    *
    *   @param $id_line (Int)	Identificador de la linea
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &insertCumplimiento($id_line){
         global $db;
         
        $ar =& self::getUnitAllProduced($id_line);
        
         $arr=$ar->fetchRow();
        $qty=$arr['units'];
        
       // $factual=date("Y-m-d H:i:s");
        $hora=date('His');
        if($hora < '190000'){$hactual=date('Y-m-d ',  strtotime('-1 day')).'19:00:00';}
        if($hora > '190000'){$hactual=date('Y-m-d ').'07:00:00';}
              
         $arreglo =& self::getShift($hactual,'dateini'); 
                         
          $row=$arreglo->fetchRow();
          $turno=$row['turno'];
          $cw=$row['cw'];
        //  $date_ini=$row['dateini']; 
        // $date_fin=$row['datefin'];
                  
          $day= date('l', strtotime($hactual));
          
          $array =& self::getCumplimiento($id_line,$cw,$day,$turno);
           $raw=$array->fetchRow();
           
           if(!$raw){        
        $sql="insert into cto_cumplimiento
              (cto_id_line,cto_shift,cto_day,cto_qty,cto_week) values ('$id_line','$turno','$day','$qty','$cw')";       
                                
        if(DEBUG==TRUE){  Basic::EventLog("insertCumplimiento--->>: ".$sql);}
            $res =& $db->query($sql);
           }else{
         if(DEBUG==TRUE){   Basic::EventLog("insertCumplimiento--->>: Yaexiste el registro");}
               }
           
            return $res;
    }
    
      /**
    *  Insertar registros de la tabla cto_cumplimiento pasando como parametro el id de linea.
    *
    *   @param $id_line   (Int)	Identificador de la linea
    *   @param $parameter (String)	Parametro a insertar en la columna cto_parameter
    *   @param $dia       (String)	Dia que completa el nombre de la columna donde se insertara el valor
    *   @param $valor     (String)	Valor a insertar en la columna cto_?dia?
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
     function &setCumplimiento($id_line,$parameter,$dia,$valor){
         global $db;
        $cw= date("W"); 
        $sql = "insert into cto_cumplimiento (cto_id_line,cto_week,cto_parameter,cto_$dia)"
                . "values ($id_line,$cw,'$parameter',$valor)";
                       
        if(DEBUG==TRUE){  Basic::EventLog("setCumplimiento--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     function &setActionPlan($issue,$action,$responsable,$due_date,$status,$id_line){
         global $db;
       
         if($responsable){
         
          $array =& self::getAction($id_line,$issue);
           $raw=$array->fetchRow();
           
         if(!$raw){  
        $sql = "insert into acp_action_plan (acp_issue,acp_action,acp_responsable,acp_due_date,acp_statusa,acp_id_line)"
                . "values ('$issue','$action','$responsable','$due_date','$status',$id_line)";
         }
       if(DEBUG==TRUE){ Basic::EventLog("setActionPlan--->>: ".$sql);}
            $res =& $db->query($sql);
         }
            return $res;
    }
     function &getActionPlan($id_line){
         global $db;        
        $sql = "select * from acp_action_plan
                WHERE acp_id_line='$id_line' order by acp_id asc";
                       
       if(DEBUG==TRUE){  Basic::EventLog("getActionPlan--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     function &getAction($id_line,$issue){
         global $db;        
        $sql = "select * from acp_action_plan
                WHERE acp_issue='$issue' and acp_id_line='$id_line' ";
                       
      if(DEBUG==TRUE){   Basic::EventLog("getActionPlan--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     function &updateActionPlan($id_line,$issue,$valor,$parameter){
         global $db;
        $sql = "UPDATE acp_action_plan set acp_$parameter='$valor' WHERE acp_issue='$issue' and acp_id_line='$id_line'";
                      
        if(DEBUG==TRUE){ Basic::EventLog("updateCumplimiento--->>: ".$sql);}
            $res =& $db->query($sql);
    }
     function &DeleteActionPlan($acp_id){
         global $db;        
        $sql = "DELETE from acp_action_plan where acp_id=$acp_id";
                       
        if(DEBUG==TRUE){   Basic::EventLog("getActionPlan--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     function &setSupport($line,$equipo){
         global $db;
        $hoy= date("Y-m-d H:i");
        $sql = "insert into enb_event_botton (enb_date,enb_line,enb_team_support) values ('$hoy','$line','$equipo');";
                       
       if(DEBUG==TRUE){  Basic::EventLog("setSupport--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     function &getSupport($line,$equipo){
         global $db;
        
        $sql = "select * from enb_event_botton where enb_line='$line' AND enb_team_support='$equipo'";
                       
        if(DEBUG==TRUE){Basic::EventLog("getSupport--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     function &DelSupport($line,$equipo){
         global $db;
        
        $sql = "delete from enb_event_botton where enb_line='$line' AND enb_team_support='$equipo'";
                       
        if(DEBUG==TRUE){ Basic::EventLog("DelSupport--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     function &getuid($uid){
         global $dbu;
        
        $sql = "SELECT personnel FROM info WHERE personnel = '$uid'";
                       
       if(DEBUG==TRUE){Basic::EventLog("getuid--->>: ".$sql);}
            $res =& $dbu->query($sql);
            
            return $res;
    }
     function &getStatusLine($id_line){
         global $db;
        
        $sql = "select sba_status from sba_subarea where sba_id=$id_line";
                       
        if(DEBUG==TRUE){ Basic::EventLog("getStatusLine--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
     function &updateStatusLine($line,$status,$color){
         global $db;
        
        $sql = "update sba_subarea set sba_status='$status',sba_status_color='$color' where sba_name='$line'";
                       
        if(DEBUG==TRUE){Basic::EventLog("updateStatusLine--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
      /**
    *  Elimina registros a la tabla lnp_line_parameters.
    *
    *   @param $id_line	(int)	Identificador de la linea
    *	@param $name	(string) Nombre del parametro que se guardara;
    *	@param $valor 	(string) Valor del parametro
    *	@param $desc 	(string) Descripcion que indica la columna donde se guardara
    */
      function &delCertification($id_line,$desc){
         global $db;

        $sql = "delete from  lnp_line_parameters where lnp_id_line='$id_line' and lnp_description='$desc'";
                    
       if(DEBUG==TRUE){   Basic::EventLog("setCertification--->>: ".$sql);}
            $res =& $db->query($sql);
    }
     /**
    *  Envia registros a la tabla lnp_line_parameters.
    *
    *   @param $id_line	(int)	Identificador de la linea
    *	@param $name	(string) Nombre del parametro que se guardara;
    *	@param $valor 	(string) Valor del parametro
    *	@param $desc 	(string) Descripcion que indica la columna donde se guardara
    */
      function &setCertification($id_line,$name,$valor,$desc){
         global $db;

        $sql = "insert into lnp_line_parameters (lnp_value,lnp_name,lnp_id_line,lnp_description) values ('$valor','$name',$id_line,'$desc')";
                    
       if(DEBUG==TRUE){  Basic::EventLog("setCertification--->>: ".$sql);}
            $res =& $db->query($sql);
    }
      /**
    *  Actualiza registros en la tabla lnp_line_parameters.
    *
    *   @param $id_line	(int)	Identificador de la linea
    *	@param $name	(string) Nombre del parametro que se guardara;
    *	@param $valor 	(string) Valor del parametro
    *	@param $desc 	(string) Descripcion que indica la columna donde se guardara
    */
    function &updateCertification($id_line,$name,$valor,$desc){
         global $db;

        $sql = "update lnp_line_parameters set lnp_value='$valor'  where lnp_name='$name' and lnp_id_line='$id_line' and lnp_description='$desc'";
                    
       if(DEBUG==TRUE){  Basic::EventLog("updateCertification--->>: ".$sql);}
            $res =& $db->query($sql);
    }
     
      /**
    *  Obtiene los registros de la tabla lnp_line_parameters pasando los filtros.
    *
    *   @param $id_line	(int)	 Identificador de la linea
    *	@param $name	(string) Nombre del parametro que se guardara;
    *	@param $desc 	(string) Descripcion que indica la columna donde se guardara
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getCertification($id_line,$desc){
         global $db;

        $sql = "select * from  lnp_line_parameters where lnp_id_line='$id_line' and lnp_description='$desc'";
                    
       if(DEBUG==TRUE){  Basic::EventLog("getCertification--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
    function formAdd($id){
        $html = '
        <form id="login" name="login">
        <table width="520" border="0" cellspacing="0" cellpadding="0" align="center" class="loginbox">
        <tr>          
          <td>
            <div class="loginbox">
            <table width="50%" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>
              <td align="right" style="white-space: nowrap">
                <label >UID:</label>
              </td>
              <td>
                <input type="text" name="username" id="username" style="width: 100px" />
              </td>
            </tr>
            <tr>
              <td align="right" style="white-space: nowrap">
                <label >Password:</label>
              </td>
              <td>
                <input type="password" name="password" id="password" style="width: 100px" />
              </td>
            </tr>
            <tr>
              <td colspan="2" align="right">
                <input type="button" name="enter" value="Enter" onClick="xajax_submitLogin(xajax.getFormValues(\'login\'),'.$id.');return false;">
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
    function formLogin($id,$id_line){
        $html = '
        <form id="login" name="login">
        <table width="520" border="0" cellspacing="0" cellpadding="0" align="center" class="loginbox">
        <tr>          
          <td>
            <div class="loginbox">
            <table width="50%" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>
              <td align="right" style="white-space: nowrap">
                <label >UID:</label>
              </td>
              <td>
                <input type="text" name="username" id="username" style="width: 100px" />
              </td>
            </tr>
            <tr>
              <td align="right" style="white-space: nowrap">
                <label >Password:</label>
              </td>
              <td>
                <input type="password" name="password" id="password" style="width: 100px" />
              </td>
            </tr>
            <tr>
              <td colspan="2" align="right">
                <input type="button" name="enter" value="Enter" onClick="xajax_certificar(xajax.getFormValues(\'login\'),'.$id.','.$id_line.');return false;">
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
    function formAddNum($id,$line){
        $html = '
        <form id="login" name="login">
        <table border="0" cellspacing="0" cellpadding="0" align="center" class="loginbox">
        <tr>          
          <td>
            <div class="loginbox">
            <table width="50%" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>              
              <td>
                <input type="text" name="uid" id="uid" maxlength="6" />
              </td>
            </tr>            
            <tr>
              <td colspan="2" align="right">
                <input type="button" name="enter" value="Enter" onClick="xajax_validarUid(\''.$id.'\',\''.$line.'\',xajax.getFormValues(\'login\'));return false;">
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
    function formAddCert($id,$id_line){
        $html = '
        <form id="certif" name="certif">
        <table border="0" cellspacing="0" cellpadding="0" align="center" class="loginbox">
        <tr>          
          <td>
            <div class="loginbox">
            <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">   
            <tr>  <td  style="white-space: nowrap">
                <label >Metodologia:</label>
              </td>
              <td>
                 <select id="meto" name="meto">
                <option value="0">Select</option> 
                <option value="5S">5S</option>
                <option value="Jidoka">Jidoka</option>
                <option value="SW">SW</option>
                <option value="TPM">TPM</option> 
                <option value="VM">VM</option> 
                </select>
              </td>
            </tr> 
             <tr> 
             <td  style="white-space: nowrap">
                <label >Nombre o Firma:</label>
              </td>
              <td>
                 <input type="text" name="firma" id="firma" maxlength="3" style="width: 100px"/>
              </td>
            </tr> 
             <tr> 
           <td  style="white-space: nowrap">
                <label >Fecha:</label>
              </td>
              <td>
                 <input type="date" name="date" id="date"  style="width: 100px"/>
              </td>
            </tr> 
              <tr>
              <td  style="white-space: nowrap">
                <label >Certificaci&oacute;n:</label>
              </td>
              <td>
                <select id="selCert" name="selCert" onchange="xajax_InsertCert(xajax.getFormValues(\'certif\'),'.$id.','.$id_line.')">
                <option value="-1">Select</option>
                <option value="0">Blanc</option>
                <option value="1">Bronce</option>
                <option value="2">Silver</option>
                <option value="3">Gold</option>               
                </select>
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
        
        function formChangeColor($name,$id_line){
        $html = '       
        <table border="0" cellspacing="0" cellpadding="0" align="center" class="loginbox">
        <tr>          
          <td>
            <div class="loginbox">
            <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">   
            <tr>  
              <td>Selecciona la causa:<br>
                <select id="selColor" name="selColor" onchange="xajax_changeColor(\''.$name.'\',document.getElementById(\'selColor\').value,'.$id_line.')">
                <option value="FFFFFF">Seleccionar</option>  
                <option value="00FF00">No Problemas de Calidad</option> 
                <option value="FF0000">Garantias y 0Km</option>
                <option value="FFF101">Problemas internos de calidad</option>
                </select>
              </td>
            </tr> 
             </table>
          </div>
          </td>
        </tr>
        </table>';
       
                return $html;
        }
    function &getFormatJidokaById($id_line){
            global $db;

        $sql = "select * from fjk_formato_jidoka"
                . " where fjk_id_line='$id_line' order by fjk_id desc";
                       
          if(DEBUG==TRUE){
               Basic::EventLog("getFormatJidokaById--->>: ".$sql);
               
           }
            $res =& $db->query($sql);
          
            return $res;
    }
    function &setFormatJidoka($f,$id_line){
         global $db;
         
          $datel=$f['datelnew']." ".$f['selhnew'].":".$f['selminnew']; 
          $sels=$f['selsnew'];
          $textp=$f['textpnew'];
          $inpute=$f['inputenew'];
          $inputc=$f['inputcnew'];
          $textc=$f['textcnew'];
          $texta=$f['textanew'];
          $inputr=$f['inputrnew'];
          $inputn=$f['inputnnew'];
         $dateh=$f['datehnew']." ".$f['selh2new'].":".$f['selmi2new']; 
          $chekType=$f['chekTypenew'];
          $datem=$f['datemnew'];
          $selm=$f['selmnew'];
           
           foreach($f['chekDocnew'] as $selected){
             $checkDoc.="$selected ";
                                   }
           
        $sql = "insert into fjk_formato_jidoka
        (fjk_date_ini,fjk_shift,fjk_problem,fjk_station,fjk_count,fjk_root_cause,fjk_corrective_action,fjk_responsible,fjk_leader_name,fjk_date_fin,fjk_event_type,fjk_document,fjk_date_document_modif,fjk_document_status_modif,fjk_id_line) 
        values ('$datel','$sels','$textp','$inpute','$inputc','$textc','$texta','$inputr','$inputn', '$dateh','$chekType','$checkDoc','$datem','$selm','$id_line')";
          if(DEBUG==TRUE){           
          Basic::EventLog("setFormatJidoka--->>: ".$sql);}
            $res =& $db->query($sql);
    }
    function &updateFormatJidoka($id_line,$name,$valor){
         global $db;

        $sql = "UPDATE fjk_formato_jidoka set lnp_value='$valor'  WHERE lnp_name='$name' and lnp_id_line=$id_line";
                       
        if(DEBUG==TRUE){  Basic::EventLog("updateFormatJidoka--->>: ".$sql);}
            $res =& $db->query($sql);
    }
    
    
     /**
    *  Obtiene Todos los registros de la tabla prc_pyramid_coord 
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getCoordenadas(){
         global $db;
       
        $sql = "select * from prc_pyramid_coord order by prc_id desc";                       
        if(DEBUG==TRUE){   Basic::EventLog("getCoordenadas--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
    
     
     /**
    *  Obtiene Todos los registros de la tabla ltc_line_triangulo 
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getColorsPyramid($id_line){
         global $db;
       
        $sql = "select * from ltc_line_triangulo where ltc_id_line='$id_line'";                       
           if(DEBUG==TRUE){ Basic::EventLog("getColorsPyramid--->>: ".$sql);}
            $res =& $db->queryRow($sql);
            
            return $res;
    }
    
     function &updatePyramid($field_name,$color,$id_line){
         global $db;       
        $sql = "update ltc_line_triangulo set ltc_$field_name='$color' where ltc_id_line='$id_line'";                       
      if(DEBUG==TRUE){  Basic::EventLog("updatePyramid--->>: ".$sql);}
        $res =& $db->query($sql);
            
            return $res;
    }
     function &getPFByID($id_line){
            global $db;

        $sql = "SELECT * FROM spm_subarea_prod_family where spm_id_sub_area='$id_line'";
                       
          if(DEBUG==TRUE){ Basic::EventLog("get days--->>: ".$sql);}
            $res =& $db->queryRow($sql);
          
            return $res;
    }
    
       /**
    *  Obtiene Todos los registros de la tabla prc_pyramid_coord 
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &InsertColors($id_line){
         global $db;
       
        $sql = "INSERT INTO ltc_line_triangulo( ltc_id_line, ltc_triangulo1, ltc_triangulo2, ltc_triangulo3, 
            ltc_triangulo4, ltc_triangulo5, ltc_triangulo6, ltc_triangulo7, 
            ltc_triangulo8, ltc_triangulo9, ltc_triangulo10, ltc_triangulo11, 
            ltc_triangulo12, ltc_triangulo13, ltc_triangulo14, ltc_triangulo15, 
            ltc_triangulo16, ltc_triangulo17, ltc_triangulo18, ltc_triangulo19, 
            ltc_triangulo20, ltc_triangulo21, ltc_triangulo22, ltc_triangulo23, 
            ltc_triangulo24, ltc_triangulo25, ltc_triangulo26, ltc_triangulo27, 
            ltc_triangulo28, ltc_triangulo29, ltc_triangulo30, ltc_triangulo31)
    VALUES ($id_line, 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', 
            'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', 
            'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', 
            'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', 
            'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', 
            'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', 
            'FFFFFF','FFFFFF', 'FFFFFF', 'FFFFFF', 
            'FFFFFF', 'FFFFFF', 'FFFFFF');";                       
     if(DEBUG==TRUE){   Basic::EventLog("InsertColors--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
    
    /**
    *  Obtiene Todos los registros de la tabla pdp_pyramid_problem 
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    
    function &getPyramidProblem($id_line){
         global $db;
        $mes=  date("Y-m");
        $sql = "select * from pdp_pyramid_problem where to_char(pdp_day,'YYYY-MM') ='$mes' and pdp_id_line='$id_line'";                       
        if(DEBUG==TRUE){  
            Basic::EventLog("getPyramidProblem--->>: ".$sql);             
        }
            $res =& $db->query($sql);
            
            return $res;
    }
    
    function &DeletePyramid(){
         global $db;
       
        $sql = "delete from ltc_line_triangulo";                       
         if(DEBUG==TRUE){   Basic::EventLog("DeletePyramid--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
        /**
    *  Inserta registros de la tabla pdp_pyramid_problem 
    *
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &InsertPyramidProblem($id_line,$day,$problem){
         global $db;
       
        $sql = "insert into pdp_pyramid_problem (pdp_id_line,pdp_day,pdp_problem) values ($id_line,'$day','$problem')";                       
         if(DEBUG==TRUE){ Basic::EventLog("InsertPyramidProblem--->>: ".$sql);}
            $res =& $db->query($sql);
            
            return $res;
    }
    
    /**
    *  Obtiene registros de la tabla sba_subarea.
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getGraphByID($id_line,$type,$turno){
            global $db;
        $mes = date('m');
        $sql = "select * from gph_graph where gph_id_line='$id_line' and gph_month='$mes' and gph_tipo='$type' and gph_turno='$turno'";                       
        if(DEBUG==TRUE){  Basic::EventLog("getGraphByID--->>: ".$sql);}
            $res =& $db->queryRow($sql);
          
            return $res;
    }
    
     /**
    *  Actualiza registros de la tabla gph_graph.
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
    *   @param $type	(String) Tipo de grafica (SCRAP,BTS,OEE,FPY)
    *   @param $i	(int)	Identificador de la columna a editar
    *    @param $value	(int)	Valor a insertar
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &updateGraph($id_line,$type,$columna,$value,$turno){
            global $db;
        $mes = date('m');
        $sql = "update gph_graph set $columna='$value' where gph_id_line='$id_line' and gph_month='$mes' and gph_tipo='$type' and gph_turno='$turno' ";                       
        if(DEBUG==TRUE){ 
            Basic::EventLog("updateGraph--->>: ".$sql);
            
        }
            $res =& $db->queryRow($sql);
          
            return $res;
    }
     /**
    *  Inserta registros de la tabla gph_graph.
    *   @param $id_line	(int)	Identificador de la Linea 
    *   @param $type	(String) Tipo de grafica (SCRAP,BTS,OEE,FPY)
    *    @param $value	(int)	Valor a insertar
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &insertGraph($id_line,$type,$value,$turno){
            global $db;
        $mes = date('m');
        $sql = "INSERT INTO gph_graph( gph_id_line, gph_month, gph_tipo, gph_1, gph_turno)
    VALUES ($id_line, $mes,'$type', $value,'$turno')";                       
        if(DEBUG==TRUE){  Basic::EventLog("insertGraph--->>: ".$sql);}
            $res =& $db->queryRow($sql);
          
            return $res;
    }
    
     /**
    *  Obtiene registros de la tabla sba_subarea.
    *
    *   @param $id_line	(int)	Identificador de la Linea de la cual se quieren obtener los registros en esta tabla
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &getLines(){
            global $db;
       
        $sql = "select * from sba_subarea";                       
        if(DEBUG==TRUE){  Basic::EventLog("getLines--->>: ".$sql);}
            $res =& $db->query($sql);
          
            return $res;
    }
    
     /**
    *  Inserta registros de la tabla gph_graph.
    *   @param $id_line	(int)	Identificador de la Linea 
    *   @param $type	(String) Tipo de grafica (SCRAP,BTS,OEE,FPY)
    *    @param $value	(int)	Valor a insertar
    *	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
    */
    function &insertPlan($f,$id_line,$cw){
            global $db;
            $year=date('Y');
     $mlfb=$f['strmlfb'];
      if(!$f['strmonday']){$lu=0;}else{$lu=$f['strmonday'];}
      if(!$f['strtuesday']){$ma=0;}else{ $ma=$f['strtuesday'];}
      if(!$f['strwednesday']){$mi=0;}else{ $mi=$f['strwednesday'];}
      if(!$f['strthursday']){$ju=0;}else{$ju=$f['strthursday'];}
      if(!$f['strfriday']){$vi=0;}else{$vi=$f['strfriday'];}
      if(!$f['strsaturday']){$sa=0;}else{$sa=$f['strsaturday'];}
      if(!$f['strsunday']){$do=0;}else{$do=$f['strsunday'];}
       
        $sql = "INSERT INTO prp_production_plan(
            prp_mlfb, prp_monday, prp_tuesday, prp_wednesday, prp_thursday, 
            prp_friday, prp_saturday, prp_sunday, prp_cw, prp_id_line,prp_year)
    VALUES ('$mlfb', $lu,$ma,$mi,$ju,$vi,$sa,$do,$cw,$id_line,$year)";                       
        if(DEBUG==TRUE){ 
            Basic::EventLog("insertPlan--->>: ".$sql);
            
        }
            $res =& $db->query($sql);
          
            return $res;
}
 function insertMasivePlan($mlfb,$lu,$ma,$mi,$ju,$vi,$sa,$do,$id_line,$cw){
            global $db;
            $year=date('Y');
if(!$lu){$lu=0;}
if(!$ma){$ma=0;}
if(!$mi){$mi=0;}
if(!$ju){$ju=0;}
if(!$vi){$vi=0;}
if(!$sa){$sa=0;}
if(!$do){$do=0;}

        $sql = "INSERT INTO prp_production_plan(
            prp_mlfb, prp_monday, prp_tuesday, prp_wednesday, prp_thursday,
            prp_friday, prp_saturday, prp_sunday, prp_cw, prp_id_line,prp_year)
    VALUES ('$mlfb', $lu,$ma,$mi,$ju,$vi,$sa,$do,$cw,$id_line,$year)";
        if(DEBUG==TRUE){
            Basic::EventLog("insertPlan--->>: ".$sql);

        }
            $res =& $db->query($sql);

            return $res;
    }

    function &getPPlan($id_line){
         global $db;
         $cw=  date("W");
         $year=  date('Y');
       $sql="select sum(prp_monday) as lunes,sum(prp_tuesday) as martes,sum(prp_wednesday) as miercoles,sum(prp_thursday) as jueves,sum(prp_friday) as viernes,sum(prp_saturday) as sabado,sum(prp_sunday) as domingo
            from prp_production_plan 
            where prp_year=$year and prp_cw=$cw and prp_id_line=$id_line";                       
          if(DEBUG==TRUE){  Basic::EventLog("getPlanCW--->>: ".$sql);}
            $res =& $db->queryRow($sql);

            return $res;
    }
    
     function &updatePPlan($f,$i,$id){
         global $db;
     $mlfb=$f['strmlfb'.$i];
     $lu=$f['strmonday'.$i];
     $ma=$f['strtuesday'.$i];
     $mi=$f['strwednesday'.$i];
     $ju=$f['strthursday'.$i];
     $vi=$f['strfriday'.$i];
     $sa=$f['strsaturday'.$i];
     $do=$f['strsunday'.$i];
      
        $sql="UPDATE prp_production_plan
    SET prp_mlfb='$mlfb', prp_monday=$lu, prp_tuesday=$ma, prp_wednesday=$mi, 
       prp_thursday=$ju, prp_friday=$vi, prp_saturday=$sa, prp_sunday=$do       
    WHERE prp_id=$id ";                       
          if(DEBUG==TRUE){  Basic::EventLog("updatePPlan--->>: ".$sql);}
            $res =& $db->query($sql);
            return $res;
    }
      function &deletePPlan($id){
         global $db;
    
        $sql="delete from prp_production_plan WHERE prp_id=$id ";                       
          if(DEBUG==TRUE){  Basic::EventLog("deletePPlan--->>: ".$sql);}
            $res =& $db->query($sql);
            return $res;
    }
}

?>
