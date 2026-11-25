<?php
session_start();
require_once '../config/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $ip    = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

    if (!empty($email) && !empty($senha)) {
        // busca o usuário pelo email já cadastrado no banco.. trabalho da porra de digitar isso
        $stmt = $pdo->prepare("SELECT id_usuario, nome, senha, perfil FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // Prepara a auditoria de login que o prof pediu
        $stmtLog = $pdo->prepare("INSERT INTO log_login (id_usuario,email_informado, ip_acesso, sucesso) VALUES (:id_usuario,:email, :ip, :sucesso)");

        //  Verifica se o usuário existe e se a senha bate com o hash
        if ($user && password_verify($senha, $user['senha'])) {
            // Registra sucesso na auditoria (1 = true)
            $stmtLog->execute([
                ':id_usuario' => $user ? $user['id_usuario']: null,
                ':email'      =>$email,
                ':ip'         => $ip,
                ':sucesso'    => 1
            ]);

            // Salva os dados na sessão
            $_SESSION['usuario_id']   = $user['id_usuario'];
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['perfil']       = $user['perfil'];

            // 3. Redireciona conforme o perfil (RBAC) -que porra é RBAC ? acho que deve ser o login de acordo com o perfil
            if ($user['perfil'] === 'ROOT') {
                header('Location: painel_root.php');
            } elseif ($user['perfil'] === 'ADMIN') {
                header('Location: dashboard.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            // Se o e-mail existe mas a senha errou, registra tentativa falha na auditoria (0 = false)
           
                $stmtLog->execute([
                ':id_usuario' => $user ? $user['id_usuario'] : null,
                ':email'      => $email,
                ':ip'         => $ip,
                ':sucesso'    => 0
                ]);
            }
            $erro = "E-mail ou senha inválidos.";
        }
    } else {
        $erro = "Preencha o e-mail e a senha.";
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Quitandaria da Gôda</title>
</head>
<body>
    <div class="conteudo-principal-centralizado">
        <form action="login.php" method="post" class="login-box">
            <h1 class="mercado" style="font-size: 30px;">Quitandaria da Gôda</h1>
            <h2 class="mercado" style="font-size: 22px; font-weight: bold;">Bem vindo(s)(as)!</h2>

            <?php if (isset($_GET['cadastrado'])): ?>
                <p style="color: #1b5e20; font-weight: bold; text-align: center;">Cadastro realizado com sucesso! Faça seu login.</p>
            <?php endif; ?>

            <?php if (!empty($erro)): ?>
                <p style="color: #b00020; font-weight: bold; text-align: center;"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

            <br>
            <div class="campo">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>
            
            <div class="campo">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>    
            </div>
           
            <br>
            <button type="submit">Entrar</button>
            <a href="cadastro.php" class="cadastro-link">Cadastre-se</a>
            <a href="esqueceu_senha.php" class="esqueceu-senha-link">Esqueceu a senha?</a>
        </form>
        <br><br>
        <div class="footer-login">
            <p>&copy; 2026 Quitandaria da Gôda. Todos os direitos reservados. Organizações Tabajara.</p>
        </div>
    </div> 
    <script src="../js/script.js"></script> 
</body>
</html>