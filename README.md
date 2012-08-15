# PHP-LCS

*An implementation of the 'longest common subsequence' algorithm for PHP.*

## What is PHP-LCS?

PHP-LCS is a PHP implementation of an algorithm to solve the 'longest common
subsequence' problem.

From [Wikipedia](http://en.wikipedia.org/wiki/Longest_common_subsequence_problem):

> The **longest common subsequence (LCS) problem** is to find the longest
> [subsequence](http://en.wikipedia.org/wiki/Subsequence) common to all
> sequences in a set of sequences (often just two). Note that subsequence is
> different from a substring, see
> [substring vs. subsequence](http://en.wikipedia.org/wiki/Subsequence#Substring_vs._subsequence).
> It is a classic [computer science](http://en.wikipedia.org/wiki/Computer_science)
> problem, the basis of [file comparison](http://en.wikipedia.org/wiki/File_comparison)
> programs such as [diff](http://en.wikipedia.org/wiki/Diff), and has
> applications in [bioinformatics](http://en.wikipedia.org/wiki/Bioinformatics).

## Usage

```php
<?php
use Ezzatron\LCS\LCSSolver;

$solver = new LCSSolver;

$left = array(
    'B',
    'A',
    'N',
    'A',
    'N',
    'A',
);
$right = array(
    'A',
    'T',
    'A',
    'N',
    'A',
);
$expectedLCS = array(
    'A',
    'A',
    'N',
    'A',
);

$LCS = $solver->longestCommonSubsequence(
    $left,
    $right
);

if ($LCS === $expectedLCS) {
    echo 'LCS solver is working.';
} else {
    echo 'LCS solver is not working.';
}
// the above outputs 'LCS solver is working.'
```

## Code quality

PHP-LCS strives to attain a high level of quality. A full test suite is
available, and code coverage is closely monitored.

### Latest revision test suite results
[![Build Status](https://secure.travis-ci.org/ezzatron/php-lcs.png)](http://travis-ci.org/ezzatron/php-lcs)

### Latest revision test suite coverage
<http://ci.ezzatron.com/report/php-lcs/coverage/>
