<?php

include("conexao.php");

$filme = $_POST['filme'];

if($filme == ''){
    die('Informe o filme!');
} 

$sql = "delete from filmes where filme = ?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("i",$filme);
    if(!$stmt->execute()){
        die("Erro ao apagar o filme!");
    }
    header("Location:cadastrarFilme.php");

} else {
    echo 'Erro na SQL!';
}
?>
