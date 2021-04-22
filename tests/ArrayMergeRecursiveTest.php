<?php

namespace Rikudou\Tests\ArrayMergeRecursive;

use PHPUnit\Framework\TestCase;
use function Rikudou\ArrayMergeRecursive\array_merge_recursive as custom_array_merge_recursive;
use function array_merge_recursive as original_array_merge_recursive;

class ArrayMergeRecursiveTest extends TestCase
{

    /**
     * Behavior for one dimensional arrays should be identical to array_merge
     */
    public function testOneDimensionalArrays()
    {
        $arraysBothEmpty = [
            [], []
        ];
        $arraysFirstEmpty = [
            [],
            [
                'test' => 'test'
            ]
        ];
        $arraysSecondEmpty = [
            [
                'test' => 'test'
            ],
            []
        ];
        $arraysNoConflict = [
            [
                'test1' => 'test1',
                'test3' => 'test2'
            ],
            [
                'test2' => 'test3',
                'test4' => 'test4'
            ]
        ];
        $arraysConflict = [
            [
                'test1' => 'test1',
                'test2' => 'test2'
            ],
            [
                'test2' => 'test2',
                'test3' => 'test3'
            ]
        ];
        $arraysNumeric = [
            [
                'test1', 'test2', 'test3'
            ],
            [
                'test4', 'test5', 'test6'
            ]
        ];
        $arraysMixedNoConflict = [
            [
                'test1' => 'test1',
                'test2',
                'test3'
            ],
            [
                'test4' => 'test4',
                'test5',
                'test6'
            ]
        ];
        $arraysMixedConflict = [
            [
                'test1' => 'test1',
                'test2',
                'test3'
            ],
            [
                'test1' => 'test4',
                'test5',
                'test6'
            ]
        ];
        $arraysConflictMixedThree = [
            [
                'test1' => 'test1',
                'test2' => 'test2'
            ],
            [
                'test3',
                'test1' => 'test'
            ],
            [
                'test3',
                'test2' => 'test2'
            ]
        ];

        $this->assertEquals(
            array_merge($arraysBothEmpty[0], $arraysBothEmpty[1]),
            custom_array_merge_recursive($arraysBothEmpty[0], $arraysBothEmpty[1])
        );
        $this->assertEquals(
            array_merge($arraysFirstEmpty[0], $arraysFirstEmpty[1]),
            custom_array_merge_recursive($arraysFirstEmpty[0], $arraysFirstEmpty[1])
        );
        $this->assertEquals(
            array_merge($arraysSecondEmpty[0], $arraysSecondEmpty[1]),
            custom_array_merge_recursive($arraysSecondEmpty[0], $arraysSecondEmpty[1])
        );
        $this->assertEquals(
            array_merge($arraysNoConflict[0], $arraysNoConflict[1]),
            custom_array_merge_recursive($arraysNoConflict[0], $arraysNoConflict[1])
        );
        $this->assertEquals(
            array_merge($arraysConflict[0], $arraysConflict[1]),
            custom_array_merge_recursive($arraysConflict[0], $arraysConflict[1])
        );
        $this->assertEquals(
            array_merge($arraysNumeric[0], $arraysNumeric[1]),
            custom_array_merge_recursive($arraysNumeric[0], $arraysNumeric[1])
        );
        $this->assertEquals(
            array_merge($arraysMixedNoConflict[0], $arraysMixedNoConflict[1]),
            custom_array_merge_recursive($arraysMixedNoConflict[0], $arraysMixedNoConflict[1])
        );
        $this->assertEquals(
            array_merge($arraysMixedConflict[0], $arraysMixedConflict[1]),
            custom_array_merge_recursive($arraysMixedConflict[0], $arraysMixedConflict[1])
        );
        $this->assertEquals(
            array_merge($arraysConflictMixedThree[0], $arraysConflictMixedThree[1], $arraysConflictMixedThree[2]),
            custom_array_merge_recursive($arraysConflictMixedThree[0], $arraysConflictMixedThree[1], $arraysConflictMixedThree[2])
        );
    }

    public function testMultiDimensionalArrays()
    {
        $arrays = [
            [
                'first' => 'something',
                'second' => [
                    'third' => 'something-else',
                    'fourth' => [
                        'fifth' => true,
                        'sixth' => false,
                    ]
                ]
            ],
            [
                'first' => 'something2',
                'second' => [
                    'third' => [
                        'something-else' => 'something-else'
                    ],
                    'fourth' => [
                        'fifth' => false,
                        'sixth' => true,
                    ]
                ]
            ]
        ];

        $result = custom_array_merge_recursive($arrays[0], $arrays[1]);
        self::assertEquals('something2', $result['first']);
        self::assertIsArray($result['second']['third']);
        self::assertArrayHasKey('something-else', $result['second']['third']);
        self::assertEquals('something-else', $result['second']['third']['something-else']);
        self::assertFalse($result['second']['fourth']['fifth']);
        self::assertTrue($result['second']['fourth']['sixth']);
    }

}
