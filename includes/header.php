<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
}

$paginaAtual= basename($_SERVER['PHP_SELF']);

$estalogado = isset ($_SESSION['usuario_id']);
$perfilUsuario = $_SESSION['perfil'] ?? 'VISITANTE' ; // VISITANTE, CLIENTE OU ADMIN
$nomeUsuario = $_SESSION['usuario_nome'] ??  '' ;

?>

<header class="topo-dashboard">
    <a class="quitandaria-logo" href="index.php">
        <div class="logo-icone">
            <span class="emojis">🍅🫛🥕</span>
        </div>
        <div class="logo-texto">
            <strong>Quitandaria da Gôda</strong>
            <span>Sua Feira de Qualidade</span>
        </div>
    </a>

    <nav class="menu-navegacao">
        <a href="index.php" class="link-menu <?= $paginaAtual === 'index.php' ? 'ativo' : '' ?>">Página Inicial</a>

        <?php if ($estalogado && $perfilUsuario === 'ADMIN'): ?>
            <a href ="dashboard.php" class="link-menu  <?= $paginaAtual === 'dashboard.php' ? 'ativo' : '' ?>">Dashboard</a>
        <?php endif; ?>

        <div class="menu-dropdown">
          <a href=produtos.php class="link-menu <?= $paginaAtual === 'produtos.php' ? 'ativo' : '' ?> ">Produtos ▾</a>
           <ul class="submenu">
             <li><a href="produtos.php#legumes" class="link-submenu"> Em Legumes e Raízes</a></li>
             <li><a href="produtos.php#frutas" class="link-submenu"> Em Frutas</a></li>
             <li><a href="produtos.php#mercearia" class="link-submenu">Em Mercearia</a></li>
           </ul> 
        </div>
        <a href=contatos.php class="link-menu <?= $paginaAtual === 'contatos.php' ? 'ativo' : '' ?> ">Contato</a>
        <a href=sobre.php class="link-menu <?= $paginaAtual === 'sobre.php' ? 'ativo' : '' ?> ">Sobre a Quitandaria</a>
    
    </nav>    

    <div class="menu-usuario">
        <?php if ($estalogado): ?>
            <span class="saudacao-usuario">Olá, <?= htmlspecialchars($nomeUsuario) ?></span>
            <a href="logout.php" class="btn-sair-topo">Sair</a>
        <?php else: ?> 
            <a href="login.php" class="btn-entrar-topo">Entrar</a>
        <?php endif; ?>
    </div>  

</header>    


<!--Botão Flutuante da Sacola (fica oculto se nada for selecionado)-->
<button id="btn-abrir-carrinho" class="btn-carrinho-flutuante" type="button" data-logado="<?= $estalogado ? 'true' : 'false' ?>"  style="display:none;">
   🛒Minha Sacola (<span id="contador-sacola">0</span>)
</button>

<!--Painel LAteral do Carrinho-->
<aside id="painel-carrinho" class="painel-carrinho">
    <div class="carrinho-topo">
        <h3> 📃Seu Pedido </h3>
        <button id="btn-fechar-carrinho" type="button" class="btn-fechar-carrinho">X</button>
    </div>

    <div id ="lista-itens-carrinho" class="carrinho-lista">
        <p class="carrinho-vazio">Sua sacola está vazia!. Escolha ítens da feira!.</p>
    </div>
    
    <div class="carrinho-rodape">
        <div class="linha-total">
            <span>Total Estimado:</span>
            <strong id="valor-total-carrinho">R$0,00</strong>
        </div>
        <button id="btn-limpar-carrinho" type="button" class="btn-limpar">Esvaziar Sacola</button> 
        <button id="btn-finalizar-pedido" type="button" class="btn-finalizar">Finalizar Pedido</button>  
    </div>
</aside>   

<script src="../js/script.js?v=4"></script>
    
    



        