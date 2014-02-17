# PHP-LCS

*An implementation of the 'longest common subsequence' algorithm for PHP.*

[![The most recent stable version is 2.0.0][version-image]][Semantic versioning]
[![Current build status image][build-image]][Current build status]
[![Current coverage status image][coverage-image]][Current coverage status]

## Installation and documentation

- Available as [Composer] package [eloquent/lcs].
- [API documentation] available.

## What is PHP-LCS?

*PHP-LCS* is a PHP implementation of an algorithm to solve the 'longest common
subsequence' problem.

From [Wikipedia - longest common subsequence problem]:

> The **longest common subsequence (LCS) problem** is to find the longest
> [subsequence] common to all sequences in a set of sequences (often just two).
> Note that subsequence is different from a substring, see [substring vs.
> subsequence]. It is a classic [computer science] problem, the basis of [file
> comparison] programs such as [diff], and has applications in [bioinformatics].

## Usage

```php
use Eloquent\Lcs\LcsSolver;

$solver = new LcsSolver;

$sequenceA = array('B', 'A', 'N', 'A', 'N', 'A');
$sequenceB = array('A', 'T', 'A', 'N', 'A');

// calculates the LCS to be array('A', 'A', 'N', 'A')
$lcs = $solver->longestCommonSubsequence($sequenceA, $sequenceB);
```

Elements in sequences can be anything. By default, sequence members are compared
using the `===` operator. To customize this comparison, simply construct the
solver with a custom comparator, like so:

```php
use Eloquent\Lcs\LcsSolver;

$solver = new LcsSolver(
    function ($left, $right) {
        // return true if $left and $right are equal
    }
);
```

<!-- References -->

[bioinformatics]: http://en.wikipedia.org/wiki/Bioinformatics
[computer science]: http://en.wikipedia.org/wiki/Computer_science
[diff]: http://en.wikipedia.org/wiki/Diff
[file comparison]: http://en.wikipedia.org/wiki/File_comparison
[subsequence]: http://en.wikipedia.org/wiki/Subsequence
[substring vs. subsequence]: http://en.wikipedia.org/wiki/Subsequence#Substring_vs._subsequence
[Wikipedia - longest common subsequence problem]: http://en.wikipedia.org/wiki/Longest_common_subsequence_problem

[API documentation]: http://lqnt.co/php-lcs/artifacts/documentation/api/
[Composer]: http://getcomposer.org/
[build-image]: http://img.shields.io/travis/eloquent/php-lcs/develop.svg "Current build status for the develop branch"
[Current build status]: https://travis-ci.org/eloquent/php-lcs
[coverage-image]: http://img.shields.io/coveralls/eloquent/php-lcs/develop.svg "Current test coverage for the develop branch"
[Current coverage status]: https://coveralls.io/r/eloquent/php-lcs
[eloquent/lcs]: https://packagist.org/packages/eloquent/lcs
[Semantic versioning]: http://semver.org/
[version-image]: http://img.shields.io/:semver-2.0.0-brightgreen.svg "This project uses semantic versioning"
