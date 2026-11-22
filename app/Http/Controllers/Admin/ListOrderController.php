<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CollectionItem;
use App\Models\Company;
use App\Models\JobOpening;
use App\Models\ProjectMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ListOrderController extends Controller
{
    public function __invoke(Request $request, string $kind, ?string $collection = null): JsonResponse
    {
        $query = match ($kind) {
            'companies' => Company::query(),
            'certificates' => Certificate::query(),
            'project-media' => ProjectMedia::query(),
            'job-openings' => JobOpening::query(),
            'collections' => CollectionItem::query()->where('collection', $collection),
            default => abort(404),
        };
        abort_if($kind === 'collections' && ! array_key_exists($collection ?? '', config('cms.collections')), 404);
        $data = $request->validate([
            'ids' => ['required', 'array', 'list', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct'],
        ]);
        DB::transaction(function () use ($query, $data): void {
            $existing = (clone $query)->orderBy('id')->lockForUpdate()->pluck('id')->all();
            $ids = array_map(intval(...), $data['ids']);
            $sorted = $ids;
            sort($sorted);
            if ($sorted !== $existing) {
                throw ValidationException::withMessages(['ids' => 'The list changed. Reload the page and try again.']);
            }
            foreach ($ids as $position => $id) {
                (clone $query)->whereKey($id)->update(['sort_order' => $position]);
            }
        });

        return response()->json(['message' => 'Order saved.']);
    }
}
