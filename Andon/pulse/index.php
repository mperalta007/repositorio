<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
include_once('common.php');

  $idlinea=$_GET['idline'];
  $id_project=$_GET['idproject'];
    
  Layout::pre_header("Pulse");
  header("Refresh: 120; url=/Andon/andon.php?idline=$idlinea&idproject=$id_project");  //header sin advert
  
  //$xajax->printJavascript("/include/");
  //Layout::post_header("Pulse");
    echo '<center><h3>Pulse</h3></center>';
    
 $lines = new Line();

       $array = $lines->getRecordById_line($idlinea);

       $raw=$array->fetchRow();
       $name_line=$raw['sba_pulse_name'];

       $resultado=$lines->getC_keyByName($name_line);

        $rowline=oci_fetch_array($resultado);
        $root_c_key=$rowline['ROOT_C_KEY'];
        $c_key=$rowline['C_KEY'];

        $name=split(' ',$name_line);


    $dia= date('d');
    $mes=date('m');
    $year= date('Y');


    $hour= date('g');
    $hour2= date('g', strtotime("+1 hour"));

    $time=date('a');
    $time2= date('a', strtotime($hour2));

    //echo "$dia-$mes-$year $hour:00 $time  a $hour2:00 $time2";
    $tam_name=count($name);
        switch ($tam_name) {
    case 1:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+hh%3Amm%3Ass&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key='.$root_c_key.'&node_name='.$name[0].'&complete_name='.$name[0].'&node_type=N&c_key='.$c_key.'&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
   case 2:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key='.$root_c_key.'&node_name='.$name[0].'+'.$name[1].'&complete_name='.$name[0].'+'.$name[1].'&node_type=N&c_key='.$c_key.'&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
   case 3:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key='.$root_c_key.'&node_name='.$name[0].'+%2F+'.$name[2].'&complete_name='.$name[0].'+%2F+'.$name[2].'&node_type=N&c_key='.$c_key.'&is_line=N&line_level=0&refresh=&line_reporting=false';
    break;
}
   
      echo '<center><iframe src="'.$source.'" width="90%" height="80%" frameborder="0" ></iframe></center>';
  
  //  Layout::footer()1
