# Dicionário de Dados — Quitandaria da Gôda

Este documento descreve a estrutura completa das **10 tabelas**, colunas, tipos de dados e relacionamentos do banco de dados `banco_quitandaria_goda`.

---

## 1. Tabela: `fornecedores`
Registra as empresas ou produtores rurais que fornecem mercadorias para a quitandaria.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_fornecedor` | INT, AUTO_INCREMENT | Sim | PK | Identificador único do fornecedor |
| `nome` | VARCHAR(100) | Sim | UNIQUE | Razão social ou nome fantasia do fornecedor (não permite duplicados) |
| `email` | VARCHAR(100) | Sim | | E-mail comercial para contato e reposição de pedidos |
| `telefone` | VARCHAR(15) | Sim | | Telefone comercial com DDD do fornecedor |
| `cnpj` | VARCHAR(14) | Não | UNIQUE | Cadastro Nacional da Pessoa Jurídica (apenas números, opcional) |

---

## 2. Tabela: `usuarios`
Gerencia as credenciais de autenticação e os níveis de permissão (RBAC) de todos os usuários do sistema.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_usuario` | INT, AUTO_INCREMENT | Sim | PK | Identificador único da conta de usuário |
| `nome` | VARCHAR(100) | Sim | | Nome de exibição do usuário no sistema |
| `email` | VARCHAR(100) | Sim | UNIQUE | E-mail utilizado para login (único no sistema) |
| `senha` | VARCHAR(255) | Sim | | Senha criptografada (`password_hash`) para autenticação |
| `perfil` | ENUM('CLIENTE','ADMIN','ROOT') | Não | | Nível de acesso do usuário (padrão: `'CLIENTE'`) |

---

## 3. Tabela: `produtos`
Catálogo de itens comercializados pela quitandaria, vinculados aos seus respectivos fornecedores.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_produto` | INT, AUTO_INCREMENT | Sim | PK | Identificador único do produto |
| `id_fornecedor` | INT | Sim | FK → `fornecedores.id_fornecedor` | Fornecedor responsável pelo abastecimento do item |
| `unidade` | VARCHAR(20) | Sim | | Unidade de medida comercial (ex: `kg`, `un`, `bandeja`, `barra`) |
| `imagem` | VARCHAR(255) | Não | | Caminho ou nome do arquivo da foto do produto (padrão: `NULL`) |
| `nome` | VARCHAR(75) | Sim | | Nome comercial do produto (ex: Cenoura, Bananas, Queijo Coalho) |
| `categoria` | VARCHAR(50) | Sim | | Seção ou categoria do item (ex: Legumes e Raízes, Frutas, Mercearia) |
| `preco` | DECIMAL(10,2) | Sim | | Preço de venda em reais conforme a unidade |
| `quantidade_estoque` | INT | Sim | | Saldo atual disponível em estoque |

---

## 4. Tabela: `clientes`
Armazena os dados cadastrais e de entrega dos clientes vinculados a uma conta de usuário.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_cliente` | INT, AUTO_INCREMENT | Sim | PK | Identificador único do perfil de cliente |
| `id_usuario` | INT | Sim | FK → `usuarios.id_usuario` (UNIQUE) | Conta de acesso associada ao cliente (relação 1:1) |
| `nome` | VARCHAR(100) | Sim | | Nome completo do cliente |
| `email` | VARCHAR(100) | Sim | UNIQUE | Endereço de e-mail de contato do cliente |
| `telefone` | VARCHAR(15) | Sim | | Número de telefone com DDD para contato/entrega |
| `cpf` | CHAR(11) | Não | UNIQUE | Cadastro de Pessoa Física do cliente (apenas números, opcional) |
| `endereco` | VARCHAR(200) | Sim | | Endereço completo para entrega de pedidos |

---

