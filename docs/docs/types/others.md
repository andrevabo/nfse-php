# Outras Informações

Estes DTOs cobrem cenários específicos como obras, eventos, substituições e comércio exterior.

## AtividadeEventoData

Utilizado quando o serviço está vinculado a uma atividade ou evento específico (ex: shows, feiras).

### Propriedades

| Propriedade         | Tipo           | Mapeamento XML | Descrição                          |
| :------------------ | :------------- | :------------- | :--------------------------------- |
| `nome`              | `string`       | `xNome`        | Nome do evento.                    |
| `dataInicio`        | `string`       | `dtIni`        | Data de início.                    |
| `dataFim`           | `string`       | `dtFim`        | Data de fim.                       |
| `idAtividadeEvento` | `string`       | `idAtvEvt`     | Identificador da atividade/evento. |
| `endereco`          | `EnderecoData` | `end`          | Local onde ocorre a atividade.     |

---

## ObraData

Utilizado para serviços de construção civil vinculados a uma obra.

### Propriedades

| Propriedade                  | Tipo           | Mapeamento XML | Descrição                       |
| :--------------------------- | :------------- | :------------- | :------------------------------ |
| `inscricaoImobiliariaFiscal` | `string`       | `inscImobFisc` | Inscrição da obra no município. |
| `codigoObra`                 | `string`       | `cObra`        | Código identificador da obra.   |
| `endereco`                   | `EnderecoData` | `end`          | Local da obra.                  |

---

## SubstituicaoData

Utilizado para identificar a nota que está sendo substituída pela atual.

### Propriedades

| Propriedade        | Tipo     | Mapeamento XML | Descrição                                                        |
| :----------------- | :------- | :------------- | :--------------------------------------------------------------- |
| `chaveSubstituida` | `string` | `chSubstda`    | Chave da NFS-e anterior.                                         |
| `codigoMotivo`     | `string` | `cMotivo`      | Motivo (01-Desenquadramento SN, 02-Enquadramento SN, 99-Outros). |
| `descricaoMotivo`  | `string` | `xMotivo`      | Descrição detalhada se o motivo for 99.                          |

---

## ComercioExteriorData

Utilizado para serviços de exportação ou que envolvam partes no exterior.

### Propriedades

| Propriedade                    | Tipo     | Mapeamento XML | Descrição                                          |
| :----------------------------- | :------- | :------------- | :------------------------------------------------- |
| `modoPrestacao`                | `int`    | `mdPrestacao`  | 1-Transfronteiriço, 2-Consumo no Brasil, etc.      |
| `vinculoPrestacao`             | `int`    | `vincPrest`    | 1-Sem vínculo, 2-Com vínculo.                      |
| `tipoMoeda`                    | `string` | `tpMoeda`      | Código ISO 4217 da moeda.                          |
| `valorServicoMoeda`            | `float`  | `vServMoeda`   | Valor na moeda estrangeira.                        |
| `mecanismoApoioComexPrestador` | `string` | `mecAFComexP`  | Mecanismo de apoio ao Comex (Prestador).           |
| `mecanismoApoioComexTomador`   | `string` | `mecAFComexT`  | Mecanismo de apoio ao Comex (Tomador).             |
| `movimentacaoTemporariaBens`   | `string` | `movTempBens`  | Movimentação temporária de bens.                   |
| `numeroDeclaracaoImportacao`   | `string` | `nDI`          | Número da Declaração de Importação.                |
| `numeroRegistroExportacao`     | `string` | `nRE`          | Número do Registro de Exportação.                  |
| `mdic`                         | `string` | `mdic`         | Compartilhamento de dados com MDIC (1-Sim, 2-Não). |
