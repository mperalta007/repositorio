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

require_once ('common.php');

function email($id){
     $objResponse = new xajaxResponse();    
$objResponse->addAlert($id);
switch ($id){
     case "1":
         Basic::sendMail("AVISOS","angel.carreon@continental-corporation.com","Hola tu como estas no te conocemos");
        break;
     case "2":
         Basic::sendMail("Avisos_Pruebas","alejandro.andrade@continental-corporation.com","Hola como estas? estoy haciendo pruebas con el envio de correos disculpa por las molestias :)");
        break;
     case "3":
         Basic::sendMail("Avisos_Pruebas","jesus.velazquez@continental-corporation.com","Hola como estas? estoy haciendo pruebas con el envio de correos disculpa por las molestias :)");
        break;
     case "4":
         Basic::sendMail("Avisos_Pruebas","narcizo.ruiz.perez@continental-corporation.com","Hola como estas? estoy haciendo pruebas con el envio de correos disculpa por las molestias :)");
        break;
     case "5":
         Basic::sendMail("Saludos","rodrigo.hernandez@continental-corporation.com","Hola como estas?   ");
        break;
     case "6":
        break;
     case "7":
        break;
     case "8":
        break;
     case "9":
        break;
     
}
    return $objResponse->getXML();
}

$xajax->processRequests();
sw
?>
