<?php

namespace App\Http\Controllers;

use App\Support\PortfolioCatalog;
use Inertia\Inertia;
use Inertia\Response;

class SitePageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'projects' => PortfolioCatalog::all(),
        ]);
    }

    public function about(): Response
    {
        return Inertia::render('About');
    }

    public function portfolio(): Response
    {
        return Inertia::render('Portfolio', [
            'projects' => PortfolioCatalog::all(),
        ]);
    }
}
