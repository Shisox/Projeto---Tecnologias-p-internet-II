<?php

include("conexao.php");

$ano = $_POST['ano'];
$genero = $_POST['genero'];
$nome = $_POST['nome'];

if($ano == ''){
    die('Informe o ano!');
} if($nome == ''){
    die('Informe o nome!'); 
} if($genero == ''){
    die('Informe o gênero!');
} 

$sql = "insert into filmes (nome,ano,genero) values (?,?,?)";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("sii",$nome,$ano,$genero);
    if(!$stmt->execute()){
        die("Erro ao inserir o filme!");
    }
    header("Location: cadastrarFilme.php");

} else {
    echo 'Erro na SQL!';
}
?>
