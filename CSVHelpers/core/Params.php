<?php

declare(strict_types=1);

namespace DrLenux\Helpers\CSV\core;

/**
 * Class Params
 * @package DrLenux\Helpers\CSV\core
 */
class Params
{
    /**
     * @var string
     */
    private $csvPath;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var bool
     */
    private $parseHeader = false;

    /**
     * @return bool
     */
    public function isParseHeader(): bool
    {
        return $this->parseHeader;
    }

    /**
     * @param bool $parseHeader
     */
    public function setParseHeader(bool $parseHeader): void
    {
        $this->parseHeader = $parseHeader;
    }

    /**
     * @return string
     */
    public function getCsvPath(): string
    {
        return $this->csvPath;
    }

    /**
     * @param string $csvPath
     */
    public function setCsvPath(string $csvPath): void
    {
        $this->csvPath = $csvPath;
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter(string $delimiter): void
    {
        $this->delimiter = $delimiter;
    }
}