<?php

/*
 * This file is part of the PHP-LCS package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ezzatron\LCS;

class LCSSolver
{
    /**
     * Returns the longest common subsequence of the given arrays.
     *
     * See http://en.wikipedia.org/wiki/Longest_common_subsequence_problem
     *
     * @param  array $left            The first array.
     * @param  array $right           The second array.
     * @param  array $additional,...  Any number of additional arrays.
     *
     * @return array The longest common subsequence.
     */
    public function longestCommonSubsequence(array $left, array $right)
    {
        if (func_num_args() > 2) {
            $arguments = func_get_args();
            array_splice(
                $arguments,
                0,
                2,
                array(
                    $this->longestCommonSubsequence($left, $right)
                )
            );

            return call_user_func_array(
                array($this, 'longestCommonSubsequence'),
                $arguments
            );
        }

        $m = count($left);
        $n = count($right);

        // $a[$i][$j] = length of LCS of $left[$i..$m] and $right[$j..$n]
        $a = array();

        // compute length of LCS and all subproblems via dynamic programming
        for ($i = $m - 1; $i >= 0; $i--) {
            for ($j = $n - 1; $j >= 0; $j--) {
                if ($left[$i] === $right[$j]) {
                    $a[$i][$j] =
                        (
                            isset($a[$i + 1][$j + 1]) ?
                            $a[$i + 1][$j + 1] :
                            0
                        ) +
                        1
                    ;
                } else {
                    $a[$i][$j] = max(
                        (
                            isset($a[$i + 1][$j]) ?
                            $a[$i + 1][$j] :
                            0
                        ),
                        (
                            isset($a[$i][$j + 1]) ?
                            $a[$i][$j + 1] :
                            0
                        )
                    );
                }
            }
        }

        // recover LCS itself
        $i = 0;
        $j = 0;
        $lcs = array();

        while($i < $m && $j < $n) {
            if ($left[$i] === $right[$j]) {
                $lcs[] = $left[$i];

                $i++;
                $j++;
            } elseif (
                (
                    isset($a[$i + 1][$j]) ?
                    $a[$i + 1][$j] :
                    0
                ) >=
                (
                    isset($a[$i][$j + 1]) ?
                    $a[$i][$j + 1] :
                    0
                )
            ) {
                $i++;
            } else {
                $j++;
            }
        }

        return $lcs;
    }
}
