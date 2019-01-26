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
    <title>Noticias de estudiantes</title>
</head>
<body>
    <div id="contenedor">
    <?php
        session_start();
        echo "<h1>Hola estudiante ".$_SESSION['usu']."</h1>";
    ?>
    <?php
        $curso = $_SESSION['nickname'];
        $usu = $_SESSION['usu'];
        $user = 'root';
        $passwd = '';
        $db = 'demo';
        $port = 3306;
        $host = '127.0.0.1';
        $mysqli = new mysqli($host, $user,$passwd, $db);
        if($mysqli-> connect_errno){
            die("Fallo la conexion".$mysqli -> mysqli_connect_errno() . $mysqli -> mysqli_connect_error());
        }
            $SQL = "SELECT * FROM noticias WHERE (para = '$curso')or(para='$usu') ORDER BY id DESC";
            $result = $mysqli->query($SQL);
        while($fila = $result->fetch_array()){
            if($fila[4]==$curso){
            echo "<div class='w3-card noti w3-display-container'>";
            echo "<h2>".$fila[2]."</h2>";
            echo "<p class='parrafo'>".$fila[3]."</p>";
            echo "<div class='w3-display-bottomright' style='color:black'>".$fila[5]."</div>";
            echo "</div>";
            }else{
                echo "<div class='w3-card noti w3-display-container'style='background-color:red !important'>";
                echo "<h2>".utf8_encode($fila[2])."</h2>";
                echo "<p class='parrafo'>".utf8_encode($fila[3])."</p>";
                echo "<div class='w3-display-bottomright' style='color:white'>".utf8_encode($fila[5])."</div>";
                echo "</div>";  
            }
        }
    ?>
    </div>
</body>
</html>