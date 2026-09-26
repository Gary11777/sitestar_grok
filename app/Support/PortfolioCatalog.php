<?php

namespace App\Support;

/**
 * Published work shown on the home page and the portfolio.
 *
 * Descriptions are written for this site. They are not copied from the projects.
 */
class PortfolioCatalog
{
    /**
     * @return list<array{slug: string, title: string, url: string, summary: string, discipline: string, image: string}>
     */
    public static function all(): array
    {
        return [
            [
                'slug' => 'dimgent',
                'title' => 'Dimgent Technologies',
                'url' => 'https://dimgent.com/',
                'discipline' => 'Company site',
                'image' => '/images/portfolio/dimgent.svg',
                'summary' => 'An English-language home for an electronics studio that carries a device from a written brief through circuits, boards, firmware, and a tested prototype. The pages put that sequence in order, and leave a finished instrument at the end of the path.',
            ],
            [
                'slug' => 'dimgent-by',
                'title' => 'Dimgent',
                'url' => 'https://dimgent.by/',
                'discipline' => 'Company site',
                'image' => '/images/portfolio/dimgent-by.svg',
                'summary' => 'The same practice, written for Russian-speaking clients. Services follow the order a build actually happens, and the Garand 101 magnetometer is shown as a completed device rather than a separate advertisement.',
            ],
            [
                'slug' => 'gradiometr',
                'title' => 'Garand 101',
                'url' => 'https://gradiometr.com/',
                'discipline' => 'Product site',
                'image' => '/images/portfolio/gradiometr.svg',
                'summary' => 'A product page for the Garand 101, a walking magnetometer that notices iron and steel underground. It explains a precise field instrument in plain language: the weight in the hand, the signal on the screen, and the ground it is carried over.',
            ],
        ];
    }
}
