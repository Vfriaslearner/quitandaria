# Histórico de Versões (Changelog) — Quitandaria Godá

Todas as alterações notáveis deste projeto estão documentadas neste arquivo.

---

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
