<?php

/*
 * This file is part of the PHP-LCS package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Lcs;

use PHPUnit_Framework_TestCase;

class LcsSolverTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->solver = new LcsSolver;
    }

    public function testConstructor()
    {
        $comparator = function () {};
        $this->solver = new LcsSolver($comparator);

        $this->assertSame($comparator, $this->solver->comparator());
    }

    public function testConstructorDefaults()
    {
        $this->assertTrue(is_callable($this->solver->comparator()));
    }

    public function longestCommonSubsequenceData()
    {
        return array(
            'All elements equal' => array(
                array('A', 'B', 'C'),
                array('A', 'B', 'C'),
                array('A', 'B', 'C'),
            ),
            'Second sequence is a subsequence of first' => array(
                array('A', 'B', 'C', 'D', 'E', 'F'),
                array('B', 'C', 'D', 'E'),
                array('B', 'C', 'D', 'E'),
            ),
            'Basic common subsequence' => array(
                array('A', 'B', 'D', 'E'),
                array('A', 'C', 'D', 'F'),
                array('A', 'D'),
            ),
            'Common subsequence of larger data set' => array(
                array('A', 'B', 'C', 'D', 'E', 'F'),
                array('J', 'A', 'D', 'F', 'A', 'F', 'K', 'D', 'F', 'B', 'C', 'D', 'E', 'H', 'J', 'D', 'F', 'G'),
                array('A', 'B', 'C', 'D', 'E', 'F'),
            ),
            'Single element subsequence at start' => array(
                array('A', 'B', 'C', 'D', 'E', 'F'),
                array('A'),
                array('A'),
            ),
            'Single element subsequence at middle' => array(
                array('A', 'B', 'C', 'D', 'E', 'F'),
                array('D'),
                array('D'),
            ),
            'Single element subsequence at end' => array(
                array('A', 'B', 'C', 'D', 'E', 'F'),
                array('F'),
                array('F'),
            ),
            'Elements after end of first sequence' => array(
                array('J', 'A', 'F', 'A', 'F', 'K', 'D', 'B', 'C', 'E', 'H', 'J', 'D', 'F'),
                array('J', 'D', 'F', 'A', 'K', 'D', 'F', 'C', 'D', 'E', 'J', 'D', 'F', 'G'),
                array('J', 'F', 'A', 'K', 'D', 'C', 'E', 'J', 'D', 'F'),
            ),
            'No common elements' => array(
                array('A', 'B', 'C'),
                array('D', 'E', 'F'),
                array(),
            ),
            'README example' => array(
                array('B', 'A', 'N', 'A', 'N', 'A'),
                array('A', 'T', 'A', 'N', 'A'),
                array('A', 'A', 'N', 'A'),
            ),
        );
    }

    /**
     * @dataProvider longestCommonSubsequenceData
     */
    public function testLongestCommonSubsequence($sequenceA, $sequenceB, $expected)
    {
        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceA, $sequenceB));
        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceB, $sequenceA));
    }

    public function testLongestCommonSubsequence3Way()
    {
        $sequenceA = array('A', 'B', 'D', 'E', 'G', 'H');
        $sequenceB = array('A', 'D', 'G', 'J');
        $sequenceC = array('B', 'C', 'D', 'E', 'F', 'G');
        $expected = array('D', 'G');

        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceA, $sequenceB, $sequenceC));
        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceA, $sequenceC, $sequenceB));
        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceB, $sequenceA, $sequenceC));
        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceB, $sequenceC, $sequenceA));
        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceC, $sequenceA, $sequenceB));
        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceC, $sequenceB, $sequenceA));
    }

    public function testLongestCommonSubsequenceCustomComparator()
    {
        $comparator = function ($left, $right) {
            return strtolower($left) === strtolower($right);
        };
        $this->solver = new LcsSolver($comparator);
        $sequenceA = array('B', 'A', 'N', 'A', 'N', 'A');
        $sequenceB = array('a', 't', 'a', 'n', 'a');
        $expected = array('A', 'A', 'N', 'A');

        $this->assertSame($expected, $this->solver->longestCommonSubsequence($sequenceA, $sequenceB));
    }
}
