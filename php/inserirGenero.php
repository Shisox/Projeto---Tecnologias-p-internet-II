<?php

include("conexao.php");

$descricao = $_POST['descricao'];

if($descricao == ''){
    die('Informe a descriação!');
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
