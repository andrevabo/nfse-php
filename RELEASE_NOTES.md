# 🚀 NFS-e Nacional PHP SDK v1.0.0-beta

A primeira versão pública do SDK mais moderno e completo para integração com a NFS-e Nacional!

## ✨ Destaques

-   **SDK Completo**: Integração com SEFIN Nacional, ADN e CNC
-   **DTOs Tipados**: Estruturas de dados completas com `spatie/laravel-data`
-   **Assinatura A1**: Suporte nativo a certificados PKCS#12/PFX
-   **139 Testes**: Cobertura extensiva com Pest
-   **Documentação**: Site completo em [nfse-php.netlify.app](https://nfse-php.netlify.app)

## 📦 Instalação

```bash
composer require nfse-nacional/nfse-php:1.0.0-beta
```

## 🌐 Web Services

### Contribuinte

```php
$nfse = new Nfse($context);
$contribuinte = $nfse->contribuinte();

$contribuinte->emitir($dps);           // Emitir NFS-e
$contribuinte->consultarNfse($chave);  // Consultar nota
$contribuinte->registrarEvento($evento); // Cancelar/substituir
```

### Município

```php
$municipio = $nfse->municipio();

$municipio->baixarDfe($nsu);           // Baixar notas
$municipio->consultarAliquota(...);    // Consultar alíquotas
$municipio->consultarContribuinte(...); // Consultar cadastro
```

## 📋 Requisitos

-   PHP 8.4+
-   Extensão OpenSSL
-   Certificado digital A1 (PFX/P12)

## 🔗 Links

-   📚 [Documentação](https://nfse-php.netlify.app)
-   💬 [Discussões](https://github.com/nfse-nacional/nfse-php/discussions)
-   🐛 [Issues](https://github.com/nfse-nacional/nfse-php/issues)

---

⚠️ **Nota**: Esta é uma versão beta. Reporte problemas no [Issues](https://github.com/nfse-nacional/nfse-php/issues).

💖 **Apoie o projeto**: [GitHub Sponsors](https://github.com/sponsors/a21ns1g4ts)
