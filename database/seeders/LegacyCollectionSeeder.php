<?php

namespace Database\Seeders;

use App\Models\CollectionItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LegacyCollectionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['services' => 'Service', 'products' => 'Product', 'faqs' => 'FAQ'] as $collection => $label) {
            $source = file_get_contents(resource_path('views/pages/'.$collection.'.blade.php'));
            preg_match_all('/<!-- '.preg_quote($label, '/').' \d+ -->(.*?)(?=<!-- '.preg_quote($label, '/').' \d+ -->|$)/s', $source, $matches);

            foreach ($matches[1] as $index => $markup) {
                $this->import($collection, $markup, $index);
            }
        }

        foreach (['blogs' => ['blog', 'bg-default-100 p-4 rounded group relative'], 'team-members' => ['about', 'flex flex-col gap-4']] as $collection => [$page, $class]) {
            $source = file_get_contents(resource_path('views/pages/'.$page.'.blade.php'));
            $chunks = explode('<div class="'.$class.'">', $source);
            array_shift($chunks);

            foreach ($chunks as $index => $markup) {
                $this->import($collection, $markup, $index);
            }
        }

        $home = file_get_contents(resource_path('views/pages/home.blade.php'));
        $cases = preg_split('/<!-- Slide \d+ -->/', $home);
        array_shift($cases);
        foreach (array_slice($cases, 0, 5) as $index => $markup) {
            preg_match('/<h3[^>]*>(.*?)<\/h3>/s', $markup, $title);
            preg_match('/<p[^>]*>(.*?)<\/p>/s', $markup, $description);
            preg_match_all('/<h3[^>]*>(.*?)<\/h3>/s', $markup, $headings);
            preg_match_all("/asset\\('([^']+)'\\)/", $markup, $images);
            if (! isset($title[1])) {
                continue;
            }

            $name = trim(preg_replace('/\s+/', ' ', strip_tags($title[1])));
            CollectionItem::query()->firstOrCreate(
                ['collection' => 'case-studies', 'slug' => Str::slug($name).'-'.($index + 1)],
                [
                    'title' => $name,
                    'description' => isset($description[1]) ? trim(html_entity_decode(preg_replace('/\s+/', ' ', strip_tags($description[1])))) : null,
                    'image' => isset($images[1][0]) ? '/'.$images[1][0] : null,
                    'icon' => isset($images[1][1]) ? '/'.$images[1][1] : null,
                    'category' => 'Materials engineering',
                    'metric' => isset($headings[1][1]) ? trim(strip_tags($headings[1][1])) : null,
                    'status' => 'published',
                    'sort_order' => $index,
                ],
            );
        }

        preg_match_all('/<!-- Service \d+ -->(.*?)(?=<!-- Service \d+ -->|<\/section>)/s', $home, $services);
        foreach (array_slice($services[1], 0, 4) as $index => $markup) {
            preg_match_all('/<div class="flex items-center gap-2">\s*<i[^>]*><\/i>\s*<div>(.*?)<\/div>/s', $markup, $features);
            $item = CollectionItem::query()->where('collection', 'services')->where('sort_order', $index)->first();
            if ($item && ! $item->features) {
                $item->update(['features' => array_map(fn ($feature) => trim(html_entity_decode(strip_tags($feature))), $features[1])]);
            }
        }

        preg_match_all('/<!-- Content \d+ -->(.*?)(?=<!-- Content \d+ -->|<!-- End Tab Content -->)/s', $home, $testimonials);
        foreach ($testimonials[1] as $index => $markup) {
            preg_match('/<p class="text-default-900">(.*?)<\/p>/s', $markup, $quote);
            preg_match('/<h3[^>]*>(.*?)<\/h3>/s', $markup, $name);
            preg_match('/<div class="text-sm text-default-600">(.*?)<\/div>/s', $markup, $designation);
            if (! isset($name[1])) {
                continue;
            }

            CollectionItem::query()->firstOrCreate(
                ['collection' => 'testimonials', 'slug' => Str::slug($name[1]).'-'.($index + 1)],
                [
                    'title' => trim(strip_tags($name[1])),
                    'client_name' => trim(strip_tags($name[1])),
                    'description' => isset($quote[1]) ? trim(html_entity_decode(preg_replace('/\s+/', ' ', strip_tags($quote[1])))) : null,
                    'designation' => isset($designation[1]) ? trim(strip_tags($designation[1])) : null,
                    'rating' => 5,
                    'status' => 'published',
                    'sort_order' => $index,
                ],
            );
        }
    }

    private function import(string $collection, string $markup, int $index): void
    {
        preg_match('/<h[23][^>]*>(.*?)<\/h[23]>/s', $markup, $titleMatch);
        if (! isset($titleMatch[1])) {
            return;
        }

        $title = html_entity_decode(strip_tags($titleMatch[1]));
        $title = trim(preg_replace('/\s+/', ' ', $title));
        $slug = Str::slug($title).'-'.($index + 1);
        preg_match('/<p[^>]*>(.*?)<\/p>/s', $markup, $descriptionMatch);
        preg_match("/asset\\('([^']+)'\\)/", $markup, $imageMatch);
        preg_match('/<span[^>]*bg-white[^>]*>(.*?)<\/span>/s', $markup, $categoryMatch);
        preg_match('/<div class="team-job-title">(.*?)<\/div>/s', $markup, $roleMatch);
        preg_match('/<h3[^>]*>(.*?)<\/h3>/s', $markup, $metricMatch);
        preg_match_all('/class="text-white text-sm">(.*?)<\/div>/s', $markup, $metadataMatch);
        preg_match_all('/<a href="([^"]+)"[^>]*class="social-link[^\"]*"/s', $markup, $socialMatch);

        $description = isset($descriptionMatch[1]) ? trim(html_entity_decode(strip_tags($descriptionMatch[1]))) : null;
        $summary = null;
        $image = isset($imageMatch[1]) ? '/'.$imageMatch[1] : null;
        $category = isset($categoryMatch[1]) ? trim(html_entity_decode(strip_tags($categoryMatch[1]))) : null;
        $displayDate = $collection === 'blogs' ? '17 Oct 25' : null;
        $articleSubheading = null;
        $videoUrl = null;

        if ($collection === 'blogs') {
            $description = null;
            if ($index === 0) {
                $detail = file_get_contents(resource_path('views/pages/blog-detail.blade.php'));
                preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $detail, $detailTitle);
                preg_match('/<p class="mb-5 text-center[^>]*>(.*?)<\/p>/s', $detail, $detailSummary);
                preg_match('/<section class="overflow-hidden relative size-full py-25"[^>]*>(.*?)<\/section>/s', $detail, $detailBody);
                preg_match("/asset\\('(assets\/blog-detail[^']+)'\\)/", $detail, $detailImage);
                $title = isset($detailTitle[1]) ? trim(strip_tags($detailTitle[1])) : $title;
                $summary = isset($detailSummary[1]) ? trim(preg_replace('/\s+/', ' ', strip_tags($detailSummary[1]))) : null;
                if (isset($detailBody[1])) {
                    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/s', $detailBody[1], $articleHeadings);
                    preg_match('/<iframe[^>]*src="([^"]+)"/s', $detailBody[1], $articleVideo);
                    preg_match_all('/<(p|li|em)\b[^>]*>(.*?)<\/\1>/s', $detailBody[1], $articleParts, PREG_SET_ORDER);
                    $articleSubheading = isset($articleHeadings[1][1]) ? trim(strip_tags($articleHeadings[1][1])) : null;
                    $videoUrl = $articleVideo[1] ?? null;
                    $description = implode("\n\n", array_map(
                        fn ($part) => trim(html_entity_decode(preg_replace('/\s+/', ' ', strip_tags($part[2])))),
                        $articleParts,
                    ));
                }
                $image = isset($detailImage[1]) ? '/'.$detailImage[1] : $image;
                $category = 'Smart manufacturing';
                $displayDate = 'October 17, 2025';
                $slug = Str::slug($title).'-1';
            }
        }

        CollectionItem::query()->firstOrCreate(
            ['collection' => $collection, 'slug' => $slug],
            [
                'title' => $title,
                'description' => $description,
                'summary' => $summary,
                'article_subheading' => $articleSubheading,
                'video_url' => $videoUrl,
                'image' => $image,
                'category' => $category,
                'role' => isset($roleMatch[1]) ? trim(strip_tags($roleMatch[1])) : null,
                'social_links' => $collection === 'team-members' ? [
                    'instagram' => $socialMatch[1][0] ?? null,
                    'linkedin' => $socialMatch[1][1] ?? null,
                    'x' => $socialMatch[1][2] ?? null,
                ] : null,
                'metric' => $collection === 'case-studies' && isset($metricMatch[1]) ? trim(strip_tags($metricMatch[1])) : null,
                'material' => isset($metadataMatch[1][0]) ? html_entity_decode($metadataMatch[1][0]) : null,
                'capability' => isset($metadataMatch[1][1]) ? html_entity_decode($metadataMatch[1][1]) : null,
                'size_range' => isset($metadataMatch[1][2]) ? html_entity_decode($metadataMatch[1][2]) : null,
                'display_date' => $displayDate,
                'sort_order' => $index,
                'status' => 'published',
            ],
        );
    }
}
