<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'site_contents' => ['value'],
            'collection_items' => ['image', 'icon', 'gallery'],
            'site_assets' => ['value'],
            'companies' => ['image_path'],
            'certificates' => ['image_path'],
        ];

        foreach ($tables as $table => $columns) {
            DB::table($table)
                ->select(['id', ...$columns])
                ->orderBy('id')
                ->chunkById(100, function (Collection $rows) use ($table, $columns): void {
                    foreach ($rows as $row) {
                        $updates = [];

                        foreach ($columns as $column) {
                            $value = $row->{$column};
                            if (! is_string($value)) {
                                continue;
                            }

                            if ($column === 'gallery') {
                                $gallery = json_decode($value, true);
                                if (! is_array($gallery)) {
                                    continue;
                                }

                                $normalizedGallery = array_map(
                                    fn (mixed $image): mixed => is_string($image) ? $this->normalizeUrl($image) : $image,
                                    $gallery,
                                );
                                $normalized = $normalizedGallery === $gallery
                                    ? $value
                                    : json_encode($normalizedGallery, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
                            } else {
                                $normalized = $this->normalizeUrl($value);
                            }

                            if ($normalized !== $value) {
                                $updates[$column] = $normalized;
                            }
                        }

                        if ($updates !== []) {
                            DB::table($table)->where('id', $row->id)->update($updates);
                        }
                    }
                });
        }
    }

    /** The previous machine-specific hosts cannot be restored safely. */
    public function down(): void {}

    private function normalizeUrl(string $value): string
    {
        return preg_replace('~https?://(?:localhost|127\.0\.0\.1)(?::\d+)?/storage/~i', '/storage/', $value) ?? $value;
    }
};
