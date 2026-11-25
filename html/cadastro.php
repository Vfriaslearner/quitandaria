<?php
require_once '../config/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recebe os dados do formulário usando o atributo name=""
    $nome            = trim($_POST['nome'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $senha           = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    $telefone        = trim($_POST['telefone'] ?? '');
    // Remove pontos e traços do CPF caso o usuário digite formatado (ex: 123.456.789-00 -> 12345678900)
    $cpf             = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
    $endereco        = trim($_POST['endereco'] ?? '');

    // 2. Validações básicas antes de ir ao banco
    if ($senha !== $confirmar_senha) {
        $erro = "As senhas não conferem!";
    } elseif (strlen($cpf) !== 11) {
        $erro = "O CPF deve conter exatamente 11 dígitos.";
    } else {
        try {
            // 3. Criptografa a senha com segurança
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // 4. Inicia a transação (grava nas duas tabelas ou em nenhuma)
            $pdo->beginTransaction();

            // Insere na tabela pai: usuarios
            $stmtUser = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
            $stmtUser->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':senha' => $senha_hash
            ]);

            // Pega o ID recém-gerado em usuarios
            $id_usuario = $pdo->lastInsertId();

            // Insere na tabela filha: clientes
            $stmtCliente = $pdo->prepare("INSERT INTO clientes (id_usuario, nome, email, telefone, cpf, endereco) VALUES (:id_usuario, :nome, :email, :telefone, :cpf, :endereco)");
            $stmtCliente->execute([
                ':id_usuario' => $id_usuario,
                ':nome'       => $nome,
                ':email'      => $email,
                ':telefone'   => $telefone,
                ':cpf'        => $cpf,
                ':endereco'   => $endereco
            ]);

            // Confirma a gravação nas duas tabelas
            $pdo->commit();

            // Redireciona para o login com aviso de sucesso
            header("Location: login.php?cadastrado=1");
            exit;

        } catch (PDOException $e) {
            // Desfaz qualquer inserção parcial se der erro (ex: e-mail ou CPF já cadastrado)
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            if ($e->getCode() == 23000) {
                $erro = "Este e-mail ou CPF já está cadastrado no sistema.";
            } else {
                $erro = "Erro ao cadastrar: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Quitandaria da Gôda</title>
</head>
<body>
    <div class="conteudo-principal-centralizado">
        <form action="" method="post" class="cadastro-box">
            <h2 class="cadastro-cliente">Cadastro de Clientes</h2> 
            <p class="cadastro-cliente">Faça seu cadastro para acessar nossa plataforma e garantir as melhores promoções!!</p>

            <?php if (!empty($erro)): ?>
                <p style="color: #b00020; font-weight: bold; text-align: center;"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

            <div class="campo">
                <label for="nome-cadastro">Nome Completo</label>
                <input type="text" name="nome" id="nome-cadastro" placeholder="Digite seu nome completo" required>
            </div>
            <div class="campo">
                <label for="email-cadastro">E-mail</label>
                <input type="email" name="email" id="email-cadastro" placeholder="Digite seu e-mail" required>
            </div>
            <div class="campo">
                <label for="senha-cadastro">Senha</label>
                <input type="password" name="senha" id="senha-cadastro" placeholder="Digite sua senha" required>
            </div>
            <div class="campo">
                <label for="confirmar-senha-cadastro">Confirmar Senha</label>
                <input type="password" name="confirmar_senha" id="confirmar-senha-cadastro" placeholder="Confirme sua senha" required>
            </div>
            <div class="campo">
                <label for="telefone-cadastro">Telefone</label>
                <input type="text" name="telefone" id="telefone-cadastro" placeholder="Digite seu telefone" required>
            </div>
            <div class="campo">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" placeholder="Digite seu CPF (11 dígitos)" required>
            </div>
            <div class="campo">
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" id="endereco" placeholder="Digite seu endereço completo" required>
            </div>
            <button type="submit" id="cadastrar-btn">Cadastrar</button>
        </form>
        <br><br><br>
        <div class="footer">
            <p>&copy; 2026 Quitandaria da Gôda. Todos os direitos reservados. Organizações Tabajara.</p>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>