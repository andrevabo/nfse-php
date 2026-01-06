<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class RegimeTributarioData extends DataTransferObject
{
    /**
     * Opção pelo Simples Nacional.
     * 1 - Não Optante
     * 2 - Optante - Microempreendedor Individual (MEI)
     * 3 - Optante - Microempresa ou Empresa de Pequeno Porte (ME/EPP)
     */
    #[MapFrom('opSimpNac')]
    public ?int $opcaoSimplesNacional = null;

    /**
     * Regime de apuração dos tributos (SN).
     * Obrigatório se opSimpNac = 3.
     * 1 - Regime de apuração dos tributos federais e municipal pelo SN
     * 2 - Regime de apuração dos tributos federais pelo SN e municipal pelo regime normal (ISSQN)
     */
    #[MapFrom('regApTribSN')]
    public ?int $regimeApuracaoTributosSn = null;

    /**
     * Regime Especial de Tributação.
     * 0 - Nenhum
     * 1 - Ato Cooperado (Cooperativa)
     * 2 - Estimativa
     * 3 - Microempresa Municipal
     * 4 - Notário ou Registrador
     * 5 - Profissional Autônomo
     * 6 - Sociedade de Profissionais
     */
    #[MapFrom('regEspTrib')]
    public ?int $regimeEspecialTributacao = null;
}
