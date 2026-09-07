<?php

namespace App\Http\Controllers;

use App\Queries\Catalog;
use App\Support\Localization;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(Catalog $catalog): Response
    {
        $categories = $catalog->categories();
        $entries = [];

        $static = [
            'home',
            'services.index',
            'about',
            'business',
            'faq',
            'contact.create',
            'legal.imprint',
            'legal.privacy',
            'legal.terms',
            'legal.withdrawal',
        ];

        foreach ($static as $name) {
            $entries = array_merge($entries, $this->entries($name, fn (string $locale): array => []));
        }

        foreach ($categories as $category) {
            $entries = array_merge($entries, $this->entries('services.category', function (string $locale) use ($category): array {
                return [
                    'serviceCategory' => (string) $category->translated('slug', $locale, ''),
                ];
            }));

            foreach ($category->services as $service) {
                $entries = array_merge($entries, $this->entries('services.show', function (string $locale) use ($category, $service): array {
                    return [
                        'serviceCategory' => (string) $category->translated('slug', $locale, ''),
                        'service' => (string) $service->translated('slug', $locale, ''),
                    ];
                }));
            }
        }

        return response()
            ->view('sitemap', ['entries' => $entries])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * @param  callable(string): array<string, string>  $parametersForLocale
     * @return list<array{loc: string, alternates: array<string, string>}>
     */
    private function entries(string $name, callable $parametersForLocale): array
    {
        $alternates = [];

        foreach (Localization::supported() as $locale) {
            if (! Localization::hasRoute($name, $locale)) {
                continue;
            }

            $parameters = $parametersForLocale($locale);

            if (in_array('', $parameters, true)) {
                continue;
            }

            $alternates[$locale] = Localization::route($name, $parameters, $locale);
        }

        $entries = [];

        foreach ($alternates as $url) {
            $entries[] = [
                'loc' => $url,
                'alternates' => $alternates,
            ];
        }

        return $entries;
    }
}
