<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;

trait HandlesBulkDeletion
{
    /**
     * Validate selected IDs, delete matching records, and remove orphaned public storage files.
     *
     * @param  callable(): Builder  $queryFactory
     * @param  array<int, string>  $fileColumns
     * @param  array<int, string>  $storagePrefixes
     */
    protected function executeBulkDestroy(
        Request $request,
        callable $queryFactory,
        Exists $existsRule,
        string $redirectRoute,
        array|string $routeParameters,
        string $singularMessage,
        string $pluralMessageTemplate,
        array $fileColumns = [],
        array $storagePrefixes = [],
    ): RedirectResponse {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct', $existsRule],
        ]);

        $ids = $data['ids'];

        [$deletedCount, $candidatePaths] = DB::transaction(function () use ($queryFactory, $ids, $fileColumns): array {
            $paths = $fileColumns !== []
                ? $this->extractFilePaths($queryFactory()->whereIn('id', $ids)->get($fileColumns), $fileColumns)
                : [];

            $count = $queryFactory()->whereIn('id', $ids)->delete();

            return [$count, $paths];
        });

        if ($candidatePaths !== [] && $storagePrefixes !== []) {
            $activePaths = $this->extractFilePaths($queryFactory()->get($fileColumns), $fileColumns);

            foreach ($candidatePaths as $path) {
                if (! in_array($path, $activePaths, true)) {
                    $this->deleteStoredPublicPath($path, $storagePrefixes);
                }
            }
        }

        $status = $deletedCount === 1
            ? $singularMessage
            : str_replace(':count', (string) $deletedCount, $pluralMessageTemplate);

        return redirect()->route($redirectRoute, $routeParameters)->with('status', $status);
    }

    /**
     * @param  array<int, string>  $fileColumns
     * @return array<int, string>
     */
    private function extractFilePaths(EloquentCollection $records, array $fileColumns): array
    {
        $paths = [];

        foreach ($records as $record) {
            foreach ($fileColumns as $column) {
                $value = $record->{$column};
                if (is_array($value)) {
                    foreach ($value as $entry) {
                        if (is_string($entry) && $entry !== '') {
                            $paths[] = $entry;
                        }
                    }
                } elseif (is_string($value) && $value !== '') {
                    $paths[] = $value;
                }
            }
        }

        return array_values(array_unique($paths));
    }

    /** @param array<int, string> $storagePrefixes */
    protected function deleteStoredPublicPath(?string $path, array $storagePrefixes): void
    {
        if ($path === null) {
            return;
        }

        foreach ($storagePrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                Storage::disk('public')->delete(substr($path, strlen('/storage/')));

                return;
            }
        }
    }
}
