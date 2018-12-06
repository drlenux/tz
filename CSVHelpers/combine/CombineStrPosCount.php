<?php

namespace DrLenux\Helpers\CSV\combine;

use DrLenux\Helpers\CSV\core\Params;
use DrLenux\Helpers\CSV\core\ParserCSV;

/**
 * Class CombineStrPosCount
 * @package DrLenux\Helpers\CSV\combine
 */
class CombineStrPosCount implements ICombine
{
    private $data = [];

    /**
     * @var string
     */
    private $updateFieldName = '';

    /**
     * for whom to search
     *
     * @var string
     */
    private $searchInField = '';

    /**
     * where to do a search
     *
     * @var string
     */
    private $searchForField = '';

    /**
     * CombineStrPosCount constructor.
     * @param string|int $updateFieldName
     * @param string|int $searchInField [for whom to search]
     * @param string|int $searchForField [where to do a search]
     */
    public function __construct($updateFieldName, $searchInField, $searchForField)
    {
        $this->updateFieldName = $updateFieldName;
        $this->searchInField = $searchInField;
        $this->searchForField = $searchForField;
    }

    /**
     * @param Params $main
     * @param Params $slave
     */
    public function run(Params $main, Params $slave): void
    {
        $this->fillData($main);
        $this->parseSlave($slave);
        $this->saveChange($main);
    }

    /**
     * @param Params $main
     */
    private function fillData(Params $main): void
    {
        $dataMain = (new ParserCSV($main))->get();
        foreach ($dataMain as $item) {
            $this->data[$item[$this->searchInField]] = 0;
        }
    }

    /**
     * @param Params $slave
     */
    private function parseSlave(Params $slave): void
    {
        $dataSlave = (new ParserCSV($slave));

        foreach ($dataSlave->stepsGet() as $row) {
            $forSearch = $row[$this->searchForField];

            foreach ($this->data as $key => &$count) {
                if (false !== strpos($forSearch, $key)) {
                    $count++;
                    break 1;
                }
            }
        }
    }

    /**
     * @param Params $main
     */
    private function saveChange(Params $main): void
    {
        unlink($main->getCsvPath());
        $fp = fopen($main->getCsvPath(), 'w');

        foreach ($this->data as $key => $count) {
            $row = [
                $this->searchInField => $key,
                $this->updateFieldName => $count
            ];
            fputcsv($fp, $row, $main->getDelimiter());
        }
        fclose($fp);
    }
}