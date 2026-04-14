<?php

include("conexao.php");

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];

if($cpf == ''){
    die('Informe o CPF!');
} if($nome == ''){
    die('Informe o nome!'); 
} if($senha == ''){
    die('Informe a senha!');
} 

$sql = "insert into usuarios (cpf,nome,senha) values (?,?,?)";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("sss",$cpf,$nome,$senha);
    if(!$stmt->execute()){
        die("Erro ao inserir o usuário!");
    }
    header("Location: cadastrarUsuario.php");

} else {
    echo 'Erro na SQL!';
}
?>
