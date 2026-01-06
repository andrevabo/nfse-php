<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class SubstituicaoData extends DataTransferObject
{
    /**
     * Chave de acesso da NFS-e a ser substituída.
     */
    #[MapFrom('chSubstda')]
    public ?string $chaveNfseSubstituida = null;

    /**
     * Código do motivo da substituição.
     * 01 - Desenquadramento de NFS-e do Simples Nacional
     * 02 - Enquadramento de NFS-e no Simples Nacional
     * 99 - Outros
     */
    #[MapFrom('cMotivo')]
    public ?string $codigoMotivo = null;

    /**
     * Descrição do motivo da substituição.
     * Obrigatório se cMotivo = 99.
     */
    #[MapFrom('xMotivo')]
    public ?string $descricaoMotivo = null;
}
