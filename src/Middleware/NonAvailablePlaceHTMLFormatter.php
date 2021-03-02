<?php

declare(strict_types=1);

namespace CultuurNet\CalendarSummaryV3\Middleware;

use Closure;
use CultuurNet\CalendarSummaryV3\HtmlStatusFormatter;
use CultuurNet\CalendarSummaryV3\Translator;
use CultuurNet\CalendarSummaryV3\Offer\Offer;

final class NonAvailablePlaceHTMLFormatter implements FormatterMiddleware
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
        if ($this->appliesToOffer($offer)) {
            return HtmlStatusFormatter::forOffer($offer, $this->translator)
                ->withElement('span')
                ->withoutBraces()
                ->capitalize()
                ->toString();
        }

        return $next($offer);
    }

    private function appliesToOffer(Offer $offer): bool
    {
        if (!$offer->isPlace()) {
            return false;
        }

        return in_array($offer->getStatus()->getType(), ['Unavailable', 'TemporarilyUnavailable']);
    }
}
