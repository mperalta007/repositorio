<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
  include_once('common.php');
$search = array ('�','�','�','�','�','�','�','�','�','&OACUTE;','�','�','&Atilde;&shy;','&Atilde;&iexcl;','é','í','&Atilde;&sup3;','ú','ñ','�á','�é','�í','�ó','�ú','�ñ');
$replace = array('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�', '�', '�','�','�','�','�','�','�','�','�');

function encabezado($a_titulo, $a_font_color, $a_usuario) {
    //Declaracion de variables
       $v_hoy = date("H:i:s");
    ?>
     <head>
    <title></title>
            
       <script language="JavaScript" src="/include/js/scripts.js"></script>
	 
  </head>
  <body onload="mueveReloj()" leftmargin="0px" topmargin="0px" marginwidth="0px" marginheight="0px">
      <form name="form_reloj">
           <div align="center" style="margin-left:1em; margin-top: .5em; margin-right: 1em " >
        <table border="0" cellpadding="0" cellspacing="0" style="width:100% ; ">
              
    <tr valign="top" style="padding:0px 0px 0 0px;margin:0px 0px 0 0px;">
        <td  align="left" >
          <table bgcolor="#000000" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" >
              <tr><td  width="20%" style=" text-align:left; padding-left: 1em;" ><a href="http://10.218.108.150:10018/Andon/"><img border="0" src="/images/contilogo.png" style="width: 80%;" ></a></td>
       <td  align="right" style=" text-align: right; padding-right:0em; padding-left: 0em; font-size: 1.5em; color: #ffffff; font-family: 'Arial';"> <?php echo "Continental Periferico  |";?>
     <input type="text" disabled="true" name="reloj" size="10" style=" border: none; background: #000000;color: #ffffff; font-family : Verdana, Arial; font-size :0.9em; text-align :left;"> </td>
      </tr>
    </table>
      </td>
    </tr>
          </table>
  </div>
          </form>
     
      
      </body>

<?php } 
function tablalines(){
    global $db;
    $sql ="select * from lines_comp order by id";
   $res =& $db->query($sql);
   $grey = true;
 
echo ' <table border="1" class="estable" ><tr>';

                   while($va_tupla=$res->fetchrow()){                      
                      if($va_tupla['atributo']=="")
                     if($grey){
                      echo "<td id='cuad".$va_tupla['id']."'class='tdazul' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
                      $grey=false;
                     }else { echo "<td id='cuad".$va_tupla['id']."'class='tdverder' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>"; $grey=true; }
                     
                 if($va_tupla['atributo']=="E")
                      echo "<td id='cuad".$va_tupla['id']."'class='tdrojo' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
                 
                 if($va_tupla['atributo']=="M")
                      echo "<td id='cuad".$va_tupla['id']."'class='tdamarillo' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
    
                 if($va_tupla['atributo']=="C")
                      echo "<td id='cuad".$va_tupla['id']."'class='tdamarillo' onclick='xajax_lineinfo(".$va_tupla['id'].")'> ".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
           }
    
    echo "</tr></table>";
       }
      function tablastations(){
    global $db;
    $sql ="select * from lines_comp order by id";
   $res =& $db->query($sql);
   $grey = true;
 
echo ' <table border="1" class="estable" ><tr>';

                   while($va_tupla=$res->fetchrow()){                      
                      if($va_tupla['atributo']=="")
                     if($grey){
                      echo "<td id='cuad".$va_tupla['id']."'class='tdazul' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
                      $grey=false;
                     }else { echo "<td id='cuad".$va_tupla['id']."'class='tdverder' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>"; $grey=true; }
                     
                 if($va_tupla['atributo']=="E")
                      echo "<td id='cuad".$va_tupla['id']."'class='tdrojo' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
                 
                 if($va_tupla['atributo']=="M")
                      echo "<td id='cuad".$va_tupla['id']."'class='tdamarillo' onclick='xajax_lineinfo(".$va_tupla['id'].")'>".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
    
                 if($va_tupla['atributo']=="C")
                      echo "<td id='cuad".$va_tupla['id']."'class='tdamarillo' onclick='xajax_lineinfo(".$va_tupla['id'].")'> ".$va_tupla['atributo']."</br>".$va_tupla['strname']."</td>";
           }
    
    echo "</tr></table>";
       }                                                         
    
function tabla(){
   global $db;
    $sql ="select * from lines_comp order by id";
   $res =& $db->query($sql);
 $va_tupla=$res->fetchrow();
echo ' <table border="1" class="estableonly" ><tr>';

                      echo "<td class='tdazul'></br>".$va_tupla['strname']."</td>";
              
    
    echo "</tr></table>";
       }

