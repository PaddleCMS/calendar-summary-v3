<?php

declare(strict_types=1);

namespace CultuurNet\CalendarSummaryV3\Permanent;

use CultuurNet\CalendarSummaryV3\Offer\CalendarType;
use CultuurNet\CalendarSummaryV3\Offer\Offer;
use CultuurNet\CalendarSummaryV3\Offer\OfferType;
use CultuurNet\CalendarSummaryV3\Offer\OpeningHour;
use CultuurNet\CalendarSummaryV3\Offer\Status;
use CultuurNet\CalendarSummaryV3\Translator;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class LargePermanentPlainTextFormatterTest extends TestCase
{
    /**
     * @var LargePermanentPlainTextFormatter
     */
    protected $formatter;

    protected function setUp(): void
    {
        $this->formatter = new LargePermanentPlainTextFormatter(new Translator('nl_NL'));
    }

    public function testFormatASimplePermanent(): void
    {
        $place = new Offer(
            OfferType::place(),
            new Status('Available', []),
            new DateTimeImmutable('25-11-2025'),
            new DateTimeImmutable('30-11-2030')
        );

        $openingHours1 = new OpeningHour(
            ['monday','tuesday', 'wednesday'],
            '09:00',
            '13:00'
        );

        $openingHours2 = new OpeningHour(
            ['friday'],
            '00:01',
            '13:00'
        );

        $openingHours3 = new OpeningHour(
            ['saturday', 'sunday'],
            '09:00',
            '19:00'
        );

        $place = $place->withOpeningHours(
            [
                $openingHours1,
                $openingHours2,
                $openingHours3,
            ]
        );

        $this->assertEquals(
            'Ma van 9:00 tot 13:00' . PHP_EOL
            . 'Di van 9:00 tot 13:00' . PHP_EOL
            . 'Wo van 9:00 tot 13:00' . PHP_EOL
            . 'Do gesloten' . PHP_EOL
            . 'Vr van 0:01 tot 13:00' . PHP_EOL
            . 'Za van 9:00 tot 19:00' . PHP_EOL
            . 'Zo van 9:00 tot 19:00' . PHP_EOL,
            $this->formatter->format($place)
        );
    }

    public function testFormatAMixedPermanent(): void
    {
        $place = new Offer(
            OfferType::place(),
            new Status('Available', []),
            new DateTimeImmutable('25-11-2025'),
            new DateTimeImmutable('25-11-2025')
        );

        $openingHours1 = new OpeningHour(
            ['monday','tuesday', 'wednesday'],
            '09:00',
            '13:00'
        );

        $openingHours2 = new OpeningHour(
            ['monday','tuesday', 'wednesday'],
            '17:00',
            '20:00'
        );

        $openingHours3 = new OpeningHour(
            ['friday', 'saturday'],
            '10:00',
            '15:00'
        );

        $openingHours4 = new OpeningHour(
            ['friday', 'saturday'],
            '18:00',
            '21:00'
        );

        $place = $place->withOpeningHours(
            [
                $openingHours1,
                $openingHours2,
                $openingHours3,
                $openingHours4,
            ]
        );

        $this->assertEquals(
            'Ma van 9:00 tot 13:00' . PHP_EOL . 'van 17:00 tot 20:00' . PHP_EOL
            . 'Di van 9:00 tot 13:00' . PHP_EOL . 'van 17:00 tot 20:00' . PHP_EOL
            . 'Wo van 9:00 tot 13:00' . PHP_EOL . 'van 17:00 tot 20:00' . PHP_EOL
            . 'Do gesloten' . PHP_EOL
            . 'Vr van 10:00 tot 15:00' . PHP_EOL . 'van 18:00 tot 21:00' . PHP_EOL
            . 'Za van 10:00 tot 15:00' . PHP_EOL . 'van 18:00 tot 21:00' . PHP_EOL
            . 'Zo gesloten' . PHP_EOL,
            $this->formatter->format($place)
        );
    }

    public function testFormatAComplexPermanent(): void
    {
        $place = new Offer(
            OfferType::place(),
            new Status('Available', []),
            new DateTimeImmutable('25-11-2025'),
            new DateTimeImmutable('25-11-2025')
        );

        $openingHours1 = new OpeningHour(
            ['monday','tuesday'],
            '09:30',
            '13:45'
        );

        $openingHours2 = new OpeningHour(
            ['monday'],
            '17:00',
            '20:00'
        );

        $openingHours3 = new OpeningHour(
            ['tuesday'],
            '18:00',
            '20:00'
        );

        $openingHours4 = new OpeningHour(
            ['tuesday'],
            '21:00',
            '23:00'
        );

        $openingHours5 = new OpeningHour(
            ['friday', 'saturday'],
            '10:00',
            '15:00'
        );

        $place = $place->withOpeningHours(
            [
                $openingHours1,
                $openingHours2,
                $openingHours3,
                $openingHours4,
                $openingHours5,
            ]
        );

        $this->assertEquals(
            'Ma van 9:30 tot 13:45' . PHP_EOL . 'van 17:00 tot 20:00' . PHP_EOL
            . 'Di van 9:30 tot 13:45' . PHP_EOL . 'van 18:00 tot 20:00' . PHP_EOL
            . 'van 21:00 tot 23:00' . PHP_EOL
            . 'Wo gesloten' . PHP_EOL
            . 'Do gesloten' . PHP_EOL
            . 'Vr van 10:00 tot 15:00' . PHP_EOL
            . 'Za van 10:00 tot 15:00' . PHP_EOL
            . 'Zo gesloten' . PHP_EOL,
            $this->formatter->format($place)
        );
    }

    public function testFormatAnUnavailablePermanent(): void
    {
        $event = new Offer(
            OfferType::event(),
            new Status('Unavailable', []),
            null,
            null,
            CalendarType::permanent()
        );

        $this->assertEquals(
            'Geannuleerd',
            $this->formatter->format($event)
        );
    }

    public function testFormatATemporarilyUnavailablePermanent(): void
    {
        $event = new Offer(
            OfferType::event(),
            new Status('TemporarilyUnavailable', []),
            null,
            null,
            CalendarType::permanent()
        );

        $this->assertEquals(
            'Uitgesteld',
            $this->formatter->format($event)
        );
    }
}
