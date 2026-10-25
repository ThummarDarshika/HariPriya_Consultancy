<?php

namespace Tests\Feature;

use App\Models\CollectionItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseStudyPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_five_case_studies_fit_on_one_page_without_pagination(): void
    {
        foreach (range(1, 5) as $number) {
            CollectionItem::factory()->create([
                'collection' => 'case-studies',
                'title' => "Case study {$number}",
                'sort_order' => $number,
            ]);
        }

        $response = $this->get('/case-studies');

        $response->assertSee('Case study 5')
            ->assertDontSee('aria-label="Case study pages"', false);
    }

    public function test_additional_case_studies_have_working_next_and_previous_pages(): void
    {
        foreach (range(1, 7) as $number) {
            CollectionItem::factory()->create([
                'collection' => 'case-studies',
                'title' => "Case study {$number}",
                'sort_order' => $number,
            ]);
        }
        CollectionItem::factory()->create([
            'collection' => 'case-studies',
            'title' => 'Unpublished case study',
            'status' => 'draft',
        ]);

        $firstPage = $this->get('/case-studies');
        $secondPage = $this->get('/case-studies?case_page=2');

        $firstPage->assertSee('Case study 6')
            ->assertDontSee('Case study 7')
            ->assertSee('Page 1 of 2')
            ->assertSee('case_page=2#case-studies-list', false)
            ->assertDontSee('Unpublished case study');
        $secondPage->assertSee('Case study 7')
            ->assertDontSee('Case study 1')
            ->assertSee('Page 2 of 2')
            ->assertDontSee('rel="next"', false)
            ->assertSee('case_page=1#case-studies-list', false);
    }
}
