<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../css/estilo.css?v=4">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Produtos | Quitandaria da Gôda </title>
</head>
<body>
    <div class="conteudo-principal">

        <?php require_once __DIR__ . '/../includes/header.php'; ?>
    
    
       <main class="conteudo-principal-produtos">
         <div class="titulo-acima-da-tabela">
            <h2>Lista de Produtos</h2>
            <p>Confira os itens disponíveis em estoque na feira.</p>
        </div> 

        <h3 class="legumes" id="legumes">Em Legumes e Raízes</h3>

        <section class="secao-tabela-produtos-page">
            <div class="produtos-grid">
                <div class="produto-card">
                    <img src="../imagens/cenoura.jpg" alt="Cenouras">
                    <h3>Cenoura</h3>
                    
                    <p>Preço: R$ 10,00/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/macaxeira.jpg" alt="Macaxeira">
                    <h3>Macaxeira</h3>
                    <p>Preço: R$ 5,00</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/alface.jpg" alt="Alface Manteiga">
                    <h3>Alface Manteiga</h3>
                    <p>Preço: R$ 6,50</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/batata-doce.jpg" alt="Batata Doce">
                    <h3>Batata Doce</h3>
                    <p>Preço: R$ 4,20 /kg</p>
                </div> 
                
                <div class="produto-card">
                    <img src="../imagens/pimentao.png" alt="Pimentão">
                    <h3>Pimentão Verde</h3>
                    <p>Preço: R$ 7,00 /kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/cebola.jpg" alt="Cebola">
                    <h3>Cebola Graudinha</h3>
                    <p>Preço:R$ 9,25 /kg</p>
                </div>



                <!-- Adicione mais produtos conforme necessário -->
            </div>
        </section>

        <h3 class="frutas" id="frutas"> Em Frutas</h3>

        <section class="secao-tabela-produtos-page">
            <div class="produtos-grid">
                <div class="produto-card">
                    <img src="../imagens/tomate.jpg" alt="tomate">
                    <h3>Tomate Importado</h3>
                    
                    <p>Preço: R$ 8,50/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/banana.jpg" alt="Banana">
                    <h3>Bananas </h3>
                    <p>Preço: R$ 8,50 /Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/maca.jpg" alt="Maças Importadas">
                    <h3>Maçãs Importadas</h3>
                    <p>Preço: R$ 7,00 /Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/manga.jpg" alt="Manga">
                    <h3>Mangas Rosadinhas</h3>
                    <p>Preço: R$ 11,20 /kg</p>
                </div> 
                
                <div class="produto-card">
                    <img src="../imagens/melancia.jpg" alt="Melancia">
                    <h3>Melancia da Fazenda</h3>
                    <p>Preço: R$ 12,00/un</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/pera.jpg" alt="Peras">
                    <h3>Pera Abelhinha</h3>
                    <p>Preço:R$ 5,50 /kg</p>
                </div>



                <!-- Adicione mais produtos conforme necessário -->
            </div>
        </section>


        <h3 class="mercearia" id="mercearia"> Em Mercearia</h3> 


        <section class="secao-tabela-produtos-page">
            <div class="produtos-grid">
                <div class="produto-card">
                    <img src="../imagens/alhopicado.jpg" alt="Alho Picado">
                    <h3>Alho Picado Frito da casa</h3>
                    
                    <p>Preço: R$ 5,50/ Kg</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/leite.jpg" alt="Leite">
                    <h3>Leite da Casa </h3>
                    <p>Preço: R$ 6,80</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/ovos.jpg" alt="Bandeja de Ovos">
                    <h3>Ovos</h3>
                    <p>Preço: R$ 13,50 /Bandeja 30Un</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/queijoprato.jpg" alt="Queijo Prato">
                    <h3>Queijo Prato da Casa</h3>
                    <p>Preço: R$ 26,00 /kg</p>
                </div> 
                
                <div class="produto-card">
                    <img src="../imagens/quejocoalho.jpg" alt="Queijo Coalho">
                    <h3>Queijo Coalho da Casa</h3>
                    <p>Preço: R$ 21,00/Barra</p>
                </div>

                <div class="produto-card">
                    <img src="../imagens/sal.jpg" alt="Sal">
                    <h3>Sal da Casa</h3>
                    <p>Preço:R$ 4,00</p>
                </div>



                <!-- Adicione mais produtos conforme necessário -->
            </div>
        </section>



       
       
        <br>
        <div class="footer-produtos">
        <p>&copy; 2026 Quitandaria da Gôda. Todos os direitos reservados. Organizações Tabajara.</p>
    </div> 
    </main>

    
     <script src="../js/script.js"></script>
    
</body>
</html>