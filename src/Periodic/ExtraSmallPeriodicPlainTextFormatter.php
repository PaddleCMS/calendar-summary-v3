<?php

namespace CultuurNet\CalendarSummaryV3\Periodic;

use CultuurNet\CalendarSummaryV3\DateComparison;
use CultuurNet\CalendarSummaryV3\DateFormatter;
use CultuurNet\CalendarSummaryV3\PlainTextSummaryBuilder;
use CultuurNet\CalendarSummaryV3\Translator;
use CultuurNet\SearchV3\ValueObjects\Offer;
use \DateTime;
use \DateTimeInterface;

final class ExtraSmallPeriodicPlainTextFormatter implements PeriodicFormatterInterface
{
    /**
     * @var DateFormatter
     */
    private $formatter;

    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->formatter = new DateFormatter($translator->getLocale());
        $this->translator = $translator;
    }

    public function format(Offer $offer): string
    {
        $startDate = $offer->getStartDate()->setTimezone(new \DateTimeZone(date_default_timezone_get()));
        $startDate->setTime(0, 0, 1);

        if (DateComparison::inTheFuture($startDate)) {
            return $this->formatNotStarted($startDate)->appendStatus($offer->getStatus())->toString();
        }

        $endDate = $offer->getEndDate();
        return $this->formatStarted($endDate)->appendStatus($offer->getStatus())->toString();
    }

    private function formatStarted(DateTimeInterface $endDate): PlainTextSummaryBuilder
    {
        return PlainTextSummaryBuilder::start($this->translator)
            ->till($this->formatter->formatAsShortDate($endDate));
    }

    private function formatNotStarted(DateTimeInterface $startDate): PlainTextSummaryBuilder
    {
        return PlainTextSummaryBuilder::start($this->translator)
            ->fromPeriod($this->formatter->formatAsShortDate($startDate));
    }
}
