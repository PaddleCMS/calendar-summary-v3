<?php

namespace CultuurNet\CalendarSummaryV3\Tests\Single;

use CultuurNet\CalendarSummaryV3\Multiple\MediumMultipleHTMLFormatter;
use CultuurNet\SearchV3\ValueObjects\Event;

class MediumMultipleHTMLFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MediumMultipleHTMLFormatter
     */
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new MediumMultipleHTMLFormatter();
    }

    public function testFormatHTMLMultipleDateMediumOneDay()
    {
        $subEvents = json_decode(file_get_contents(__DIR__ . '/data/subEvents.json'), true);
        $event = new Event();
        $event->setSubEvents($subEvents);

        $expectedOutput = '<span class="cf-weekday cf-meta">donderdag</span> ';
        $expectedOutput .= '<span class="cf-date">9 november 2017</span>';
        $expectedOutput .= '<span class="cf-weekday cf-meta">donderdag</span> ';
        $expectedOutput .= '<span class="cf-date">16 november 2017</span>';
        $expectedOutput .= '<span class="cf-weekday cf-meta">donderdag</span> ';
        $expectedOutput .= '<span class="cf-date">23 november 2017</span>';
        $expectedOutput .= '<span class="cf-weekday cf-meta">donderdag</span> ';
        $expectedOutput .= '<span class="cf-date">30 november 2017</span>';

        $this->assertEquals(
            $expectedOutput,
            $this->formatter->format($event)
        );
    }

    public function testFormatHTMLMultipleDateMediumMoreDays()
    {
        $subEvents = json_decode(file_get_contents(__DIR__ . '/data/subEventsMoreDays.json'), true);
        $event = new Event();
        $event->setSubEvents($subEvents);

        $expectedOutput = '<span class="cf-from cf-meta">Van</span> ';
        $expectedOutput .= '<span class="cf-weekday cf-meta">maandag</span> ';
        $expectedOutput .= '<span class="cf-date">6 november 2017</span> ';
        $expectedOutput .= '<span class="cf-to cf-meta">tot</span> ';
        $expectedOutput .= '<span class="cf-weekday cf-meta">donderdag</span> ';
        $expectedOutput .= '<span class="cf-date">9 november 2017</span>';
        $expectedOutput .= '<span class="cf-from cf-meta">Van</span> ';
        $expectedOutput .= '<span class="cf-weekday cf-meta">dinsdag</span> ';
        $expectedOutput .= '<span class="cf-date">14 november 2017</span> ';
        $expectedOutput .= '<span class="cf-to cf-meta">tot</span> ';
        $expectedOutput .= '<span class="cf-weekday cf-meta">donderdag</span> ';
        $expectedOutput .= '<span class="cf-date">16 november 2017</span>';
        $expectedOutput .= '<span class="cf-from cf-meta">Van</span> ';
        $expectedOutput .= '<span class="cf-weekday cf-meta">dinsdag</span> ';
        $expectedOutput .= '<span class="cf-date">21 november 2017</span> ';
        $expectedOutput .= '<span class="cf-to cf-meta">tot</span> ';
        $expectedOutput .= '<span class="cf-weekday cf-meta">donderdag</span> ';
        $expectedOutput .= '<span class="cf-date">23 november 2017</span>';
        $expectedOutput .= '<span class="cf-from cf-meta">Van</span> ';
        $expectedOutput .= '<span class="cf-weekday cf-meta">dinsdag</span> ';
        $expectedOutput .= '<span class="cf-date">28 november 2017</span> ';
        $expectedOutput .= '<span class="cf-to cf-meta">tot</span> ';
        $expectedOutput .= '<span class="cf-weekday cf-meta">donderdag</span> ';
        $expectedOutput .= '<span class="cf-date">30 november 2017</span>';

        $this->assertEquals(
            $expectedOutput,
            $this->formatter->format($event)
        );
    }
}
