# Biblioteca de integração PagHiper para PHP - Atualizada 2022 - Compatível com Laravel 8

## Autor do repositório original: Pedro Lima (@webmasterdro)
[Link do repositório original](https://github.com/webmasterdro/paghiper-php-sdk)

## Descrição

Utilizando essa biblioteca você pode integrar o PagHiper no seu sistema e utilizar os recursos que o PagHiper fornece em sua API, deixando seu código mais legível e manutenível.

**Esta biblioteca tem suporte testado aos seguintes recursos: (possui vários outros, mas não testei e nem mantenho)**
- [Receber notificações automáticas (Retorno Automático)](https://dev.paghiper.com/reference#qq)
- [Pix](https://dev.paghiper.com/reference#emiss%C3%A3o-de-pix-paghiper)

## Instalação

Para usar em seu projeto é necessário alterar o seu composer.json da seguinte forma:
![ComposerJSON](https://i.imgur.com/AZ7W7Fk.png)

### Compatibilidade

 Versão | KevinEduardo/paghiper-php-sdk | PHP | guzzlehttp/guzzle
:---------|:----------|:----------|:----------
 **latest**  | `KevinEduardo/paghiper-php-sdk` | PHP >= 7.2 | Guzzle >= 7


## Utilizando

Antes de utilizar, obtenha suas credenciais (`apiKey` e `token`) em [https://www.paghiper.com/painel/credenciais/](https://www.paghiper.com/painel/credenciais/)

### Pix

**Para utilizar a nova modalidade de pagamento (PIX)** você só precisa fazer isto:

```php
$paghiper = new PagHiper('api_key', 'token', 'pix');
$paghiper->pix()->create([
    'order_id' => 'ABC-456-789',
    'payer_name' => 'Pedro Lima',
    'payer_email' => 'comprador@email.com',
    'payer_cpf_cnpj' => '1234567891011', // CPF Inválido - vai gerar um erro, portanto altere para um válido
    'days_due_date' => '3',
    'items' => [[
        'description' => 'Teste',
        'quantity' => 1,
        'item_id' => 'e24fc781-f543-4591-a51c-dde972e8e0af',
        'price_cents' => '1000'
    ]]
]);
$paghiper->pix()->status($transaction_id);
$paghiper->pix()->cancel($transaction_id);
$paghiper->pix()->notification($_POST['notification_id'], $_POST['idTransacao']);
```

### Emissão de Boleto

**Para emitir um boleto você pode fazer da seguinte maneira:**

```php
use KevinEduardo\PagHiper\PagHiper;

$paghiper = new PagHiper('api_key', 'token');
$transaction = $paghiper->billet()->create([
    'order_id' => 'ABC-456-789',
    'payer_name' => 'Pedro Lima',
    'payer_email' => 'comprador@email.com',
    'payer_cpf_cnpj' => '1234567891011',
    'type_bank_slip' => 'boletoa4',
    'days_due_date' => '3',
    'items' => [[
        'description' => 'Macbook',
        'quantity' => 1,
        'item_id' => 'e24fc781-f543-4591-a51c-dde972e8e0af',
        'price_cents' => '1000'
    ]]
]);
```

Você pode obter a lista de dados que você pode enviar no seguinte link: [https://dev.paghiper.com/reference#gerar-boleto](https://dev.paghiper.com/reference#gerar-boleto)

**Para cancelar um boleto:**

```php
$transaction = $paghiper->billet()->cancel('JKP03X9KN0RELVLH');
```
**Para consultar o status de um boleto:**

```php
$transaction = $paghiper->billet()->status('JKP03X9KN0RELVLH');
```

**Para gerar múltiplos boletos em único PDF:**

```php
$transaction = $paghiper->billet()->multiple([
    'id_transacao'
], 'boletoCarne');
```

**Para obter informações do pagamento via retorno automático:**

```php
$transaction = $paghiper->notification()->response($_POST['notification_id'], $_POST['idTransacao']);
```

**Para obter a lista de suas contas bancárias:**

```php
$banckAccounts = $paghiper->banking()->accounts();
```

**Para realizar um saque:**

```php
$banckAccounts = $paghiper->banking()->withdraw('id_conta_bancaria');
```
