<?php

namespace Tests\Feature;

use App\Models\CollectionItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutCapabilitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_capabilities_show_the_first_four_published_services_and_link_to_services(): void
    {
        foreach (range(1, 5) as $number) {
            CollectionItem::factory()->create([
                'collection' => 'services',
                'title' => "Capability service {$number}",
                'sort_order' => $number,
            ]);
        }
        CollectionItem::factory()->create([
            'collection' => 'services',
            'title' => 'Draft capability service',
            'status' => 'draft',
            'sort_order' => 0,
        ]);

        $response = $this->get('/about');

        $response->assertSee('Capability service 1')
            ->assertSee('Capability service 4')
            ->assertDontSee('Capability service 5')
            ->assertDontSee('Draft capability service')
            ->assertSee('href="'.route('services').'" class="flex items-center justify-between"', false);
    }
}
