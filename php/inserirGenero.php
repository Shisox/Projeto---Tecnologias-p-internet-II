<?php

include("conexao.php");

$descricao = $_POST['descricao'];

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

$sql = "insert into generos (descricao) values (?)";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("s",$descricao);
    if(!$stmt->execute()){
        die("Erro ao inserir o gênero!");
    }
    header("Location: cadastrarGenero.php");
} else {
    echo 'Erro na SQL!';
}
?>