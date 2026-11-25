<?php
session_start();
require_once '../config/conexao.php';

// Proteção RBAC estrita: apenas ROOT pode acessar
if (!isset($_SESSION['usuario_id']) || ($_SESSION['perfil'] ?? '') !== 'ROOT') {
    header('Location: login.php');
    exit;
}

$mensagem_status = '';
$tipo_status = 'sucesso';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    try {
        // 1. Alterar perfil de usuário (CLIENTE / ADMIN / ROOT)
        if ($acao === 'alterar_perfil') {
            $id_alvo    = (int) ($_POST['id_usuario'] ?? 0);
            $novoPerfil = $_POST['perfil'] ?? '';

            if ($id_alvo > 0 && in_array($novoPerfil, ['CLIENTE', 'ADMIN', 'ROOT'])) {
                if ($id_alvo === (int)$_SESSION['usuario_id'] && $novoPerfil !== 'ROOT') {
                    $mensagem_status = "Você não pode remover seu próprio acesso ROOT.";
                    $tipo_status = 'erro';
                } else {
                    $stmt = $pdo->prepare("UPDATE usuarios SET perfil = :perfil WHERE id_usuario = :id");
                    $stmt->execute([':perfil' => $novoPerfil, ':id' => $id_alvo]);
                    $mensagem_status = "Perfil do usuário atualizado para $novoPerfil!";
                }
            }
        }

        // 2. Excluir usuário
        if ($acao === 'excluir_usuario') {
            $id_alvo = (int) ($_POST['id_usuario'] ?? 0);
            if ($id_alvo === (int)$_SESSION['usuario_id']) {
                $mensagem_status = "Você não pode excluir sua própria conta logada.";
                $tipo_status = 'erro';
            } elseif ($id_alvo > 0) {
                $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id")->execute([':id' => $id_alvo]);
                $mensagem_status = "Usuário removido com sucesso.";
            }
        }

        // 3. Cadastrar Fornecedor
        if ($acao === 'cadastrar_fornecedor') {
            $nome     = trim($_POST['nome'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $cnpj     = preg_replace('/\D/', '', $_POST['cnpj'] ?? '');

            if ($nome && $email && $telefone) {
                $stmt = $pdo->prepare("INSERT INTO fornecedores (nome, email, telefone, cnpj) VALUES (:nome, :email, :tel, :cnpj)");
                $stmt->execute([
                    ':nome'  => $nome,
                    ':email' => $email,
                    ':tel'   => $telefone,
                    ':cnpj'  => $cnpj ?: null
                ]);
                $mensagem_status = "Fornecedor cadastrado com sucesso!";
            } else {
                $mensagem_status = "Preencha nome, e-mail e telefone do fornecedor.";
                $tipo_status = 'erro';
            }
        }

        // 4. Cadastrar Funcionário
        if ($acao === 'cadastrar_funcionario') {
            $nome     = trim($_POST['nome'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $cpf      = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
            $cargo    = trim($_POST['cargo'] ?? '');
            $salario  = (float) str_replace(',', '.', $_POST['salario'] ?? 0);

            if ($nome && $email && $telefone && $cargo && $salario > 0) {
                $stmt = $pdo->prepare("INSERT INTO funcionarios (nome, email, telefone, cpf, cargo, salario) VALUES (:nome, :email, :tel, :cpf, :cargo, :sal)");
                $stmt->execute([
                    ':nome'  => $nome,
                    ':email' => $email,
                    ':tel'   => $telefone,
                    ':cpf'   => $cpf ?: null,
                    ':cargo' => $cargo,
                    ':sal'   => $salario
                ]);
                $mensagem_status = "Funcionário cadastrado com sucesso!";
            } else {
                $mensagem_status = "Preencha todos os dados obrigatórios do funcionário.";
                $tipo_status = 'erro';
            }
        }
    } catch (PDOException $e) {
        $mensagem_status = "Erro no banco: " . $e->getMessage();
        $tipo_status = 'erro';
    }
}

// Consultas para o Painel ROOT
$usuarios     = $pdo->query("SELECT id_usuario, nome, email, perfil FROM usuarios ORDER BY id_usuario ASC")->fetchAll();
$fornecedores = $pdo->query("SELECT * FROM fornecedores ORDER BY nome ASC")->fetchAll();
$funcionarios = $pdo->query("SELECT * FROM funcionarios ORDER BY nome ASC")->fetchAll();
$logsLogin    = $pdo->query("SELECT * FROM log_login ORDER BY data_hora DESC LIMIT 15")->fetchAll();
$logsLogout   = $pdo->query("
    SELECT l.*, u.nome 
    FROM log_logout l 
    LEFT JOIN usuarios u ON l.id_usuario = u.id_usuario 
    ORDER BY l.data_hora DESC LIMIT 15
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel ROOT | Quitandaria da Gôda</title>
    <style>
        .root-box { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin: 25px auto; max-width: 1100px; text-align: left; }
        .root-box h3 { color: #1b5e20; margin-bottom: 15px; border-bottom: 2px solid #e8f5e9; padding-bottom: 8px; }
        .grid-form-root { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; }
        .grid-form-root input { padding: 8px; border: 1px solid #ccc; border-radius: 6px; width: 100%; box-sizing: border-box; }
        .btn-root-verde { background: #2e7d32; color: #fff; border: none; padding: 9px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-root-verde:hover { background: #1b5e20; }
        .btn-root-vermelho { background: #c62828; color: #fff; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 12px; }
        .tabela-root { width: 100%; border-collapse: collapse; font-size: 14px; margin-top: 10px; }
        .tabela-root th, .tabela-root td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        .tabela-root th { background: #e8f5e9; color: #1b5e20; }
        .badge-ok { background: #e8f5e9; color: #1b5e20; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .badge-falha { background: #ffebee; color: #b71c1c; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .aviso-root { max-width: 1100px; margin: 15px auto; padding: 12px; border-radius: 6px; font-weight: bold; text-align: center; }
        .aviso-ok { background: #e8f5e9; color: #1b5e20; border: 1px solid #a5d6a7; }
        .aviso-err { background: #ffebee; color: #b71c1c; border: 1px solid #ef9a9a; }
    </style>
</head>
<body class="pagina-dashboard">

    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <br>

    <main class="conteudo-principal-dashboard">
        <div class="titulo-acima">
            <h2>Painel ROOT — Administração Geral</h2>
            <br>
            <p class="dashiboardi">
                Acesso mestre de <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>. Gerencie permissões de usuários, fornecedores, funcionários e auditoria de segurança.
                <a href="dashboard.php" style="margin-left:10px; color:#1b5e20; font-weight:bold;">[Ir para Dashboard de Produtos]</a>
            </p>
        </div>

        <?php if ($mensagem_status): ?>
            <div class="aviso-root <?= $tipo_status === 'erro' ? 'aviso-err' : 'aviso-ok' ?>">
                <?= htmlspecialchars($mensagem_status) ?>
            </div>
        <?php endif; ?>

        <!-- Cards de Resumo ROOT -->
        <section class="cards-resumo">
            <div class="card">
                <p>Usuários Cadastrados</p>
                <p class="numero"><?= count($usuarios) ?></p>
            </div>
            <div class="card">
                <p>Fornecedores Ativos</p>
                <p class="numero"><?= count($fornecedores) ?></p>
            </div>
            <div class="card">
                <p>Funcionários</p>
                <p class="numero"><?= count($funcionarios) ?></p>
            </div>
        </section>

        <!-- 1. Gerenciamento de Usuários e RBAC -->
        <div class="root-box">
            <h3>Controle de Usuários e Perfis (RBAC)</h3>
            <div style="overflow-x:auto;">
                <table class="tabela-root">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil Atual</th>
                            <th>Alterar Permissão</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td>#<?= $u['id_usuario'] ?></td>
                                <td><strong><?= htmlspecialchars($u['nome']) ?></strong></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td><strong><?= htmlspecialchars($u['perfil']) ?></strong></td>
                                <td>
                                    <form method="post" style="display:flex; gap:6px; align-items:center;">
                                        <input type="hidden" name="acao" value="alterar_perfil">
                                        <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                                        <select name="perfil" style="padding:5px; border-radius:4px;">
                                            <option value="CLIENTE" <?= $u['perfil'] === 'CLIENTE' ? 'selected' : '' ?>>CLIENTE</option>
                                            <option value="ADMIN" <?= $u['perfil'] === 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
                                            <option value="ROOT" <?= $u['perfil'] === 'ROOT' ? 'selected' : '' ?>>ROOT</option>
                                        </select>
                                        <button type="submit" class="btn-root-verde" style="padding:5px 10px; font-size:12px;">Salvar</button>
                                    </form>
                                </td>
                                <td>
                                    <?php if ((int)$u['id_usuario'] !== (int)$_SESSION['usuario_id']): ?>
                                        <form method="post" onsubmit="return confirm('Excluir este usuário permanentemente?');">
                                            <input type="hidden" name="acao" value="excluir_usuario">
                                            <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                                            <button type="submit" class="btn-root-vermelho">Excluir</button>
                                        </form>
                                    <?php else: ?>
                                        <small style="color:#777;">(Você)</small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Cadastro e Lista de Fornecedores -->
        <div class="root-box">
            <h3>Fornecedores</h3>
            <form method="post" class="grid-form-root" style="margin-bottom:15px;">
                <input type="hidden" name="acao" value="cadastrar_fornecedor">
                <input type="text" name="nome" placeholder="Nome / Razão Social" required>
                <input type="email" name="email" placeholder="E-mail do fornecedor" required>
                <input type="text" name="telefone" placeholder="Telefone (ex: 81999998888)" required>
                <input type="text" name="cnpj" placeholder="CNPJ (somente números, opcional)" maxlength="14">
                <button type="submit" class="btn-root-verde">+ Cadastrar Fornecedor</button>
            </form>

            <div style="overflow-x:auto;">
                <table class="tabela-root">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fornecedor</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>CNPJ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($fornecedores)): ?>
                            <tr><td colspan="5">Nenhum fornecedor cadastrado.</td></tr>
                        <?php else: ?>
                            <?php foreach ($fornecedores as $f): ?>
                                <tr>
                                    <td>#<?= $f['id_fornecedor'] ?></td>
                                    <td><strong><?= htmlspecialchars($f['nome']) ?></strong></td>
                                    <td><?= htmlspecialchars($f['email']) ?></td>
                                    <td><?= htmlspecialchars($f['telefone']) ?></td>
                                    <td><?= htmlspecialchars($f['cnpj'] ?? '—') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Cadastro e Lista de Funcionários -->
        <div class="root-box">
            <h3>Funcionários</h3>
            <form method="post" class="grid-form-root" style="margin-bottom:15px;">
                <input type="hidden" name="acao" value="cadastrar_funcionario">
                <input type="text" name="nome" placeholder="Nome completo" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="text" name="telefone" placeholder="Telefone" required>
                <input type="text" name="cpf" placeholder="CPF (11 dígitos)" maxlength="11">
                <input type="text" name="cargo" placeholder="Cargo (ex: Caixa, Estoquista)" required>
                <input type="number" step="0.01" name="salario" placeholder="Salário (R$)" required>
                <button type="submit" class="btn-root-verde">+ Cadastrar Funcionário</button>
            </form>

            <div style="overflow-x:auto;">
                <table class="tabela-root">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cargo</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Salário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($funcionarios)): ?>
                            <tr><td colspan="5">Nenhum funcionário cadastrado.</td></tr>
                        <?php else: ?>
                            <?php foreach ($funcionarios as $func): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($func['nome']) ?></strong></td>
                                    <td><?= htmlspecialchars($func['cargo']) ?></td>
                                    <td><?= htmlspecialchars($func['email']) ?></td>
                                    <td><?= htmlspecialchars($func['telefone']) ?></td>
                                    <td>R$ <?= number_format((float)$func['salario'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Logs de Auditoria (Login e Logout) -->
        <div class="root-box">
            <h3>Auditoria de Segurança — Últimos Logins</h3>
            <div style="overflow-x:auto;">
                <table class="tabela-root">
                    <thead>
                        <tr>
                            <th>Data/Hora</th>
                            <th>E-mail Informado</th>
                            <th>IP de Acesso</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($logsLogin)): ?>
                            <tr><td colspan="4">Nenhum registro de login encontrado.</td></tr>
                        <?php else: ?>
                            <?php foreach ($logsLogin as $log): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i:s', strtotime($log['data_hora'])) ?></td>
                                    <td><?= htmlspecialchars($log['email_informado']) ?></td>
                                    <td><?= htmlspecialchars($log['ip_acesso']) ?></td>
                                    <td>
                                        <?php if ((int)$log['sucesso'] === 1): ?>
                                            <span class="badge-ok">SUCESSO</span>
                                        <?php else: ?>
                                            <span class="badge-falha">FALHA</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <h3 style="margin-top:25px;">Auditoria de Segurança — Últimos Logouts</h3>
            <div style="overflow-x:auto;">
                <table class="tabela-root">
                    <thead>
                        <tr>
                            <th>Data/Hora</th>
                            <th>Usuário</th>
                            <th>IP de Acesso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($logsLogout)): ?>
                            <tr><td colspan="3">Nenhum registro de logout encontrado.</td></tr>
                        <?php else: ?>
                            <?php foreach ($logsLogout as $out): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i:s', strtotime($out['data_hora'])) ?></td>
                                    <td><?= htmlspecialchars($out['nome'] ?? 'ID #' . ($out['id_usuario'] ?? 'Desconhecido')) ?></td>
                                    <td><?= htmlspecialchars($out['ip_acesso']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="footer">
        <p>&copy; 2026 Quitandaria da Gôda. Todos os direitos reservados. Organizações Tabajara.</p>
    </div>

    <script src="../js/script.js"></script>
</body>
</html>