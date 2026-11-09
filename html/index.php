<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindos! | Quitandaria da Gôda</title>
</head>
<body class="pagina-dashboard"> 
    <div class="conteudo-principal">

   
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
    
   <main class="conteudo-principal-inicio">
        
            <div class="boas-vindas-inicio">
                <h1>Boas Vindas à Quitandaria da Gôda!</h1>
            </div>

            <section class="cartoes-pitch">
                <div class="cartao-pitch">
                    <h4>Produtos Frescos🥬🥕🍅</h4>
                </div>

                <div class="cartao-pitch">
                    <h4>Serviço de Entrega 🛵💨</h4>
                
                </div>

                <div class="cartao-pitch">
                    <h4>Pagamento Fácil e Seguro 💳</h4>
                 </div>

            </section>

            <div class="mensagem-destaque">
                <h2>Confira os Destaques da Quitandaria !!</h2>
            </div>    

            <section class="secao-tabela-produtos-page">
            <div class="produtos-grid">


                <div class="produto-card">
                    <img src="../imagens/alface.jpg" alt="Alface">
                    <h3>Alface Florzinha</h3>
                    <p>Preço: R$ 5,50/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/cebola.jpg" alt="Cebola">
                    <h3>Cebola</h3>
                    <p>Preço: R$ 4,50/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/pimentao.png" alt="Pimentão">
                    <h3>Pimentão</h3>
                    <p>Preço: R$ 8,00/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/melancia.jpg" alt="Melancia">
                    <h3>Melancia</h3>
                    <p>Preço: R$ 12,00/Unidade</p>
                </div> 
                
                <div class="produto-card">
                    <img src="../imagens/maca.jpg" alt="Maçã">
                    <h3>Maçã da Casa</h3>
                    <p>Preço: R$ 7,00/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/manga.jpg" alt="Manga">
                    <h3>Manga</h3>
                    <p>Preço: R$ 8,00/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/carvao.jpg" alt="Carvão">
                    <h3>Carvão</h3>
                    <p>Preço: R$ 10,50 /Saco 5Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/quejocoalho.jpg" alt="Queijo Coalho">
                    <h3>Queijo Coalho</h3>
                    <p>Preço: R$ 21,00/Barra</p>
                </div>


                <div class="produto-card">
                    <img src="../imagens/mel.jpg" alt="Mel">
                    <h3>Mel</h3>
                    <p>Preço: R$ 60,50/pote</p>
                </div>
            </div>
        </section>

         <h2 class="product-arrivals">Chegando Na Quitandaria...</h2>

         <section class="secao-produtos-novos">
            <div class="produtos-grid">
                <div class="produto-card">
                    <img src="../imagens/mel.jpg" alt="Mel Italiano">
                    <h3>Mel Italiano</h3>
                    
                    <p>Preço: R$ 60,50/pote</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/charque.jpg" alt="Charque">
                    <h3>Charque da Casa</h3>
                    <p>Preço: R$ 25,00/kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/carvao.jpg" alt="Carvão">
                    <h3>Carvão Churras Garantido</h3>
                    <p>Preço: R$ 10,50 /Saco 5Kg</p>
                </div>
            </div>

            <div class="call-to-action">
                <p>Não viu aqui o que precisa ? Vem dar uma checada nos produtos, temos várias opções em Frutas,legumes raízes e mercearia!</p>
                <button type="button" button class="conhecer-produtos" onclick="window.location.href='produtos.php'">Ver Todos os Produtos 🛒🥕🥬🍅</button>
            </div>
        </section>

        <section class="secao-receitas">
            <h2>Pratos com nossos Ingredientes</h2>
            <p class="subtitulo-receitas">Veja Possibilidades de Pratos Saudáveis Abaixo</p>

            <div class="container-receitas">
                <div class="bloco-imagem-prato">
                    <img id="imagem-prato-destaque" src="../imagens/nsalada.jpg" alt="Salada Refrescante">
                    <p id="legenda-prato">Salada Tropical Refrescante </p>
                </div>

            <div class="bloco-lista-pratos">
                <ul class="lista-receitas">
                    <li class="item-receita-ativa">
                        <h3>🥗Salada Tropical Refrescante</h3>
                        <p>Mix de alface,tomate ceretinho,manga e molho especial</p>
                    </li>
                    <li class="item-receita">
                        <h3>🍜Sopa Cremosa de Abóbora</h3>
                        <p>Abóbora  cabotiá Fresca com toque de gengibre e ervas.</p>
                    </li>
                    <li class="item-receita">
                        <h3>Escondidinho de Macaxeira com Charque</h3>
                        <p>Massa de macaxeira leve com charque desfiada </p>
                    </li> 
                    <li class="item-receita">
                        <h3>🧃Suco Detox</h3>
                        <p>Couve fresca, maçã verde, limão e gengibre selecionados. </p>
                    </li>  
                </ul>              
             </div>
            </div>
    </section>    

         
         <div class="footer">
        <p>&copy; 2026 Quitandaria da Gôda. Todos os direitos reservados. Organizações Tabajara.</p>
    </div> 

    </main>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>