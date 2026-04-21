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
                </div>
                <!-- Conteúdo principal -->
                <div class="dashboard-content">
                    <h2>Cadastro de Usuários</h2>
                    <form action="inserirUsuario.php" method="post">
                        CPF:<input type="text" name="cpf"><br>
                        Nome: <input type="text" name="nome"><br>
                        Senha: <input type="text" name="senha"><br>
                        <input type="submit" value="Inserir">
                    </form>
                    <hr>
                    <h2>Lista de Usuários</h2>
                    <?php include("conexao.php");?>
                    <table>
                        <tr>
                        <td>CPF</td>
                        <td>Nome</td>
                        <td>Senha</td>
                        <td>Alternar</td>
                        <td>Apagar</td>
                    </tr>
                <?php       
                    $sql = "select * from usuarios";
                    $stmt = $conn->prepare($sql);

                    if($stmt){
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?=  $row['cpf']; ?></td>
                                <td><?=  $row['nome']; ?></td>
                                <td><?=  $row['senha']; ?></td>
                                <td>Alterar</td>
                                <td>
                                    <form method="post" action="apagarUsuario.php">
                                        <input type="hidden" value="<?= $row['cpf'];?>" name="cpf">
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