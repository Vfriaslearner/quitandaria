// Lógica para o usuário escolher os itens e ver o somatório deles

document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.produto-card');
    const painelCarrinho = document.getElementById('painel-carrinho');
    const btnAbrir = document.getElementById('btn-abrir-carrinho');
    const btnFechar = document.getElementById('btn-fechar-carrinho');
    const listaItensEl = document.getElementById('lista-itens-carrinho');
    const totalEl = document.getElementById('valor-total-carrinho');
    const contadorEl = document.getElementById('contador-sacola');
    const btnLimpar = document.getElementById('btn-limpar-carrinho');
    const btnFinalizar = document.getElementById('btn-finalizar-pedido');

    if (!painelCarrinho || !btnAbrir) return;

    let carrinho = JSON.parse(localStorage.getItem('quitandaria_carrinho')) || [];

    const formatarMoeda = (valor) => {
        return valor.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
    };

    const salvarCarrinho = () => {
        localStorage.setItem('quitandaria_carrinho', JSON.stringify(carrinho));
    };

    // 1. Injeta os controles de quantidade e botão adicionar em cada card
    cards.forEach((card) => {
        if (card.querySelector('.card-controles')) return;
        const nomeEl = card.querySelector('h3');
        const precoEl = card.querySelector('p');
        if (!nomeEl || !precoEl) return;

        const nome = nomeEl.textContent.trim();
        const textoPreco = precoEl.textContent;

        const matchPreco = textoPreco.match(/(\d+,\d{2})/);
        const preco = matchPreco ? parseFloat(matchPreco[1].replace(',', '.')) : 0;

        let unidade = 'un';
        if (/kg/i.test(textoPreco)) unidade = 'kg';
        else if (/bandeja/i.test(textoPreco)) unidade = 'bandeja';
        else if (/barra/i.test(textoPreco)) unidade = 'barra';

        const controles = document.createElement('div');
        controles.className = 'card-controles';
        controles.innerHTML = `
            <div class="seletor-qtd">
                <button type="button" class="btn-qtd menos">-</button>
                <span class="valor-qtd">1</span>
                <button type="button" class="btn-qtd mais">+</button>
            </div>
            <button type="button" class="btn-adicionar-item">Adicionar</button>
        `;

        card.appendChild(controles);

        let qtdAtual = 1;
        const spanQtd = controles.querySelector('.valor-qtd');

        controles.querySelector('.menos').addEventListener('click', () => {
            if (qtdAtual > 1) {
                qtdAtual--;
                spanQtd.textContent = qtdAtual;
            }
        });

        controles.querySelector('.mais').addEventListener('click', () => {
            qtdAtual++;
            spanQtd.textContent = qtdAtual;
        });

        controles.querySelector('.btn-adicionar-item').addEventListener('click', () => {
            adicionarAoCarrinho(nome, preco, unidade, qtdAtual);
            qtdAtual = 1;
            spanQtd.textContent = '1';
            painelCarrinho.classList.add('aberto');
        });
    });

    // 2. Manipulação dos itens na Sacola
    const adicionarAoCarrinho = (nome, preco, unidade, quantidade) => {
        const existente = carrinho.find((item) => item.nome === nome);
        if (existente) {
            existente.quantidade += quantidade;
        } else {
            carrinho.push({ nome, preco, unidade, quantidade });
        }
        salvarCarrinho();
        renderizarCarrinho();
    };

    const alterarQtdCarrinho = (index, delta) => {
        carrinho[index].quantidade += delta;
        if (carrinho[index].quantidade <= 0) {
            carrinho.splice(index, 1);
        }
        salvarCarrinho();
        renderizarCarrinho();
    };

    // 3. Renderiza o Recibo Atualizado
    const renderizarCarrinho = () => {
        const totalItems = carrinho.reduce((acc, item) => acc + item.quantidade, 0);
        contadorEl.textContent = totalItems;

        if (totalItems > 0) {
            btnAbrir.style.display = 'inline-flex';
        } else {
            btnAbrir.style.display = 'none';
        }

        if (carrinho.length === 0) {
            listaItensEl.innerHTML = '<p class="carrinho-vazio">Sua sacola está vazia. Escolha itens da feira!</p>';
            totalEl.textContent = 'R$ 0,00';
            return;
        }

        let totalGeral = 0;
        listaItensEl.innerHTML = '';

        carrinho.forEach((item, index) => {
            const subtotal = item.preco * item.quantidade;
            totalGeral += subtotal;

            const linha = document.createElement('div');
            linha.className = 'item-recibo';
            linha.innerHTML = `
                <div class="item-recibo-info">
                    <strong>${item.nome}</strong>
                    <span>${item.quantidade} ${item.unidade} x ${formatarMoeda(item.preco)}</span>
                </div>
                <div class="item-recibo-acoes">
                    <strong>${formatarMoeda(subtotal)}</strong>
                    <div class="mini-controles">
                        <button type="button" class="mini-btn" data-idx="${index}" data-delta="-1">-</button>
                        <button type="button" class="mini-btn" data-idx="${index}" data-delta="1">+</button>
                    </div>
                </div>
            `;

            listaItensEl.appendChild(linha);
        });

        totalEl.textContent = formatarMoeda(totalGeral);
        listaItensEl.querySelectorAll('.mini-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                const idx = parseInt(btn.dataset.idx, 10);
                const delta = parseInt(btn.dataset.delta, 10);
                alterarQtdCarrinho(idx, delta);
            });
        });
    };

    // 4. Eventos de abrir, fechar, limpar e finalizar
    btnAbrir.addEventListener('click', () => painelCarrinho.classList.add('aberto'));
    btnFechar.addEventListener('click', () => painelCarrinho.classList.remove('aberto'));

    btnLimpar.addEventListener('click', () => {
        carrinho = [];
        salvarCarrinho();
        renderizarCarrinho();
    });

    btnFinalizar.addEventListener('click', () => {
        if (carrinho.length === 0) {
            alert('Adicione pelo menos um produto à sacola antes de finalizar!');
            return;
        }

        const estaLogado = btnAbrir.dataset.logado === 'true';
        if (!estaLogado) {
            alert('Para finalizar seu pedido, faça login ou cadastre-se primeiro. Sua sacola ficará salva!');
            window.location.href = 'login.php';
            return;
        }

        window.location.href = 'recibo_pix.php';
    });

    renderizarCarrinho();
});

// Sessão de receitas no Index
document.addEventListener('DOMContentLoaded', () => {
    const itensReceita = document.querySelectorAll('.lista-receitas .item-receita');
    const imgDestaque = document.getElementById('imagem-prato-destaque');
    const legendaPrato = document.getElementById('legenda-prato');

    if (itensReceita.length > 0 && imgDestaque && legendaPrato) {
        itensReceita.forEach((item) => {
            item.addEventListener('click', () => {
                itensReceita.forEach((el) => el.classList.remove('item-receita-ativa'));
                item.classList.add('item-receita-ativa');

                const novaImagem = item.getAttribute('data-imagem');
                const novaLegenda = item.getAttribute('data-legenda');

                if (novaImagem) {
                    imgDestaque.src = novaImagem;
                    imgDestaque.alt = novaLegenda || 'Prato da Quitandaria';
                }
                if (novaLegenda) {
                    legendaPrato.textContent = novaLegenda;
                }
            });
        });
    }
});