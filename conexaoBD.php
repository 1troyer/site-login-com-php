<?php
$hostname = "localhost";
$dbusername = "root";
$dbsenha = "";
$bancodedados= "bancodedados";

$mysqli = new mysqli($hostname,$dbusername,$dbsenha,$bancodedados);
if($mysqli->connect_errno){
    echo"Falha ao conectar:";
}else{
    echo "Sucesso!";
}
?>