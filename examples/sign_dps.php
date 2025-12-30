<?php

/**
 * Exemplo de uso do XmlSigner com parâmetros customizados
 * 
 * Este exemplo demonstra como assinar um DPS com diferentes configurações
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Nfse\Signer\Certificate;
use Nfse\Signer\XmlSigner;

// Configuração do certificado
$pfxPath = __DIR__ . '/../tests/fixtures/certs/test.pfx';
$password = '1234';

// Carregar o certificado
try {
    $certificate = new Certificate($pfxPath, $password);
    echo "✓ Certificado carregado com sucesso\n\n";
} catch (Exception $e) {
    die("✗ Erro ao carregar certificado: {$e->getMessage()}\n");
}

// Criar o assinador
$signer = new XmlSigner($certificate);

// Exemplo 1: Assinatura simples (padrão)
echo "=== Exemplo 1: Assinatura Simples ===\n";
$dpsPath = __DIR__ . '/../tests/fixtures/xml/dps/ExemploPrestadorPessoaFisica.xml';
$xml = file_get_contents($dpsPath);

try {
    $signedXml = $signer->sign($xml, 'infDPS');
    echo "✓ DPS assinado com sucesso (SHA-1)\n";
    echo "  Tamanho: " . strlen($signedXml) . " bytes\n\n";
} catch (Exception $e) {
    echo "✗ Erro: {$e->getMessage()}\n\n";
}

// Exemplo 2: Assinatura com SHA-256
echo "=== Exemplo 2: Assinatura com SHA-256 ===\n";
try {
    $signedXml = $signer->sign(
        content: $xml,
        tagname: 'infDPS',
        algorithm: OPENSSL_ALGO_SHA256
    );
    echo "✓ DPS assinado com SHA-256\n";
    echo "  Contém rsa-sha256: " . (strpos($signedXml, 'rsa-sha256') !== false ? 'Sim' : 'Não') . "\n\n";
} catch (Exception $e) {
    echo "✗ Erro: {$e->getMessage()}\n\n";
}

// Exemplo 3: Assinatura com validação de elemento raiz
echo "=== Exemplo 3: Assinatura com Validação ===\n";
try {
    $signedXml = $signer->sign(
        content: $xml,
        tagname: 'infDPS',
        rootname: 'DPS'
    );
    echo "✓ DPS assinado com validação de elemento raiz\n";
    echo "  Elemento raiz validado: DPS\n\n";
} catch (Exception $e) {
    echo "✗ Erro: {$e->getMessage()}\n\n";
}

// Exemplo 4: Assinatura com todos os parâmetros
echo "=== Exemplo 4: Assinatura Completa ===\n";
$dpsPath2 = __DIR__ . '/../tests/fixtures/xml/dps/ExemploPisZeradoCofinsSobreFaturamentoPreenchido.xml';
$xml2 = file_get_contents($dpsPath2);

try {
    $signedXml = $signer->sign(
        content: $xml2,
        tagname: 'infDPS',
        mark: 'Id',
        algorithm: OPENSSL_ALGO_SHA1,
        canonical: [true, false, null, null],
        rootname: 'DPS'
    );
    echo "✓ DPS assinado com todos os parâmetros customizados\n";
    echo "  Tag: infDPS\n";
    echo "  Mark: Id\n";
    echo "  Algorithm: SHA-1\n";
    echo "  Root: DPS\n";
    echo "  Tamanho: " . strlen($signedXml) . " bytes\n\n";
    
    // Salvar exemplo
    $outputPath = __DIR__ . '/dps-signed-example.xml';
    file_put_contents($outputPath, $signedXml);
    echo "  Arquivo salvo: {$outputPath}\n\n";
} catch (Exception $e) {
    echo "✗ Erro: {$e->getMessage()}\n\n";
}

// Exemplo 5: Tratamento de erros
echo "=== Exemplo 5: Tratamento de Erros ===\n";

// Erro 1: XML vazio
try {
    $signer->sign('', 'infDPS');
    echo "✗ Deveria ter lançado exceção para XML vazio\n";
} catch (Exception $e) {
    echo "✓ Erro capturado: {$e->getMessage()}\n";
}

// Erro 2: Tag não encontrada
try {
    $signer->sign($xml, 'tagInexistente');
    echo "✗ Deveria ter lançado exceção para tag inexistente\n";
} catch (Exception $e) {
    echo "✓ Erro capturado: {$e->getMessage()}\n";
}

// Erro 3: Elemento raiz incorreto
try {
    $signer->sign(
        content: $xml,
        tagname: 'infDPS',
        rootname: 'NFSe'
    );
    echo "✗ Deveria ter lançado exceção para elemento raiz incorreto\n";
} catch (Exception $e) {
    echo "✓ Erro capturado: {$e->getMessage()}\n";
}

echo "\n=== Exemplos concluídos ===\n";
