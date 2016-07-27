<?php
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
$pdf=$_POST['pdf'];
$id_project=$_POST['id_project'];
$id_line=$_POST['id_line'];
    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];

    //comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
     if(!is_dir($_SERVER["DOCUMENT_ROOT"]."/doctos/$id_project/")){
        mkdir($_SERVER["DOCUMENT_ROOT"]."/doctos/$id_project/", 0777);
           }
   if(!is_dir($_SERVER["DOCUMENT_ROOT"]."/doctos/$id_project/$id_line/")){
        mkdir($_SERVER["DOCUMENT_ROOT"]."/doctos/$id_project/$id_line/", 0777);
           }
   if(!is_dir($_SERVER["DOCUMENT_ROOT"]."/doctos/$id_project/$id_line/$pdf/")){
   mkdir($_SERVER["DOCUMENT_ROOT"]."/doctos/$id_project/$id_line/$pdf/", 0777);}
    //comprobamos si el archivo ha subido
   if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/doctos/$id_project/$id_line/$pdf/$pdf".".pdf"))
    {
       sleep(3);//retrasamos la petición 3 segundos
       echo $file;//devolvemos el nombre del archivo para pintar la imagen
    }
}else{
    throw new Exception("Error Processing Request", 1);   
}