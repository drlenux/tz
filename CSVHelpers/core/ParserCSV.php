<?php

declare(strict_types=1);

namespace DrLenux\Helpers\CSV\core;

/**
 * Class Parser
 * @package DrLenux\Helpers\CSV
 */
class ParserCSV
{
    /**
     * @var bool|resource
     */
    private $fp;
    /**
     * @var bool
     */
    private $parse_header;
    /**
     * @var array|false|null
     */
    private $header;
    /**
     * @var string
     */
    private $delimiter;
    /**
     * @var int
     */
    private $length;

    /**
     * Parser constructor.
     * @param Params $params
     * @param int $length
     */
    public function __construct(Params $params, int $length = 8000)
    {

        $this->fp = fopen($params->getCsvPath(), "r");
        $this->parse_header = $params->isParseHeader();
        $this->delimiter = $params->getDelimiter();
        $this->length = $length;

        if ($this->parse_header) {
            $this->header = fgetcsv($this->fp, $this->length, $this->delimiter);
        }

    }

    /**
     *
     */
    public function __destruct()
    {
        if ($this->fp) {
            fclose($this->fp);
        }
    }

    /**
     * @param int $max_lines
     * @return array
     */
    public function get(int $max_lines = 0): array
    {
        $data = array();
        foreach ($this->stepsGet($max_lines) as $row) {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * @param int $max_lines
     * @return \Generator
     */
    public function stepsGet(int $max_lines = 0): \Generator
    {

        if ($max_lines > 0)
            $line_count = 0;
        else
            $line_count = -1; // so loop limit is ignored

        while ($line_count < $max_lines && ($row = fgetcsv($this->fp, $this->length, $this->delimiter)) !== FALSE) {
            if ($this->parse_header) {
                $row_new = [];
                foreach ($this->header as $i => $heading_i) {
                    $row_new[$heading_i] = $row[$i];
                }
                yield $row_new;
            } else {
                yield $row;
            }

            if ($max_lines > 0)
                $line_count++;
        }
    }
}