<?php

declare(strict_types=1);

namespace CultuurNet\CalendarSummaryV3\Middleware;

use Closure;
use CultuurNet\CalendarSummaryV3\Translator;
use CultuurNet\SearchV3\ValueObjects\Offer;
use CultuurNet\SearchV3\ValueObjects\Place;

class NonAvailablePlacePlainTextFormatter implements FormatterMiddleware
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(
        Translator $translator
    ) {
        $this->translator = $translator;
    }

    public function format(Offer $offer, Closure $next): string
    {
        if ($offer instanceof Place) {
            if ($offer->getStatus()->getType() === 'Unavailable') {
                return $this->translator->translate('permanently_closed');
            }

            if ($offer->getStatus()->getType() === 'TemporarilyUnavailable') {
                return $this->translator->translate('temporarily_closed');
            }
        }

        return $next($offer);
    }
}
