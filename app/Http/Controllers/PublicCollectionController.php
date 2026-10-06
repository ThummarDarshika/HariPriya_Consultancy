<?php

namespace App\Http\Controllers;

use App\Models\CollectionItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PublicCollectionController extends Controller
{
    public function __invoke(string $collection): JsonResponse
    {
        abort_unless(array_key_exists($collection, config('cms.collections')), 404);

        $items = CollectionItem::query()
            ->where('collection', $collection)
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(100)
            ->get();

        return response()->json($items->map(fn (CollectionItem $item): array => $this->formatted($item)));
    }

    public function show(string $collection, CollectionItem $item): JsonResponse
    {
        abort_unless(array_key_exists($collection, config('cms.collections')), 404);
        abort_unless($item->collection === $collection && $item->status === 'published', 404);

        return response()->json($this->formatted($item));
    }

    /** @return array<string, mixed> */
    private function formatted(CollectionItem $item): array
    {
        $options = [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 100,
            'max_delimiters_per_line' => 1000,
        ];
        $blocks = preg_split('/\r?\n\s*\r?\n/', $item->description ?? '');

        return [
            ...$item->toArray(),
            'description_blocks_html' => array_map(
                fn (string $block): string => (string) Str::of($block)->inlineMarkdown($options),
                array_values(array_filter($blocks, fn (string $block): bool => trim($block) !== '')),
            ),
            'summary_html' => (string) Str::of($item->summary ?? '')->inlineMarkdown($options),
        ];
    }
}
