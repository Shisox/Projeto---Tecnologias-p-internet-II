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
            <!-- cabeçalho -->
            <div class="dashboard-header">
                <div class="welcome">Olá, <?php echo $_SESSION['nome'];?>!</div>
                <!-- botão de sair -->
                <a href="sair.php" class="logout-btn">Sair</a>
            </div>
            <!-- Aqui está a parte abaixo do cabeçalho -->
            <div class="dashboard-main">
                <!-- menu lateral -->
                <div class="dashboard-menu">
                    <a href="cadastrarUsuario.php" class="menu-link">Cadastrar Usuário</a>
                </div>
                <!-- conteúdo central -->
                <div class="dashboard-content">
                    <h2>Cadastro de Usuários</h2>
                    <form action="inserirUsuario.php" method="post">
                        CPF: <input type="text" name="cpf"><br>
                        Nome: <input type="text" name="nome"><br>
                        Senha: <input type="text" name="senha"><br>
                        <input type="submit" value="Inserir">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>