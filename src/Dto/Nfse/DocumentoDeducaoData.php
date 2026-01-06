<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class DocumentoDeducaoData extends DataTransferObject
{
    /**
     * Chave de NFS-e.
     */
    #[MapFrom('chNFSe')]
    public ?string $chaveNfse = null;

    /**
     * Chave de NF-e.
     */
    #[MapFrom('chNFe')]
    public ?string $chaveNfe = null;

    /**
     * Tipo de dedução/redução.
     */
    #[MapFrom('tpDedRed')]
    public ?int $tipoDeducaoReducao = null;

    /**
     * Descrição de outras deduções.
     */
    #[MapFrom('xDescOutDed')]
    public ?string $descricaoOutrasDeducoes = null;

    /**
     * Data de emissão do documento.
     */
    #[MapFrom('dEmiDoc')]
    public ?string $dataEmissaoDocumento = null;

    /**
     * Valor dedutível/redutível.
     */
    #[MapFrom('vDedutivelRedutivel')]
    public ?float $valorDedutivelRedutivel = null;

    /**
     * Valor de dedução/redução.
     */
    #[MapFrom('vDeducaoReducao')]
    public ?float $valorDeducaoReducao = null;
}
