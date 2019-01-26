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
$usu= $_SESSION['nickname'];

$mysqli = new mysqli($host, $user,$passwd, $db);
//$strCnx = "host=$host user=$user password=$passwd";
/*$connect = mysql_connect($strCnx);
$cnx = mysql_select_db($db) or die ("Error de conexion. ". mysql_error(mysql_connect($strCnx)));*/
if($mysqli-> connect_errno){
        die("Fallo la conexion".$mysqli -> mysqli_connect_errno() . $mysqli -> mysqli_connect_error());
}
$titulo = $_GET['titulo'];
$desc = $_GET['descripcion'];
$curso = $_GET['para'];
$fecha = getdate();
$SQL = "INSERT INTO `noticias`( `profesor`, `titulo`, `descripcion`, `para`, `fecha`) VALUES ('$usu','$titulo','$desc','$curso',NOW())";
if($mysqli->query($SQL)==TRUE){
    echo "t";
}else{
    echo 'f'.$SQL;
}
$mysqli->close();
?>