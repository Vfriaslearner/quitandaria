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
3. No phpMyAdmin, importe `database/quitandaria.sql`.
4. Acesse http://localhost/quitandaria


ESCOLA TÉCNICA ESTADUAL PORTO DIGITAL
Curso Técnico em Desenvolvimento de Sistemas
Disciplinas: Programação em Novas Tecnologias · Engenharia de Software
Aluno desenvolvedor: Vitor Pereira Farias
Minicurso: Documentação de Sistemas
Novembro de 2026

## Usuário de teste

- E-mail: vpf1@etepd.com
- Senha: xxxxxxxxxxxxx
## Documentação

- Requisitos: `docs/requisitos.md`
- Banco de dados: `docs/banco-de-dados.md`
- Manual do usuário: `docs/manual-usuario.md`

## Equipe

- Vitor Pereira Farias — back-end (PHP)
- Vitor Pereira Farias — banco de dados (e o resto)

## Requisitos Funcionais (RF)

COD     Descrição                                                                                              Prioridade
RF01   O sistema deve permitir que o usuário se cadastre  com nome , telefone e endereço e senha               Alta
RF02   O sistema deve permitir que o usuário adicione produtos ao carrinho                                     Alta
RF03   O sistema deve permitir que a administração da Quitandaria altere o status do Pedido para entrega       Alta
RF04   O sistema deve mostrar o histórico de pedidos do usuário                                                Média
RF05   O sistema deve sugerir a recompra dos ítens que o usuário  compra com frequência                        Média
RF06   O sistema deve fornecer descontos aos usuários  (a Definir) 

## Requisitos Não Funcionais (RNF)

COD          Descrição

RNF01       As senhas devem ser guardadas com password_hash().
RNF02      O sistema deve ser feito em PHP 8 e MySql 8

## Regras de Negócio (RN)

COD        Descrição

RN01      Produto com estoque zerado não aparece no catálogo
RN02      A política de cancelamento de compras ainda será definida
RN03      Os horários de pedidos ainda serão definidos. 



        

  - Carla Mendes — front-end e documentação
Projeto do curso técnico em Desenvolvimento de Sistemas —
ETE Porto Digital, 2026.
