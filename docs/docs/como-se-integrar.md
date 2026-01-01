---
id: como-se-integrar
title: Como Se Integrar
sidebar_label: Como Se Integrar
---

# Análise Detalhada das Especificações de API do Sistema Nacional NFS-e

Este documento apresenta uma análise técnica das especificações de API encontradas em https://www.gov.br/nfse/pt-br/biblioteca/documentacao-tecnica/apis-prod-restrita-e-producao. O objetivo é clarificar o escopo, público-alvo e funcionalidade de cada especificação para orientar a implementação e integração.

## Endpoints e Ambientes

Abaixo estão listados os endereços base para os ambientes de Produção e Homologação (Produção Restrita) de cada API.

| API                           | Ambiente de Homologação (Produção Restrita)                    | Ambiente de Produção                      |
| :---------------------------- | :------------------------------------------------------------- | :---------------------------------------- |
| **ADN Contribuinte**          | `https://adn.producaorestrita.nfse.gov.br/contribuintes`       | `https://adn.nfse.gov.br/contribuintes`   |
| **ADN Município**             | `https://adn.producaorestrita.nfse.gov.br/municipios`          | `https://adn.nfse.gov.br/municipios`      |
| **ADN Recepção**              | `https://adn.producaorestrita.nfse.gov.br`                     | `https://adn.nfse.gov.br`                 |
| **ADN Parâmetros Municipais** | `https://adn.producaorestrita.nfse.gov.br/parametrizacao`      | `https://adn.nfse.gov.br/parametrizacao`  |
| **ADN DANFSe**                | `https://adn.producaorestrita.nfse.gov.br/danfse`              | `https://adn.nfse.gov.br/danfse`          |
| **CNC Consulta**              | `https://adn.producaorestrita.nfse.gov.br/cnc/consulta`        | `https://adn.nfse.gov.br/cnc/consulta`    |
| **CNC Município**             | `https://adn.producaorestrita.nfse.gov.br/cnc/municipio`       | `https://adn.nfse.gov.br/cnc/municipio`   |
| **CNC Recepção**              | `https://adn.producaorestrita.nfse.gov.br/cnc`                 | `https://adn.nfse.gov.br/cnc`             |
| **Sefin Nacional**            | `https://sefin.producaorestrita.nfse.gov.br/API/SefinNacional` | `https://sefin.nfse.gov.br/SefinNacional` |

## 1. APIs do Ambiente de Dados Nacional (ADN)

O ADN é o repositório centralizado dos documentos fiscais.

### 1.1. ADN Contribuinte

-   **Público-Alvo:** **Contribuintes** (Tomadores e Prestadores).
-   **Escopo:** Distribuição de documentos.
-   **Função:** Permite que o contribuinte baixe as notas fiscais onde ele figura como prestador ou tomador, além de eventos relacionados.
-   **Endpoints Principais:**
    -   `GET /DFe/{NSU}`: Baixa documentos (NFS-e, Eventos) incrementalmente via NSU.
    -   `GET /NFSe/{ChaveAcesso}/Eventos`: Consulta eventos de uma nota específica.

### 1.2. ADN Município (`API NFS-e - ADN Município (v1).json`)

-   **Público-Alvo:** **Municípios (Prefeituras)**.
-   **Escopo:** Sincronização e Gestão Municipal.
-   **Função:** Permite à prefeitura baixar todos os documentos fiscais emitidos ou tomados em sua jurisdição para manter sua base local atualizada.
-   **Endpoints Principais:**
    -   `GET /municipios/dfe/{NSU}`: Endpoint principal para "baixar" a arrecadação e notas do município.
    -   `GET /parametros_municipais/...`: Consulta de alíquotas e convênios.
-   _Nota: Detalhes completos no documento `api_adn_municipio.md`._

### 1.3. ADN Recepção (`API NFS-e - ADN Recepção (v1).json`)

-   **Público-Alvo:** **Municípios e Emissores Autorizados**.
-   **Escopo:** Entrada de Dados no Nacional.
-   **Função:** Porta de entrada para enviar lotes de documentos (DPS, Eventos) para o ambiente nacional.
-   **Endpoints Principais:**
    -   `POST /DFe`: Envio de lote de documentos XML (compactados e em Base64).

### 1.4. ADN DANFSe (`API NFS-e - ADN DANFSe (v1).json`)

-   **Público-Alvo:** **Público Geral / Contribuintes / Municípios**.
-   **Escopo:** Visualização.
-   **Função:** Obtenção da representação visual (PDF/Impressão) da Nota Fiscal.
-   **Endpoints Principais:**
    -   `GET /{chaveAcesso}`: Retorna o DANFSe da nota.

---

## 2. APIs do Cadastro Nacional de Contribuintes (CNC)

O CNC centraliza as informações cadastrais dos contribuintes, complementando a base da Receita Federal.

### 2.1. CNC Consulta (`API NFS-e - CNC Consulta (v1).json`)

-   **Público-Alvo:** **Municípios**.
-   **Escopo:** Consulta Cadastral.
-   **Função:** Permite que o município consulte dados cadastrais de contribuintes no cadastro nacional.
-   **Endpoints Principais:**
    -   `GET /cad`: Consulta dados atuais de um contribuinte.

### 2.2. CNC Município (`API NFS-e - CNC Município (v1).json`)

-   **Público-Alvo:** **Municípios**.
-   **Escopo:** Sincronização de Cadastro.
-   **Função:** Permite ao município receber atualizações cadastrais (movimentações) de contribuintes de seu interesse via NSU.
-   **Endpoints Principais:**
    -   `GET /cad/NSU`: Baixa alterações no cadastro nacional incrementalmente.

### 2.3. CNC Recepção (`API NFS-e - CNC Recepção (v1).json`)

-   **Público-Alvo:** **Municípios**.
-   **Escopo:** Alimentação de Cadastro.
-   **Função:** O município envia para o nacional os dados dos contribuintes que ele gere, alimentando a base nacional.
-   **Endpoints Principais:**
    -   `POST /CNC`: Cadastra ou atualiza um contribuinte no CNC.

---

## 3. APIs da Sefin Nacional

### 3.1. Sefin Nacional (`API NFS-e - Sefin Nacional (v1).json`)

-   **Público-Alvo:** **Contribuintes (Emissores)** e **Integradores**.
-   **Escopo:** Emissão e Operação.
-   **Função:** API "Core" para a emissão síncrona de notas fiscais (transformação de DPS em NFS-e) e gestão do ciclo de vida da nota.
-   **Endpoints Principais:**
    -   `POST /nfse`: Emissão síncrona (Envia DPS -> Recebe NFS-e).
    -   `GET /nfse/{chaveAcesso}`: Consulta de nota emitida.
    -   `GET /dps/{id}`: Recupera nota pelo ID do DPS.
    -   `POST /nfse/{chaveAcesso}/eventos`: Registro de eventos (Cancelamento, etc.).

---

## Resumo de Permissões

| API                  | Uso Principal                 | Uso Secundário              |
| :------------------- | :---------------------------- | :-------------------------- |
| **ADN Contribuinte** | Contribuinte (PF/PJ)          | -                           |
| **ADN Município**    | Prefeitura                    | Órgãos de Controle          |
| **ADN Recepção**     | Prefeitura / Emissor          | -                           |
| **ADN DANFSe**       | Qualquer portador da chave    | -                           |
| **CNC (Todas)**      | Prefeitura                    | -                           |
| **Sefin Nacional**   | Emissor (Software de Emissão) | Prefeitura (Emissão Avulsa) |
