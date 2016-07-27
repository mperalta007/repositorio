<?php                                             
//error_reporting(E_ALL);
// error_reporting(E_STRICT);
//ini_set('display_errors', 1);

//require_once(dirname(__FILE__) .'/include.inc.php');  
require_once(dirname(__FILE__) .'/callbackstr.php');  
require_once(dirname(__FILE__) .'/server/classes/cls_db.php');  
require_once(dirname(__FILE__) .'/server/classes/cls_dataarray.php');  
require_once(dirname(__FILE__) .'/server/classes/cls_datagrid.php');  
require_once(dirname(__FILE__) .'/server/classes/cls_util.php');  
require_once(dirname(__FILE__) .'/server/classes/cls_control.php');  
require_once(dirname(__FILE__) .'/server/adodb5/adodb.inc.php');  
require_once(dirname(__FILE__) .'/server/pdftable/lib/pdftable.inc.php');


// fix missing DOCUMENT_ROOT in IIS
if(!isset($_SERVER['DOCUMENT_ROOT'])){ if(isset($_SERVER['SCRIPT_FILENAME'])){
		$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF'])));
}; };
if(!isset($_SERVER['DOCUMENT_ROOT'])){ if(isset($_SERVER['PATH_TRANSLATED'])){
		$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0-strlen($_SERVER['PHP_SELF'])));
}; };
// NOT USED. Define custom CSS files to load. 
define('ADDITIONAL_JS_FILES', implode(',', array()));
// NOT USED. Define custom JS files to load. 
define('ADDITIONAL_CSS_FILES', implode(',', array()));

// used by highlighter.js as the default css style
define('JS_HIGHLIGHT_CSS_STYLE', "zenburn");

define('GRID_SESSION_KEY', 'camline');
define('JQGRID_ROWID_KEY', 'id');
define("CHECKBOX", "checkbox");
define("SELECT", "select");
define("MULTISELECT", "multiselect");  
define('FPDF_FONTPATH',dirname(__FILE__).'/include/jqGrid/server/pdftable/font/');
define('PK_DELIMITER', '---');     // must be 3 characters
define('PHPGRID_DB_HOSTNAME','10.218.108.189'); // database host name
define('PHPGRID_DB_USERNAME', 'postgres');     // database user name
define('PHPGRID_DB_PASSWORD', ''); // database password
define('PHPGRID_DB_NAME', 'camline'); // database name
define('PHPGRID_DB_TYPE', 'postgres');  // database type
define('PHPGRID_DB_CHARSET','');
?>
