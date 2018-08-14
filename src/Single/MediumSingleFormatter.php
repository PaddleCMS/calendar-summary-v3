<?php

namespace CultuurNet\CalendarSummaryV3\Single;

use IntlDateFormatter;
use CultuurNet\CalendarSummaryV3\Translator;

abstract class MediumSingleFormatter
{
    protected $fmt;

    protected $fmtDay;

    protected $trans;

    public function __construct($langCode)
    {
        $this->fmt = new IntlDateFormatter(
            $langCode,
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            date_default_timezone_get(),
            IntlDateFormatter::GREGORIAN,
            'd MMMM yyyy'
        );

        $this->fmtDay = new IntlDateFormatter(
            $langCode,
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            date_default_timezone_get(),
            IntlDateFormatter::GREGORIAN,
            'eeee'
        );

        $this->trans = new Translator();
        $this->trans->setLanguage($langCode);
    }
}
