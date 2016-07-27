<?php

/******************************************************************************
 *  MES Self-Service Version 1.0.1
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jose Iniguez  (jose.iniguez@continental-corporation.com)
 *  Descripcion:                                                               
 *   Archivo que contiene las configuraciones iniciales del sistema
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/


// Constants
  if(!defined('PATH_APP'))            define('PATH_APP',$_SERVER["DOCUMENT_ROOT"]);
  if(!defined('INCLUDE_PATH'))        define('INCLUDE_PATH',PATH_APP.'/include/');
  if(!defined('LOG_ENABLED'))         define('LOG_ENABLED',1);
  if(!defined('LOG_DATE_FORMAT'))     define('LOG_DATE_FORMAT', "M d H:i:s Y");
  if(!defined('FILE_LOG'))            define('FILE_LOG','/var/www/htdocs/vhosts/Andon/log/andon.log');
  if(!defined('SQLC'))                define('SQLC', "pgsql://postgres@10.218.108.189/camline");
  if(!defined('SQLC_CONTROL'))        define('SQLC_CONTROL',"pgsql://postgres@10.218.108.189/control");
  if(!defined('SQLC_MDS'))            define('SQLC_MDS',"pgsql://postgres@10.218.108.189/mdsgl");
  if(!defined('SQLC_USERS'))          define('SQLC_USERS',"pgsql://postgres@10.218.108.253/employees");
  if(!defined('SQLC_CAMLINE'))        define('SQLC_CAMLINE',"oci8://wip:CamLine4gdl@10.218.231.22/mestq");
  if(!defined('SQLC_PULSE'))          define('SQLC_PULSE',"oci8://pulse:CamLine4gdl@10.218.231.22/mestq");
  if(!defined('SQLC_DWH'))            define('SQLC_DWH',"oci8://ppqr:ppqr@10.218.231.22/mestqdwh");
  if(!defined('TITLE'))               define('TITLE',"Andon Board System");
  if(!defined('SUB_TITLE'))           define('SUB_TITLE'," Andon Board System");
  if(!defined('VERSION'))             define('VERSION',"1.0.1");
  if(!defined('FOOTER_LEFT'))         define('FOOTER_LEFT',"Production Data Network");
  if(!defined('FOOTER_CENTER'))       define('FOOTER_CENTER',"Andon Board System");
  if(!defined('FOOTER_RIGHT'))        define('FOOTER_RIGHT','<img src="/images/contilogo.png" style="width: 20%;">');
  if(!defined('TIMEOUT'))             define('TIME_OUT',12000);
  if(!defined('AD_SERVER_PRIMARY'))   define('AD_SERVER_PRIMARY','tq2c101a.cw01.contiwan.com');
  if(!defined('AD_SERVER_SECONDARY')) define('AD_SERVER_SECONDARY','gl2c101a.cw01.contiwan.com');
  if(!defined('AD_SERVER_PORT'))      define('AD_SERVER_PORT','389');
  if(!defined('ROWSXPAGE'))           define('ROWSXPAGE', 20);
  if(!defined('MAXROWSXPAGE'))        define('MAXROWSXPAGE', 1000);
  if(!defined('SESSION_NAME'))        define('SESSION_NAME', '_AndOn');
  if(!defined('NOW'))                 define('NOW', date("Y-m-d H:i:s"));
  if(!defined('DEBUG'))               define('DEBUG', FALSE);
  
// Variables

  ini_set('include_path',INCLUDE_PATH);	// Set the include_path php variable
  putenv("TZ=America/Mexico_City");	// Set the Time Zone

  require_once("PEAR.php");
  include_once('MDB2.php');
  require_once("Event.inc.php");
  require_once("basic.inc.php");
  require_once("layout.inc.php");
  require_once("User.inc.php");
  require_once("xajax.inc.php");
  require_once("xajaxGrid.inc.php");
  require_once("fancyr.php");
  require_once("Projects.inc.php");
  require_once("BusinessUnits.inc.php");
  require_once("ProductFamilyRough.inc.php");
  require_once("Products.inc.php");
  require_once('Plan.inc.php');
  require_once('ProductFamily.inc.php');
  require_once('BDOracle.inc.php');
  require_once('Line.inc.php');
  require_once('Formulario.inc.php');
  require_once('Monitor.inc.php');
  require_once('Mail.php');
  require_once('Andon.inc.php');
  require_once('MDS.inc.php');
  require_once(dirname(__FILE__) .'/jqGrid/phpGrid.php');
  
  
  $GLOBALS['dbc'] =& MDB2::connect(SQLC_CONTROL);
    if (PEAR::isError($GLOBALS['dbc'])){
        die("Error de conexion : ".$GLOBALS['dbc']->getMessage());
        exit;
    }
  $GLOBALS['dbc']->setFetchMode(MDB2_FETCHMODE_ASSOC);
    
  
  $GLOBALS['db'] =& MDB2::connect(SQLC);
  if (PEAR::isError($GLOBALS['db'])){
    die("Error de conexion : ".$GLOBALS['db']->getMessage());
    exit;
  }    
  $GLOBALS['db']->setFetchMode(MDB2_FETCHMODE_ASSOC);
  
  $GLOBALS['dbu'] =& MDB2::connect(SQLC_USERS);
  if (PEAR::isError($GLOBALS['dbu'])){
    die("Error de conexion : ".$GLOBALS['dbu']->getMessage());
    exit;
  }    
  $GLOBALS['dbu']->setFetchMode(MDB2_FETCHMODE_ASSOC);
  
    $GLOBALS['mds'] =& MDB2::connect(SQLC_MDS);
  if (PEAR::isError($GLOBALS['mds'])){
    die("Error de conexion : ".$GLOBALS['mds']->getMessage());
    exit;
  }    
  $GLOBALS['mds']->setFetchMode(MDB2_FETCHMODE_ASSOC);
  
  
  
 if (!isset($_SESSION['user'])) {
        session_cache_limiter('nocache');
        ini_set('session.gc_maxlifetime',TIME_OUT);
        session_start();
  
  if (!@(is_object($_SESSION['user']))) {
        $_SESSION['user'] = & new User();
    } 
    //session_start();
  }
  $GLOBALS['user']  =& $_SESSION['user'];
  
    
  
  
?>
