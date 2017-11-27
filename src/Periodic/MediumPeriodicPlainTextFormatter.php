<?php

namespace CultuurNet\CalendarSummaryV3\Periodic;

use IntlDateFormatter;

/**
 * Provide a medium plain text formatter for periodic calendar type.
 * @package CultuurNet\CalendarSummaryV3\Periodic
 */
class MediumPeriodicPlainTextFormatter implements PeriodicFormatterInterface
{

    /**
     * Return formatted period string.
     *
     * @param \CultuurNet\SearchV3\ValueObjects\Offer|\CultuurNet\SearchV3\ValueObjects\Place $offer
     * @return string
     */
    public function format($offer)
    {
        $fmt = new IntlDateFormatter(
            'nl_BE',
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            date_default_timezone_get(),
            IntlDateFormatter::GREGORIAN,
            'd MMMM yyyy'
        );

        $fmtDay = new IntlDateFormatter(
            'nl_BE',
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            date_default_timezone_get(),
            IntlDateFormatter::GREGORIAN,
            'eeee'
        );

        $dateFrom = $offer->getStartDate();
        $dateFromTimestamp = $dateFrom->getTimestamp();
        $intlDateFrom =$fmt->format($dateFromTimestamp);
        $intlDateFromDay = $fmtDay->format($dateFromTimestamp);

        $dateTo = $offer->getEndDate();
        $dateToTimestamp = $dateTo->getTimestamp();
        $intlDateTo = $fmt->format($dateToTimestamp);

        if ($intlDateFrom == $intlDateTo) {
            $output = $intlDateFromDay . ' ' . $intlDateFrom;
        } else {
            $output = 'Van ' . $intlDateFrom . ' tot '. $intlDateTo;
        }

        return $output;
    }
}
