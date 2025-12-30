# Checklist de DTOs (nfse-php)

Lista de Data Transfer Objects a serem implementados utilizando `spatie/laravel-data`.
Baseado no layout `ANEXO_I-SEFIN_ADN-DPS_NFSe-SNNFSe.xlsx` (via `dps_example.xml`).

## Estrutura DPS (Declaração de Prestação de Serviço)

- [ ] **DpsData** (Root)

  - Mapeia `<DPS>`
  - Propriedades:
    - `versao`
    - `infDps` (Objeto `InfDpsData`)

- [ ] **InfDpsData**
  - Mapeia `<infDPS>`
  - Propriedades:
    - `id` (Atributo `Id`)
    - `tpAmb` -> `tipoAmbiente`
    - `dhEmi` -> `dataEmissao`
    - `verAplic` -> `versaoAplicativo`
    - `serie`
    - `nDPS` -> `numeroDps`
    - `dCompet` -> `dataCompetencia`
    - `tpEmit` -> `tipoEmitente`
    - `cLocEmi` -> `codigoLocalEmissao`
  - Relacionamentos:
    - `prest` -> `prestador` (`PrestadorData`)
    - `toma` -> `tomador` (`TomadorData`)
    - `serv` -> `servico` (`ServicoData`)
    - `valores` -> `valores` (`ValoresData`)

## Atores

- [ ] **PrestadorData**

  - Mapeia `<prest>`
  - Propriedades:
    - `CNPJ` -> `cnpj`
    - `IM` -> `inscricaoMunicipal`
    - `fone` -> `telefone`
    - `email`
  - Relacionamentos:
    - `regTrib` -> `regimeTributario` (`RegimeTributarioData`)

- [ ] **TomadorData**
  - Mapeia `<toma>`
  - Propriedades:
    - `CPF` -> `cpf`
    - `CNPJ` -> `cnpj`
    - `xNome` -> `nome`
  - Relacionamentos:
    - `end` -> `endereco` (`EnderecoData`)

## Componentes Reutilizáveis

- [ ] **RegimeTributarioData**

  - Mapeia `<regTrib>`
  - Propriedades:
    - `#[MapInputName('opSimpNac')]` `opcaoSimplesNacional`
    - `#[MapInputName('regApTribSN')]` `regimeApuracaoTributariaSN`
    - `#[MapInputName('regEspTrib')]` `regimeEspecialTributacao`

- [ ] **EnderecoData**

  - Mapeia `<end>`
  - Propriedades:
    - `#[MapInputName('endNac.cMun')]` `codigoMunicipio`
    - `#[MapInputName('endNac.CEP')]` `cep`
    - `#[MapInputName('xLgr')]` `logradouro`
    - `#[MapInputName('nro')]` `numero`
    - `#[MapInputName('xBairro')]` `bairro`

- [ ] **ServicoData**

  - Mapeia `<serv>`
  - Propriedades:
    - `#[MapInputName('locPrest.cLocPrestacao')]` `codigoLocalPrestacao`
    - `#[MapInputName('cServ.cTribNac')]` `codigoTributacaoNacional`
    - `#[MapInputName('cServ.xDescServ')]` `descricaoServico`

- [ ] **ValoresData**

  - Mapeia `<valores>`
  - Propriedades:
    - `#[MapInputName('vServPrest.vServ')]` `valorServico`
  - Relacionamentos:
    - `trib` -> `tributacao` (`TributacaoData`)

- [ ] **TributacaoData**
  - Mapeia `<trib>`
  - Propriedades:
    - `#[MapInputName('tribMun.tribISSQN')]` `tributacaoIssqn`
    - `#[MapInputName('tribMun.tpRetISSQN')]` `tipoRetencaoIssqn`
    - `#[MapInputName('tribFed.piscofins.CST')]` `cstPisCofins`
    - `#[MapInputName('totTrib.pTotTribSN')]` `percentualTotalTributosSN`
