<?php

namespace CultuurNet\CalendarSummaryV3\Permanent;

use CultuurNet\SearchV3\ValueObjects\Offer;

/**
 * Provide a large HTML formatter for permanent calendar type.
 * @package CultuurNet\CalendarSummaryV3\Permanent
 */
class MediumPermanentHTMLFormatter extends MediumPermanentFormatter implements PermanentFormatterInterface
{

    /**
     * {@inheritdoc}
     */
    public function format(Offer $offer)
    {
        $output = '';
        if ($offer->getOpeningHours()) {
            $output .= $this->generateWeekScheme($offer->getOpeningHours());
        } else {
            $output .= '<p class="cf-openinghours">' . ucfirst($this->trans->getTranslations()->t('always_open')) . '</p>';
        }

        return $output;
    }

    /**
     * Generate a weekscheme based on the given opening hours.
     *
     * @param $openingHoursData
     * @return string
     */
    protected function generateWeekScheme($openingHoursData)
    {
        $outputWeek = '<span>' . ucfirst($this->trans->getTranslations()->t('open')) . ' ' . '<span class="cf-weekdays">';
        // Create an array with formatted days.
        $formattedDays = [];

        foreach ($openingHoursData as $openingHours) {
            $daysOfWeek = $openingHours->getDaysOfWeek();
            foreach ($daysOfWeek as $i => $dayOfWeek) {
                $translatedDay = $this->fmtShortDays->format(strtotime($dayOfWeek));

                if (!isset($formattedDays[$dayOfWeek])) {
                    $formattedDays[$dayOfWeek] = $translatedDay;
                }
            }
        }

        $i = 0;

        foreach ($formattedDays as $formattedDay) {
            $outputWeek .= '<span class="cf-weekday-open>' . $formattedDay . '</span>';
            if (++$i !== count($formattedDays)) {
                $outputWeek .= ', ';
            }
        }

        $outputWeek .= '</span></span>';

        return $outputWeek;
    }
}
