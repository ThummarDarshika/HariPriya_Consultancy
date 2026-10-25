<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProjectPageController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.projects');
    }
}
