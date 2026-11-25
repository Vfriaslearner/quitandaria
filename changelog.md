# Histórico de Versões (Changelog) — Quitandaria da Gôda

Todas as alterações notáveis deste projeto estão documentadas neste arquivo.

## [0.3.0] - 2026-11-24

### Adicionado (`feat` / `docs` / PHP / JavaScript / SQL)
- **Sistema de Autenticação e Controle de Acesso (RBAC):** Implementação completa em PHP com sessões (`$_SESSION`) separando os níveis de acesso entre **Cliente**, **Admin** e **Root**, garantindo isolamento de rotas e segurança entre perfis.
- **Experiência do Cliente:** Navegação completa pelo catálogo, adição dinâmica de itens à sacola via JavaScript (`localStorage`), visualização detalhada do resumo de itens selecionados e acesso à história da Quitandaria da Gôda.
- **Workspace do Administrador (`dashboard.php`):** Painel administrativo integrado ao banco de dados para cadastro de novos produtos e fornecedores, controle de entrada e saída de estoque em tempo real, indicadores de estoque baixo, vitrine de itens com maior saída e gerenciamento das mensagens enviadas pelo formulário de contato (de usuários logados ou visitantes).
- **Painel Mestre do Root (`painel_root.php`):** Acesso total às funcionalidades administrativas somado à gestão de permissões de usuários (`CLIENTE`, `ADMIN`, `ROOT`), cadastro de funcionários e monitoramento de auditoria de segurança (`log_login` e `log_logout`, registrando tentativas bem-sucedidas e falhas com IP e data/hora).
- **Integração Front-end e Back-end (Ponta a Ponta):** Modelagem e conexão finalizada com o banco de dados relacional MySQL via PHP PDO, acompanhada de validações em JavaScript, travas de segurança e testes de QA.


## [0.2.0] - 2026-11-18
### Adicionado (`feat` / `docs`)
- **Documentação completa do sistema** na pasta `docs/`:
  - Levantamento de requisitos funcionais, não funcionais, regras de negócio e histórias de usuário (`docs/requisitos.md`).
  - Diagrama Entidade-Relacionamento (`docs/der.png`) e Dicionário de Dados (`docs/banco-de-dados.md`).
  - Mapa de telas, rotas de back-end previstas e fluxo principal de navegação (`docs/telas-e-fluxos.md`) com capturas de tela (`docs/telas/`).
  - Guia técnico de instalação e configuração no XAMPP (`docs/instalacao.md`).
  - Manual do usuário final com passo a passo e FAQ (`docs/manual-usuario.md`).
- **Banco de dados estruturado:** Exportação do script SQL completo (`database/quitandaria-goda.sql`) contendo as tabelas `clientes`, `estoque`, `fornecedores`, `funcionarios`, `produtos` e `vendas`.

### Alterado (`refactor`)
- Padronização da estrutura de diretórios do repositório (`docs/` e `database/`).
- Atualização do `README.md` com instruções gerais e links para a documentação.

---

## [0.1.0] - 2026-11-11
### Adicionado (`feat`)
- Criação inicial do repositório e estrutura front-end das telas (`index.php`, `sobre.php`, `contatos.php`, `cadastro.php`, `login.php`, `esqueceu_senha.php`, `dashboard.php` e `produtos.php`).
- Modelagem inicial do banco de dados `banco_quitandaria_goda` no phpMyAdmin/MySQL.