## 5. Tabela: `vendas`
Registra o histórico de compras realizadas pelos clientes no sistema.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_venda` | INT, AUTO_INCREMENT | Sim | PK | Número único identificador da venda |
| `id_cliente` | INT | Sim | FK → `clientes.id_cliente` | Cliente que efetuou a compra |
| `id_produto` | INT | Sim | FK → `produtos.id_produto` | Produto adquirido na venda |
| `quantidade` | INT | Sim | | Quantidade de unidades/quilos comprados |
| `data_venda` | DATETIME | Sim | | Data e hora exatas em que a venda foi registrada |

---

## 6. Tabela: `estoque`
Controla o histórico de movimentações (entradas e saídas) de mercadorias por produto.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_estoque` | INT, AUTO_INCREMENT | Sim | PK | Identificador único da movimentação de estoque |
| `id_produto` | INT | Sim | FK → `produtos.id_produto` | Produto que sofreu alteração de saldo |
| `quantidade_movimentada` | INT | Sim | | Quantidade adicionada ou retirada na operação |
| `tipo` | ENUM('ENTRADA','SAIDA') | Não | | Natureza da movimentação (`ENTRADA` de fornecedor ou `SAIDA` por venda/perda) |
| `data_movimentacao` | DATETIME | Não | | Data e hora da movimentação (padrão: `CURRENT_TIMESTAMP`) |

---

## 7. Tabela: `funcionarios`
Armazena os dados cadastrais, cargos e remuneração dos colaboradores da quitandaria.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_funcionario` | INT, AUTO_INCREMENT | Sim | PK | Identificador único do funcionário |
| `nome` | VARCHAR(100) | Sim | | Nome completo do colaborador |
| `email` | VARCHAR(100) | Sim | UNIQUE | E-mail corporativo ou de contato do colaborador |
| `telefone` | VARCHAR(15) | Sim | | Telefone com DDD do colaborador |
| `cpf` | CHAR(11) | Não | UNIQUE | CPF do colaborador (apenas números, opcional) |
| `cargo` | VARCHAR(50) | Sim | | Função exercida na quitandaria (ex: Caixa, Estoquista, Gerente) |
| `salario` | DECIMAL(10,2) | Sim | | Valor do salário mensal em reais |

---

## 8. Tabela: `mensagens_contato`
Armazena as mensagens enviadas pelo formulário de contato, tanto por visitantes anônimos quanto por usuários autenticados.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_mensagem` | INT, AUTO_INCREMENT | Sim | PK | Identificador único da mensagem recebida |
| `id_usuario` | INT | Não | FK → `usuarios.id_usuario` | ID do usuário caso estivesse logado no envio (`NULL` para visitantes) |
| `nome` | VARCHAR(100) | Sim | | Nome informado pelo remetente |
| `email` | VARCHAR(100) | Sim | | E-mail de retorno informado pelo remetente |
| `assunto` | VARCHAR(100) | Sim | | Título ou categoria do contato (ex: Dúvida, Sugestão, Reclamação) |
| `mensagem` | VARCHAR(1000) | Sim | | Conteúdo textual completo da mensagem enviada |
| `data_envio` | DATETIME | Não | | Data e hora do envio da mensagem (padrão: `CURRENT_TIMESTAMP`) |

---

## 9. Tabela: `log_login`
Registra a auditoria de todas as tentativas de autenticação (bem-sucedidas ou falhas) para monitoramento de segurança pelo perfil `ROOT`.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_log` | INT, AUTO_INCREMENT | Sim | PK | Identificador único do registro de tentativa de login |
| `id_usuario` | INT | Não | FK → `usuarios.id_usuario` | Usuário correspondente ao e-mail, se existir no banco (`NULL` se inválido) |
| `email_informado` | VARCHAR(100) | Sim | | E-mail digitado no formulário no momento da tentativa |
| `ip_acesso` | VARCHAR(45) | Sim | | Endereço IP (IPv4 ou IPv6) de origem da requisição |
| `sucesso` | TINYINT(1) | Não | | Indicador de resultado (`1` para login aprovado, `0` para falha/senha incorreta) |
| `data_hora` | DATETIME | Não | | Data e hora exatas da tentativa de login (padrão: `CURRENT_TIMESTAMP`) |

---

## 10. Tabela: `log_logout`
Registra o encerramento de sessões dos usuários autenticados para rastreabilidade de acesso.

| Coluna | Tipo | Obrigatório | Chave | Descrição |
| :--- | :--- | :---: | :---: | :--- |
| `id_log` | INT, AUTO_INCREMENT | Sim | PK | Identificador único do registro de saída |
| `id_usuario` | INT | Não | FK → `usuarios.id_usuario` | Usuário que encerrou a sessão |
| `ip_acesso` | VARCHAR(45) | Sim | | Endereço IP (IPv4 ou IPv6) de onde o logout foi solicitado |
| `data_hora` | DATETIME | Não | | Data e hora exatas do encerramento da sessão (padrão: `CURRENT_TIMESTAMP`) |