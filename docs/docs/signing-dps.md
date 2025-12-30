# Assinando a DPS

A assinatura digital da DPS (Declaração de Prestação de Serviço) é obrigatória e deve seguir o padrão XMLDSig com algoritmo RSA-SHA1, conforme especificado pela ABRASF.

## Pré-requisitos

Antes de assinar uma DPS, você precisa:

1. ✅ Certificado Digital A1 (arquivo `.pfx` ou `.p12`)
2. ✅ Senha do certificado
3. ✅ XML da DPS gerado
4. ✅ Extensão `openssl` habilitada no PHP

## Processo de Assinatura

### Passo 1: Carregar o Certificado

```php
use Nfse\Signer\Certificate;

$certificado = new Certificate(
    '/caminho/para/certificado.pfx',
    'senha_do_certificado'
);
```

### Passo 2: Gerar o XML da DPS

```php
use Nfse\Xml\DpsXmlBuilder;

$builder = new DpsXmlBuilder();
$xmlSemAssinatura = $builder->build($dpsData);
```

### Passo 3: Assinar o XML

```php
use Nfse\Signer\XmlSigner;

$signer = new XmlSigner($certificado);
$xmlAssinado = $signer->sign($xmlSemAssinatura, 'infDPS');
```

---

## Exemplo Completo

```php
use Nfse\Signer\{Certificate, XmlSigner};
use Nfse\Xml\DpsXmlBuilder;
use Nfse\Dto\DpsData;

// 1. Criar o DTO da DPS
$dps = new DpsData(
    versao: '1.00',
    infDps: new InfDpsData(
        id: IdGenerator::generateDpsId(...),
        // ... outros campos
    )
);

// 2. Gerar XML
$builder = new DpsXmlBuilder();
$xmlSemAssinatura = $builder->build($dps);

// 3. Carregar certificado
$certificado = new Certificate(
    '/caminho/para/certificado.pfx',
    'senha123'
);

// 4. Assinar
$signer = new XmlSigner($certificado);
$xmlAssinado = $signer->sign($xmlSemAssinatura, 'infDPS');

// 5. Salvar ou enviar
file_put_contents('dps-assinada.xml', $xmlAssinado);
```

---

## Parâmetros da Assinatura

O método `sign()` aceita os seguintes parâmetros:

```php
public function sign(
    string $xmlContent,  // XML a ser assinado
    string $tagToSign    // Tag que será assinada (ex: 'infDPS')
): string
```

### Tag a Assinar

Para DPS, **sempre** use `'infDPS'`:

```php
$xmlAssinado = $signer->sign($xml, 'infDPS'); // ✅ Correto
```

❌ **Não use:**

```php
$signer->sign($xml, 'DPS');     // ❌ Errado
$signer->sign($xml, 'infDps');  // ❌ Case-sensitive
```

---

## Detalhes Técnicos da Assinatura

### Algoritmos Utilizados

| Componente          | Algoritmo           | URI                                                     |
| ------------------- | ------------------- | ------------------------------------------------------- |
| **Assinatura**      | RSA-SHA1            | `http://www.w3.org/2000/09/xmldsig#rsa-sha1`            |
| **Digest**          | SHA1                | `http://www.w3.org/2000/09/xmldsig#sha1`                |
| **Canonização**     | C14N                | `http://www.w3.org/TR/2001/REC-xml-c14n-20010315`       |
| **Transformação 1** | Enveloped Signature | `http://www.w3.org/2000/09/xmldsig#enveloped-signature` |
| **Transformação 2** | C14N                | `http://www.w3.org/TR/2001/REC-xml-c14n-20010315`       |

### Estrutura da Assinatura

A assinatura é inserida como elemento `<Signature>` dentro do elemento `<DPS>`, após o `<infDPS>`:

```xml
<DPS xmlns="http://www.sped.fazenda.gov.br/nfse">
    <infDPS Id="DPS..." versao="1.00">
        <!-- Dados da DPS -->
    </infDPS>
    <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
        <SignedInfo>
            <CanonicalizationMethod Algorithm="..."/>
            <SignatureMethod Algorithm="..."/>
            <Reference URI="#DPS...">
                <Transforms>
                    <Transform Algorithm="..."/>
                    <Transform Algorithm="..."/>
                </Transforms>
                <DigestMethod Algorithm="..."/>
                <DigestValue>...</DigestValue>
            </Reference>
        </SignedInfo>
        <SignatureValue>...</SignatureValue>
        <KeyInfo>
            <X509Data>
                <X509Certificate>...</X509Certificate>
            </X509Data>
        </KeyInfo>
    </Signature>
</DPS>
```

---

## Validações Automáticas

