<?php
session_start();
require_once '../config/conexao.php';

// Proteção RBAC: permite apenas ADMIN ou ROOT
if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['perfil'] ?? '', ['ADMIN', 'ROOT'])) {
    header('Location: login.php');
    exit;
}

$mensagem_status = '';
$tipo_status = 'sucesso';

// Processamento de ações (Cadastrar produto, Movimentar estoque, Excluir produto/mensagem)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    try {
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


        if ($acao === 'cadastrar_produto') {
            $nome          = trim($_POST['nome'] ?? '');
            $categoria     = trim($_POST['categoria'] ?? '');
            $unidade       = trim($_POST['unidade'] ?? '');
            $preco         = (float) str_replace(',', '.', $_POST['preco'] ?? 0);
            $estoque       = (int) ($_POST['quantidade_estoque'] ?? 0);
            $id_fornecedor = (int) ($_POST['id_fornecedor'] ?? 0);
            $imagem        = trim($_POST['imagem'] ?? '');

            if ($nome && $categoria && $unidade && $preco > 0 && $id_fornecedor > 0) {
                $stmt = $pdo->prepare("
                    INSERT INTO produtos (id_fornecedor, unidade, imagem, nome, categoria, preco, quantidade_estoque)
                    VALUES (:forn, :unid, :img, :nome, :cat, :preco, :est)
                ");
                $stmt->execute([
                    ':forn'  => $id_fornecedor,
                    ':unid'  => $unidade,
                    ':img'   => $imagem ?: null,
                    ':nome'  => $nome,
                    ':cat'   => $categoria,
                    ':preco' => $preco,
                    ':est'   => $estoque
                ]);

                if ($estoque > 0) {
                    $novoId = $pdo->lastInsertId();
                    $pdo->prepare("INSERT INTO estoque (id_produto, quantidade_movimentada, tipo) VALUES (:id, :qtd, 'ENTRADA')")
                        ->execute([':id' => $novoId, ':qtd' => $estoque]);
                }

                $mensagem_status = "Produto cadastrado com sucesso!";
            } else {
                $mensagem_status = "Preencha todos os campos obrigatórios e selecione um fornecedor.";
                $tipo_status = 'erro';
            }
        }

        if ($acao === 'movimentar_estoque') {
            $id_produto = (int) ($_POST['id_produto'] ?? 0);
            $tipo       = $_POST['tipo'] ?? 'ENTRADA';
            $qtd        = (int) ($_POST['quantidade'] ?? 0);

            if ($id_produto > 0 && $qtd > 0 && in_array($tipo, ['ENTRADA', 'SAIDA'])) {
                $operador = ($tipo === 'ENTRADA') ? '+' : '-';
                $pdo->prepare("UPDATE produtos SET quantidade_estoque = GREATEST(0, quantidade_estoque $operador :qtd) WHERE id_produto = :id")
                    ->execute([':qtd' => $qtd, ':id' => $id_produto]);

                $pdo->prepare("INSERT INTO estoque (id_produto, quantidade_movimentada, tipo) VALUES (:id, :qtd, :tipo)")
                    ->execute([':id' => $id_produto, ':qtd' => $qtd, ':tipo' => $tipo]);

                $mensagem_status = "Estoque atualizado ($tipo de $qtd un.)!";
            }
        }

        if ($acao === 'excluir_produto') {
            $id_produto = (int) ($_POST['id_produto'] ?? 0);
            if ($id_produto > 0) {
                $pdo->prepare("DELETE FROM estoque WHERE id_produto = :id")->execute([':id' => $id_produto]);
                $pdo->prepare("DELETE FROM produtos WHERE id_produto = :id")->execute([':id' => $id_produto]);
                $mensagem_status = "Produto excluído com sucesso.";
            }
        }

        if ($acao === 'excluir_mensagem') {
            $id_mensagem = (int) ($_POST['id_mensagem'] ?? 0);
            if ($id_mensagem > 0) {
                $pdo->prepare("DELETE FROM mensagens_contato WHERE id_mensagem = :id")->execute([':id' => $id_mensagem]);
                $mensagem_status = "Mensagem excluída.";
            }
        }
    } catch (PDOException $e) {
        $mensagem_status = "Erro no banco: " . $e->getMessage();
        $tipo_status = 'erro';
    }
}

// Consultas reais ao banco de dados
$fornecedores = $pdo->query("SELECT id_fornecedor, nome FROM fornecedores ORDER BY nome ASC")->fetchAll();

