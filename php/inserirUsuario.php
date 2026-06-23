<?php

include("conexao.php");

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];

// Validação do CPF
if($cpf == ''){
    die('Informe o CPF!');
} 

// Remove caracteres não numéricos do CPF
$cpf = preg_replace('/[^0-9]/', '', $cpf);

// Valida se o CPF tem 11 dígitos
if(strlen($cpf) != 11) {
    die('CPF inválido! Deve conter 11 dígitos');
}

// Verifica se todos os dígitos são iguais
if(preg_match('/^(\d)\1{10}$/', $cpf)) {
    die('CPF inválido!');
}

// Validação do primeiro dígito verificador
$soma = 0;
for($i = 0; $i < 9; $i++) {
    $soma += $cpf[$i] * (10 - $i);
}
$resto = $soma % 11;
$digito1 = ($resto < 2) ? 0 : 11 - $resto;

if($cpf[9] != $digito1) {
    die('CPF inválido!');
}

// Validação do segundo dígito verificador
$soma = 0;
for($i = 0; $i < 10; $i++) {
    $soma += $cpf[$i] * (11 - $i);
}
$resto = $soma % 11;
$digito2 = ($resto < 2) ? 0 : 11 - $resto;

if($cpf[10] != $digito2) {
    die('CPF inválido!');
}

// Validação do nome
if($nome == ''){
    die('Informe o nome!');
} 

// Validação da senha
if($senha == ''){
    die('Informe a senha!');
} 

// Validação da força da senha
if(strlen($senha) < 6) {
    die('A senha deve ter no mínimo 6 caracteres!');
}

if(!preg_match('/[A-Z]/', $senha)) {
    die('A senha deve ter pelo menos 1 letra maiúscula!');
}

if(!preg_match('/[a-z]/', $senha)) {
    die('A senha deve ter pelo menos 1 letra minúscula!');
}

if(!preg_match('/[0-9]/', $senha)) {
    die('A senha deve ter pelo menos 1 número!');
}

if(!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $senha)) {
    die('A senha deve ter pelo menos 1 caractere especial (!@#$%^&*(),.?":{}|<>)!');
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