<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<script type="text/javascript" src="/include/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/include/js/jquery.maphilight.js"></script>
 
    <script type="text/javascript">
        $(function() {
        $('.map').maphilight();
        $('#squidheadlink').mouseover(function(e) {
            $('#squidhead').mouseover();
        }).mouseout(function(e) {
            $('#squidhead').mouseout();
        }).click(function(e) { e.preventDefault(); });
    });</script>

<script>
$(function() {
        $('.map').maphilight({
            fillColor: '008800'
        });
        $('#hilightlink').mouseover(function(e) {
            $('#square2').mouseover();
        }).mouseout(function(e) {
            $('#square2').mouseout();
        }).click(function(e) { e.preventDefault(); });
        $('#starlink').click(function(e) {
            e.preventDefault();
            var data = $('#star').data('maphilight') || {};
            data.neverOn = !data.neverOn;
            $('#star').data('maphilight', data);
        });
        $('#star,#starlink2').click(function(e) {
            e.preventDefault();
            var data = $('#star').mouseout().data('maphilight') || {};
            data.alwaysOn = !data.alwaysOn;
            $('#star').data('maphilight', data).trigger('alwaysOn.maphilight');
        });
    });


</script>                                                                                                              
<script language="JavaScript"> 
                                                                                                               
var ns4 = (document.layers)? true:false 
var ie4 = (document.all)? true:false 
var ns6 = (document.getElementById && !document.all) ? true: false; 
var coorX, coorY, iniX, iniY; 
                                                                                                               
if (ns6) document.addEventListener("mousemove", mouseMove, true) 
if (ns4) {document.captureEvents(Event.MOUSEMOVE); document.mousemove = mouseMove;} 
                                                                                                               
function mouseMove(e) 
{ 
        if (ns4||ns6)   {coorX = e.pageX; coorY = e.pageY;} 
        if (ie4)        {coorX = event.x; coorY = event.y;} 
        return true; 
} 
                                                                                                               
function ini()  { 
if (ie4)        document.body.onmousemove = mouseMove; 
iniX = document.getElementById("recuadro").offsetLeft; 
iniY = document.getElementById("recuadro").offsetTop; 
} 
                                                                                                               
function coordenadas()  { 
    //if(coorX < )
alert ("Pinchó las siguientes coordenadas:\nx:" + coorX + "\ny: " + coorY + "\niniX = " + iniX + "\niniY = " + iniY); 
} 
                                                                                                               
function mostrar()      { 
        document.getElementById("ayuda").style.top = coorY + 10; 
        document.getElementById("ayuda").style.left = coorX + 10; 
        document.getElementById("ayuda").style.visibility = "visible"; 
        document.getElementById("ayuda").innerHTML = "x = " + coorX +"<br>y = " + coorY; 
} 
                                                                                                               
function ocultar()      { 
        document.getElementById("ayuda").style.visibility = "hidden"; 
} 
function mover()        { 
        document.getElementById("ayuda").style.top = coorY + 10; 
        document.getElementById("ayuda").style.left = coorX + 10; 
        document.getElementById("ayuda").style.visibility = "visible"; 
        document.getElementById("ayuda").innerHTML = "x = " + coorX +"<br>y = " + coorY; 
} 
                                                                                                               
</script> 
</head> 
                                                                                                               
<body onload="ini()" > 
<div align=left> 
<h3>  
</h3> 
                                                                                                               
    <img src="/images/piramide2.png" onclick="coordenadas()" onmouseover="mostrar()" onmousemove="mover()" 
         onmouseout="ocultar()" id="recuadro" usemap="#cert">
                                                                                                               
</div> 
<div id="ayuda" style=" visibility:hidden; 
position:absolute; 
background:yellow; 
font:normal 10px/10px verdana; 
color:black; 
border:solid 1px black; 
text-align:justify; 
padding:10px 10px 10px 10px;"> 
</div> 
  	
<MAP NAME="cert">
    <AREA SHAPE="circle" COORDS="60,56,47" HREF="#" data-maphilight=\'{"stroke":false,"fillColor":"red","fillOpacity":0.8,"alwaysOn":true}\' data-tooltip="mperalta">
    <!--<AREA SHAPE="poly" COORDS="3,182,36,178, 44,165,60,169,66,184,62,196, 43,201,35,190,0,193,0,183"  HREF="#"  ALT="Sonajero" >-->
    <area id="star" shape="poly" coords="78,83,70,100,52,104,64,115,61,133,78,124,94,133,91,116,104,102,87,101,79,88" 
          href="#" alt="star" data-maphilight='{"stroke:false","fillColor:00FF00","fillOpacity:0.8","alwaysOn:true"}'>
    <area href="jidoka.php?id_linea=32&amp;aut=yes" shape="rect" COORDS="3,182,36,178, 44,165,60,169,66,184,62,196, 43,201,35,190,0,193,0,183"
          onclick="window.location='jidoka.php?id_linea=32'" data-maphilight="{&quot;stroke&quot;:false,&quot;fillColor&quot;:&quot;00FF00&quot;,&quot;fillOpacity&quot;:0.8,&quot;alwaysOn&quot;:true}" data-tooltip="PETERBILT_orig">
    
    
</MAP>                                                                                                             
                                                                                                               
</body> 
</html>  