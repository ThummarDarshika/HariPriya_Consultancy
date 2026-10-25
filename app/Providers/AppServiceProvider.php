<?php

namespace App\Providers;

use App\Http\Controllers\Admin\VisualEditorController;
use App\Models\Certificate;
use App\Models\CollectionItem;
use App\Models\Company;
use App\Models\ProjectMedia;
use App\Models\SiteAsset;
use App\Models\SiteContent;
use Illuminate\Foundation\Console\ServeCommand;
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
        if (PHP_OS_FAMILY === 'Windows' && $this->app->runningInConsole()) {
            ServeCommand::$passthroughVariables = array_values(array_unique([
                ...ServeCommand::$passthroughVariables,
                'TEMP',
                'TMP',
            ]));
        }

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

            $view->with('capabilityServices', CollectionItem::query()
                ->where('collection', 'services')
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(4)
                ->get(['title']));
        });

        View::composer('pages.case-studies', function (BladeView $view): void {
            $view->with('caseStudies', CollectionItem::query()
                ->where('collection', 'case-studies')
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->paginate(6, ['*'], 'case_page')
                ->withQueryString()
                ->fragment('case-studies-list'));
        });

        View::composer('pages.projects', function (BladeView $view): void {
            $view->with('projectMedia', ProjectMedia::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->paginate(20, ['*'], 'media_page')
                ->withQueryString()
                ->fragment('project-gallery'));
        });

        View::composer('pages.privacy-policy', function (BladeView $view): void {
            $content = SiteContent::query()
                ->where('page', 'privacy-policy')
                ->whereIn('key', [
                    'privacy-policy/body',
                    'privacy-policy/title',
                    'privacy-policy/main/section:0/div:0/div:0/h1:0/text:0',
                ])
                ->get(['key', 'value', 'updated_at'])
                ->keyBy('key');

            $policyBody = $content->get('privacy-policy/body');

            $view->with('privacyPolicyBody', $policyBody?->value);
            $view->with('privacyPolicyTitle', $content->get('privacy-policy/title')?->value
                ?? $content->get('privacy-policy/main/section:0/div:0/div:0/h1:0/text:0')?->value
                ?? 'Privacy Policy');
            $view->with('privacyPolicyLastUpdated', $policyBody?->updated_at?->timezone('Asia/Kolkata')->format('M d, Y')
                ?? 'Oct 30, 2025');
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
            $view->with('siteAssets', array_replace(
                collect(config('cms.managed_assets'))->mapWithKeys(fn (array $asset, string $key): array => [$key => $asset['default']])->all(),
                SiteAsset::query()->pluck('value', 'key')->all(),
            ));
        });
    }
}
