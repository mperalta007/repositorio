<?php
 /******************************************************************************
 *  Pack PCB's Version 1.0                                                     *
 *  Copyright (C) 2010 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Christian Iniguez  (jose.iniguez@continental-corporation.com)      *
 *  Descripcion:                                                               *
 *  Alta y Modificacion de Productos                                           *
 *                                                                             *
 ******************************************************************************/

  include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
  include_once('common.php');

  global $user, $base; 
  
  $id_line=$_GET['idline'];
  $id_project=$_GET['idproject'];
  $andon = new Andon();

 $name=$andon->getNameById($id_line);
 $name_line=$name->fetchRow();
  header("Refresh: 120; url=/pulse/index.php?idline=$id_line&idproject=$id_project");  //header sin advert
  Layout::pre_header();
  $xajax->printJavascript("/include/");
 // Layout::post_header();
  //Layout::post_header1("base");
  

/*=========================================*/ 
 

         echo '<center><h3>Hora por Hora</h3></center><br>';

    echo '<br><h1>'.$name_line['sba_name'].'</h1><br>
    <center>
    <!-- Dimensiones de la tabla 1800x720-->   
    <div name="div1" id="div1" style="height:500px;" >
    <table border="0" cellpadding="10" cellspacing="0" style="width:95%;height:90%;padding:0px 0px 0 0px;margin:0px 0px 0 0px;">
      <tr valign="top" style="height:90%;"> 
          <td align="center" style="width:80%;">
             <iframe src="desempeno.php?idline='.$id_line.'&idproject='.$id_project.'" width="100%" height="100%" frameborder="0" style="margin:0px 0px 10px 10px;"></iframe>
          </td>
         
      </tr>
           
    </table>
    
    </div>
     </center>';

 // Layout::footer();

 

