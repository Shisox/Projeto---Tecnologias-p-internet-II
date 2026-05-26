<?php

include("conexao.php");

$descricao = $_POST['descricao'];
$descricaoAnterior = $_POST['descricaoAnterior'];

if($descricao == ''){
    die('Informe a descrição!');
}

$sql = "update generos set descricao = ? where descricao = ?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("ss",$descricao, $descricaoAnterior);
    if(!$stmt->execute()){
        die("Erro ao alterar o gênero!");
    }
    header("Location: cadastrarGenero.php");

} else {
    echo 'Erro na SQL!';
}
?>
