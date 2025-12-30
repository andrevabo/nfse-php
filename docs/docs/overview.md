# Visão Geral: nfse-php

O `nfse-php` é uma biblioteca agnóstica de framework que fornece os blocos de construção para interagir com a NFSe Nacional.

## Responsabilidades

1.  **Modelagem de Dados**: Define as classes que representam o domínio (Nota Fiscal, DPS, Pessoas).
2.  **Contratos**: Define interfaces para comunicação (`ProviderInterface`) e assinatura (`SignerInterface`).
3.  **Validação**: Garante que os dados estejam em conformidade com as regras de negócio básicas antes do envio.

## Tecnologia de DTOs

Utilizamos a biblioteca `spatie/laravel-data` para definição de DTOs robustos. Isso nos permite mapear os nomes complexos do layout nacional (ex: `endNac.cMun`) para propriedades PHP legíveis.

### Exemplo de Implementação

```php
namespace Nfse\Models\Common;

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

        #[MapInputName('nro')]
        public ?string $numero,

        #[MapInputName('xBairro')]
        public ?string $bairro,
    ) {}
}
```

## Instalação

```bash
composer require nfse-nacional/nfse-php
```

## Uso Básico

```php
use Nfse\Models\Dps;

$dps = new Dps();
$dps->setSerie('E');
// ...
```
