# DocumentGenerator

A classe `DocumentGenerator` gera CPFs e CNPJs **válidos** aleatórios, com dígitos verificadores corretos. Esta classe é destinada **exclusivamente para ambientes de teste e desenvolvimento**.

> ⚠️ **ATENÇÃO:** Nunca use documentos gerados por esta classe em ambiente de produção ou para fins oficiais. Os documentos são válidos matematicamente, mas não representam pessoas ou empresas reais.

## Instalação

Esta classe faz parte do pacote principal e está disponível no namespace `Nfse\Support`.

```php
use Nfse\Support\DocumentGenerator;
```

## Métodos Disponíveis

### generateCpf()

Gera um CPF válido aleatório com dígitos verificadores corretos.

```php
$cpf = DocumentGenerator::generateCpf();
echo $cpf; // Ex: 12345678901

$cpfFormatado = DocumentGenerator::generateCpf(true);
echo $cpfFormatado; // Ex: 123.456.789-01
```

**Assinatura:**

```php
public static function generateCpf(bool $formatted = false): string
```

**Parâmetros:**

-   `$formatted` (bool) - Se `true`, retorna formatado (XXX.XXX.XXX-XX). Padrão: `false`

**Retorno:**

-   (string) CPF válido com 11 dígitos (ou 14 caracteres se formatado)

**Características:**

-   ✅ Dígitos verificadores **corretos**
-   ✅ Passa em validações matemáticas
-   ✅ Números aleatórios
-   ❌ **NÃO** representa pessoa real

---

### generateCnpj()

Gera um CNPJ válido aleatório com dígitos verificadores corretos.

```php
$cnpj = DocumentGenerator::generateCnpj();
echo $cnpj; // Ex: 12345678000195

$cnpjFormatado = DocumentGenerator::generateCnpj(true);
echo $cnpjFormatado; // Ex: 12.345.678/0001-95
```

**Assinatura:**

```php
public static function generateCnpj(bool $formatted = false): string
```

**Parâmetros:**

-   `$formatted` (bool) - Se `true`, retorna formatado (XX.XXX.XXX/XXXX-XX). Padrão: `false`

**Retorno:**

-   (string) CNPJ válido com 14 dígitos (ou 18 caracteres se formatado)

**Características:**

-   ✅ Dígitos verificadores **corretos**
-   ✅ Passa em validações matemáticas
-   ✅ Números aleatórios
-   ✅ Sempre usa `0001` como número de filial (matriz)
-   ❌ **NÃO** representa empresa real

---

## Casos de Uso

### 1. Testes Unitários

```php
use Nfse\Support\DocumentGenerator;

it('validates CPF format', function () {
    $cpf = DocumentGenerator::generateCpf();

    expect($cpf)
        ->toHaveLength(11)
        ->toMatch('/^\d{11}$/');
});

it('creates DPS with valid documents', function () {
    $cpfTomador = DocumentGenerator::generateCpf();
    $cnpjPrestador = DocumentGenerator::generateCnpj();

    $dps = new DpsData(
        versao: '1.00',
        infDps: new InfDpsData(
            prestador: new PrestadorData(
                cnpj: $cnpjPrestador,
                // ...
            ),
            tomador: new TomadorData(
                cpf: $cpfTomador,
                // ...
            )
        )
    );

    expect($dps->infDps->prestador->cnpj)->toBe($cnpjPrestador);
});
```

### 2. Seeders de Banco de Dados

```php
// database/seeders/ClienteSeeder.php
use Nfse\Support\DocumentGenerator;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            Cliente::create([
                'nome' => fake()->name(),
                'cpf' => DocumentGenerator::generateCpf(),
                'email' => fake()->email(),
                'telefone' => fake()->phoneNumber(),
            ]);
        }
    }
}
```

### 3. Factories do Laravel

```php
// database/factories/ClienteFactory.php
use Nfse\Support\DocumentGenerator;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => DocumentGenerator::generateCpf(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }

    public function empresa(): static
    {
        return $this->state(fn (array $attributes) => [
            'cpf' => null,
            'cnpj' => DocumentGenerator::generateCnpj(),
            'razao_social' => $this->faker->company(),
        ]);
    }
}
```

### 4. Dados de Demonstração

```php
use Nfse\Support\DocumentGenerator;

// Criar DPS de exemplo para demonstração
$dpsDemo = new DpsData(
    versao: '1.00',
    infDps: new InfDpsData(
        id: IdGenerator::generateDpsId(
            DocumentGenerator::generateCnpj(),
            '3550308',
            '1',
            '1'
        ),
        prestador: new PrestadorData(
            cnpj: DocumentGenerator::generateCnpj(),
            nome: 'Empresa Demonstração Ltda',
            inscricaoMunicipal: '12345',
            // ...
        ),
        tomador: new TomadorData(
            cpf: DocumentGenerator::generateCpf(),
            nome: 'Cliente Exemplo',
            // ...
        ),
        // ...
    )
);
```

### 5. Testes de API

```php
use Nfse\Support\DocumentGenerator;

test('API creates cliente with valid CPF', function () {
    $cpf = DocumentGenerator::generateCpf();

    $response = $this->postJson('/api/clientes', [
        'nome' => 'Teste',
        'cpf' => $cpf,
        'email' => 'teste@example.com',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'cpf' => $cpf,
        ]);
});
```

### 6. Ambiente de Desenvolvimento

