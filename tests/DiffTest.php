<?php
/**
 * @author Timur Kasumov (aka XAKEPEHOK)
 * Datetime: 07.08.2019 20:28
 */

namespace XAKEPEHOK\Diff;


use PHPUnit\Framework\TestCase;

class DiffTest extends TestCase
{

    public function testCalc()
    {
        $left = [
            [
                'key' => 'none_0',
                'value' => 'none_0'
            ],
            [
                'key' => 'none_1',
                'value' => 'none_1'
            ],
            [
                'key' => 'deleted_1',
                'value' => 'deleted_1'
            ],
            [
                'key' => 'none_2',
                'value' => 'none_2'
            ],
            [
                'key' => 'deleted_2',
                'value' => 'deleted_2'
            ],
        ];

        $right = [
            [
                'key' => 'inserted_1',
                'value' => 'inserted_1'
            ],
            [
                'key' => 'none_1',
                'value' => 'none_1'
            ],
            [
                'key' => 'none_0',
                'value' => 'none_0'
            ],
            [
                'key' => 'none_2',
                'value' => 'none_2'
            ],
            [
                'key' => 'inserted_2',
                'value' => 'inserted_2'
            ],
        ];

        $diff = new Diff();
        $result = $diff->calc($left, $right);
        return $result;
    }

}
