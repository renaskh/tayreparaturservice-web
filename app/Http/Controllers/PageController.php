<?php

namespace App\Http\Controllers;

use App\Queries\Catalog;
use App\Support\Localization;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about', [
            'metaTitle' => __('seo.about.title'),
            'metaDescription' => __('seo.about.description'),
            'canonical' => Localization::route('about'),
        ]);
    }

    public function business(): View
    {
        return view('pages.business', [
            'metaTitle' => __('seo.business.title'),
            'metaDescription' => __('seo.business.description'),
            'canonical' => Localization::route('business'),
        ]);
    }

    public function faq(Catalog $catalog): View
    {
        return view('pages.faq', [
            'faqs' => $catalog->faqs(),
            'metaTitle' => __('seo.faq.title'),
            'metaDescription' => __('seo.faq.description'),
            'canonical' => Localization::route('faq'),
        ]);
    }

    public function imprint(): View
    {
        return view('pages.legal.imprint', [
            'metaTitle' => __('seo.imprint.title'),
            'metaDescription' => __('seo.imprint.description'),
            'canonical' => Localization::route('legal.imprint'),
            'robots' => 'index, follow',
        ]);
    }

    public function privacy(): View
    {
        return view('pages.legal.privacy', [
            'metaTitle' => __('seo.privacy.title'),
            'metaDescription' => __('seo.privacy.description'),
            'canonical' => Localization::route('legal.privacy'),
        ]);
    }

    public function terms(): View
    {
        return view('pages.legal.terms', [
            'metaTitle' => __('seo.terms.title'),
            'metaDescription' => __('seo.terms.description'),
            'canonical' => Localization::route('legal.terms'),
        ]);
    }

    public function withdrawal(): View
    {
        return view('pages.legal.withdrawal', [
            'metaTitle' => __('seo.withdrawal.title'),
            'metaDescription' => __('seo.withdrawal.description'),
            'canonical' => Localization::route('legal.withdrawal'),
        ]);
    }
}
