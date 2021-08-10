# TransferTwo:

 ## Versões:
- PHP - 7.4.0
- Laravel : 8.53.1

### Passo a Passo:
- Execute o comando:  `composer install`
- Renomear o arquivo *.env.example*  para *.env*.
- Crie um *schema*  (utf-8) no MySQL com nome *transf* .
- Execute o comando para popular o banco de dados: `php artisan migrate --seed`
- Execute o comando `php artisan serve` para iniciar o servidor.
- Abra outro terminal no seu editor e execute o comando : `php artisan queue:work --tries=3` para executar a fila de *jobs*.
- Pronto, basta para testar a aplicação no Insominia ou Postman.
