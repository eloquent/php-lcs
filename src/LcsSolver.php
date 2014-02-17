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

/**
 * Solves longest common subsequence problems.
 */
class LcsSolver implements LcsSolverInterface
{
    /**
     * Construct a new LCS solver.
     *
     * If supplied, the comparator should take two arguments, and return a
     * boolean indicating whether they are equal.
     *
     * @param callable|null $comparator The comparator to use when comparing sequence members.
     */
    public function __construct($comparator = null)
    {
        if (null === $comparator) {
            $comparator = function ($left, $right) {
                return $left === $right;
            };
        }

        $this->comparator = $comparator;
    }

    /**
     * Get the comparator.
     *
     * @return callable The comparator.
     */
    public function comparator()
    {
        return $this->comparator;
    }

    /**
     * Returns the longest common subsequence of the given sequences.
     *
     * @link http://en.wikipedia.org/wiki/Longest_common_subsequence_problem
     *
     * @param array<integer,mixed> $sequenceA      The first sequence.
     * @param array<integer,mixed> $sequenceB      The second sequence.
     * @param array<integer,mixed> $additional,... Any number of additional sequences.
     *
     * @return array<integer,mixed> The longest common subsequence.
     */
    public function longestCommonSubsequence(array $sequenceA, array $sequenceB)
    {
        if (func_num_args() > 2) {
            $arguments = func_get_args();
            array_splice(
                $arguments,
                0,
                2,
                array($this->longestCommonSubsequence($sequenceA, $sequenceB))
            );

            return call_user_func_array(
                array($this, 'longestCommonSubsequence'),
                $arguments
            );
        }

        $comparator = $this->comparator();

        $m = count($sequenceA);
        $n = count($sequenceB);

        // $a[$i][$j] = length of LCS of $sequenceA[$i..$m] and $sequenceB[$j..$n]
        $a = array();

        // compute length of LCS and all subproblems via dynamic programming
        for ($i = $m - 1; $i >= 0; $i--) {
            for ($j = $n - 1; $j >= 0; $j--) {
                if ($comparator($sequenceA[$i], $sequenceB[$j])) {
                    $a[$i][$j] =
                        (isset($a[$i + 1][$j + 1]) ? $a[$i + 1][$j + 1] : 0) +
                        1;
                } else {
                    $a[$i][$j] = max(
                        (isset($a[$i + 1][$j]) ? $a[$i + 1][$j] : 0),
                        (isset($a[$i][$j + 1]) ? $a[$i][$j + 1] : 0)
                    );
                }
            }
        }

        // recover LCS itself
        $i = 0;
        $j = 0;
        $lcs = array();

        while ($i < $m && $j < $n) {
            if ($comparator($sequenceA[$i], $sequenceB[$j])) {
                $lcs[] = $sequenceA[$i];

                $i++;
                $j++;
            } elseif (
                (isset($a[$i + 1][$j]) ? $a[$i + 1][$j] : 0) >=
                (isset($a[$i][$j + 1]) ? $a[$i][$j + 1] : 0)
            ) {
                $i++;
            } else {
                $j++;
            }
        }

        return $lcs;
    }

    private $comparator;
}
