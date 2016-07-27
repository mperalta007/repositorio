
<html>
    <?php 
    $pdf=$_GET['pdf'];
    $id_project=$_GET['id_project'];
    $id_line=$_GET['idline'];
    ?>
<head>
    <title></title>
    <script type="text/javascript" src="/include/js/jquery_1.10.2_jquery.min.js"></script>
    <script type="text/javascript" src="/include/js/functions.js"></script>

<style type="text/css">
    .messages{
        
        font-family: sans-serif;
        display: none;
        text-align: center;
    }
    .info{
        padding: 10px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .success{
        padding: 10px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .error{
        padding: 10px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
</style>
</head>
<body>
    <!--el enctype debe soportar subida de archivos con multipart/form-data-->
    <form enctype="multipart/form-data" class="formulario">
        <center>
            <label>Subir nuevo PDF para <?php echo $pdf; ?></label><br><br>
            <input name="archivo" type="file" id="imagen" /><br>
            <input name="pdf" id="pdf" value="<?php echo $pdf; ?>" style=" visibility: hidden"><br>
            <input name="id_project" id="id_project" value="<?php echo $id_project; ?>" style=" visibility: hidden"><br>
            <input name="id_line" id="id_line" value="<?php echo $id_line; ?>" style=" visibility: hidden"><br>
      
        <br>
        <input type="button" value="Subir PDF" />
        </center>
    </form><center>
        <br><br>
    <div class="messages"></div>
   
</center>
</body>
</html>