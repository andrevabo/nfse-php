# Visão Geral: nfse-php

O `nfse-php` é uma biblioteca agnóstica de framework que fornece os blocos de construção para interagir com a NFS-e Nacional.

## Responsabilidades

1.  **Modelagem de Dados**: Define as classes que representam o domínio (Nota Fiscal, DPS, Pessoas) através de DTOs robustos.
2.  **Validação**: Garante que os dados estejam em conformidade com as regras de negócio básicas e o schema nacional antes do envio.
3.  **Geração de Tipos**: Facilita a integração com o frontend através da geração automática de tipos TypeScript.

## Tecnologia de DTOs

Utilizamos a biblioteca `spatie/laravel-data` para definição de DTOs. Isso nos permite mapear os nomes complexos do layout nacional (ex: `endNac.cMun`) para propriedades PHP legíveis e tipadas.

### Exemplo de DTO

```php
namespace Nfse\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class EnderecoData extends Data
{
    public function __construct(
        #[MapInputName('endNac.cMun')]
        public ?string $codigoMunicipio,

        #[MapInputName('endNac.CEP')]
        public ?string $cep,

        #[MapInputName('xLgr')]
        public ?string $logradouro,
        // ...
    ) {}
}
```

## Instalação

```bash
composer require nfse-nacional/nfse-php
```

## Uso Básico

A biblioteca permite criar e validar documentos de forma simples:

```php
use Nfse\Dto\DpsData;

// Criando a partir de um array de dados
$dps = DpsData::from([
    'infDps' => [
        'tpAmb' => 2,
        'dhEmi' => '2023-10-27T10:00:00',
        // ...
    ]
]);

// Validando os dados
DpsData::validate($dps->toArray());
```
