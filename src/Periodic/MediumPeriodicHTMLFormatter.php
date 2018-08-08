<?php

namespace CultuurNet\CalendarSummaryV3\Periodic;

use CultuurNet\SearchV3\ValueObjects\Offer;

/**
 * Provide a medium HTML formatter for periodic calendar type.
 * @package CultuurNet\CalendarSummaryV3\Periodic
 */
class MediumPeriodicHTMLFormatter extends MediumPeriodicFormatter implements PeriodicFormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format(Offer $offer)
    {
        $dateFrom = $offer->getStartDate();
        $intlDateFrom = $this->fmt->format($dateFrom);
        $intlDateFromDay = $this->fmtDay->format($dateFrom);

        $dateTo = $offer->getEndDate();
        $intlDateTo = $this->fmt->format($dateTo);

        if ($intlDateFrom == $intlDateTo) {
            $output = '<span class="cf-weekday cf-meta">' . $intlDateFromDay . '</span>';
            $output .= ' ';
            $output .= '<span class="cf-date">' . $intlDateFrom . '</span>';
        } else {
            $output = '<span class="cf-from cf-meta">Van</span> <span class="cf-date">' . $intlDateFrom . '</span> ';
            $output .= '<span class="cf-to cf-meta">tot</span> <span class="cf-date">'. $intlDateTo . '</span>';
        }

        return $output;
    }
}
