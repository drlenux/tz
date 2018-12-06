<?php

namespace DrLenux\Helpers\CSV;

use DrLenux\Helpers\CSV\combine\ICombine;
use DrLenux\Helpers\CSV\core\Params;

/**
 * Class CombineCSV
 * @package DrLenux\Helpers\CSV
 */
class CombineCSV
{
    /**
     * @var Params
     */
    private $paramsMain;

    /**
     * @var Params
     */
    private $paramsSlave;

    /**
     * Combine constructor.
     */
    public function __construct()
    {
        $this->paramsMain = new Params();
        $this->paramsSlave = new Params();
    }

    /**
     * @param string $path
     * @return CombineCSV
     */
    public function setPathToMainCSV(string $path): self
    {
        $this->paramsMain->setCsvPath($path);
        return $this;
    }

    /**
     * @param string $path
     * @return CombineCSV
     */
    public function setPathToSlaveCSV(string $path): self
    {
        $this->paramsSlave->setCsvPath($path);
        return $this;
    }

    /**
     * @param string $delimiter
     * @return CombineCSV
     */
    public function setDelimiterToMainCSV(string $delimiter): self
    {
        $this->paramsMain->setDelimiter($delimiter);
        return $this;
    }

    /**
     * @param string $delimiter
     * @return CombineCSV
     */
    public function setDelimiterToSlaveCSV(string $delimiter): self
    {
        $this->paramsSlave->setDelimiter($delimiter);
        return $this;
    }

    /**
     * @param bool $parseHeader
     * @return CombineCSV
     */
    public function setParseHeaderToMainCSV(bool $parseHeader = true): self
    {
        $this->paramsMain->setParseHeader($parseHeader);
        return $this;
    }

    /**
     * @param bool $parseHeader
     * @return CombineCSV
     */
    public function setParseHeaderToSlaveCSV(bool $parseHeader = true): self
    {
        $this->paramsSlave->setParseHeader($parseHeader);
        return $this;
    }

    /**
     * @param ICombine $combineMethod
     */
    public function run(ICombine $combineMethod): void
    {
        $combineMethod->run($this->paramsMain, $this->paramsSlave);
    }
}