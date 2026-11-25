<?php
session_start();
$clienteNome  = $_SESSION['usuario_nome'] ?? 'Cliente Quitandaria';
$numeroPedido = rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo PIX | Quitandaria da Gôda</title>
    <link rel="stylesheet" href="../css/estilo.css?v=4">
    <!-- Biblioteca leve QRCode.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        .recibo-container {
            max-width: 520px;
            margin: 35px auto;
            background: #fff;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.12);
            border-top: 6px solid #2e7d32;
            font-family: Arial, sans-serif;
        }
        .recibo-topo { text-align: center; border-bottom: 1px dashed #ccc; padding-bottom: 14px; }
        .recibo-topo h2 { color: #1b5e20; margin: 0 0 6px; }
        .lista-itens-recibo { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 14px; }
        .lista-itens-recibo th, .lista-itens-recibo td { padding: 8px 4px; border-bottom: 1px solid #eee; text-align: left; }
        .lista-itens-recibo th:last-child, .lista-itens-recibo td:last-child { text-align: right; }
        .total-destaque { text-align: right; font-size: 22px; font-weight: bold; color: #1b5e20; margin: 12px 0; }
        .area-pix { background: #f4fbf5; border: 1px solid #c8e6c9; border-radius: 10px; padding: 18px; text-align: center; margin-top: 15px; }
        #qrcode-pix { display: flex; justify-content: center; margin: 14px auto; padding: 10px; background: #fff; border-radius: 8px; width: fit-content; border: 1px dashed #2e7d32; }
        .campo-copia-cola { width: 100%; padding: 8px; font-size: 11px; border: 1px solid #ccc; border-radius: 6px; background: #fff; margin: 8px 0; box-sizing: border-box; }
        .btn-pix { background: #2e7d32; color: #fff; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; font-size: 14px; }
        .btn-pix:hover { background: #1b5e20; }
        .acoes-finais { display: flex; justify-content: space-between; gap: 10px; margin-top: 18px; }
        .acoes-finais a, .acoes-finais button { flex: 1; text-align: center; padding: 10px; border-radius: 6px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; font-size: 14px; }
    </style>
</head>
<body>
    <div class="recibo-container">
        <div class="recibo-topo">
            <h2>Quitandaria da Gôda</h2>
            <p style="margin:0; color:#555;">Recibo do Pedido <strong>#<?= $numeroPedido ?></strong></p>
            <small>Cliente: <strong><?= htmlspecialchars($clienteNome) ?></strong> • <?= date('d/m/Y H:i') ?></small>
        </div>

        <table class="lista-itens-recibo">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Qtd / Unid</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="corpo-recibo"></tbody>
        </table>

        <div class="total-destaque" id="total-recibo">Total: R$ 0,00</div>

        <div class="area-pix">
            <h3 style="margin:0 0 6px; color:#1b5e20; font-size:17px;">Pagamento via PIX (Simulação)</h3>
            <p style="margin:0; font-size:13px; color:#444;">Aponte a câmera do celular para o QR Code abaixo:</p>

            <div id="qrcode-pix"></div>

            <label style="font-size:12px; color:#555; display:block;">PIX Copia e Cola:</label>
            <input type="text" id="codigo-pix" class="campo-copia-cola" readonly>
            <button type="button" class="btn-pix" onclick="copiarCodigoPix()">Copiar Código PIX</button>
        </div>

        <div class="acoes-finais">
            <button type="button" onclick="window.print()" style="background:#ffb300; color:#1b1b1b;">Imprimir Recibo</button>
            <a href="index.php" onclick="concluirPedido()" style="background:#e8f5e9; color:#1b5e20;">Concluir e Voltar</a>
        </div>
    </div>

    <script>
        // Lê exatamente a chave 'quitandaria_carrinho' do seu script.js
        const carrinho = JSON.parse(localStorage.getItem('quitandaria_carrinho')) || [];
        const corpo = document.getElementById('corpo-recibo');
        let totalGeral = 0;

        if (carrinho.length === 0) {
            corpo.innerHTML = '<tr><td colspan="3" style="text-align:center; color:#777;">Nenhum item encontrado na sacola.</td></tr>';
        } else {
            carrinho.forEach(item => {
                const sub = item.preco * item.quantidade;
                totalGeral += sub;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong>${item.nome}</strong></td>
                    <td>${item.quantidade} ${item.unidade}</td>
                    <td>${sub.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })}</td>
                `;
                corpo.appendChild(tr);
            });
        }

        document.getElementById('total-recibo').textContent =
            'Total: ' + totalGeral.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });

        // Gera payload PIX padrão EMV simulado com o valor real da compra
        const valStr = totalGeral.toFixed(2);
        const tamVal = String(valStr.length).padStart(2, '0');
        const txid   = 'PED<?= $numeroPedido ?>';
        const tamTx  = String(txid.length + 4).padStart(2, '0');

        const payloadPix = `00020126580014BR.GOV.BCB.PIX0136quitandariadagoda@pix.com.br52040000530398654${tamVal}${valStr}5802BR5919QUITANDARIA DA GODA6006RECIFE62${tamTx}05${String(txid.length).padStart(2, '0')}${txid}6304ABCD`;

        document.getElementById('codigo-pix').value = payloadPix;

        new QRCode(document.getElementById('qrcode-pix'), {
            text: payloadPix,
            width: 190,
            height: 190,
            colorDark: '#1b5e20',
            colorLight: '#ffffff'
        });

        function copiarCodigoPix() {
            const input = document.getElementById('codigo-pix');
            input.select();
            navigator.clipboard.writeText(input.value);
            alert('Código PIX Copia e Cola copiado com sucesso!');
        }

        function concluirPedido() {
            localStorage.removeItem('quitandaria_carrinho');
        }
    </script>
</body>
</html>