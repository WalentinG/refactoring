<?php

/**
 * @param array{customer: string, performances: array<array{playID: string, audience: int}>} $invoice
 * @param array<string, array{name: string, type: string}> $plays
 */
function statement(array $invoice, array $plays): string
{
    $totalAmount = 0;
    $volumeCredits = 0;
    $result = "Statement for {$invoice['customer']}\n";
    $format = new \NumberFormatter("en-US", \NumberFormatter::CURRENCY);

    foreach ($invoice['performances'] as $performance) {
        $play = $plays[$performance['playID']];

        switch ($play['type']) {
            case 'tragedy':
                $thisAmount = 40000;
                if ($performance['audience'] > 30) {
                    $thisAmount += 1000 * ($performance['audience'] - 30);
                }
                break;
            case 'comedy':
                $thisAmount = 30000;
                if ($performance['audience'] > 20) {
                    $thisAmount += 10000 + 500 * ($performance['audience'] - 20);
                }
                $thisAmount += 300 * $performance['audience'];
                break;
            default:
                throw new \UnexpectedValueException("unknown type: {$play['type']}");
        }

        // add volume credits
        $volumeCredits += max($performance['audience'] - 30, 0);
        // add extra credit for every ten comedy attendees
        if ('comedy' === $play['type']) {
            $volumeCredits += floor($performance['audience'] / 5);
        }

        // print line for this order
        $result .= "  {$play['name']}: {$format->formatCurrency($thisAmount / 100, "USD")} ({$performance['audience']} seats)\n";
        $totalAmount += $thisAmount;
    }

    $result .= "Amount owed is {$format->formatCurrency($totalAmount / 100, "USD")}\n";
    $result .= "You earned {$volumeCredits} credits\n";

    return $result;
}
