<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = url('/sitemap.xml');

        $body = <<<TXT
User-agent: *
Disallow: /admin

Sitemap: {$sitemap}

TXT;

        return response($body, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
