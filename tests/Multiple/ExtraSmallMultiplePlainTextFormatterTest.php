<?php

namespace CultuurNet\CalendarSummaryV3\Tests\Multiple;

use CultuurNet\CalendarSummaryV3\Multiple\ExtraSmallMultiplePlainTextFormatter;
use CultuurNet\SearchV3\ValueObjects\Event;

class ExtraSmallMultiplePlainTextFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExtraSmallMultiplePlainTextFormatter
     */
    protected $formatter;

    protected function setUp()
    {
        $this->formatter = new ExtraSmallMultiplePlainTextFormatter('nl_NL', false);
    }

    public function testFormatMultipleWithoutLeadingZeroes(): void
    {
        $offer = new Event();
        $offer->setStartDate(new \DateTime('25-11-2025'));
        $offer->setEndDate(new \DateTime('30-11-2030'));

        $this->assertEquals(
            'Van 25/11/25 tot 30/11/30',
            $this->formatter->format($offer)
        );
    }

    public function testFormatMultipleWithLeadingZeroes(): void
    {
        $offer = new Event();
        $offer->setStartDate(new \DateTime('04-03-2025'));
        $offer->setEndDate(new \DateTime('08-03-2030'));

        $this->assertEquals(
            'Van 4/3/25 tot 8/3/30',
            $this->formatter->format($offer)
        );
    }


    public function testFormatMultipleDayWithoutLeadingZero(): void
    {
        $offer = new Event();
        $offer->setStartDate(new \DateTime('25-03-2025'));
        $offer->setEndDate(new \DateTime('30-03-2030'));

        $this->assertEquals(
            'Van 25/3/25 tot 30/3/30',
            $this->formatter->format($offer)
        );
    }

    public function testFormatMultipleMonthWithoutLeadingZero(): void
    {
        $offer = new Event();
        $offer->setStartDate(new \DateTime('04-10-2025'));
        $offer->setEndDate(new \DateTime('08-10-2030'));

        $this->assertEquals(
            'Van 4/10/25 tot 8/10/30',
            $this->formatter->format($offer)
        );
    }

    public function testFormatAPeriodWithSameBeginAndEndDate(): void
    {
        $offer = new Event();
        $offer->setStartDate(new \DateTime('08-03-2025'));
        $offer->setEndDate(new \DateTime('08-03-2025'));

        $this->assertEquals(
            '8/3/25',
            $this->formatter->format($offer)
        );
    }
}
