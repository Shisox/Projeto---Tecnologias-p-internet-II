<?php

include("conexao.php");

$genero = $_POST['genero'];

if($genero == ''){
    die('Informe o gênero!');
} 

$sql = "delete from generos where genero =?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("s",$genero);
    if(!$stmt->execute()){
        die("Erro ao apagar o gênero!");
    }
    header("Location: cadastrarGenero.php");

} else {
    echo 'Erro na SQL!';
}
?>
