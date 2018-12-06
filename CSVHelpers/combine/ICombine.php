<?php

declare(strict_types=1);

namespace DrLenux\Helpers\CSV\combine;

use DrLenux\Helpers\CSV\core\Params;

/**
 * Interface ICombine
 * @package DrLenux\Helpers\CSV\combine
 */
interface ICombine
{
    /**
     * @param Params $main
     * @param Params $slave
     */
    public function run(Params $main, Params $slave): void;
}