O `XmlSigner` realiza as seguintes validações:

### 1. Verificação do Atributo `Id`

```php
// ✅ Correto - infDPS tem atributo Id
<infDPS Id="DPS355030821234567800019900001000000000000123" versao="1.00">

// ❌ Erro - Falta o atributo Id
<infDPS versao="1.00">
// Exceção: "Tag a ser assinada deve possuir um atributo 'Id'."
```

### 2. Verificação da Tag

```php
// ✅ Correto - Tag existe
$signer->sign($xml, 'infDPS');

// ❌ Erro - Tag não existe
$signer->sign($xml, 'infNFSe');
// Exceção: "Tag infNFSe não encontrada para assinatura."
```

---

## Casos de Uso

### 1. Assinatura Simples

```php
use Nfse\Signer\{Certificate, XmlSigner};

try {
    $certificado = new Certificate($pfxPath, $senha);
    $signer = new XmlSigner($certificado);

    $xmlAssinado = $signer->sign($xml, 'infDPS');

    echo "DPS assinada com sucesso!";

} catch (Exception $e) {
    echo "Erro ao assinar: " . $e->getMessage();
}
```

### 2. Assinatura em Lote

```php
use Nfse\Signer\{Certificate, XmlSigner};

$certificado = new Certificate($pfxPath, $senha);
$signer = new XmlSigner($certificado);

$dpsList = []; // Array de DpsData

foreach ($dpsList as $dps) {
    $xml = (new DpsXmlBuilder())->build($dps);
    $xmlAssinado = $signer->sign($xml, 'infDPS');

    // Salvar ou enviar
    file_put_contents("dps_{$dps->infDps->numeroDps}.xml", $xmlAssinado);
}
```

### 3. Assinatura com Validação

```php
use Nfse\Signer\{Certificate, XmlSigner};

function assinarDps(DpsData $dps, string $pfxPath, string $senha): string
{
    // Validar DTO
    $dps->validate();

    // Gerar XML
    $xml = (new DpsXmlBuilder())->build($dps);

    // Carregar certificado
    $certificado = new Certificate($pfxPath, $senha);

    // Assinar
    $signer = new XmlSigner($certificado);
    $xmlAssinado = $signer->sign($xml, 'infDPS');

    // Validar assinatura (opcional)
    if (!str_contains($xmlAssinado, '<Signature')) {
        throw new Exception('Assinatura não foi inserida no XML');
    }

    return $xmlAssinado;
}
```

### 4. Assinatura com Cache de Certificado

```php
use Nfse\Signer\{Certificate, XmlSigner};

class DpsAssinadorService
{
    private ?Certificate $certificado = null;
    private ?XmlSigner $signer = null;

    public function __construct(
        private string $pfxPath,
        private string $senha
    ) {}

    public function assinar(string $xml): string
    {
        if ($this->signer === null) {
            $this->certificado = new Certificate($this->pfxPath, $this->senha);
            $this->signer = new XmlSigner($this->certificado);
        }

        return $this->signer->sign($xml, 'infDPS');
    }
}

// Uso
$assinador = new DpsAssinadorService($pfxPath, $senha);

foreach ($dpsList as $dps) {
    $xml = (new DpsXmlBuilder())->build($dps);
    $xmlAssinado = $assinador->assinar($xml); // Reutiliza o certificado
}
```

---

## Fluxo Completo: Da Criação ao Envio

```php
use Nfse\Support\IdGenerator;
use Nfse\Dto\{DpsData, InfDpsData, PrestadorData, TomadorData};
use Nfse\Xml\DpsXmlBuilder;
use Nfse\Signer\{Certificate, XmlSigner};

// 1. CRIAR DADOS
$idDps = IdGenerator::generateDpsId(
    '12345678000199',
    '3550308',
    '1',
    '100'
);

$dps = new DpsData(
    versao: '1.00',
    infDps: new InfDpsData(
        id: $idDps,
        tipoAmbiente: 2,
        dataEmissao: now()->format('Y-m-d\TH:i:sP'),
        serie: '1',
        numeroDps: '100',
        prestador: new PrestadorData(
            cnpj: '12345678000199',
            nome: 'Minha Empresa Ltda',
            // ...
        ),
        tomador: new TomadorData(
            cpf: '12345678901',
            nome: 'Cliente Exemplo',
            // ...
        ),
        // ... outros campos
    )
);

// 2. VALIDAR
$dps->validate();

// 3. GERAR XML
$builder = new DpsXmlBuilder();
$xmlSemAssinatura = $builder->build($dps);

// 4. ASSINAR
$certificado = new Certificate(
    storage_path('certificados/empresa.pfx'),
    config('nfse.certificado_senha')
);

$signer = new XmlSigner($certificado);
$xmlAssinado = $signer->sign($xmlSemAssinatura, 'infDPS');

// 5. SALVAR (opcional)
Storage::put("dps/dps_{$dps->infDps->numeroDps}.xml", $xmlAssinado);

// 6. ENVIAR PARA SEFIN
// $response = Http::post($urlSefin, [
//     'xml' => base64_encode($xmlAssinado)
// ]);
```

