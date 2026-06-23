<?php
    include("conexao.php");

    $ano = $_POST['ano'];
    $genero = $_POST['genero'];
    $nome = $_POST['nome'];

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