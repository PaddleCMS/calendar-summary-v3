<?php

declare(strict_types=1);

namespace CultuurNet\CalendarSummaryV3\Offer;

use DateTimeImmutable;
use PHPStan\Testing\TestCase;

final class OfferTest extends TestCase
{
    public function testCanCreateFromJsonLd(): void
    {
        $jsonLd = file_get_contents(__DIR__ . '/data/offer.json');
        $expected = new Offer(
            OfferType::event(),
            new Status(
                'TemporarilyUnavailable',
                [
                    'nl' => 'Uitgesteld',
                    'en' => 'Postponed',
                ]
            ),
            new DateTimeImmutable('2021-03-01T23:00:00+00:00'),
            new DateTimeImmutable('2021-03-28T22:59:59+00:00'),
            CalendarType::single()
        );

        $this->assertEquals($expected, Offer::fromJsonLd($jsonLd));
    }

    public function testCanParsePermanentOffer(): void
    {
        $jsonLd = file_get_contents(__DIR__ . '/data/permanent.json');
        $expected = new Offer(
            OfferType::event(),
            new Status('Available', []),
            null,
            null,
            CalendarType::permanent()
        );

        $this->assertEquals($expected, Offer::fromJsonLd($jsonLd));
    }

    public function testCanParseSubEvents(): void
    {
        $jsonLd = file_get_contents(__DIR__ . '/data/offer-with-subevents.json');
        $expected = new Offer(
            OfferType::event(),
            new Status('Available', []),
            new DateTimeImmutable('2021-03-01T23:00:00+00:00'),
            new DateTimeImmutable('2021-03-28T22:59:59+00:00'),
            CalendarType::multiple()
        );

        $expected = $expected->withSubEvents(
            [
                new Offer(
                    OfferType::event(),
                    new Status('Available', []),
                    new DateTimeImmutable('2021-03-01T23:00:00+00:00'),
                    new DateTimeImmutable('2021-03-14T22:59:59+00:00')
                ),
                new Offer(
                    OfferType::event(),
                    new Status('Available', []),
                    new DateTimeImmutable('2021-03-15T23:00:00+00:00'),
                    new DateTimeImmutable('2021-03-28T22:59:59+00:00')
                )
            ]
        );

        $this->assertEquals($expected, Offer::fromJsonLd($jsonLd));
    }
}
