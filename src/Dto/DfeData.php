<?php

namespace Nfse\Dto;

use Nfse\Enums\DfeType;
use Spatie\LaravelData\Data;

/**
 * @typescript
 */
abstract class DfeData extends Data
{
    abstract public function getType(): DfeType;
}
