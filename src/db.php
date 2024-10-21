<?php

$host = "db";
$user = "root";
$password = "root";
$db = "Vulnerabile";

$connessione=new mysqli($host,$user,$password,$db);

if($connessione->connect_error){
    echo("connessione Fallita ".$connessione->connect_error);
}


?>