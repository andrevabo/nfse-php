<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class TributacaoData extends DataTransferObject
{
    /**
     * Tributação do ISSQN.
     * 1 - Operação tributável
     * 2 - Imunidade
     * 3 - Exportação de serviço
     * 4 - Não Incidência
     */
    #[MapFrom('tribMun.tribISSQN')]
    public ?int $tributacaoIssqn = null;

    /**
     * Tipo de imunidade.
     * Obrigatório se tribISSQN = 2.
     * 0 - Imunidade (tipo não informado na nota de origem)
     * 1 - Patrimônio, renda ou serviços, uns dos outros (CF88, Art 150, VI, a)
     * 2 - Templos de qualquer culto (CF88, Art 150, VI, b)
     * 3 - Patrimônio, renda ou serviços dos partidos políticos, inclusive suas fundações, das entidades sindicais dos trabalhadores, das instituições de educação e de assistência social, sem fins lucrativos, atendidos os requisitos da lei (CF88, Art 150, VI, c)
     * 4 - Livros, jornais, periódicos e o papel destinado a sua impressão (CF88, Art 150, VI, d)
     */
    #[MapFrom('tribMun.tpImunidade')]
    public ?int $tipoImunidade = null;

    /**
     * Tipo de retencao do ISSQN.
     * 1 - Não Retido
     * 2 - Retido pelo Tomador
     * 3 - Retido pelo Intermediario
     */
    #[MapFrom('tribMun.tpRetISSQN')]
    public ?int $tipoRetencaoIssqn = null;

    /**
     * Suspensão da exigibilidade do ISSQN.
     * 1 - Suspenso por decisão judicial
     * 2 - Suspenso por decisão administrativa
     */
    #[MapFrom('tribMun.exigSusp.tpSusp')]
    public ?int $tipoSuspensao = null;

    /**
     * Número do processo judicial ou administrativo de suspensão da exigibilidade.
     */
    #[MapFrom('tribMun.exigSusp.nProcesso')]
    public ?string $numeroProcessoSuspensao = null;

    /**
     * Benefício Municipal.
     */
    #[MapFrom('tribMun.BM')]
    public ?BeneficioMunicipalData $beneficioMunicipal = null;

    /**
     * Código da Situação Tributária do PIS/COFINS.
     */
    #[MapFrom('tribFed.piscofins.CST')]
    public ?string $cstPisCofins = null;

    /**
     * Base de cálculo PIS/COFINS.
     */
    #[MapFrom('tribFed.piscofins.vBCPisCofins')]
    public ?float $baseCalculoPisCofins = null;

    /**
     * Alíquota PIS.
     */
    #[MapFrom('tribFed.piscofins.pAliqPis')]
    public ?float $aliquotaPis = null;

    /**
     * Alíquota COFINS.
     */
    #[MapFrom('tribFed.piscofins.pAliqCofins')]
    public ?float $aliquotaCofins = null;

    /**
     * Valor PIS.
     */
    #[MapFrom('tribFed.piscofins.vPis')]
    public ?float $valorPis = null;

    /**
     * Valor COFINS.
     */
    #[MapFrom('tribFed.piscofins.vCofins')]
    public ?float $valorCofins = null;

    /**
     * Tipo de Retenção PIS/COFINS.
     * 1 - Não Retido
     * 2 - Retido
     */
    #[MapFrom('tribFed.piscofins.tpRetPisCofins')]
    public ?int $tipoRetencaoPisCofins = null;

    /**
     * Valor retido de IRRF.
     */
    #[MapFrom('tribFed.vRetIRRF')]
    public ?float $valorRetidoIrrf = null;

    /**
     * Valor retido de CSLL.
     */
    #[MapFrom('tribFed.vRetCSLL')]
    public ?float $valorRetidoCsll = null;

    /**
     * Valor total dos tributos federais.
     */
    #[MapFrom('totTrib.vTotTrib.vTotTribFed')]
    public ?float $valorTotalTributosFederais = null;

    /**
     * Valor total dos tributos estaduais.
     */
    #[MapFrom('totTrib.vTotTrib.vTotTribEst')]
    public ?float $valorTotalTributosEstaduais = null;

    /**
     * Valor total dos tributos municipais.
     */
    #[MapFrom('totTrib.vTotTrib.vTotTribMun')]
    public ?float $valorTotalTributosMunicipais = null;

    /**
     * Valor percentual total aproximado dos tributos federais, estaduais e municipais.
     */
    #[MapFrom('totTrib.pTotTribSN')]
    public ?float $percentualTotalTributosSN = null;

    /**
     * Indicador de informação de valor total de tributos.
     * 0 - Nenhum
     */
    #[MapFrom('totTrib.indTotTrib')]
    public ?int $indicadorTotalTributos = null;
}
