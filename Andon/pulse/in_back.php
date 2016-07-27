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
    
    /*
    $lines = new Line();   
     
       $array = $lines->getRecordById_line($idlinea);
       
       $raw=$array->fetchRow();
       $name_line=$raw['sba_name'];
     
       $resultado=$lines->getC_keyByName($name_line);
                        
        $rowline=oci_fetch_array($resultado);
           
        $c_key=$rowline['ID'];
     
        $name=  split(' ',$name_line);                  
          
        if($idlinea == 3){
        $source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=contiLineStdReport&root_c_key=18707&node_name=Toyota+989A&complete_name=Toyota+989A&node_type=N&c_key=35424&is_line=&line_level=0&line_reporting=false&params_to_session=line_reporting&file=pulse_conti_oee_qr_trend.xml';
        }else{
           
        if($idlinea == 38){
              
        $source="http://tqmesasv.cw01.contiwan.com:8861/iGate/stdReport?root_c_key=18707&node_name=Matrix+%2F+Pinta&complete_name=Matrix+%2F+Pinta&node_type=N&c_key=21018&tsf_ti_format=dd.MM.yyyy&file=pulse_conti_oee_trend.xml&null_params=target_uptime";
    
        }else{
              
        $source="http://tqmesasv.cw01.contiwan.com:8861/iGate/stdReport?root_c_key=18707&node_name=$name[0]&complete_name=$name[0]&node_type=N&c_key=$c_key&tsf_ti_format=dd.MM.yyyy&file=pulse_conti_oee_trend.xml&null_params=target_uptime";
   
      if($name[1]){
        $source="http://tqmesasv.cw01.contiwan.com:8861/iGate//plugin?plugin_name=contiLineStdReport&root_c_key=18707&node_name=$name[0]+$name[1]&complete_name=$name[0]+$name[1]&node_type=N&c_key=$c_key&is_line=&line_level=0&line_reporting=false&params_to_session=line_reporting&file=pulse_conti_oee_qr_trend.xml";
        }
     if($name[2]){
        $source="http://tqmesasv.cw01.contiwan.com:8861/iGate/stdReport?root_c_key=18707&node_name=$name[0]+$name[1]+$name[2]&complete_name=$name[0]+$name[1]+$name[2]&node_type=N&c_key=$c_key&tsf_ti_format=dd.MM.yyyy&file=pulse_conti_oee_trend.xml&null_params=target_uptime";
    }
           }}*/
    $dia= date('d');
    $mes=date('m');
    $year= date('Y');
   

    $hour= date('g');
    $hour2= date('g', strtotime("+1 hour"));
      
    $time=date('a');
    $time2= date('a', strtotime($hour2));       
   
    //echo "$dia-$mes-$year $hour:00 $time  a $hour2:00 $time2";
    
        switch ($idlinea) {
    case 3:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+hh%3Amm%3Ass&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=Toyota+989A&complete_name=Toyota+989A&node_type=N&c_key=35424&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
 case 15:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=DS+HL&complete_name=DS+HL&node_type=N&c_key=37871&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
   case 16:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=DS+ML&complete_name=DS+ML&node_type=N&c_key=21307&is_line=N&line_level=0&refresh=&line_reporting=false'; 
       break;
   case 30:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=Matrix+%2F+Pinta&complete_name=Matrix+%2F+Pinta&node_type=N&c_key=21018&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
   case 31:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=Rushmore+Satelite&complete_name=Rushmore+Satelite&node_type=N&c_key=22558&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
    case 32:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=Rushmore+Cluster&complete_name=Rushmore+Cluster&node_type=N&c_key=22320&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
   case 36:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=CVSG+L1&complete_name=CVSG+L1&node_type=N&c_key=22094&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
   case 37:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=CVSG+L2&complete_name=CVSG+L2&node_type=N&c_key=22108&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
   case 38:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=18707&node_name=CVSG+MEC&complete_name=CVSG+MEC&node_type=N&c_key=22314&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;
  case 55:
$source='http://tqmesasv.cw01.contiwan.com:8861/iGate/plugin?plugin_name=pulseLogBook&tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_start='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour.'%3A00%3A00+'.$time.'&pulse_tsf_ti='.$mes.'%2F'.$dia.'%2F'.$year.'+'.$hour2.'%3A00%3A00+'.$time2.'&pulse_tsf_ti_format=MM%2Fdd%2Fyyyy+h%3Amm%3Ass+a&params_to_session=pulse_tsf_ti%3Bpulse_tsf_ti_start%3Bpulse_tsf_ti_format&use_ttn=&time_track=D&track_type=Time&file=pulse_logbook_rep.xml&root_c_key=19403&node_name=SMD+5&complete_name=SMD+5&node_type=N&c_key=24463&is_line=N&line_level=0&refresh=&line_reporting=false';
       break;

}   
    
      echo '<center><iframe src="'.$source.'" width="90%" height="80%" frameborder="0" ></iframe></center>';
  
  //  Layout::footer()1
