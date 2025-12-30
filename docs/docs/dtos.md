# Data Transfer Objects (DTOs)

A biblioteca `nfse-php` utiliza DTOs (Data Transfer Objects) para representar a estrutura complexa da NFS-e Nacional. Esses objetos facilitam a manipulação de dados, garantem a integridade através de validações e permitem a geração automática de tipos para o frontend.

## Referência de Tipos

Para uma documentação detalhada de cada DTO, incluindo suas propriedades e relacionamentos, consulte a seção **[Tipos (DTOs)](./types/main-documents)**.

## Como Instanciar DTOs

Existem duas formas principais de criar instâncias dos DTOs:

### 1. Usando o método `from()`

Ideal quando você já confia na origem dos dados ou quer apenas mapear um array.

```php
$dps = DpsData::from([
    'infDps' => [
        'tpAmb' => 2,
        // ...
    ]
]);
```

### 2. Usando `validateAndCreate()`

Recomendado para dados vindos de requisições externas, pois dispara uma exceção se as regras de validação não forem atendidas.

```php
try {
    $dps = DpsData::validateAndCreate($requestData);
} catch (\Illuminate\Validation\ValidationException $e) {
    // Tratar erros
}
```

## Mapeamento Automático

Graças ao `spatie/laravel-data`, todos os DTOs suportam mapeamento automático de nomes.

> [!TIP]
> Utilizamos o atributo `#[MapInputName]` para vincular o nome técnico do layout nacional (ex: `dhEmi`) à propriedade PHP legível. Isso permite que você trabalhe com nomes amigáveis no seu código enquanto mantém a compatibilidade com o padrão oficial.
