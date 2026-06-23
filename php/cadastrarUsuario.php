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
                    <h2>Cadastro de Usuários</h2>
                    <form action="inserirUsuario.php" method="post" onsubmit="return validarFormulario()">
                        CPF:<input type="text" name="cpf" id="cpf" maxlength="14"><br>
                        Nome: <input type="text" name="nome" id="nome"><br>
                        Senha: <input type="text" name="senha" id="senha"><br>
                        <small style="color: #666; font-size: 12px;">
                            Mínimo 6 caracteres, 1 letra maiúscula, 1 minúscula, 1 número e 1 caractere especial
                        </small><br>
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
                            $contador = 0;
                            while($row = $result->fetch_assoc()){
                                $contador++;
                            ?>
                            <tr>
                                <form action="alterarUsuario.php" method="post" onsubmit="return validarAlteracao<?=$contador;?>()">
                                    <input type="hidden" name="cpfAnterior" value="<?=$row['cpf'];?>">
                                    <td><input type="text" value="<?=$row['cpf'];?>" name="cpf" id="cpf<?=$contador;?>" maxlength="14"></td>
                                    <td><input type="text" value="<?=$row['nome'];?>" name="nome" id="nome<?=$contador;?>"></td>
                                    <td><input type="password" value="<?=$row['senha'];?>" name="senha" id="senha<?=$contador;?>"></td>
                                    <td><input type="submit" value="Alterar" id="alterar"></td>
                                    </form>
                                    <td>
                                        <form method="post" action="apagarUsuario.php" onsubmit="return confirm('Tem certeza que deseja apagar este usuário?');">
                                            <input type="hidden" value="<?= $row['cpf'];?>" name="cpf">
                                            <input type="submit" value="Apagar">
                                        </form>
                                    </td>
                            </tr>
                            <script>
                            function validarAlteracao<?=$contador;?>() {
                                var cpf = document.getElementById('cpf<?=$contador;?>').value.trim();
                                var nome = document.getElementById('nome<?=$contador;?>').value.trim();
                                var senha = document.getElementById('senha<?=$contador;?>').value;
                                
                                var erros = [];
                                
                                // Validar CPF
                                if (cpf === '') {
                                    erros.push('• O campo CPF é obrigatório');
                                } else if (!validarCPF(cpf)) {
                                    erros.push('• CPF inválido!');
                                }
                                
                                // Validar nome
                                if (nome === '') {
                                    erros.push('• O campo nome é obrigatório');
                                }
                                
                                // Validar senha
                                if (senha === '') {
                                    erros.push('• O campo senha é obrigatório');
                                } else {
                                    var errosSenha = validarSenha(senha);
                                    if (errosSenha.length > 0) {
                                        erros = erros.concat(errosSenha);
                                    }
                                }
                                
                                // Se houver erros, mostra todos em uma única mensagem
                                if (erros.length > 0) {
                                    var mensagem = 'Por favor, corrija os seguintes erros:\n\n' + erros.join('\n');
                                    alert(mensagem);
                                    
                                    // Foca no primeiro campo com erro
                                    if (cpf === '' || !validarCPF(cpf)) {
                                        document.getElementById('cpf<?=$contador;?>').focus();
                                    } else if (nome === '') {
                                        document.getElementById('nome<?=$contador;?>').focus();
                                    } else if (senha === '' || validarSenha(senha).length > 0) {
                                        document.getElementById('senha<?=$contador;?>').focus();
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
        // Função para validar CPF
        function validarCPF(cpf) {
            // Remove caracteres não numéricos
            cpf = cpf.replace(/[^\d]/g, '');
            
            // Verifica se tem 11 dígitos
            if (cpf.length !== 11) {
                return false;
            }
            
            // Verifica se todos os dígitos são iguais (CPF inválido)
            if (/^(\d)\1{10}$/.test(cpf)) {
                return false;
            }
            
            // Validação do primeiro dígito verificador
            var soma = 0;
            for (var i = 0; i < 9; i++) {
                soma += parseInt(cpf.charAt(i)) * (10 - i);
            }
            var resto = soma % 11;
            var digito1 = (resto < 2) ? 0 : 11 - resto;
            
            if (parseInt(cpf.charAt(9)) !== digito1) {
                return false;
            }
            
            // Validação do segundo dígito verificador
            soma = 0;
            for (var i = 0; i < 10; i++) {
                soma += parseInt(cpf.charAt(i)) * (11 - i);
            }
            resto = soma % 11;
            var digito2 = (resto < 2) ? 0 : 11 - resto;
            
            if (parseInt(cpf.charAt(10)) !== digito2) {
                return false;
            }
            
            return true;
        }
        
        // Função para validar senha
        function validarSenha(senha) {
            var erros = [];
            
            if (senha.length < 6) {
                erros.push('• A senha deve ter no mínimo 6 caracteres');
            }
            if (!/[A-Z]/.test(senha)) {
                erros.push('• A senha deve ter pelo menos 1 letra maiúscula');
            }
            if (!/[a-z]/.test(senha)) {
                erros.push('• A senha deve ter pelo menos 1 letra minúscula');
            }
            if (!/[0-9]/.test(senha)) {
                erros.push('• A senha deve ter pelo menos 1 número');
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(senha)) {
                erros.push('• A senha deve ter pelo menos 1 caractere especial (!@#$%^&*(),.?":{}|<>)');
            }
            
            return erros;
        }
        
        // Função para formatar CPF enquanto digita
        function formatarCPF(input) {
            var cpf = input.value.replace(/[^\d]/g, '');
            
            if (cpf.length > 3) {
                cpf = cpf.substring(0, 3) + '.' + cpf.substring(3);
            }
            if (cpf.length > 7) {
                cpf = cpf.substring(0, 7) + '.' + cpf.substring(7);
            }
            if (cpf.length > 11) {
                cpf = cpf.substring(0, 11) + '-' + cpf.substring(11);
            }
            
            input.value = cpf.substring(0, 14);
        }
        
        function validarFormulario() {
            var cpf = document.getElementById('cpf').value.trim();
            var nome = document.getElementById('nome').value.trim();
            var senha = document.getElementById('senha').value;
            
            var erros = [];
            
            // Validar CPF
            if (cpf === '') {
                erros.push('• O campo CPF é obrigatório');
            } else if (!validarCPF(cpf)) {
                erros.push('• CPF inválido! Digite um CPF válido');
            }
            
            // Validar nome
            if (nome === '') {
                erros.push('• O campo Nome é obrigatório');
            }
            
            // Validar senha
            if (senha === '') {
                erros.push('• O campo Senha é obrigatório');
            } else {
                var errosSenha = validarSenha(senha);
                if (errosSenha.length > 0) {
                    erros = erros.concat(errosSenha);
                }
            }
            
            // Se houver erros, mostra todos em uma única mensagem
            if (erros.length > 0) {
                var mensagem = 'Por favor, corrija os seguintes erros:\n\n' + erros.join('\n');
                alert(mensagem);
                
                // Foca no primeiro campo com erro
                if (cpf === '' || !validarCPF(cpf)) {
                    document.getElementById('cpf').focus();
                } else if (nome === '') {
                    document.getElementById('nome').focus();
                } else if (senha === '' || validarSenha(senha).length > 0) {
                    document.getElementById('senha').focus();
                }
                
                return false;
            }
            
            return true;
        }
        
        // Adiciona formatação automática nos campos de CPF
        document.addEventListener('DOMContentLoaded', function() {
            // Formatação para o formulário principal
            var cpfPrincipal = document.getElementById('cpf');
            if (cpfPrincipal) {
                cpfPrincipal.addEventListener('input', function() {
                    formatarCPF(this);
                });
            }
            
            // Formatação para os formulários de alteração
            var inputsCPF = document.querySelectorAll('input[name="cpf"]');
            inputsCPF.forEach(function(input) {
                if (input.id !== 'cpf') {
                    input.addEventListener('input', function() {
                        formatarCPF(this);
                    });
                }
            });
        });
        </script>
    </body>
</html>