<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width>, initial-scale=1.0">
    <title>Dashboard | Quitandaria da Gôda</title>
</head>
<body class="pagina-dashboard">
       
    <header class="topo-dashboard">
        <a class="quitandaria-logo" href="index.html">
            <div class="logo-icone">
                <span class="emojis">🍅🫛🥕</span>
            </div>
            <div class="logo-texto">
                <strong>Quitandaria da Gôda</strong>
                <span>Sua Feira de Qualidade</span>
            </div>
        </a>

       <nav class="menu-navegacao">
        <a href="index.php" class="link-menu"> Página Inicial</a>
        <a href="dashboard.php" class="link-menu">Dashboard</a>
        <div class="menu-dropdown">
        <a href="produtos.php" class="link-menu">Produtos</a>
        <div class="submenu">
            <a href="produtos.php#legumes" class="link-submenu">Legumes e Raízes</a>
            <a href="produtos.php#frutas" class="link-submenu">Frutas</a>
            <a href="produtos.php#mercearia" class="link-submenu">Mercearia</a>
          </div>
        </div>  
        <a href="contatos.php" class="link-menu">Contato</a>
        <a href="sobre.php" class="link-menu">Sobre a Quitandaria</a>
    </nav>

    
    <div class="menu-usuario">
        <a href="login.php" class="btn-sair-topo">Sair</a>
    </div>
    </header>
     <br>
     <main class="conteudo-principal-dashboard">
        <div class="titulo-acima">
        <h2>Dashboard</h2>
        <br>
        <p class="dashiboardi">Bem-vindo ao painel de controle da Quitandaria da Gôda! Aqui você pode gerenciar seus produtos, visualizar estatísticas e muito mais.</p>
        </div>

        <section class="cards-resumo" font-size="16px">
            <div class="card">
                <p>Produtos Cadastrados</p>
                <p class="numero">55</p>
            </div>

            <div class="card">
                <p>Itens em Estoque </p>
                <p class="numero">120</p>
            </div>

            <div class="card">
                <p>Ítens Com Estoque Baixo</p>
                <p class="numeroVermelho">3</p>
                
            </div> 
        </section> 
        
        <div class="produtos-saida">
           <h3>Produtos Com Mais Saída</h3>   
        </div> 


        <section class="secao-tabela-produtos-page">
            <div class="produtos-grid">
                <div class="produto-card">
                    <img src="../imagens/banana.jpg" alt="Bananas">
                    <h3>Bananas</h3>
                    
                    <p>Preço: R$ 8,50/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/macaxeira.jpg" alt="Macaxeira">
                    <h3>Leite da Casa </h3>
                    <p>Preço: R$ 5,00/Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/ovos.jpg" alt="Bandeja de Ovos">
                    <h3>Ovos</h3>
                    <p>Preço: R$ 13,50 /Bandeja 30Un</p>
                </div>

               
                
                <div class="produto-card">
                    <img src="../imagens/quejocoalho.jpg" alt="Queijo Coalho">
                    <h3>Queijo Coalho da Casa</h3>
                    <p>Preço: R$ 21,00/Barra</p>
                </div>

                
                <!-- Adicione mais produtos conforme necessário -->
            </div>
        </section>




    </main>  
        <div class="footer">
        <p>&copy; 2026 Quitandaria da Gôda. Todos os direitos reservados. Organizações Tabajara.</p>
    </div>  


 </div>
 <script src="../js/script.js"></script>
</body>
</html>