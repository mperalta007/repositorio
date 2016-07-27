<?php

/******************************************************************************
 *  Backflush Version 2.0.1 - Backflush SYSYTEM                                  
 *  Copyright (C) 2009 Continental Services Guadalajara Mexico                 
 *                                                                             
 *  Author: Jesus Velazquez  (jjvema@yahoo.com)                                
 *  Descripcion:                                                               
 *   Archivo que contiene la clase de manejo de funciones de layout
 *                                                                             
 *  Modifications                                                              
 *                                                                             
 ******************************************************************************/



class Layout extends PEAR{

/**
	*  Imprime la primer parte del encabezado de una pagina HTML
	*
	*   @param None
	*	@return None 	
	*/
    
	function pre_header(){
		$html = '

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   
	<title>'.TITLE.'</title>
	<meta name="robots" content="index, follow" />
        <link rel="shortcut icon" href="/images/favicon.ico" />
	<meta http-equiv="Content-Language" content="es-mx">
	<link href="/css/style_2.css" type="text/css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <!--[if lt IE 9]>
           <script src="/include/js/modernzr.js"></script>
        <![endif]-->
        <script type="text/javascript">
      function disable_backspace(){
        document.onkeydown = function(evt) {
            evt = evt || window.event;
           if (evt.keyCode == 8) {
              return false;
           }
        };
      }
        function enable_backspace(){
        document.onkeydown = function(evt) {
            evt = evt || window.event;
           if (evt.keyCode == 8) {
              return true;
           }
        };
      }
      </script>
      <script type="text/javascript" src="/include/js/jquery-1-4-2-min.js">
</script>

<script type="text/javascript">
//<![CDATA[
var j = jQuery.noConflict();
j(function (){
j(".botonera").hover(function(){
j(".botonera").stop(true, false).animate({right:"0"},"medium");
},function(){
j(".botonera").stop(true, false).animate({right:"-400"},"medium");
},500);
return false;
});
//]]>
</script>
        <script language="JavaScript" type="text/javascript" src="/include/js/JSCookMenu_mini.js"></script>
        <script language="JavaScript" type="text/javascript" src="/include/js/ThemeOffice/theme.js"></script>
        <script type="text/javascript" src="/include/js/jquery.min-1.7.2.js"></script>
        <link rel="stylesheet" type="text/css" media="screen" src="/css/jquery-ui-1.8.18.css">
        <script type="text/javascript" src="/include/js/jquery-ui.min-1.8.18.js"></script>';
	echo $html;
	}

    /**
	*  Imprime la segunda parte del encabezado de una pagina HTML
	*
	*   @param $param (string) Pone en el tag <body> lo que se le haya pasado en esta variable
	*	@return None 	
	*/
	function post_header($param = null){
    global $login;
		echo '
</head>
<body '.$param.'>
     
<div align="center">
  <table border="0" cellpadding="0" cellspacing="0" style="width:100%;height:100%;padding:0px 0px 0 0px;margin:0px 0px 0 0px;">
    <tr valign="top" style="height:37px;padding:0px 0px 0 0px;margin:0px 0px 0 0px;"> 
      <td align="left">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td valign="center" class="main-header">&nbsp;'.SUB_TITLE.'</td>
            <td valign="center" class="main-header2" align="right">'.Basic::longDate().'</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="top" style="height:100%;padding:0px 0px 0 0px;margin:0px 0px 0 0px;"> 
      <td align="left">';
	}

    /**
	*  Imprime el menu de acuerdo al tipo de permiso 
	*
	*   @param $perm (string) Permiso del usuario
	*	@return None 	
	*/
  function print_menu($perm = null){
    //global $user;
    //$perm = $user->checkperms('Menu');
   //$perm="Administrator";
    echo '<div id="myMenuID" class="menubackgr" style="padding-left:5px;" ></div>';
    
  //  include($_SERVER["DOCUMENT_ROOT"].'/include/js/menu'.$perm.'.js');
    include($_SERVER["DOCUMENT_ROOT"].'/include/js/menu.js');
   /* 
    switch ($perm){
      case 'Administrator': include($_SERVER["DOCUMENT_ROOT"].'/include/js/menuAdministrator.js'); break;
      case 'Supervisor': include($_SERVER["DOCUMENT_ROOT"].'/include/js/menuSupervisor.js'); break;
      case 'Operator': include($_SERVER["DOCUMENT_ROOT"].'/include/js/menuOperator.js'); break;
      default : include($_SERVER["DOCUMENT_ROOT"].'/include/js/menuOperator.js'); break;
    }
    */
  }

