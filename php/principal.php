<?php
    include("valida.php");
?>
<html>
    <link rel="stylesheet" href="style.css">
    <head>
        <title>Site</title>
    </head>
    <body>
        <header>
            <span>Olá, <?php echo $_SESSION['nome']; ?>!</span>
            <a href="sair.php">Sair</a>
        </header>
        
        <aside>
            Menu
        </aside>
        
        <main>
            Conteúdo
        </main>
    </body>
</html>