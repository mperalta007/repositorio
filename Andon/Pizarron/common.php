<?php
 /******************************************************************************
 *  SICE Version 1.0 - Modulos de Alumnos                                      *
 *  Copyright (C) 2006 Jesus Velazquez                                         *
 *  Para Sistemas Aplicados Y Telecomunicaciones S.A.                          *
 *                                                                             *
 *  Author: Jesus Velazquez                                                    *
 *  Descripcion:                                                               *
 *   Modulo diseñado para la consulta y actualizacion de datos de los          *
 *   Alumnos                                                                   *
 *  Modificaciones:                                                            *
 *  Fecha        Autor                   Descripcion                           *
 *  29.Nov.2007  J. Velazquez            Inicio de la programacion             *
 *               <jjvema@yahoo.com>                                            *
 *                                                                             *
 ******************************************************************************/
	include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
	require_once ("xajax.inc.php");

  $xajax = new xajax("server.php");
  $xajax->registerFunction("mostrar");
  $xajax->registerFunction("email");
  $xajax->registerFunction("login");
  $xajax->registerFunction("submitLogin");
  $xajax->registerFunction("update");
  $xajax->registerFunction('uploadPdf');
  $xajax->registerFunction('setCumplimiento');
  $xajax->registerFunction('saveAction');
  $xajax->registerFunction('printUid');
  $xajax->registerFunction('validarUid');
  $xajax->registerFunction('certificar');
  $xajax->registerFunction('InsertCert');
  $xajax->registerFunction('CertLogin');
  $xajax->registerFunction('stop');
  $xajax->registerFunction('restart');
  $xajax->registerFunction('statusChange');
  $xajax->registerFunction('Delete');
  $xajax->registerFunction('saveFJ');
  $xajax->registerFunction('Redirect');
  $xajax->registerFunction('showAlertColor');
  $xajax->registerFunction('showButtons');
  $xajax->registerFunction('changeColor');
  $xajax->registerFunction('showColor');
  $xajax->registerFunction('savePyramid');
  $xajax->registerFunction('saveGrafica');
  $xajax->registerFunction('showPPlan');
  $xajax->registerFunction('cargarPlan');
  $xajax->registerFunction('showTable');
  $xajax->registerFunction('saveRow');
  $xajax->registerFunction('updateRow');
  $xajax->registerFunction('deleteRow');
  $xajax->registerFunction('saveMasivePlan');
  $xajax->registerFunction('active');

?>
