<?php
require_once("../conf.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
		<title>phpChart - Image Export Demo</title>
    </head>
    <body>
        <div><span> </span><span id="info1b"></span></div>

<?php
    

    $line1 = array(6.75, 14, 10.75, 5.125, 10);
    $line2 = array(1, 4, 5, 2, 2);

    $tickers = array('2008-03-01', '2008-04-01', '2008-05-01', '2008-06-01', '2008-07-01');
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 1 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $pc = new C_PhpChartX(array($line1,$line2),'chart2');
    $pc->add_plugins(array('canvasTextRenderer'));

    
    
    $pc->set_stack_series(array('stackSeries'=>true));
    $pc->set_legend(array('show'=>true,'location'=>'ne'));
    $pc->set_title(array('text'=>'Data per month stack by user'));
    $pc->set_series_default(array(
        'renderer'=>'plugin::BarRenderer',
        'rendererOptions'=>array('barWidth'=>20)
    ));
    
    $pc->add_series(array('label'=>'User1'));
    $pc->add_series(array('label'=>'User2'));

    $pc->set_axes(array(
        'xaxis'=>array(
			'renderer'=>'plugin::CategoryAxisRenderer',
			'ticks'=>$tickers,
			'rendererOptions'=>array(),
			'tickOptions'=>array()),
        'yaxis'=>array('min'=>0)
    ));
    
    $pc->draw(400,300);
    ?>

 <script type="text/javascript">
$(document).ready(function(){if(!$.jqplot._noCodeBlock){$("script.code").each(function(c){if($("pre.code").eq(c).length){$("pre.code").eq(c).text($(this).html())}else{var d=$('<pre class="code prettyprint brush: js"></pre>');$("div.jqplot-target").eq(c).after(d);d.text($(this).html());d=null}});$("script.common").each(function(c){$("pre.common").eq(c).text($(this).html())});var b="";if($("script.include, link.include").length>0){if($("pre.include").length==0){var a=['<div class="code prettyprint include">','<p class="text">The charts on this page depend on the following files:</p>','<pre class="include prettyprint brush: html gutter: false"></pre>',"</div>"];a=$(a.join("\n"));$("div.example-content").append(a);a=null}$("script.include").each(function(c){if(b!==""){b+="\n"}b+='<script type="text/javascript" src="'+$(this).attr("src")+'"><\/script>'});$("link.include").each(function(c){if(b!==""){b+="\n"}b+='<link rel="stylesheet" type="text/css" hrf="'+$(this).attr("href")+'" />'});$("pre.include").text(b)}else{$("pre.include").remove();$("div.include").remove()}}if(!$.jqplot.use_excanvas){$("div.jqplot-target").each(function(){var d=$(document.createElement("div"));var g=$(document.createElement("div"));var f=$(document.createElement("div"));d.append(g);d.append(f);d.addClass("jqplot-image-container");g.addClass("jqplot-image-container-header");f.addClass("jqplot-image-container-content");g.html("Right Click to Save Image As...");var e=$(document.createElement("a"));e.addClass("jqplot-image-container-close");e.html("Close");e.attr("href","#");e.click(function(){$(this).parents("div.jqplot-image-container").hide(500)});g.append(e);$(this).after(d);d.hide();d=g=f=e=null;if(!$.jqplot._noToImageButton){var c=$(document.createElement("button"));c.text("View Plot Image");c.addClass("jqplot-image-button");c.bind("click",{chart:$(this)},function(h){var j=h.data.chart.jqplotToImageElem();var i=$(this).nextAll("div.jqplot-image-container").first();i.children("div.jqplot-image-container-content").empty();i.children("div.jqplot-image-container-content").append(j);i.show(500);i=null});$(this).after(c);c.after("<br />");c=null}})}$(document).unload(function(){$("*").unbind()})});
// alternative solution (requires Canvas element. Does not work in IE8 and below)
/*
var imgData = $('#chart2').jqplotToImageStr({});
var imgElem = $('<img/>').attr('src',imgData);
$('#imgChart1').append(imgElem);
*/
</script>



    </body>
</html>