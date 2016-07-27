<?php 

  include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
  include_once('common.php');
  $id_line=$_GET['id_line'];
  $fecha=$_GET['fecha'];
  $columna=$_GET['columna'];
?>
<html>
   <head>
         <?php $xajax->printJavascript("/include/");?> 
	
	<meta http-equiv="Content-Language" content="es-mx">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="/css/style_monitor.css" type="text/css" rel="stylesheet" />
       
   </head>

<body>
  <?php
 
  $plan= new Line();
  $andon= new Andon();
  $monitor = New Monitor();
  
    $hoy=date('Y-m-d');
    
    if($fecha == $hoy){
      $id_area=$plan->getIdArea($id_line);
    
    switch ($id_area) {
        case 3:
$host= $plan->getEndCtrlById($id_line);
            break;
        case 4:
$host= $plan->getAOIById($id_line);
            break;
        case 5:
$host= $plan->getEndCtrlById($id_line);
            break;
        case 6:
$host= $plan->getICTById($id_line);
            break;
    }

     $host_name=$host->fetchRow();
     $partPass=$plan->getProductionCurrent($host_name['stn_host_name']); 
    }

 // $array_plan=$plan->getPlanByIdLine($id_line,$fecha);
    $array_plan=$plan->getPlanByIdLineNew($id_line,$columna);
  $array_real=$plan->getRealByIdLine($id_line,$fecha);

  $x=0;
  while($row_plan=$array_plan->fetchRow()){
      
     $plan_pro [0][$x] =$row_plan['pro_product'];
     $plan_pro [1][$x] =$row_plan['pro_quantity'];
      
      $x++;
     // echo '<tr><td>'.$row_plan['pro_product'].'</td><td>'.$row_plan['pro_quantity'].'</td></tr>';
  }

  
  $j=0;
while($row_real=$array_real->fetchRow()){
    
    $real [0][$j] =$row_real['partno'];
    $real [1][$j] =$row_real['qty'];
    $j++;
    // echo '<tr><td>'.$row_real['partno'].'</td><td>'.$row_real['qty'].'</td></tr>';
  }  
$k=0;

//echo "<br>Plan<br>";
//   for ($i = 0; $i < count($plan_pro [0]); $i++) {
//   echo $plan_pro [0][$i]." ".$plan_pro [1][$i]."<br>";
//   }
 if($fecha == $hoy){
while($row=oci_fetch_array($partPass)){  
        
    $real_2 [0][$k] =$row['PARTNO'];
    $real_2 [1][$k] =$row['UNITS']/2;
    $K++;
       } 
       
//  echo "<br>Real Turno<br>";
//       for ($i = 0; $i < count($real [0]); $i++) {
//    echo $real [0][$i]." ".$real [1][$i]."<br>";
//    }
   
//  echo "<br>Real hora<br>";
//      for ($j = 0; $j < count($real_2 [0]); $j++) {
//    echo $real_2 [0][$j]." ".$real_2 [1][$j]."<br> ";
//    }
//        
//    echo "<br>Real Turno vs Real hora<br>";

for ($i = 0; $i < count($real [0]); $i++) {        
    for ($j = 0; $j < count($real_2 [0]); $j++) {
     //   echo $real [0][$i]." vs ".$real_2 [0][$j]."<br>";
        if($real [0][$i] == $real_2 [0][$j]){  
                      $real [1][$i] = $real [1][$i] + $real_2 [1][$j];           
        }    
    }
}
//    echo "<br>".count($real[0])."<br>";
//    echo "<br>".count($real_2[0])."<br>";
if(count($real[0]) == 0){
     for ($j = 0; $j < count($real_2[0]); $j++) {
         //echo $real_2 [0][$j];
         $real[0][]=$real_2[0][$j];
         $real[1][]=$real_2[1][$j];            
    }
}
    }
// echo "<br>Real Total<br>";
//   for ($i = 0; $i < count($real [0]); $i++) {
// echo $real [0][$i]." ".$real [1][$i]."<br>";
//    }

  
 // echo "<br>Plan  Real<br>";
 
  for ($i = 0; $i < count($plan_pro [0]); $i++) {  
       $c=0;
    for ($j = 0; $j < count($real [0]); $j++) {
      //  echo $plan_pro [0][$i]." vs ".$real [0][$j]."<br>";
        if($plan_pro [0][$i] == $real [0][$j]){
            $plan_pro [2][$i]=$real [1][$j];
            $plan_pro [3][$i] = $plan_pro [1][$i] - $real [1][$j];
            $c++;
        } else{
            if($c ==0){
            $plan_pro [2][$i]=0;
            $plan_pro [3][$i] = $plan_pro [1][$i]; 
            }
        }   
    }
} 
$resultado = array_diff($real [0],$plan_pro [0]);
//echo "<br>Diferencias<br>";
foreach ($resultado as $value) {    
    for ($i = 0; $i < count($real [0]); $i++) {
   //      echo $value." vs ".$real [0][$i]."<br>";
    if($value==$real [0][$i]){
         array_push($plan_pro [0],$real [0][$i]);
         array_push($plan_pro [1],"No Planeado");
         array_push($plan_pro [2],$real [1][$i]);
         array_push($plan_pro [3],0);
    }
    }
   
}

echo '<table  align="center" border="0" class="adminlist" id="tableh" name="tableh"><tr>
                        <th>No. Parte</th>
                        <th>Unidades Planeadas</th>
                        <th>Unidades Producidas</th>
                        <th>Unidades Faltantes</th>                     
                   </tr> ';

    for ($i = 0; $i < count($plan_pro [0]); $i++) {
          
    echo "<tr><td style='text-align:center'>".$plan_pro [0][$i]."</td><td style='text-align:center'>"
            .$plan_pro [1][$i]."</td><td style='text-align:center'>".$plan_pro [2][$i]."</td><td style='text-align:center'>".$plan_pro [3][$i]."</td></tr>";
    }
  
 
  echo'</table></center>
   </body>
</html>';

?>

