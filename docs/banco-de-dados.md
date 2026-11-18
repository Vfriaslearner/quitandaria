# Dicionário de Dados — Quitandaria  da Gôda

Este documento descreve a estrutura de todas as tabelas e colunas do banco de dados `banco_quitandaria_goda`.

---

## Tabela: `clientes`
Armazena os dados cadastrais dos clientes da quitandaria.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_cliente` | INT(11), AUTO_INCREMENT | Sim | PK | Identificador único do cliente |
| `nome` | VARCHAR(100) | Sim | UNIQUE | Nome completo do cliente (não permite duplicados) |
| `email` | VARCHAR(100) | Sim | UNIQUE | Endereço de e-mail para contato ou acesso |
| `telefone` | VARCHAR(15) | Sim | | Número de telefone com DDD do cliente |
| `cpf` | CHAR(11) | Não | UNIQUE | Cadastro de Pessoa Física do cliente (apenas números, opcional) |
| `endereco` | VARCHAR(200) | Sim | | Endereço completo para entrega ou registro |

---

## Tabela: `estoque`
Controla a movimentação e o saldo de itens disponíveis por produto.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_estoque` | INT(11), AUTO_INCREMENT | Sim | PK | Identificador único do registro de estoque |
| `id_produto` | INT(11) | Sim | FK → `produtos.id_produto` | Produto ao qual o saldo de estoque pertence |
| `quantidade` | INT(11) | Sim | | Quantidade atual disponível deste produto |

---

## Tabela: `fornecedores`
Registra as empresas ou produtores que fornecem mercadorias para a quitandaria.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_fornecedor` | INT(11), AUTO_INCREMENT | Sim | PK | Identificador único do fornecedor |
| `nome` | VARCHAR(100) | Sim | UNIQUE | Razão social ou nome fantasia do fornecedor |
| `email` | VARCHAR(100) | Sim | | E-mail comercial para contato e pedidos |
| `telefone` | VARCHAR(15) | Sim | | Telefone comercial do fornecedor |
| `cnpj` | VARCHAR(14) | Não | UNIQUE | Cadastro Nacional da Pessoa Jurídica (apenas números, opcional) |

---

## Tabela: `funcionarios`
Armazena os dados cadastrais, cargos e salários dos colaboradores da quitandaria.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_funcionario` | INT(11), AUTO_INCREMENT | Sim | PK | Identificador único do funcionário |
| `nome` | VARCHAR(100) | Sim | | Nome completo do colaborador |
| `email` | VARCHAR(100) | Sim | UNIQUE | E-mail do colaborador |
| `telefone` | VARCHAR(15) | Sim | | Telefone de contato do colaborador |
| `cpf` | CHAR(11) | Não | UNIQUE | CPF do colaborador (apenas números, opcional) |
| `cargo` | VARCHAR(50) | Sim | | Função exercida na quitandaria (ex: caixa, estoquista) |
| `salario` | DECIMAL(10,2) | Sim | | Valor da remuneração mensal em reais |

---

## Tabela: `produtos`
Catálogo de itens comercializados pela quitandaria.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_produto` | INT(11), AUTO_INCREMENT | Sim | PK | Identificador único do produto |
| `nome` | VARCHAR(75) | Sim | | Nome comercial do produto (ex: Banana Prata, Tomate) |
| `categoria` | VARCHAR(50) | Sim | | Classificação do item (ex: Frutas, Verduras, Legumes) |
| `preco` | DECIMAL(10,2) | Sim | | Preço unitário ou por quilo de venda em reais |
| `quantidade_estoque` | INT(11) | Sim | | Quantidade total em estoque registrada no cadastro do produto |

---

## Tabela: `vendas`
Registra as compras realizadas pelos clientes no sistema.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_venda` | INT(11), AUTO_INCREMENT | Sim | PK | Número único identificador da venda |
| `id_cliente` | INT(11) | Sim | FK → `clientes.id_cliente` | Cliente que realizou a compra |
| `id_produto` | INT(11) | Sim | FK → `produtos.id_produto` | Produto adquirido na venda |
| `quantidade` | INT(11) | Sim | | Quantidade de itens comprados |
| `data_venda` | DATETIME | Sim | | Data e hora exatas em que a venda foi registrada |
