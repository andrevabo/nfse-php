<?php

namespace Nfse\Enums;

/**
 * Tipo de Retenção do PIS/COFINS e CSLL
 */
enum TipoRetencaoPisCofins: int
{
    /**
     * PIS/COFINS/CSLL Não Retidos
     */
    case NaoRetidos = 0;

    /**
     * PIS/COFINS Retido
     */
    case PisCofinsRetido = 1;

    /**
     * PIS/COFINS Não Retido
     */
    case PisCofinsNaoRetido = 2;

    /**
     * PIS/COFINS/CSLL Retidos
     */
    case Retidos = 3;

    /**
     * PIS/COFINS Retidos, CSLL Não Retido
     */
    case PisCofinsRetidosCsllNaoRetido = 4;

    /**
     * PIS Retido, COFINS/CSLL Não Retido
     */
    case PisRetidoCofinsCsllNaoRetido = 5;

    /**
     * COFINS Retido, PIS/CSLL Não Retido
     */
    case CofinsRetidoPisCsllNaoRetido = 6;

    /**
     * PIS Não Retido, COFINS/CSLL Retidos
     */
    case PisNaoRetidoCofinsCsllRetidos = 7;

    /**
     * PIS/COFINS Não Retidos, CSLL Retido
     */
    case PisCofinsNaoRetidosCsllRetido = 8;

    /**
     * COFINS Não Retido, PIS/CSLL Retidos
     */
    case CofinsNaoRetidoPisCsllRetidos = 9;

    public function getDescription(): string
    {
        return match ($this) {
            self::NaoRetidos => 'PIS/COFINS/CSLL Não Retidos',
            self::PisCofinsRetido => 'PIS/COFINS Retido',
            self::PisCofinsNaoRetido => 'PIS/COFINS Não Retido',
            self::Retidos => 'PIS/COFINS/CSLL Retidos',
            self::PisCofinsRetidosCsllNaoRetido => 'PIS/COFINS Retidos, CSLL Não Retido',
            self::PisRetidoCofinsCsllNaoRetido => 'PIS Retido, COFINS/CSLL Não Retido',
            self::CofinsRetidoPisCsllNaoRetido => 'COFINS Retido, PIS/CSLL Não Retido',
            self::PisNaoRetidoCofinsCsllRetidos => 'PIS Não Retido, COFINS/CSLL Retidos',
            self::PisCofinsNaoRetidosCsllRetido => 'PIS/COFINS Não Retidos, CSLL Retido',
            self::CofinsNaoRetidoPisCsllRetidos => 'COFINS Não Retido, PIS/CSLL Retidos',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
