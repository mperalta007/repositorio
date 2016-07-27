$(document).ready(function(){
 
  var id= $(".formulario")[1];
    $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
       
        //obtenemos un array con los datos del archivo
        var file = $("#archivo")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>File: "+fileName+", total weight: "+fileSize+" bytes.</span>");
    });
 
    //al enviar el formulario
    $(':button').click(function(){
        //información del formulario
        var formData = new FormData($(".formulario")[0],id);
        var message = "";
        //hacemos la petición ajax  
        $.ajax({
            url: '/ControlProjects/upload.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                message = $("<span class='before'>Upload file, please wait...</span>");
                showMessage(message)        
            },
            //una vez finalizado correctamente
            success: function(data){
                if(!(data)){ message = $("<span class='success'>The field is empty</span>");}else{
                message = $("<span class='success'>The file was uploaded successfully.</span>");
            }
                showMessage(message);
                
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>An error has ocurred.</span>");
                showMessage(message);
            }
        });
    });
})
 
//como la utilizamos demasiadas veces, creamos una función para
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}
 
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase())
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg':
            return true;
        break;
        default:
            return false;
        break;
    }
}