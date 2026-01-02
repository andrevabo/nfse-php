# Changelog

All notable changes to `nfse-php` will be documented in this file.

## [1.0.0-beta] - 2026-01-01

### 🎉 Lançamento Inicial (Beta)

Esta é a primeira versão pública do SDK NFS-e Nacional PHP. O pacote oferece uma solução completa e moderna para integração com a NFS-e Nacional.

### ✨ Funcionalidades

#### 📦 DTOs (Data Transfer Objects)

-   DTOs completos para DPS, NFS-e e Eventos usando `spatie/laravel-data`
-   Validação automática de campos obrigatórios
-   Mapeamento de nomes de campos conforme especificação oficial
-   Suporte a todos os tipos de operação: emissão, cancelamento, substituição

#### 🔐 Assinatura Digital

-   Suporte a certificado A1 (PKCS#12/PFX)
-   Assinatura XML-DSig compatível com ICP-Brasil
-   Algoritmos SHA-1 e SHA-256

#### 📄 Serialização XML

-   Geração de XML compatível com XSDs oficiais
-   Builder fluente para DPS e Eventos
-   Serialização automática de DTOs para XML

#### 🌐 Web Services (SDK)

-   **SEFIN Nacional**: Emissão, consulta, verificação e listagem de eventos
-   **ADN (Ambiente de Dados Nacional)**: Distribuição de DFe, consulta de alíquotas, regimes especiais, retenções
-   **CNC (Cadastro Nacional de Contribuintes)**: Consulta e atualização cadastral

#### 🏢 Camada de Serviços

-   `ContribuinteService`: Operações para contribuintes emissores
-   `MunicipioService`: Operações para sistemas municipais
-   Interface simplificada através da classe `Nfse`

#### 🧪 Qualidade de Código

-   139 testes automatizados com Pest
-   485 assertions
-   Análise estática com PHPStan (nível máximo)
-   Code style com Laravel Pint

#### 📚 Documentação

-   Site de documentação com Docusaurus
-   Busca local integrada
-   Exemplos práticos e guias de uso

### 📋 Requisitos

-   PHP 8.4+
-   Extensão OpenSSL
-   Certificado digital A1 (PFX/P12)

### 📦 Dependências

-   `guzzlehttp/guzzle` ^7.9
-   `illuminate/support` ^12.0
-   `illuminate/validation` ^12.0
-   `illuminate/translation` ^12.0
-   `spatie/laravel-data` ^4.11

### 🔗 Links

-   [Documentação](https://nfse-php.netlify.app)
-   [GitHub](https://github.com/nfse-nacional/nfse-php)
-   [Packagist](https://packagist.org/packages/nfse-nacional/nfse-php)
