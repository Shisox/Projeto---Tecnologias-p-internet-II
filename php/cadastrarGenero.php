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
                </div>
                <!-- Conteúdo principal -->
                <div class="dashboard-content">
                    <h2>Cadastro de Gêneros</h2>
                    <form action="inserirGenero.php" method="post">
                        Descrição: <input type="text" name="descricao"><br>
                        <input type="submit" value="Inserir">
                    </form>
                    <hr>
                    <h2>Lista de Gêneros</h2>
                    <?php include("conexao.php");?>
                    <table>
                        <tr>
                        <td>Descrição</td>
                        <td>Alterar</td>
                        <td>Apagar</td>
                    </tr>
                <?php       
                    $sql = "select * from generos";
                    $stmt = $conn->prepare($sql);

                    if($stmt){
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                            <tr>
                                <form action="alterarGenero.php" method="post">
                                    <input type="hidden" name="descricaoAnterior" value="<?= $row['descricao'];?>">
                                    <td><input type="text" value="<?=$row['descricao'];?>" name="descricao"></td>
                                    <td><input type="submit" value="Alterar" id="alterar"></td>
                                </form>
                                <td>
                                    <form method="post" action="apagarGenero.php">
                                        <input type="hidden" value="<?= $row['genero'];?>" name="genero">
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