$produtos = $pdo->query("
    SELECT p.*, f.nome AS nome_fornecedor 
    FROM produtos p 
    LEFT JOIN fornecedores f ON p.id_fornecedor = f.id_fornecedor 
    ORDER BY p.id_produto DESC
")->fetchAll();

$mensagens = $pdo->query("SELECT * FROM mensagens_contato ORDER BY data_envio DESC")->fetchAll();

// Estatísticas reais para os seus cards
$totalProdutos = count($produtos);
$totalItensEstoque = array_sum(array_column($produtos, 'quantidade_estoque'));
$estoqueBaixo = count(array_filter($produtos, fn($p) => (int)$p['quantidade_estoque'] <= 10));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Quitandaria da Gôda</title>
    <style>
        .painel-box { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin: 25px auto; max-width: 1100px; text-align: left; }
        .painel-box h3 { color: #1b5e20; margin-bottom: 15px; border-bottom: 2px solid #e8f5e9; padding-bottom: 8px; }
        .grid-form-adm { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; }
        .grid-form-adm input, .grid-form-adm select { padding: 8px; border: 1px solid #ccc; border-radius: 6px; width: 100%; box-sizing: border-box; }
        .btn-adm-verde { background: #2e7d32; color: #fff; border: none; padding: 9px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-adm-verde:hover { background: #1b5e20; }
        .btn-adm-vermelho { background: #c62828; color: #fff; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 12px; }
        .tabela-dashboard { width: 100%; border-collapse: collapse; font-size: 14px; margin-top: 10px; }
        .tabela-dashboard th, .tabela-dashboard td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        .tabela-dashboard th { background: #e8f5e9; color: #1b5e20; }
        .aviso-dash { max-width: 1100px; margin: 15px auto; padding: 12px; border-radius: 6px; font-weight: bold; text-align: center; }
        .aviso-ok { background: #e8f5e9; color: #1b5e20; border: 1px solid #a5d6a7; }
        .aviso-err { background: #ffebee; color: #b71c1c; border: 1px solid #ef9a9a; }
    </style>
</head>
<body class="pagina-dashboard">

    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <br>

    <main class="conteudo-principal-dashboard">
        <div class="titulo-acima">
            <h2>Dashboard</h2>
            <br>
            <p class="dashiboardi">
                Bem-vindo(a), <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>! Aqui você gerencia os produtos, o estoque e as mensagens da Quitandaria da Gôda.
                <?php if ($_SESSION['perfil'] === 'ROOT'): ?>
                    <a href="painel_root.php" style="margin-left:10px; color:#b45309; font-weight:bold;">[Ir para Painel ROOT]</a>
                <?php endif; ?>
            </p>
        </div>

        <?php if ($mensagem_status): ?>
            <div class="aviso-dash <?= $tipo_status === 'erro' ? 'aviso-err' : 'aviso-ok' ?>">
                <?= htmlspecialchars($mensagem_status) ?>
            </div>
        <?php endif; ?>

        <!-- Cards de Resumo (Agora dinâmicos direto do MySQL) -->
        <section class="cards-resumo">
            <div class="card">
                <p>Produtos Cadastrados</p>
                <p class="numero"><?= $totalProdutos ?></p>
            </div>

            <div class="card">
                <p>Itens em Estoque</p>
                <p class="numero"><?= $totalItensEstoque ?></p>
            </div>

            <div class="card">
                <p>Itens Com Estoque Baixo</p>
                <p class="numeroVermelho"><?= $estoqueBaixo ?></p>
            </div>
        </section>

        <!-- Formulário de Cadastro de Produto -->
          <!-- Cadastro de Fornecedor (Disponível para ADMIN e ROOT) -->
               <div class="painel-box">
                 <h3>Cadastrar Novo Fornecedor</h3>
                 <form method="post" class="grid-form-adm">
                  <input type="hidden" name="acao" value="cadastrar_fornecedor">
                  <input type="text" name="nome" placeholder="Nome / Razão Social" required>
                 <input type="email" name="email" placeholder="E-mail do fornecedor" required>
                  <input type="text" name="telefone" placeholder="Telefone (ex: 81999998888)" required>
                  <input type="text" name="cnpj" placeholder="CNPJ (somente números, opcional)" maxlength="14">
                  <button type="submit" class="btn-adm-verde">+ Cadastrar Fornecedor</button>
              </form>
        </div>

        <div class="painel-box">
            <h3>Cadastrar Novo Produto</h3>
            <?php if (empty($fornecedores)): ?>
                <p style="color:#b71c1c;">Cadastre pelo menos 1 fornecedor no <strong>Painel ROOT</strong> (ou na tabela <code>fornecedores</code>) antes de adicionar produtos.</p>
            <?php else: ?>
                <form method="post" class="grid-form-adm">
                    <input type="hidden" name="acao" value="cadastrar_produto">
                    <input type="text" name="nome" placeholder="Nome (ex: Banana Prata)" required>
                    <input type="text" name="categoria" placeholder="Categoria (ex: Frutas)" required>
                    <input type="text" name="unidade" placeholder="Unidade (ex: Kg, Bandeja)" required>
                    <input type="number" step="0.01" name="preco" placeholder="Preço (R$)" required>
                    <input type="number" name="quantidade_estoque" placeholder="Qtd. em Estoque" min="0" required>
                    <select name="id_fornecedor" required>
                        <option value="">Fornecedor...</option>
                        <?php foreach ($fornecedores as $f): ?>
                            <option value="<?= $f['id_fornecedor'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="imagem" placeholder="Imagem (ex: ../imagens/banana.jpg)">
                    <button type="submit" class="btn-adm-verde">+ Cadastrar</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Tabela de Gerenciamento de Estoque -->
        <div class="painel-box">
            <h3>Controle de Estoque e Catálogo</h3>
            <div style="overflow-x:auto;">
                <table class="tabela-dashboard">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Fornecedor</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Entrada / Saída</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($produtos)): ?>
                            <tr><td colspan="7">Nenhum produto cadastrado no banco ainda.</td></tr>
                        <?php else: ?>
                            <?php foreach ($produtos as $p): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($p['nome']) ?></strong> (<?= htmlspecialchars($p['unidade']) ?>)</td>
                                    <td><?= htmlspecialchars($p['categoria']) ?></td>
                                    <td><?= htmlspecialchars($p['nome_fornecedor'] ?? '—') ?></td>
                                    <td>R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?></td>
                                    <td>
                                        <strong style="color: <?= $p['quantidade_estoque'] <= 10 ? '#c62828' : '#1b5e20' ?>;">
                                            <?= (int)$p['quantidade_estoque'] ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <form method="post" style="display:flex; gap:4px; align-items:center;">
                                            <input type="hidden" name="acao" value="movimentar_estoque">
                                            <input type="hidden" name="id_produto" value="<?= $p['id_produto'] ?>">
                                            <select name="tipo" style="padding:4px;">
                                                <option value="ENTRADA">+ Entrada</option>
                                                <option value="SAIDA">- Saída</option>
                                            </select>
                                            <input type="number" name="quantidade" min="1" value="1" style="width:55px; padding:4px;" required>
                                            <button type="submit" class="btn-adm-verde" style="padding:4px 8px; font-size:12px;">OK</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" onsubmit="return confirm('Excluir este produto?');">
                                            <input type="hidden" name="acao" value="excluir_produto">
                                            <input type="hidden" name="id_produto" value="<?= $p['id_produto'] ?>">
                                            <button type="submit" class="btn-adm-vermelho">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sua Vitrine de Produtos em Destaque -->
        <div class="produtos-saida">
            <h3>Produtos Com Mais Saída</h3>
        </div>

        <section class="secao-tabela-produtos-page">
            <div class="produtos-grid">
                <div class="produto-card">
                    <img src="../imagens/banana.jpg" alt="Bananas">
                    <h3>Bananas</h3>
                    <p>Preço: R$ 8,50 / Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/macaxeira.jpg" alt="Macaxeira">
                    <h3>Macaxeira</h3>
                    <p>Preço: R$ 5,00 / Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/ovos.jpg" alt="Bandeja de Ovos">
                    <h3>Ovos</h3>
                    <p>Preço: R$ 13,50 / Bandeja 30Un</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/quejocoalho.jpg" alt="Queijo Coalho">
                    <h3>Queijo Coalho da Casa</h3>
                    <p>Preço: R$ 21,00 / Barra</p>
                </div>
            </div>
        </section>

        <!-- Mensagens do Fale Conosco -->
        <div class="painel-box">
            <h3>Mensagens de Contato Recebidas (<?= count($mensagens) ?>)</h3>
            <div style="overflow-x:auto;">
                <table class="tabela-dashboard">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Assunto</th>
                            <th>Mensagem</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($mensagens)): ?>
                            <tr><td colspan="5">Nenhuma mensagem recebida ainda.</td></tr>
                        <?php else: ?>
                            <?php foreach ($mensagens as $m): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($m['data_envio'])) ?></td>
                                    <td><strong><?= htmlspecialchars($m['nome']) ?></strong><br><small><?= htmlspecialchars($m['email']) ?></small></td>
                                    <td><?= htmlspecialchars($m['assunto']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($m['mensagem'])) ?></td>
                                    <td>
                                        <form method="post" onsubmit="return confirm('Excluir mensagem?');">
                                            <input type="hidden" name="acao" value="excluir_mensagem">
                                            <input type="hidden" name="id_mensagem" value="<?= $m['id_mensagem'] ?>">
                                            <button type="submit" class="btn-adm-vermelho">Excluir</button>
                                        </form>
                                    </td>
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