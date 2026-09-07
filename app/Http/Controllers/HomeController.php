<?php

namespace App\Http\Controllers;

use App\Queries\Catalog;
use App\Support\Localization;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Catalog $catalog): View
    {
        return view('pages.home', [
            'categories' => $catalog->categories(),
            'faqs' => $catalog->faqs()->take(6),
            'metaTitle' => __('seo.home.title'),
            'metaDescription' => __('seo.home.description'),
            'canonical' => Localization::route('home'),
        ]);
    }
}
