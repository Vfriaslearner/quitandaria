# Telas, Rotas e Fluxos — Quitandaria Gôda

Este documento apresenta o mapa de todas as telas existentes no sistema, as rotas de processamento previstas para o back-end e o fluxo principal de navegação do usuário.

---

## 1. Mapa de Telas

| Tela | Arquivo | Quem acessa | O que faz |
| :--- | :--- | :--- | :--- |
| Página Inicial (Home) | `index.php` | Todos | Apresentação da quitandaria e links de navegação principais. |
| Sobre Nós | `sobre.php` | Todos | Exibe a história, missão e informações institucionais da quitandaria. |
| Contato | `contatos.php` | Todos | Formulário e canais de atendimento para clientes entrarem em contato. |
| Cadastro | `cadastro.php` | Visitante | Formulário para criação de nova conta de usuário/cliente no sistema. |
| Login | `login.php` | Todos | Tela de autenticação com e-mail e senha para entrar no sistema. |
| Recuperar Senha | `esqueceu_senha.php` | Todos | Permite solicitar a redefinição de senha em caso de esquecimento. |
| Painel (Dashboard) | `dashboard.php` | Usuário logado | Área restrita com visão geral, atalhos e gerenciamento do sistema. |
| Produtos | `produtos.php` | Todos / Logado | Exibe o catálogo de produtos disponíveis (frutas, verduras e legumes). |

---

## 2. Arquivos de Processamento (Rotas de Back-end)
*Arquivos PHP responsáveis por receber os dados dos formulários via POST, validar, gravar no banco MySQL e redirecionar o usuário.*

| Arquivo | Método | Recebe | Faz | Redireciona para |
| :--- | :---: | :--- | :--- | :--- |
| `processa_cadastro.php` | POST | `nome`, `email`, `telefone`, `cpf`, `endereco`, `senha` | Valida os dados e insere um novo cliente na tabela `clientes`. | `login.php` |
| `autenticar.php` | POST | `email`, `senha` | Verifica as credenciais no banco com `password_verify()` e inicia a sessão. | `dashboard.php` ou volta para `login.php` com erro |
| `processa_contato.php` | POST | `nome`, `email`, `mensagem` | Registra ou envia a mensagem de contato do visitante. | `contatos.php` |

---

## 3. Fluxo Principal: Cadastro e Acesso ao Sistema

```text
[ Página Inicial ] ──> [ Login ] ──> ( Já possui conta? )
   (index.php)        (login.php)             │
                                 ┌────────────┴────────────┐
                                Não                       Sim
                                 │                         │
                                 ▼                         ▼
                           [ Cadastro ]          ( Senha confere? )
                          (cadastro.php)                   │
                                 │            ┌────────────┴────────────┐
                                 │           Não                       Sim
                                 │            │                         │
                                 │            ▼                         ▼
                                 │    [ Volta ao Login ]         [ Dashboard ]
                                 │                              (dashboard.php)
                                 └──────────────────────────────────────┘
                                       (Após cadastrar, faz login)
