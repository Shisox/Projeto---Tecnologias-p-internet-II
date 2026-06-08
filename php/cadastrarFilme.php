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
                    <form action="inserirFilme.php" method="post">
                        Nome:<input type="text" name="nome"><br>
                        Ano: <input type="text" name="ano"><br>
                        Gênero: 
                        <?php include("conexao.php");?>
                        <select name="genero">
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
                    
                    <table>
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
                            while($row = $result->fetch_assoc()){
                            ?>
                            <tr>
                                <form method="post" action="alterarFilme.php">
                                    <input type="hidden" name="filme" value="<?=$row['filme'];?>">
                                    <td><input type="text" value="<?=$row['nome'];?>" name="nome"></td>
                                    <td><input type="text" value="<?=$row['ano'];?>" name="ano"></td>
                                    <td><select name="genero">
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
                                    </select>
                                    
                                    </td>
                                    <td><input type="submit" value="Alterar" id="alterar"></td>
                                    </form>
                                    <td>
                                        <form method="post" action="apagarFilme.php">
                                            <input type="hidden" value="<?= $row['filme'];?>" name="filme">
                                            <input type="submit" value="Apagar">
                                        </form>
                                    </td>
                            </tr>
                            <?php
                            }
                        } else {
                            echo 'Nenhum dado encontrado!';
                        }
                    } else {
                        echo 'Erro na SQL!';
                    }
                ?>
                </table>
                </div>
            </div>
        </div>
    </body>
</html>