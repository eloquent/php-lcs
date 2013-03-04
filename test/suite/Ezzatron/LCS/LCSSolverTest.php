<?php

/*
 * This file is part of the PHP-LCS package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ezzatron\LCS;

use PHPUnit_Framework_TestCase;

class LCSSolverTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->_solver = new LCSSolver;
    }

    public function longestCommonSubsequenceData()
    {
        $data = array();

        $left = array('A', 'B', 'C');
        $right = array('A', 'B', 'C');
        $expected = array('A', 'B', 'C');
        $data['All elements equal'] = array($expected, $left, $right);

        $left = array('A', 'B', 'C', 'D', 'E', 'F');
        $right = array('B', 'C', 'D', 'E');
        $expected = array('B', 'C', 'D', 'E');
        $data['Second sequence is a subsequence of first'] = array($expected, $left, $right);

        $left = array('A', 'B', 'D', 'E');
        $right = array('A', 'C', 'D', 'F');
        $expected = array('A', 'D',);
        $data['Basic common subsequence'] = array($expected, $left, $right);

        $left = array('A', 'B', 'C', 'D', 'E', 'F');
        $right = array('J', 'A', 'D', 'F', 'A', 'F', 'K', 'D', 'F', 'B', 'C', 'D', 'E', 'H', 'J', 'D', 'F', 'G');
        $expected = array('A', 'B', 'C', 'D', 'E', 'F');
        $data['Common subsequence of larger data set'] = array($expected, $left, $right);

        $left = array('A', 'B', 'C', 'D', 'E', 'F');
        $right = array('A');
        $expected = array('A');
        $data[] = array($expected, $left, $right);

        $left = array('A', 'B', 'C', 'D', 'E', 'F');
        $right = array('D');
        $expected = array('D');
        $data['Single element subsequence'] = array($expected, $left, $right);

        $left = array('A', 'B', 'C', 'D', 'E', 'F');
        $right = array('F');
        $expected = array('F');
        $data['Single element subsequence at end of other sequence'] = array($expected, $left, $right);

        $left = array('J', 'A', 'F', 'A', 'F', 'K', 'D', 'B', 'C', 'E', 'H', 'J', 'D', 'F');
        $right = array('J', 'D', 'F', 'A', 'K', 'D', 'F', 'C', 'D', 'E', 'J', 'D', 'F', 'G');
        $expected = array('J', 'F', 'A', 'K', 'D', 'C', 'E', 'J', 'D', 'F');
        $data['Elements after end of first sequence'] = array($expected, $left, $right);

        $left = array('A', 'B', 'C');
        $right = array('D', 'E', 'F');
        $expected = array();
        $data['No common elements'] = array($expected, $left, $right);

        $left = array('B', 'A', 'N', 'A', 'N', 'A');
        $right = array('A', 'T', 'A', 'N', 'A');
        $expected = array('A', 'A', 'N', 'A');
        $data['README example'] = array($expected, $left, $right);

        $first = array('A', 'B', 'D', 'E', 'G', 'H');
        $second = array('A', 'D', 'G', 'J');
        $third = array('B', 'C', 'D', 'E', 'F', 'G');
        $expected = array('D', 'G');
        $data['Three-way subsequence'] = array($expected, $first, $second, $third);

        return $data;
    }

    /**
     * @dataProvider longestCommonSubsequenceData
     */
    public function testLongestCommonSubsequence(array $expected, array $left, array $right)
    {
        $arguments = func_get_args();
        array_shift($arguments);

        $this->assertSame($expected, call_user_func_array(
            array($this->_solver, 'longestCommonSubsequence'),
            $arguments
        ));
        $this->assertSame($expected, call_user_func_array(
            array($this->_solver, 'longestCommonSubsequence'),
            array_reverse($arguments)
        ));
    }
}
