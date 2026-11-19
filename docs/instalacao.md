# Guia de Instalação — Quitandaria da Gôda

Este guia descreve o passo a passo completo para configurar e executar o projeto **Quitandaria  da Gôda** em um ambiente local utilizando o XAMPP.

---

## 1. Requisitos do Sistema

Antes de iniciar, certifique-se de ter instalado em seu computador:
* **XAMPP** (versão 8.2 ou superior) contendo **Apache**, **PHP 8.2+** e **MariaDB / MySQL**.
-link do site:https://www.apachefriends.org/pt_br/index.html para download e instalação.
* **Navegador Web** atualizado (Google Chrome, Microsoft Edge ou Firefox).
* **Git** (opcional, caso deseje clonar o repositório via terminal).
-Link do site :https://git-scm.com/  para download e instalação.

---

## 2. Passo a Passo de Instalação

### Passo 1: Baixar os arquivos do projeto
1. Acesse o repositório do projeto no GitHub. (**link para acesso**:https://github.com/Vfriaslearner/quitandaria/tree/master)
2. Clique no botão verde **Code** e selecione **Download ZIP** (ou execute `git clone` no terminal).
3. Extraia o conteúdo da pasta dentro do diretório público do XAMPP:
   ```text
   C:\xampp\htdocs\quitandaria

### Passo 2: Iniciar  os Serviços no XAMPP

1. Abra o XAMPP Control Panel
2. Clique em Start ao lado do módulo Apache
3. Clique em Start ao lado do módulo MySQL
4. Aguarde ambos ficarem destacados em verde

## 3. Criar e importar Banco de Dados

1.Ao lado de MYSQL, onde você clicou em start, agora vai ter a opção stop. E ao lado direito dele tem um botão que se chama admin. clique nele.
2.Após o navegador abrir , copie esse endereço (http://localhost/phpmyadmin) e cole na URL do navegador e aperte enter.
3.No menu lateral esquerdo,clique em Novo (ou na aba Banco de dados)
4.No campo Nome do Banco de Dados, digite exatamente: banco_quitandaria_goda
5.Selecione o agrupamento  utf8mb4_general_ci  e clique em criar.
6.Com o banco banco_quitandaria_goda selecionado, clique na aba Importar no menu superior.
7.Clique em Escolher arquivo, navegue até a pasta do projeto e selecione o script:database/quitandaria-goda.sql
8.Role até o final da página e clique em Importar (ou Executar). Todas as 6 tabelas (clientes, estoque, fornecedores, funcionarios, produtos e vendas) serão criadas automaticamente.

## 4.Acessando ao Sistema

1.Com o Apache e o MySQL ativos e o banco importado, abra o navegador e acesse: http://localhost/quitandaria/index.php



