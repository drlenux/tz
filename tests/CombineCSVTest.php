<?php

declare(strict_types=1);

/**
 * Class CombineCSVTest
 */
class CombineCSVTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    private $tmpDir;

    private function init()
    {
        $data = [
            'master' => [
                ['test'],
                ['make'],
                ['final'],
                ['release']
            ],
            'slave' => [
                ['cloud master'],
                ['make install'],
                ['final project'],
                ['final state']
            ]
        ];
        $this->tmpDir = __DIR__ . '/tmp/CombineCSVTest/';

        if (!file_exists($this->tmpDir)) {
            mkdir($this->tmpDir, 0755);
        }

        $this->createCSV($this->tmpDir . 'master.csv', $data['master']);
        $this->createCSV($this->tmpDir . 'slave.csv', $data['slave']);
    }

    private function createCSV(string $path, array $data): void
    {
        $fp = fopen($path, 'w');
        foreach ($data as $item) {
            fputcsv($fp, $item, ',');
        }
        fclose($fp);
    }

    public function testCombineStrPosCount()
    {
        $this->init();

        $combineType = new \DrLenux\Helpers\CSV\combine\CombineStrPosCount(1, 0, 0);
        (new \DrLenux\Helpers\CSV\CombineCSV())
            ->setPathToSlaveCSV($this->tmpDir . 'slave.csv')
            ->setPathToMainCSV($this->tmpDir . 'master.csv')
            ->setDelimiterToSlaveCSV(',')
            ->setDelimiterToMainCSV(',')
            ->run($combineType);

        $fp = fopen($this->tmpDir . 'master.csv', 'r');

        $res = [];
        while ($data = fgetcsv($fp)) {
            $res[] = $data;
        }
        fclose($fp);

        $this->assertEquals($this->expectedDataForCombineStrPosCount(), $res);
    }

    public function expectedDataForCombineStrPosCount(): array
    {
        return [
            ['test', 0],
            ['make', 1],
            ['final', 2],
            ['release', 0]
        ];
    }
}