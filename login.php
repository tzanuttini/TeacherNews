<?php
session_start();
// ini_set("display_errors",1);
// error_reporting(E_ALL);

// Cabeceras para respuesta JSON
$user = 'root';
$passwd = '';
$db = 'demo';
$port = 3306;
$host = '127.0.0.1';

$mysqli = new mysqli($host, $user,$passwd, $db);
//$strCnx = "host=$host user=$user password=$passwd";
/*$connect = mysql_connect($strCnx);
$cnx = mysql_select_db($db) or die ("Error de conexion. ". mysql_error(mysql_connect($strCnx)));*/
if($mysqli-> connect_errno){
        die("Fallo la conexion".$mysqli -> mysqli_connect_errno() . $mysqli -> mysqli_connect_error());
}
$usuario = $_GET['usuario'];
$clave = $_GET['clave'];



$SQL="select * from profesores where usuario = '$usuario' and clave = '$clave'";
$result = $mysqli->query($SQL);
$row     = $result->fetch_row();
if ($result->num_rows== 1) {
        echo "profesor";
        $_SESSION['nickname'] = $usuario;
}
else  {
      $SQL="SELECT curso FROM alumno WHERE usuario = '$usuario' and clave = '$clave'";
      $result = $mysqli->query($SQL);
      $row = $result->fetch_row();
      if($result->num_rows==1){
                echo "alumno";
                $_SESSION['nickname'] = $row[0];
                $_SESSION['usu']= $usuario;
        }else{
        echo "false";
        }
}
