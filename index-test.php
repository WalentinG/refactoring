<?php

require_once 'index.php';

$plays = [
    'hamlet' => [
        'name' => 'Hamlet',
        'type' => 'tragedy',
    ],
    'as-like' => [
        'name' => 'As You Like It',
        'type' => 'comedy',
    ],
    'othello' => [
        'name' => 'Othello',
        'type' => 'tragedy',
    ],
];

$invoice = [
    'customer' => 'BigCo',
    'performances' => [
        [
            'playID' => 'hamlet',
            'audience' => 55,
        ],
        [
            'playID' => 'as-like',
            'audience' => 35,
        ],
        [
            'playID' => 'othello',
            'audience' => 40,
        ],
    ],
];

$expected = <<<EOT
Statement for BigCo
  Hamlet: $650.00 (55 seats)
  As You Like It: $580.00 (35 seats)
  Othello: $500.00 (40 seats)
Amount owed is $1,730.00
You earned 47 credits

EOT;

$actual = statement($invoice, $plays);

if ($actual === $expected) {
    die('Success!');
}

echo "Failed\n";
echo "Actual: \n";
echo $actual;
echo "Expected: \n";
echo $expected;


