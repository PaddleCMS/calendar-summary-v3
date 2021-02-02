<?php

namespace CultuurNet\CalendarSummaryV3;

use CultuurNet\SearchV3\ValueObjects\Event;
use CultuurNet\SearchV3\ValueObjects\Status;
use PHPUnit\Framework\TestCase;

class CalendarHTMLFormatterTest extends TestCase
{
    /**
     * @var CalendarHTMLFormatter
     */
    protected $formatter;

    protected function setUp(): void
    {
        $this->formatter = new CalendarHTMLFormatter();
    }

    public function testGeneralFormatMethod(): void
    {
        $offer = new Event();
        $offer->setStatus(new Status('Available'));
        $offer->setCalendarType(Event::CALENDAR_TYPE_SINGLE);
        $offer->setStartDate(new \DateTime('2018-01-25T20:00:00+01:00'));
        $offer->setEndDate(new \DateTime('2018-01-25T21:30:00+01:00'));

        $this->assertSame(
            '<span class="cf-date">25</span> <span class="cf-month">jan</span>',
            $this->formatter->format($offer, 'xs')
        );
    }

    public function testGeneralFormatMethodAndCatchException(): void
    {
        $offer = new Event();
        $offer->setStatus(new Status('Available'));
        $offer->setCalendarType(Event::CALENDAR_TYPE_SINGLE);
        $offer->setStartDate(new \DateTime('2018-01-25T20:00:00+01:00'));
        $offer->setEndDate(new \DateTime('2018-01-25T21:30:00+01:00'));

        $this->expectException(FormatterException::class);
        $this->formatter->format($offer, 'sx');
    }
}
