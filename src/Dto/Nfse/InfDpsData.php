<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class InfDpsData extends DataTransferObject
{
    /**
     * Identificador da DPS.
     * Formado por: "DPS" + Cód.Mun.Emi. + Tipo Inscrição + Inscrição + Série + Número.
     */
    #[MapFrom('@Id')]
    public ?string $id = null;

    /**
     * Ambiente de emissão.
     * 1 - Produção
     * 2 - Homologação
     */
    #[MapFrom('tpAmb')]
    public ?int $tipoAmbiente = null;

    /**
     * Data e hora de emissão da DPS.
     * Formato: AAAA-MM-DDThh:mm:ssTZD
     */
    #[MapFrom('dhEmi')]
    public ?string $dataEmissao = null;

    /**
     * Versão do aplicativo emissor.
     */
    #[MapFrom('verAplic')]
    public ?string $versaoAplicativo = null;

    /**
     * Série da DPS.
     */
    #[MapFrom('serie')]
    public ?string $serie = null;

    /**
     * Número da DPS.
     */
    #[MapFrom('nDPS')]
    public ?string $numeroDps = null;

    /**
     * Data de competência da DPS.
     * Formato: AAAA-MM-DD
     */
    #[MapFrom('dCompet')]
    public ?string $dataCompetencia = null;

    /**
     * Tipo de emitente da DPS.
     * 1 - Prestador
     * 2 - Tomador
     * 3 - Intermediário
     */
    #[MapFrom('tpEmit')]
    public ?int $tipoEmitente = null;

    /**
     * Código do município emissor da DPS (IBGE).
     */
    #[MapFrom('cLocEmi')]
    public ?string $codigoLocalEmissao = null;

    /**
     * Motivo da emissão da DPS pelo Tomador ou Intermediário.
     * Obrigatório se tpEmit = 2 ou 3.
     */
    #[MapFrom('cMotivoEmisTI')]
    public ?string $motivoEmissaoTomadorIntermediario = null;

    /**
     * Chave de acesso da NFS-e rejeitada.
     * Obrigatório se cMotivoEmisTI = 4.
     */
    #[MapFrom('chNFSeRej')]
    public ?string $chaveNfseRejeitada = null;

    /**
     * Informações de substituição de NFS-e.
     */
    #[MapFrom('subst')]
    public ?SubstituicaoData $substituicao = null;

    /**
     * Dados do prestador do serviço.
     */
    #[MapFrom('prest')]
    public ?PrestadorData $prestador = null;

    /**
     * Dados do tomador do serviço.
     */
    #[MapFrom('toma')]
    public ?TomadorData $tomador = null;

    /**
     * Dados do intermediário do serviço.
     */
    #[MapFrom('interm')]
    public ?IntermediarioData $intermediario = null;

    /**
     * Dados do serviço prestado.
     */
    #[MapFrom('serv')]
    public ?ServicoData $servico = null;

    /**
     * Valores do serviço e tributos.
     */
    #[MapFrom('valores')]
    public ?ValoresData $valores = null;
}
