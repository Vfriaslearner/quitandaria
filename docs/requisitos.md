## Requisitos Funcionais (RF)

COD     Descrição                                                                                              Prioridade
RF01   O sistema deve permitir que o usuário se cadastre  com nome , telefone e endereço e senha               Alta
RF02   O sistema deve permitir que o usuário adicione produtos ao carrinho                                     Alta
RF03   O sistema deve permitir que a administração da Quitandaria altere o status do Pedido para entrega       Alta
RF04   O sistema deve mostrar o histórico de pedidos do usuário                                                Média
RF05   O sistema deve sugerir a recompra dos ítens que o usuário  compra com frequência                        Média
RF06   O sistema deve fornecer descontos aos usuários  (a Definir)                                             Média

## Requisitos Não Funcionais (RNF)

COD          Descrição

RNF01       As senhas devem ser guardadas com password_hash().
RNF02       O sistema deve ser feito em PHP 8 e MySql 8
RNF03       Produto com estoque zero não aparece no cardápio

## Regras de Negócio (RN)

COD        Descrição

RN01      Produto com estoque zerado não aparece no catálogo
RN02      A política de cancelamento de compras ainda será definida
RN03      Os horários de pedidos ainda serão definidos. 


## Histórias de Usuário 
1. Como usuário, quero  poder entrar em um site de um local que eu conheça fisicamente (porque o ponto existe) e saiba que posso comprar tranquilamente frutas ,verduras e itens de mercearia de qualidade no conforto da minha casa. Principalmente as frutas e verduras.
2. Se não for posível ir até o ponto físico, é possível acompanhar 

 a)usuário entra  no site, escolhe o que precisa, paga de forma facilitada via pix ou cartão
 b)usuário visualiza a o status da entrega dos seus ítens: montando feira, empacotando feira, feira a caminho, sua feira chegou!
 c)usuário espera sua feira chegar no conforto de sua casa enquanto faz outras atividades do dia.
 
