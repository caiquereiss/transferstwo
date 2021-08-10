# TransferTwo:
 ## Versões:
 PHP - 7.4.0
 Laravel : 8.53.1
 ### Passo a Passo:

 1 - Clonar o repositório: TransferTwo

 2 - Dentro do projeto, precisamos instalar a dependencia do autoload:  composer install.

 3 - Renomear o arquivo .env.example para .env (Existem algumas configurações especificar do projeto la dentro).

 4 - Necessário que tenha o serviço do mysql na sua maquina.

 5 - Tenha um schema com nome transf e caso queira mudar, basta alterar no arquivo .env previamente renomeado.

 6 - Tendo feito os passoa anteriores. Deve rodar o comando que vai ajudar a popular o banco de dados: php artisan migrate:fresh --seed

 7 - Rodar o comando php artisan serve para iniciar o servidor, mas antes deve conferir se a porta 8000 está sendo utilizado por outro processo.

8 - Abra outro terminal no seu editor e rode o comando : php artisan queue:work --tries=3. Esse comando se Responsabilizará  em olhar a fila de jobs.

9 - Ao realizar todos os passos supracitado, está pronto para testar a aplicação no insominia, postman.

Rotas:
 http://localhost:8000/api/transaction
 http://localhost:8000/api/user
#### Sobre a aplicação: 

Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles.


Requisitos:

Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.

Lojistas só recebem transferências, não enviam dinheiro para ninguém.

Validar se o usuário tem saldo antes da transferência.

Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).

A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.

No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify).

Este serviço deve ser RESTFul.



