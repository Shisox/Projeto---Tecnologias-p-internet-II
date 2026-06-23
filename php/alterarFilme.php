<?php

include("conexao.php");

$filme = $_POST['filme'];
$ano = $_POST['ano'];
$nome = $_POST['nome'];
$genero = $_POST['genero'];

// Validação do filme
if($filme == ''){
    die('Informe o filme!');
} 

// Validação do nome
if($nome == ''){
    die('Informe o nome!');
} 

// Validação do ano
if($ano == ''){
    die('Informe o ano!');
} 

// Verifica se é número
if(!is_numeric($ano)){
    die('Ano deve ser um número!');
}

// Validação do intervalo do ano
$anoAtual = date('Y');
if($ano > $anoAtual || $ano < 1900) {
    die("Ano inválido! Deve estar entre 1900 e $anoAtual");
}

// Validação do gênero
if($genero == ''){
    die('Informe o gênero!');
} 

$sql = "update filmes set ano = ?, nome = ?, genero = ? where filme = ?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("isii",$ano,$nome,$genero,$filme);
    if(!$stmt->execute()){
        die("Erro ao alterar o filme!");
    }
    header("Location: cadastrarFilme.php");
} else {
    echo 'Erro na SQL!';
}
?>