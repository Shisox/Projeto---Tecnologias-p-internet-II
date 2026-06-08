<?php

include("conexao.php");

$filme = $_POST['filme'];
$ano = $_POST['ano'];
$nome = $_POST['nome'];
$genero = $_POST['genero'];

if($filme == ''){
    die('Informe o filme!');
} if($ano == ''){
    die('Informe o ano!'); 
} if($nome == ''){
    die('Informe o nome!');
} if ($genero == ''){
    die('Informe o gênero!');
}

$sql = "update filmes set ano = ?, nome = ?, genero = ? where filme = ?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("isii",$ano,$nome,$genero,$filme);
    if(!$stmt->execute()){
        die("Erro ao alterar o ufilme!");
    }
    header("Location: cadastrarFilme.php");

} else {
    echo 'Erro na SQL!';
}
?>
