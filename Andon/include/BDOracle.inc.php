<?php
putenv("ORACLE_HOME=/usr/lib/oracle/xe/app/oracle/product/10.2.0/server");
putenv("ORACLE_SID=mestq");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 /** \brief Clase para el manejo de la conexion a oracle
	*
	* En esta clase se definen los metodos para el manejo de la conexion a oracle
	* <b>"ORACLE"</b>.
	*
	* @author	Miguel Peralta
	* @version	1.0
	* @date		Dic 22, 2014
	*
	* 
	*/
class BDOracle extends PEAR  {
    
    
     /**
    *  Funcion para conectarse a Oracle.
    *
    *   @param $user	(string)	Usuario para la conexion a la base de datos de oracle
    *	@param $pass	(string)	Password para la conexion a la base de datos de oracle
    *	@param $bdname 	(string)        Nombre de la base de datos en oracle
    *	@return $conn 	(object)        Objeto que contiene la conexion a oracle.
    */
    function connect(){
      
         $conn = oci_connect('pulse','CamLine4gdl','mestq'); 
    if (!$conn) {
      $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
   //trigger_error(htmlentities($e['message']), E_USER_ERROR);
                }
       return $conn;
    }
    
  /**
    *  Funcion para ejecutar los querys en oracle.
    *
    *   @param $user	(string)	Usuario para la conexion a la base de datos de oracle
    *	@param $query	(string)	Query que se ejecutara en la base de datos
    *	@return $stid	(array)         Array con el resultado del query
    */
 function executeqry($query){
        
$conn= self::connect();
          
    $stid = oci_parse($conn, $query);
    oci_execute($stid);
   
    oci_close($conn);
    
          return $stid;  
    }
	


}

