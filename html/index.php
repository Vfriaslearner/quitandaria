<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css?v=2">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindos! | Quitandaria da Gôda</title>
</head>
<body class="pagina-dashboard"> 
    <div class="conteudo-principal">

     <?php require_once __DIR__ . '/../includes/header.php' ; ?>
          
    
   <main class="conteudo-principal-inicio">
        
            <div class="boas-vindas-inicio">
                <h2>Boas Vindas à Quitandaria da Gôda!</h2>
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
                <h3>Confira os Destaques da Quitandaria !!</h3>
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
            <p class="subtitulo-receitas">Clique em Um Exemplo de Prato Saudável</p>

            <div class="container-receitas">
                <div class="bloco-imagem-prato">
                    <img id="imagem-prato-destaque" src="../imagens/salada.jpg" alt="Salada Refrescante">
                    <p id="legenda-prato">Salada Tropical Refrescante </p>
                </div>

            <div class="bloco-lista-pratos">
                <ul class="lista-receitas">
                <li class="item-receita item-receita-ativa" 
                   data-imagem="../imagens/salada.jpg" 
                   data-legenda="Salada Tropical Refrescante">
                   <h3>🥗 Salada Tropical Refrescante</h3>
                   <p>Mix de alface, tomate cerejinha, manga e molho especial</p>
                </li>
              <li class="item-receita" 
                  data-imagem="../imagens/sopa-abobora.jpg" 
                  data-legenda="Sopa Cremosa de Abóbora">
                  <h3>🍜 Sopa Cremosa de Abóbora</h3>
                  <p>Abóbora cabotiá fresca com toque de gengibre e ervas.</p>
              </li>
              <li class="item-receita" 
                  data-imagem="../imagens/escondidinho.jpg" 
                  data-legenda="Escondidinho de Macaxeira com Charque">
                    <h3>🥘 Escondidinho de Macaxeira com Charque</h3>
                    <p>Massa de macaxeira leve com charque desfiada</p>
              </li> 
              <li class="item-receita" 
                   data-imagem="../imagens/detox.jpg" 
                   data-legenda="Suco Detox">
                   <h3>🧃 Suco Detox</h3>
                  <p>Couve fresca, maçã verde, limão e gengibre selecionados.</p>
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
    
       <script>
             const itensReceita = document.querySelectorAll('.lista-receitas li');
             const imgDestaque  = document.getElementById('imagem-prato-destaque');
             const legendaPrato = document.getElementById('legenda-prato');

             itensReceita.forEach((item) => {
                item.addEventListener('click', () => {
            // 1. Apaga o destaque de TODOS os itens da lista (inclusive o 1º)
            itensReceita.forEach((el) => {
                el.classList.remove('item-receita-ativa');
                el.classList.add('item-receita');
            });

            // 2. Acende APENAS a porra do item clicado
            item.classList.add('item-receita-ativa');

            // 3. Troca a foto e a legenda
            if (item.dataset.imagem) {
                imgDestaque.src = item.dataset.imagem;
            }
            if (item.dataset.legenda) {
                legendaPrato.textContent = item.dataset.legenda;
            }
        });
    });
</script>
    </script>
</body>
</html>
</body>
</html>