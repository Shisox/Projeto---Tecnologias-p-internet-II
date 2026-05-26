<?php

include("conexao.php");

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];
$cpfAnterior = $_POST['cpfAnterior'];

if($cpf == ''){
    die('Informe o CPF!');
} if($nome == ''){
    die('Informe o nome!'); 
} if($senha == ''){
    die('Informe a senha!');
} 

$sql = "update usuarios set cpf = ?, nome = ?, senha = ? where cpf = ?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("ssss",$cpf,$nome,$senha,$cpfAnterior);
    if(!$stmt->execute()){
        die("Erro ao alterar o usuário!");
    }
    header("Location: cadastrarUsuario.php");

} else {
    echo 'Erro na SQL!';
}
?>
