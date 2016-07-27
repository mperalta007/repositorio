<?php
require_once("../conf.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpChart - get_display function Example</title>
</head>
<body>
    
<?php
$pc = new C_PhpChartX(array(array(11, 9, 5, 12, 14)),'Get_Display');
$pc->enable_debug(false);
$pc->draw(400, 300, '', false);
echo $pc->get_display(true);
?>

</body>
</html>