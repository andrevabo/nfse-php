# DocumentFormatter

A classe `DocumentFormatter` oferece métodos estáticos para formatar e limpar documentos brasileiros (CPF, CNPJ, CEP).

## Instalação

Esta classe faz parte do pacote principal e está disponível no namespace `Nfse\Support`.

```php
use Nfse\Support\DocumentFormatter;
```

## Métodos Disponíveis

### formatCpf()

Formata um CPF no padrão brasileiro (XXX.XXX.XXX-XX).

```php
echo DocumentFormatter::formatCpf('12345678901');
// Saída: 123.456.789-01
```

**Assinatura:**

```php
public static function formatCpf(string $cpf): string
```

**Parâmetros:**

-   `$cpf` (string) - CPF sem formatação, contendo apenas números

**Retorno:**

-   (string) CPF formatado no padrão XXX.XXX.XXX-XX

**Exemplo:**

```php
$cpfBanco = '12345678901';
$cpfExibicao = DocumentFormatter::formatCpf($cpfBanco);

echo $cpfExibicao; // 123.456.789-01
```

---

### formatCnpj()

Formata um CNPJ no padrão brasileiro (XX.XXX.XXX/XXXX-XX).

```php
echo DocumentFormatter::formatCnpj('12345678000199');
// Saída: 12.345.678/0001-99
```

**Assinatura:**

```php
public static function formatCnpj(string $cnpj): string
```

**Parâmetros:**

-   `$cnpj` (string) - CNPJ sem formatação, contendo apenas números

**Retorno:**

-   (string) CNPJ formatado no padrão XX.XXX.XXX/XXXX-XX

**Exemplo:**

```php
$cnpjBanco = '12345678000199';
$cnpjExibicao = DocumentFormatter::formatCnpj($cnpjBanco);

echo $cnpjExibicao; // 12.345.678/0001-99
```

---

### formatCep()

Formata um CEP no padrão brasileiro (XXXXX-XXX).

```php
echo DocumentFormatter::formatCep('12345678');
// Saída: 12345-678
```

**Assinatura:**

```php
public static function formatCep(string $cep): string
```

**Parâmetros:**

-   `$cep` (string) - CEP sem formatação, contendo apenas números

**Retorno:**

-   (string) CEP formatado no padrão XXXXX-XXX

**Exemplo:**

```php
$cepBanco = '01310100';
$cepExibicao = DocumentFormatter::formatCep($cepBanco);

echo $cepExibicao; // 01310-100
```

---

### unformat()

Remove toda a formatação de um documento, mantendo apenas os números.

```php
echo DocumentFormatter::unformat('123.456.789-01');
// Saída: 12345678901
```

**Assinatura:**

```php
public static function unformat(string $value): string
```

**Parâmetros:**

-   `$value` (string) - Valor formatado (CPF, CNPJ, CEP, etc.)

**Retorno:**

-   (string) Apenas os dígitos numéricos

**Exemplos:**

```php
// CPF
echo DocumentFormatter::unformat('123.456.789-01');
// 12345678901

// CNPJ
echo DocumentFormatter::unformat('12.345.678/0001-99');
// 12345678000199

// CEP
echo DocumentFormatter::unformat('12345-678');
// 12345678

// Qualquer string com números
echo DocumentFormatter::unformat('ABC-123.456/789');
// 123456789
```

---

## Casos de Uso

### 1. Exibição em Views

```php
// Controller
$cliente = Cliente::find(1);

// View
<p>CPF: {{ DocumentFormatter::formatCpf($cliente->cpf) }}</p>
<p>CNPJ: {{ DocumentFormatter::formatCnpj($empresa->cnpj) }}</p>
```

### 2. Normalização antes de Salvar

```php
use Nfse\Support\DocumentFormatter;

// Recebe do formulário (pode vir formatado)
$cpf = $request->input('cpf'); // "123.456.789-01"

// Remove formatação antes de salvar
$cliente->cpf = DocumentFormatter::unformat($cpf); // "12345678901"
$cliente->save();
```

### 3. API Response Formatting

```php
return response()->json([
    'cliente' => [
        'nome' => $cliente->nome,
        'cpf' => DocumentFormatter::formatCpf($cliente->cpf),
        'endereco' => [
            'cep' => DocumentFormatter::formatCep($cliente->cep),
            // ...
        ]
    ]
]);
```

### 4. Preparação para XML

```php
use Nfse\Support\DocumentFormatter;

// Garantir que o documento está sem formatação
$tomadorData = new TomadorData(
    cpf: DocumentFormatter::unformat($request->cpf),
    cnpj: null,
    // ...
);
```

### 5. Validação Condicional

```php
$documento = $request->input('documento');
$documentoLimpo = DocumentFormatter::unformat($documento);

if (strlen($documentoLimpo) === 11) {
    // É CPF
    $cpfFormatado = DocumentFormatter::formatCpf($documentoLimpo);
} elseif (strlen($documentoLimpo) === 14) {
    // É CNPJ
    $cnpjFormatado = DocumentFormatter::formatCnpj($documentoLimpo);
}
```

---

## Boas Práticas

### ✅ Recomendado

```php
// Sempre armazene sem formatação no banco
$cliente->cpf = DocumentFormatter::unformat($request->cpf);

// Formate apenas para exibição
$cpfExibicao = DocumentFormatter::formatCpf($cliente->cpf);
```

### ❌ Evite

```php
// Não armazene formatado no banco
$cliente->cpf = DocumentFormatter::formatCpf($request->cpf); // ❌

// Não use formatação em comparações
if ($cpf === '123.456.789-01') { // ❌
    // ...
}

// Use sem formatação
if (DocumentFormatter::unformat($cpf) === '12345678901') { // ✅
    // ...
}
```

---

## Integração com Validação Laravel

```php
use Illuminate\Validation\Rule;
use Nfse\Support\DocumentFormatter;

// No FormRequest
public function prepareForValidation()
{
    $this->merge([
        'cpf' => DocumentFormatter::unformat($this->cpf),
        'cnpj' => DocumentFormatter::unformat($this->cnpj),
        'cep' => DocumentFormatter::unformat($this->cep),
    ]);
}

public function rules()
{
    return [
        'cpf' => ['required', 'cpf'], // Validação já recebe sem formatação
        'cnpj' => ['nullable', 'cnpj'],
        'cep' => ['required', 'regex:/^\d{8}$/'],
    ];
}
```

---

## Notas Técnicas

-   **Performance:** Todos os métodos são estáticos e não mantêm estado, sendo extremamente rápidos.
-   **Validação:** Esta classe **não valida** se o CPF/CNPJ é válido, apenas formata. Use validadores específicos para isso.
-   **Encoding:** Funciona com strings UTF-8 sem problemas.
-   **Null Safety:** Não aceita valores `null`. Certifique-se de passar strings válidas.

---

## Veja Também

-   [TaxCalculator](/utilities/tax-calculator) - Cálculos tributários
-   [IdGenerator](/utilities/id-generator) - Geração de IDs únicos
-   [DocumentGenerator](/utilities/document-generator) - Geração de documentos para testes
