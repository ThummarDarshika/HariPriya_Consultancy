<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisualEditorController extends Controller
{
    public const PAGES = [
        'home', 'about', 'services', 'products', 'case-studies', 'blog',
        'blog-detail', 'contact', 'faqs', 'privacy-policy', 'error-404',
    ];

    public function __invoke(Request $request): View
    {
        $page = $request->string('page')->toString() ?: 'home';
        abort_unless(in_array($page, self::PAGES, true), 404);

        return view('pages.'.$page, ['cmsEditorPage' => $page]);
    }
}
