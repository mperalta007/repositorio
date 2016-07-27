<?php 
 /******************************************************************************
 *  WLS Version 1.0 - Andon Board System                                       *
 *  Copyright (C) 2015 Continental Services Guadalajara Mexico                 *
 *                                                                             *
 *  Author: Miguel Peralta                                                     *
 *                                                                             *
 *                                                                             *
 ******************************************************************************/
  include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
  include_once('common.php');

  global $user;
  
  $bu = new BusinessUnits();
 // $data = new MDS();
  
  Layout::pre_header();
  $xajax->printJavascript("/include/");
  Layout::post_header();
  Layout::post_header1("base");
  echo "<center><form id='general'><br>";
  
echo "<table><tr><td><div id='divBu' style='font-size:2em'>".$bu->printSelect(1982,'getProjects')."</div></td>";
//echo "<table><tr><td><div id='divBu' style='font-size:2em'>".$data->printSelectDivision("getProjects")."</div></td>";?>
<td><div id='divProject' style='font-size:2em'></div></td>
<td><div id="divLine"    style='font-size:2em'></div></td></tr></table>

</form>
<img src="/images/logocontinental.png" style="opacity:0.4">
 </center>
  <?php
 Layout::footer();
 

