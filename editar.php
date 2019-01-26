<?php
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
$dato = $_POST['dato'];
$string = "";
$SQL = "SELECT usuario FROM alumno WHERE curso='$dato'";
$result = $mysqli->query($SQL);
while($fila = $result->fetch_array()){
    $string .= $fila[0].",";
}
echo $string;
?>