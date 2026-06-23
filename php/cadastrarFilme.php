<?php
    include("valida.php");
?>
<html>
    <link rel="stylesheet" href="style.css">
    <head>
        <title>Site</title>
    </head>
    <body>
        <div class="dashboard">
            <div class="dashboard-header">
                <div class="welcome">Olá, <?php echo $_SESSION['nome']; ?>!</div>
                <a href="sair.php" class="logout-btn">Sair</a>
            </div>
            
            <div class="dashboard-main">
                <!-- Menu lateral -->
                <div class="dashboard-menu">
                    <h2>Menu</h2>
                    <a href="cadastrarUsuario.php" class="menu-link">Cadastrar Usuário</a>
                    <a href="cadastrarGenero.php"  class="menu-link">Cadastrar Gênero</a>
                    <a href="cadastrarFilme.php"  class="menu-link">Cadastrar Filme</a>
                </div>
                <!-- Conteúdo principal -->
                <div class="dashboard-content">
                    <h2>Cadastro de Filmes</h2>
                    <form action="inserirFilme.php" method="post" onsubmit="return validarFormulario()">
                        Nome:<input type="text" name="nome" id="nome"><br>
                        Ano: <input type="text" name="ano" id="ano"><br>
                        Gênero: 
                        <?php include("conexao.php");?>
                        <select name="genero" id="genero">
                            <option value="">Selecione um gênero</option>
                            <?php       
                                $sql = "select * from generos";
                                $stmt = $conn->prepare($sql);

                                if($stmt){
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if($result->num_rows > 0){
                                        while($row = $result->fetch_assoc()){
                                            ?>
                                            <option value="<?= $row['genero'];?>"><?=$row['descricao'];?></option>
                                            <?php

                                        }
                                    }
                                }
                                ?>
                        </select>            

                        <br>
                        <input type="submit" value="Inserir">
                    </form>
                    <hr>
                    <h2>Lista de Filmes</h2>
                    
                    <table border="1">
                        <tr>
                            <td>Nome</td>
                            <td>Ano</td>
                            <td>Gênero</td>
                            <td>Alternar</td>
                            <td>Apagar</td>
                        </tr>
                <?php       
                    $sql = "select f.filme,f.ano,f.nome,g.genero,g.descricao from filmes f join generos g on (g.genero=f.genero)";
                    $stmt = $conn->prepare($sql);

                    if($stmt){
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if($result->num_rows > 0){
                            $contador = 0;
                            while($row = $result->fetch_assoc()){
                                $contador++;
                            ?>
                            <tr>
                                <form method="post" action="alterarFilme.php" onsubmit="return validarAlteracao<?=$contador;?>()">
                                    <input type="hidden" name="filme" value="<?=$row['filme'];?>">
                                    <td><input type="text" value="<?=$row['nome'];?>" name="nome" id="nome<?=$contador;?>"></td>
                                    <td><input type="text" value="<?=$row['ano'];?>" name="ano" id="ano<?=$contador;?>"></td>
                                    <td><select name="genero" id="genero<?=$contador;?>">
                                            <option value="">Selecione um gênero</option>     
                                            <?php  
                                                $sqlGeneros = "select * from generos";
                                                $stmtGeneros = $conn->prepare($sqlGeneros);

                                                if($stmtGeneros){
                                                    $stmtGeneros->execute();
                                                    $resultGeneros = $stmtGeneros->get_result();

                                                    if($resultGeneros->num_rows > 0){
                                                        while($rowGeneros = $resultGeneros->fetch_assoc()){
                                                            ?>
                                                            <option value="<?= $rowGeneros['genero']; ?>" <?= ($rowGeneros['genero'] == $row['genero']) ? 'selected' : ''; ?>><?= $rowGeneros['descricao'];?></option>
                                                            <?php

                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>    
                                    </td>
                                    <td><input type="submit" value="Alterar" id="alterar"></td>
                                </form>
                                <td>
                                    <form method="post" action="apagarFilme.php" onsubmit="return confirm('Tem certeza que deseja apagar este filme?');">
                                        <input type="hidden" value="<?= $row['filme'];?>" name="filme">
                                        <input type="submit" value="Apagar">
                                    </form>
                                </td>
                            </tr>
                            <script>
                            function validarAlteracao<?=$contador;?>() {
                                var nome = document.getElementById('nome<?=$contador;?>').value.trim();
                                var ano = document.getElementById('ano<?=$contador;?>').value.trim();
                                var genero = document.getElementById('genero<?=$contador;?>').value;
                                
                                var erros = [];
                                
                                if (nome === '') {
                                    erros.push('• O campo Nome é obrigatório');
                                }
                                
                                if (ano === '') {
                                    erros.push('• O campo Ano é obrigatório');
                                } else if (isNaN(ano) || !Number.isInteger(Number(ano))) {
                                    erros.push('• O ano deve ser um número inteiro');
                                } else {
                                    var anoNumero = parseInt(ano);
                                    var anoAtual = new Date().getFullYear();
                                    
                                    if (anoNumero < 1900 || anoNumero > anoAtual) {
                                        erros.push('• O ano deve estar entre 1900 e ' + anoAtual);
                                    }
                                }
                                
                                if (genero === '') {
                                    erros.push('• Selecione um gênero');
                                }
                                
                                if (erros.length > 0) {
                                    var mensagem = 'Por favor, corrija os seguintes erros:\n\n' + erros.join('\n');
                                    alert(mensagem);
                                    
                                    if (nome === '') {
                                        document.getElementById('nome<?=$contador;?>').focus();
                                    } else if (ano === '' || isNaN(ano) || !Number.isInteger(Number(ano)) || 
                                              (parseInt(ano) < 1900 || parseInt(ano) > new Date().getFullYear())) {
                                        document.getElementById('ano<?=$contador;?>').focus();
                                    } else if (genero === '') {
                                        document.getElementById('genero<?=$contador;?>').focus();
                                    }
                                    
                                    return false;
                                }
                                
                                return true;
                            }
                            </script>
                            <?php
                            }
                        } else {
                            echo '<tr><td colspan="5">Nenhum dado encontrado!</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">Erro na SQL!</td></tr>';
                    }
                ?>
                </table>
                </div>
            </div>
        </div>
        
        <script>
        function validarFormulario() {
            var nome = document.getElementById('nome').value.trim();
            var ano = document.getElementById('ano').value.trim();
            var genero = document.getElementById('genero').value;
            
            var erros = [];
            
            if (nome === '') {
                erros.push('• O campo nome é obrigatório');
            }
            
            if (ano === '') {
                erros.push('• O campo Ano é obrigatório');
            } else if (isNaN(ano) || !Number.isInteger(Number(ano))) {
                erros.push('• O ano deve ser um número inteiro');
            } else {
                var anoNumero = parseInt(ano);
                var anoAtual = new Date().getFullYear();
                
                if (anoNumero < 1900 || anoNumero > anoAtual) {
                    erros.push('• O ano deve estar entre 1900 e ' + anoAtual);
                }
            }
            
            if (genero === '') {
                erros.push('• Selecione um gênero');
            }
            
            if (erros.length > 0) {
                var mensagem = 'Por favor, corrija os seguintes erros:\n\n' + erros.join('\n');
                alert(mensagem);
                
                if (nome === '') {
                    document.getElementById('nome').focus();
                } else if (ano === '' || isNaN(ano) || !Number.isInteger(Number(ano)) || 
                          (parseInt(ano) < 1900 || parseInt(ano) > new Date().getFullYear())) {
                    document.getElementById('ano').focus();
                } else if (genero === '') {
                    document.getElementById('genero').focus();
                }
                
                return false;
            }
            
            return true;
        }
        </script>
    </body>
</html>