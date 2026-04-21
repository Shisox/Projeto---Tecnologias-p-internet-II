<?php

include("conexao.php");

$cpf = $_POST['cpf'];

if($cpf == ''){
    die('Informe o CPF!');
} 

$sql = "delete from usuarios where cpf =?";
$stmt = $conn->prepare($sql);

if($stmt){
    $stmt->bind_param("s",$cpf);
    if(!$stmt->execute()){
        die("Erro ao apagar o usuário!");
    }
    header("Location: cadastrarUsuario.php");

} else {
    echo 'Erro na SQL!';
}
?>
