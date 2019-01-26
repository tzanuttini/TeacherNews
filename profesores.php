<!DOCTYPE html>
<html lang="es">
<head>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/w3.css">
    <style>
        body, html{
            width:100%;
            height:100%;
        }
        #contenedor{
            margin:0 auto;
            width:75%;
            text-align:center;
        }
        .noti{
            border-radius:10px;
            width:100%;
            text-align:justify;
            padding-left:10%;
            background-color: #f7fcb0;
        }
        .noti h1{
            padding-top:30px;
        }
        .parrafo{
            padding-bottom:30px;
        }
    </style>
    <title>Noticias de profesores</title>
</head>
<body>
    <div id="contenedor">
    <?php
        session_start();
        echo "<h1>Hola ".$_SESSION['nickname']."</h1>";
        ?>
        <button onclick="document.getElementById('modal').style.display='block'" class="w3-button">Subir notificacion nueva</button>
        <div class="w3-modal" id="modal">
        <div class="w3-modal-content">
        <div class="w3-container">
        <span onclick="document.getElementById('modal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <p>Título:</p>
        <input type="text" name="Titulo" id="Titulo" size=50>
        <p>Descripcion: </p>
        <textarea name="descripcion" id="descripcion" cols="80" rows="10"></textarea>
        <br>
        <input type="checkbox" name="para" id="para">Noticia para alumno <br>
        <select id='select' style="margin-bottom:5px">
        <?php
            $usu= $_SESSION['nickname'];
            $user = 'root';
            $passwd = '';
            $db = 'demo';
            $port = 3306;
            $host = '127.0.0.1';
            $mysqli = new mysqli($host, $user,$passwd, $db);
            if($mysqli-> connect_errno){
                die("Fallo la conexion".$mysqli -> mysqli_connect_errno() . $mysqli -> mysqli_connect_error());
            }
            $SQL = "SELECT descripcion FROM curso WHERE profesor = '$usu' ";
            $result = $mysqli->query($SQL);
            while($fila = $result->fetch_array()){
                echo "<option value='".$fila[0]."'>".$fila[0]."</option>";
            }
        ?>
        </select>
        <select name="alumno" id="nombre" style="display:none">
        </select> 
        <br>
        <button name="ingresar" id="subir">Subir</button>
        </div>
        </div>
        </div>
        <?php
            $SQL = "SELECT * FROM noticias WHERE profesor = '$usu' ORDER BY id DESC";
            $result = $mysqli->query($SQL);
            while($fila = $result->fetch_array()){
                echo "<div class='w3-card noti w3-display-container'>";
                echo "<h2>".utf8_encode($fila[2])."</h2>";
                echo "<p class='parrafo'>".utf8_encode($fila[3])."</p>";
                echo "<div class='w3-display-bottomright' style='color:black'>".utf8_encode($fila[5])."</div>";
                echo "<div class='w3-display-bottomleft' style='color:black'>".utf8_encode($fila[4])."</div>";
                echo "</div>";
            }
        ?>
        <script>
            var check=false;
            $("#para").change(function (){
                if(!check){
                    check=true;
                }else{
                    check=false;
                }
                $("#nombre").toggle();
                var dato = $("#select").val();
                $.ajax({
            type: "POST",
            url: "editar.php",
            data: {dato},
            success: function(html){
                var strin = html.split(",");
                for(var i = 0; i<strin.length ; i++){
                    if(strin[i]!=""){
                        var text = document.createElement('option');
                        text.value = strin[i];
                        text.innerHTML = strin[i];
                        $("#nombre").append(text);
                    }
                }
                }
            });
            });
            $("#subir").click(function () {
                var subido = true;
                if($("#Titulo").val()==""){
                    window.alert("Debe ingresar un titulo!.");
                    $("#Titulo").focus();
                    subido = false;
                }
                else{
                    if($('#descripcion').val()==""){
                        window.alert("Debe ingresar un texto o comunicado!");
                        $("#descripcion").focus();
                        subido = false;
                    }
                }
                if(subido){
                    if(check==false){
                    $.ajax({
                        url:'subirnoticias.php',
                        data: 'titulo='+$("#Titulo").val()+'&descripcion='+$("#descripcion").val()+'&para='+$("#select").val(),
                        type: 'get',
                        success: function(html){
                            if(html == 't'){
                                window.alert("Comunicado agregado con exito");
                                location.reload(true);
                            }else{
                                window.alert("No se pudo agregar el comunicado.");
                            }
                        }
                    })
                    }else{
                        $.ajax({
                        url:'subirnoticias.php',
                        data: 'titulo='+$("#Titulo").val()+'&descripcion='+$("#descripcion").val()+'&para='+$("#nombre").val(),
                        type: 'get',
                        success: function(html){
                            if(html == 't'){
                                window.alert("Comunicado agregado con exito");
                                location.reload(true);
                            }else{
                                window.alert("No se pudo agregar el comunicado.");
                            }
                        }
                    })
                    }
                }
            });
        </script>
        </div>
</body>
</html>