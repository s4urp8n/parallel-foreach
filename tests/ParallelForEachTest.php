<?php

use Zver\Common;
use Zver\Parallel;

class ParallelForEachTest extends PHPUnit\Framework\TestCase
{

    use \Zver\Package\Test;

    public static function setUpBeforeClass()
    {

    }

    public static function tearDownAfterClass()
    {

    }

    public function testExeptionCallback()
    {

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Aborting, the callback is not set');

        Parallel::forEach ()
                ->run();
    }

    public function testExeptionArguments()
    {

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Aborting, the arguments is not set');

        Parallel::forEach ()
                ->setCallback(function () {
                })
                ->run();
    }

    public function testNoExeptionEmptyArguments()
    {
        Parallel::forEach ()
                ->setCallback(function () {
                })
                ->setArguments([])
                ->run();
    }

    public function clearTestFiles()
    {
        for ($i = 1; $i <= 4; $i++) {
            file_put_contents(Common::getPackageTestFilePath('test' . $i . '.txt'), '');
        }
    }

    public function testSameResults()
    {
        $this->clearTestFiles();

        $arguments = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $results = [$arguments];

        /**
         * native foreach
         */
        foreach ($arguments as $argument) {
            file_put_contents(Common::getPackageTestFilePath('test1.txt'), $argument . "\n", FILE_APPEND);
        }

        /**
         * concurrents
         */
        for ($i = 2; $i <= 4; $i++) {
            Parallel::forEach ()
                    ->setMaximumConcurrents($i)
                    ->setArguments($arguments)
                    ->setCallback(function ($argument) use ($i) {
                        file_put_contents(Common::getPackageTestFilePath('test' . $i . '.txt'), $argument . "\n", FILE_APPEND);
                    })
                    ->run();
            $currentResult = explode("\n", trim(file_get_contents(Common::getPackageTestFilePath('test' . $i . '.txt'))));
            sort($currentResult);
            $results[] = $currentResult;
        }

        foreach ($results as $result1) {
            foreach ($results as $result2) {
                foreach ($results as $result3) {
                    foreach ($results as $result4) {
                        $this->foreachSame([
                                               [
                                                   $result1,
                                                   $result2,
                                               ],
                                               [
                                                   $result3,
                                                   $result4,
                                               ],
                                           ]);
                    }
                }
            }
        }

        $this->clearTestFiles();

    }

}