    /**
	*  Imprime la tercera parte del encabezado de la pagina HTML
	*
	*   @param None
	*	@return None 	
	*/
    
  function post_header1($moduleTitle = null){
    global $login;
    Layout::print_menu();
  }

    /**
	*  Imprime el pie de pagina en HTML
	*
	*   @param None
	*	@return None 	
	*/
  function footer(){
	 $html = '
</td>
    </tr>
    <tr VALIGN=BOTTOM style="height:10px;padding:0px 0px 0 0px;margin:0px 0px 0 0px;"> <!-- Footer -->
      <td>
        <table border="0" width="100%" class="tableFooter">
        <tr>
          <td align="left" width="33%">
            '.FOOTER_LEFT.'
          </td>
          <td align="center" width="34%">
            '.FOOTER_CENTER.'				    
          </td>
          <td align="right" width="33%">
            '.FOOTER_RIGHT.'	
          </td>
        </tr>
        </table>
      </td>
   </tr>
  </table>
</div>
</html>
';
	echo $html;
  }

    /**
	*  Imprime la caja de dialogo para el login de usuario
	*
	*   @param None
	*	@return None 	
	*/
  function login_form($var){
    echo '
        <br><br>
        <form id="login" name="login">
        <table width="520" border="0" cellspacing="0" cellpadding="0" align="center" class="loginbox">
        <tr>
          <td valign="top" align="center">
            <img src="/images/security.png">
	     Welcome to  '.FOOTER_CENTER.'
            <br><br>Write your UID and password to access.
            
          </td>
          <td>
          <div><img src="/images/login.gif"></div>
          <div class="loginbox">
            <table width="50%" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>
              <td align="right" style="white-space: nowrap">
                <label for="username">Username:</label>
              </td>
              <td>
                <input type="text" name="username" id="username" style="width: 150px" />
                <input type="text" name="var" id="var" style="width: 150px; visibility:hidden"  value="'.$var.'"/>
              </td>
            </tr>
            <tr>
              <td align="right" style="white-space: nowrap">
                <label for="password">Password:</label>
              </td>
              <td>
                <input type="password" name="password" id="password" style="width: 150px" />
              </td>
            </tr>
            <tr>
              <td colspan="2" align="right">
                <input type="button" name="enter" value="Enter" onClick="xajax_submitLogin(xajax.getFormValues(\'login\'));return false;">
              </td>
            </tr>
            </table>
          </div>
          </td>
        </tr>
        </table>
        <br>
         <div id="errorMessage"></div>
        </form>
        <br><br>
        <center>
          <img src="/images/logocontinental.png">
        </center>
        ';
	}

    /**
	*  Inicia la creacion de un Panel Tab
	*
	*   @param $id (String) Identificador del Tab Panel, necesario para el codigo de Javascript
	*	@return $html (String) 	Devuelve el codigo HTML necesario para la creacion de un Panel Tab
	*/
    
  function startPanel($id){
    $html = '
      <div class="tab-pane" id="'.$id.'">
        <script type="text/javascript">
          tp1 = new WebFXTabPane( document.getElementById( "'.$id.'" ) );
        </script>';
        return $html;
    }

  /**
	*  Termina la creacion de un Panel Tab
	*
	*   @param None
	*	@return $html (String) 	Devuelve el codigo HTML necesario para la terminacion de un Panel Tab
	*/
  function endPanel() {
    $html = "</div>\n";
      return $html;
    }

 /**
	*  Inicia la creacion de un Tab
	*
	*   @param $tabText (String) Textp que identifica el Tab, necesario para el codigo de Javascript
    *   @param $tabID (String) Identificador del Tab Panel, necesario para el codigo de Javascript
	*	@return $html (String) 	Devuelve el codigo HTML necesario para la creacion de un Panel Tab
	*/
  function startTab( $tabText, $tabID ) {
    $html = '
      <div class="tab-page" id="'.$tabID.'">
        <h2 class="tab">'.$tabText.'</h2>
        <script type="text/javascript">
          tp1.addTabPage( document.getElementById( "'.$tabID.'" ) );
        </script>';

      return $html;
  }

 /**
	*  Finaliza la creacion de un Tab Panel
	*
	*   @param None
	*	@return $html (String) 	Devuelve el codigo HTML necesario para la terminacion de un Tab
	*/
    
  function endTab() {
    $html = "</div>\n";
    return $html;
  }

}

?>