---

## Tratamento de Erros

### Erros Comuns

#### 1. Certificado Inválido

```php
try {
    $certificado = new Certificate($pfxPath, $senhaErrada);
} catch (Exception $e) {
    // "Senha do certificado incorreta ou arquivo inválido/corrompido"
}
```

#### 2. Certificado Expirado

```php
try {
    $certificado = new Certificate($pfxPath, $senha);
} catch (Exception $e) {
    // "O certificado digital está vencido. Validade: 2023-12-31"
}
```

#### 3. Tag Não Encontrada

```php
try {
    $signer->sign($xml, 'tagInexistente');
} catch (Exception $e) {
    // "Tag tagInexistente não encontrada para assinatura."
}
```

#### 4. Atributo Id Ausente

```php
try {
    $signer->sign($xmlSemId, 'infDPS');
} catch (Exception $e) {
    // "Tag a ser assinada deve possuir um atributo 'Id'."
}
```

### Tratamento Robusto

```php
use Nfse\Signer\{Certificate, XmlSigner};

function assinarDpsComTratamento(
    string $xml,
    string $pfxPath,
    string $senha
): array {
    try {
        // Carregar certificado
        $certificado = new Certificate($pfxPath, $senha);

        // Assinar
        $signer = new XmlSigner($certificado);
        $xmlAssinado = $signer->sign($xml, 'infDPS');

        return [
            'sucesso' => true,
            'xml' => $xmlAssinado,
        ];

    } catch (Exception $e) {
        return [
            'sucesso' => false,
            'erro' => $e->getMessage(),
            'codigo' => $e->getCode(),
        ];
    }
}

// Uso
$resultado = assinarDpsComTratamento($xml, $pfxPath, $senha);

if ($resultado['sucesso']) {
    echo "DPS assinada com sucesso!";
    // Enviar para SEFIN
} else {
    Log::error('Erro ao assinar DPS', $resultado);
    // Notificar usuário
}
```

---

## Boas Práticas

### ✅ Recomendado

```php
// 1. Valide antes de assinar
$dps->validate();
$xml = $builder->build($dps);
$xmlAssinado = $signer->sign($xml, 'infDPS');

// 2. Use variáveis de ambiente para credenciais
$certificado = new Certificate(
    env('CERTIFICADO_PATH'),
    env('CERTIFICADO_SENHA')
);

// 3. Reutilize o certificado em lote
$signer = new XmlSigner($certificado);
foreach ($dpsList as $dps) {
    $xml = $builder->build($dps);
    $xmlAssinado = $signer->sign($xml, 'infDPS');
}

// 4. Salve o XML assinado
Storage::put("dps_{$numero}.xml", $xmlAssinado);
```

### ❌ Evite

```php
// Não hardcode credenciais
$cert = new Certificate('/path/cert.pfx', 'senha123'); // ❌

// Não ignore erros
$signer->sign($xml, 'infDPS'); // ❌ Sem try/catch

// Não assine XML inválido
$xmlAssinado = $signer->sign($xmlInvalido, 'infDPS'); // ❌

// Não recarregue o certificado desnecessariamente
foreach ($dpsList as $dps) {
    $cert = new Certificate($pfxPath, $senha); // ❌ Dentro do loop
    $signer = new XmlSigner($cert);
}
```

---

## Segurança

### Proteção do Certificado

```php
// ✅ Armazene fora do webroot
storage_path('certificados/empresa.pfx')

// ✅ Use permissões restritas
chmod 600 storage/certificados/empresa.pfx

// ✅ Não versione no Git
// .gitignore
storage/certificados/*.pfx
```

### Proteção da Senha

```php
// ✅ Use variáveis de ambiente
// .env
CERTIFICADO_SENHA=senha_secreta

// ✅ Não logue a senha
Log::info('Assinando DPS', [
    'certificado' => $pfxPath,
    // 'senha' => $senha, // ❌ NUNCA!
]);
```

---

## Veja Também

-   [Certificate](/digital-signature#carregando-o-certificado) - Carregar certificado A1
-   [XmlSigner](/digital-signature#assinando-um-xml) - Assinatura digital
-   [DpsXmlBuilder](/xml-serialization) - Geração de XML
-   [IdGenerator](/utilities/id-generator) - Geração de IDs
