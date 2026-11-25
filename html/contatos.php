<?php 

//acho que define aqui que o usuário  logado ou não ,preencha os campos da página contatos e salve!. MAssa!
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/conexao.php';

$sucesso = '';
$erro    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim($_POST['nome'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $assunto    = trim($_POST['assunto'] ?? '');
    $mensagem   = trim($_POST['mensagem'] ?? '');
    // Se o usuário estiver logado, vincula o ID dele; senão, salva NULL
    $id_usuario = $_SESSION['usuario_id'] ?? null;

    if (!empty($nome) && !empty($email) && !empty($assunto) && !empty($mensagem)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO mensagens_contato (id_usuario, nome, email, assunto, mensagem) 
                VALUES (:id_usuario, :nome, :email, :assunto, :mensagem)
            ");
            $stmt->execute([
                ':id_usuario' => $id_usuario,
                ':nome'       => $nome,
                ':email'      => $email,
                ':assunto'    => $assunto,
                ':mensagem'   => $mensagem
            ]);

            $sucesso = "Mensagem enviada com sucesso! Em breve retornaremos pelo seu e-mail.";
        } catch (PDOException $e) {
            $erro = "Erro ao enviar mensagem: " . $e->getMessage();
        }
    } else {
        $erro = "Por favor, preencha todos os campos obrigatórios.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css?v=2">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato | Quitandaria da Gôda</title>
</head>
<body class="pagina-dashboard">
    <div class="conteudo-principal">

        <?php require_once __DIR__ . '/../includes/header.php'; ?>

        <main class="conteudo-principal">
            <div class="titulo-acima">
                <h2>Entre em Contato</h2>
                <p>Preencha seus dados para podermos retornar ou utilize nossos canais diretos.</p>
            </div>

            <div class="secao-contato">
                <section class="card-formulario">
                    <h3>Deixe seus Dados</h3>

                    <?php if (!empty($sucesso)): ?>
                        <p style="color: #1b5e20; font-weight: bold; margin-bottom: 15px;"><?= htmlspecialchars($sucesso) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($erro)): ?>
                        <p style="color: #b00020; font-weight: bold; margin-bottom: 15px;"><?= htmlspecialchars($erro) ?></p>
                    <?php endif; ?>

                    <form action="contatos.php" method="post" class="form-contato">
                        <div class="campo">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" placeholder="Digite seu nome" 
                                   value="<?= htmlspecialchars($_SESSION['usuario_nome'] ?? '') ?>" required>
                        </div>

                        <div class="campos-linha">
                            <div class="campo">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" placeholder="seu@email.com" required>
                            </div>
                            <div class="campo">
                                <label for="assunto">Assunto</label>
                                <input type="text" id="assunto" name="assunto" placeholder="Ex: Dúvida, Encomenda, Elogio" required>
                            </div>
                        </div>

                        <div class="campo">
                            <label for="mensagem">Mensagem ou Pedido</label>
                            <textarea id="mensagem" name="mensagem" rows="4" style="font-weight: bold;" placeholder="Como podemos te ajudar?" required></textarea>
                        </div>

                        <button type="submit" class="btn-cadastrar-item">Enviar Informações</button>
                    </form>
                </section>

                <aside class="card-info-contato">
                    <h3>Informações da Quitandaria</h3>

                    <div class="item-info">
                        <strong>📍 Endereço da Feira:</strong>
                        <p>Rua das Hortaliças, 123 - Bairro Central</p>
                    </div>
                    <br>

                    <div class="item-info">
                        <strong>📞 Atendimento Direto:</strong>
                        <p>(81) 3456-7890</p>
                        <p>(81) 98765-4321 (WhatsApp)</p>
                    </div>
                    <br>
                    <div class="item-info">
                        <strong>✉️ E-mail Comercial:</strong>
                        <p>contato@quitandariadagoda.com.br</p>
                    </div>
                    <br>
                    <div class="item-info">
                        <strong>⏰ Horário de Funcionamento:</strong>
                        <p>Segunda a Sexta: 07h às 19h</p>
                        <p>Sábados e Domingos: 07h às 14h</p>
                    </div>
                </aside>
            </div>
        </main>

        <div class="footer">
            <p>&copy; 2026 Quitandaria da Gôda. Todos os direitos reservados. Organizações Tabajara.</p>
        </div>
    </div>
    
</body>
</html>