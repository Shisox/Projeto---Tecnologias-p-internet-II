<?php

include("conexao.php");

$descricao = $_POST['descricao'];
$descricaoAnterior = $_POST['descricaoAnterior'];

// Validação da descrição
if($descricao == ''){
    die('Informe a descrição!');
}

// Remove espaços extras
$descricao = trim($descricao);

// Verifica novamente após trim
if($descricao == ''){
    die('Informe uma descrição válida!');
}

// Validação da descrição anterior
if($descricaoAnterior == ''){
    die('Erro: Descrição anterior não informada!');
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