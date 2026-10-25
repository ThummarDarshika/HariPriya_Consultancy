<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOpening;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisualEditorController extends Controller
{
    public const PAGES = [
        'home', 'about', 'services', 'products', 'projects', 'case-studies', 'blog',
        'blog-detail', 'contact', 'career', 'career-detail', 'faqs', 'privacy-policy', 'error-404',
    ];

    public function __invoke(Request $request): View
    {
        $page = $request->string('page')->toString() ?: 'home';
        abort_unless(in_array($page, self::PAGES, true), 404);

        if ($page === 'career') {
            return view('pages.career.index', [
                'cmsEditorPage' => $page,
                'openings' => JobOpening::query()->where('is_active', true)->orderBy('sort_order')->latest('id')->get(),
            ]);
        }

        if ($page === 'career-detail') {
            return view('pages.career.show', [
                'cmsEditorPage' => $page,
                'jobOpening' => JobOpening::query()->where('is_active', true)->orderBy('sort_order')->latest('id')->firstOrFail(),
            ]);
        }

        return view('pages.'.$page, ['cmsEditorPage' => $page]);
    }
}
