<?php

namespace CultuurNet\CalendarSummaryV3\Multiple;

use CultuurNet\SearchV3\ValueObjects\Event;
use CultuurNet\CalendarSummaryV3\Single\LargeSingleHTMLFormatter;

/**
 * Formatter to format multiple events as html in large format.
 */
class LargeMultipleHTMLFormatter implements MultipleFormatterInterface
{

    /**
    * {@inheritdoc}
    */
    public function format(Event $event)
    {
        $subEvents = $event->getSubEvents();
        $output = '';

        foreach ($subEvents as $subEvent) {
            $formatter = new LargeSingleHTMLFormatter();

            $event = new Event();
            $event->setStartDate(new \DateTime($subEvent['startDate']));
            $event->setEndDate(new \DateTime($subEvent['endDate']));

            $output .= $formatter->format($event);
        }

        return $output;
    }
}
