<?php

namespace App\View\Composers;

use App\Queries\Catalog;
use App\Support\AlternateUrls;
use App\Support\Localization;
use Illuminate\View\View;

class NavigationComposer
{
    public function __construct(
        private Catalog $catalog,
        private AlternateUrls $alternateUrls,
    ) {}

    public function compose(View $view): void
    {
        $view->with([
            'navCategories' => $this->catalog->categories(),
            'alternateUrls' => $this->alternateUrls->forCurrentRoute(),
            'currentLocale' => Localization::current(),
        ]);
    }
}
