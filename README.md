
# Quitandaria da Gôda

Sistema web completo de e-commerce e gestão interna para hortifrúti e mercearia, desenvolvido com integração ponta a ponta entre Front-end e Back-end.

## Tecnologias Utilizadas
- **Front-end:** HTML5, CSS3, JavaScript (ES6+ / `localStorage`)
- **Back-end:** PHP 8+ com PDO (Prepared Statements)
- **Banco de Dados:** MySQL

## Níveis de Acesso (RBAC)
- **Cliente (`CLIENTE`):** Navegação pelos produtos, montagem dinâmica da sacola de compras, visualização de resumo do pedido e envio de mensagens de contato.
- **Administrador (`ADMIN`):** Acesso ao `dashboard.php` com indicadores dinâmicos de estoque, cadastro de produtos e fornecedores, movimentação de estoque (`ENTRADA`/`SAIDA`) e leitura/exclusão de mensagens de contato.
- **Root (`ROOT`):** Acesso irrestrito ao sistema, incluindo o `painel_root.php` para gerenciamento de perfis de usuários, cadastro de funcionários e auditoria de logs de login e logout.

## Estrutura Principal do Projeto
- `pages/` (ou raiz PHP): `index.php`, `produtos.php`, `login.php`, `cadastro.php`, `dashboard.php`, `painel_root.php`, `contato.php`
- `config/conexao.php`: Configuração da conexão PDO com o MySQL
- `includes/header.php`: Cabeçalho dinâmico adaptado ao perfil da sessão ativa
- `css/estilo.css`: Folha de estilos principal do sistema
- `js/script.js`: Lógica da sacola de compras, cálculos em tempo real e interações de interface
- `sql/`: Scripts de criação e povoamento do banco de dados




# Quitandaria da Gôda

Sistema web de quitandaria/feira online. Navegue, escolha e compre 
legumes,hortaliças, verduras e ítens de mercearia e  as receba no conforto da sua casa.

## Funcionalidades

- Cadastro e login de Clientes
- Cardápio com preços e fotos
- Montagem e envio de pedidos
- Saldo Final com mostra de ítens,valor e condições de pagamento.

## Tecnologias

- PHP 8.2
- MySQL 8
- HTML, CSS e JavaScript
- XAMPP (ambiente local)

## Como rodar

1. Instale o XAMPP e ligue Apache e MySQL.
2. Copie a pasta `quitandaria` para `C:\xampp\htdocs`.
3. No phpMyAdmin, importe `database/banco_quitandaria_goda.sql`.
4. Acesse http://localhost/quitandaria/index.php


## Usuário de teste

- E-mail: vpf1@etepd.com
- Senha: xxxxxxxxxxxxx
## Documentação

- Requisitos: `docs/requisitos.md`
- Banco de dados (estrutura): `docs/banco-de-dados.md`
- Manual do usuário: `manual-usuario.md`
- DER: `der.png´

## Equipe

- Vitor Pereira Farias — back-end (PHP)
- Vitor Pereira Farias — banco de dados (e o resto)

ESCOLA TÉCNICA ESTADUAL PORTO DIGITAL
Curso Técnico em Desenvolvimento de Sistemas
Disciplinas: Programação em Novas Tecnologias · Engenharia de Software
Aluno desenvolvedor: Vitor Pereira Farias
Minicurso: Documentação de Sistemas
Novembro de 2026





        

  - Vitor Pereira Farias — front-end e documentação
Projeto do curso técnico em Desenvolvimento de Sistemas —
ETE Porto Digital, 2026.
