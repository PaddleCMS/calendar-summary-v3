<?php

namespace CultuurNet\CalendarSummaryV3\Single;

use CultuurNet\CalendarSummaryV3\IntlDateFormatterFactory;
use CultuurNet\CalendarSummaryV3\Translator;
use CultuurNet\SearchV3\ValueObjects\Offer;
use DateTimeInterface;
use IntlDateFormatter;

final class SmallSinglePlainTextFormatter implements SingleFormatterInterface
{
    /**
     * @var IntlDateFormatter
     */
    private $fmtDay;

    /**
     * @var IntlDateFormatter
     */
    private $fmtMonth;

    /**
     * @var Translator
     */
    private $trans;

    public function __construct(string $langCode)
    {
        $this->fmtDay = IntlDateFormatterFactory::createDayNumberFormatter($langCode);
        $this->fmtMonth = IntlDateFormatterFactory::createAbbreviatedMonthNameFormatter($langCode);

        $this->trans = new Translator();
        $this->trans->setLanguage($langCode);
    }

    public function format(Offer $offer): string
    {
        $dateFrom = $offer->getStartDate()->setTimezone(new \DateTimeZone(date_default_timezone_get()));
        $dateEnd = $offer->getEndDate()->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        if ($dateFrom->format('Y-m-d') == $dateEnd->format('Y-m-d')) {
            $output = $this->formatSameDay($dateFrom);
        } else {
            $output = $this->formatMoreDays($dateFrom, $dateEnd);
        }

        return $output;
    }

    private function formatSameDay(DateTimeInterface $dateFrom): string
    {
        $dateFromDay = $this->fmtDay->format($dateFrom);
        $dateFromMonth = rtrim($this->fmtMonth->format($dateFrom), '.');

        $output = $dateFromDay . ' ' . $dateFromMonth;

        return $output;
    }

    private function formatMoreDays(DateTimeInterface $dateFrom, DateTimeInterface $dateEnd): string
    {
        $dateFromDay = $this->fmtDay->format($dateFrom);
        $dateFromMonth = rtrim($this->fmtMonth->format($dateFrom), '.');

        $dateEndDay = $this->fmtDay->format($dateEnd);
        $dateEndMonth = rtrim($this->fmtMonth->format($dateEnd), '.');

        $output = $this->trans->getTranslations()->t('from') . ' ' . $dateFromDay . ' '
            . $dateFromMonth . ' ' . $this->trans->getTranslations()->t('till') . ' '
            . $dateEndDay . ' ' . $dateEndMonth;

        return $output;
    }
}
