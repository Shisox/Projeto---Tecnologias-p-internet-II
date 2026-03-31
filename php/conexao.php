<?php
 $servidor = "db";
 $usuario = "root";
 $senha = "root";
 $dbname = "banco";

 $conn = new mysqli($servidor, $usuario, $senha, $dbname);

 if($conn->connect_error){
    die("Falha no banco ".$conn->connect_error);
 }
 ?>