```php
// routes/web.php (apenas em desenvolvimento)
if (app()->environment('local')) {
    Route::get('/dev/generate-test-data', function () {
        return [
            'cpf' => DocumentGenerator::generateCpf(true),
            'cnpj' => DocumentGenerator::generateCnpj(true),
        ];
    });
}
```

---

## Exemplos Práticos

### Gerar Múltiplos Documentos

```php
use Nfse\Support\DocumentGenerator;

// Gerar 10 CPFs
$cpfs = collect(range(1, 10))
    ->map(fn() => DocumentGenerator::generateCpf())
    ->toArray();

// Gerar 5 CNPJs formatados
$cnpjs = collect(range(1, 5))
    ->map(fn() => DocumentGenerator::generateCnpj(true))
    ->toArray();

print_r($cpfs);
// [
//     "12345678901",
//     "98765432109",
//     ...
// ]

print_r($cnpjs);
// [
//     "12.345.678/0001-95",
//     "98.765.432/0001-10",
//     ...
// ]
```

### Integração com Faker

```php
use Nfse\Support\DocumentGenerator;
use Faker\Factory;

$faker = Factory::create('pt_BR');

$cliente = [
    'nome' => $faker->name(),
    'cpf' => DocumentGenerator::generateCpf(),
    'email' => $faker->email(),
    'telefone' => $faker->phoneNumber(),
    'endereco' => [
        'logradouro' => $faker->streetName(),
        'numero' => $faker->buildingNumber(),
        'cidade' => $faker->city(),
        'estado' => $faker->stateAbbr(),
        'cep' => $faker->postcode(),
    ],
];
```

### Criar Dataset Completo

```php
use Nfse\Support\DocumentGenerator;

function criarClientesTeste(int $quantidade): array
{
    $clientes = [];

    for ($i = 0; $i < $quantidade; $i++) {
        $tipo = rand(0, 1) ? 'PF' : 'PJ';

        $clientes[] = [
            'tipo' => $tipo,
            'documento' => $tipo === 'PF'
                ? DocumentGenerator::generateCpf(true)
                : DocumentGenerator::generateCnpj(true),
            'nome' => fake()->name(),
            'email' => fake()->email(),
        ];
    }

    return $clientes;
}

$clientes = criarClientesTeste(50);
```

---

## Validação dos Documentos Gerados

Os documentos gerados passam em validações matemáticas padrão:

```php
use Nfse\Support\DocumentGenerator;

$cpf = DocumentGenerator::generateCpf();

// Validação manual dos dígitos verificadores
function validarCpf(string $cpf): bool
{
    if (strlen($cpf) != 11) return false;

    // Cálculo do primeiro dígito
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $d1 = 11 - ($soma % 11);
    if ($d1 >= 10) $d1 = 0;

    // Cálculo do segundo dígito
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $d2 = 11 - ($soma % 11);
    if ($d2 >= 10) $d2 = 0;

    return $cpf[9] == $d1 && $cpf[10] == $d2;
}

var_dump(validarCpf($cpf)); // true ✅
```

---

## Limitações e Avisos

### ⚠️ Uso Exclusivo para Testes

```php
// ✅ CORRETO - Ambiente de teste
if (app()->environment('testing')) {
    $cpf = DocumentGenerator::generateCpf();
}

// ❌ ERRADO - Produção
$cliente->cpf = DocumentGenerator::generateCpf(); // NUNCA FAÇA ISSO!
```

### ⚠️ Não Representa Pessoas Reais

Os documentos gerados:

-   ✅ São matematicamente válidos
-   ✅ Passam em validações de dígito verificador
-   ❌ **NÃO** estão cadastrados na Receita Federal
-   ❌ **NÃO** representam pessoas ou empresas reais
-   ❌ **NÃO** devem ser usados em documentos oficiais

### ⚠️ Colisões Possíveis

Embora improvável, é possível gerar o mesmo documento duas vezes:

```php
// Adicione verificação de unicidade se necessário
$cpf = DocumentGenerator::generateCpf();

while (Cliente::where('cpf', $cpf)->exists()) {
    $cpf = DocumentGenerator::generateCpf(); // Gera outro
}
```

---

## Boas Práticas

### ✅ Recomendado

```php
// 1. Use apenas em testes
if (app()->environment(['local', 'testing'])) {
    $cpf = DocumentGenerator::generateCpf();
}

// 2. Combine com factories
Cliente::factory()
    ->count(10)
    ->create();

// 3. Marque dados de teste claramente
Cliente::create([
    'nome' => '[TESTE] ' . fake()->name(),
    'cpf' => DocumentGenerator::generateCpf(),
    'is_teste' => true,
]);
```

### ❌ Evite

```php
// Não use em produção
if (app()->environment('production')) {
    $cpf = DocumentGenerator::generateCpf(); // ❌
}

// Não assuma que o documento existe
$cpf = DocumentGenerator::generateCpf();
$pessoa = consultarReceitaFederal($cpf); // ❌ Não vai encontrar

// Não use para fraude
// Usar documentos falsos é CRIME! ⚖️
```

---

## Alternativas

Para ambientes de produção, considere:

1. **Usar documentos reais (com consentimento)**
2. **Criar um pool de documentos de teste válidos**
3. **Usar serviços de sandbox de órgãos oficiais**

---

## Veja Também

-   [DocumentFormatter](/utilities/document-formatter) - Formatação de documentos
-   [IdGenerator](/utilities/id-generator) - Geração de IDs únicos
-   [Factories do Laravel](https://laravel.com/docs/eloquent-factories) - Geração de dados de teste
