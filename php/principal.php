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
                <div class="welcome">Olá, <?php echo $_SESSION['nome']; ?>!</div>
                <!-- botão de sair -->
                <a href="sair.php" class="logout-btn">Sair</a>
            </div>
            <!-- Aqui está a parte abaixo do cabeçalho -->
            <div class="dashboard-main">
                <!-- menu lateral -->
                <div class="dashboard-menu">
                    <h2>Menu</h2>
                    <a href="cadastrarUsuario.php"  class="menu-link">Cadastrar Usuário</a>
                </div>
                <!-- conteúdo central -->
                <div class="dashboard-content">
                    Conteúdo
                </div>
            </div>
        </div>
    </body>
</html>