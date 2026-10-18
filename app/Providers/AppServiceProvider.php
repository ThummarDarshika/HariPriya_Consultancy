<?php

namespace App\Providers;

use App\Http\Controllers\Admin\VisualEditorController;
use App\Models\Certificate;
use App\Models\Company;
use App\Models\SiteAsset;
use App\Models\SiteContent;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as BladeView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['pages.home', 'pages.about'], function (BladeView $view): void {
            $founderValues = SiteContent::query()
                ->where('page', 'global')
                ->whereIn('key', ['global/founder/image', 'global/founder/name', 'global/founder/role'])
                ->pluck('value', 'key');

            $view->with('founder', collect(config('cms.founder'))
                ->mapWithKeys(fn (string $default, string $field): array => [
                    $field => $founderValues['global/founder/'.$field] ?? $default,
                ])->all());
        });

        View::composer(['pages.home', 'pages.about', 'pages.services', 'pages.products', 'pages.case-studies', 'pages.blog'], function (BladeView $view): void {
            $defaults = collect(config('cms.managed_assets'))
                ->mapWithKeys(fn (array $asset, string $key): array => [$key => $asset['default']])
                ->all();

            $view->with('siteAssets', array_replace($defaults, SiteAsset::query()->pluck('value', 'key')->all()));
        });

        View::composer(['pages.home', 'pages.about', 'pages.contact'], function (BladeView $view): void {
            $view->with('companies', Company::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get());
        });

        View::composer('pages.about', function (BladeView $view): void {
            $view->with('certificates', Certificate::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get());
        });

        View::composer('layouts.app', function (BladeView $view): void {
            $data = $view->getData();
            $page = $data['cmsEditorPage'] ?? $data['cmsPage'] ?? request()->route()?->getName() ?? 'home';

            if (! in_array($page, VisualEditorController::PAGES, true)) {
                $page = 'home';
            }

            $view->with('cmsInitialContent', SiteContent::query()
                ->whereIn('page', [$page, 'global'])
                ->get(['page', 'key', 'type', 'value'])
                ->toArray());
        });
    }
}
