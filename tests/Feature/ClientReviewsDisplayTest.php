<?php

namespace Tests\Feature;

use App\Models\CollectionItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClientReviewsDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_client_reviews_populate_the_summary_and_all_review_tabs_in_saved_order(): void
    {
        $members = collect([5, 1, 1, 2, 3, 6])->map(fn (int $position, int $index) => CollectionItem::factory()->create([
            'collection' => 'testimonials', 'client_name' => 'Client '.$index, 'designation' => 'Director '.$index,
            'description' => 'Review '.$index, 'image' => '/storage/clients/'.$index.'.jpg', 'rating' => [1, 2, 3, 4, 5, 5][$index], 'sort_order' => $position,
        ]));
        CollectionItem::factory()->create(['collection' => 'testimonials', 'status' => 'draft', 'client_name' => 'Hidden client']);
        foreach (['/', '/admin/editor?page=home'] as $url) {
            if (str_starts_with($url, '/admin')) {
                $this->actingAs(User::factory()->create(['is_admin' => true]));
            }
            $response = $this->get($url)->assertOk()->assertDontSee('Hidden client')->assertDontSee('Emily Carter')
                ->assertSee('3.3 out of 5 stars from 6 client reviews');
            $xpath = $this->xpath($response->getContent());
            $images = $xpath->query('//*[@data-client-highlight]//img');
            $this->assertSame(4, $images->length);
            foreach ([1, 2, 3, 4] as $index => $memberIndex) {
                $this->assertSame($members[$memberIndex]->image, $images->item($index)->getAttribute('src'));
            }
            $this->assertSame(6, $xpath->query('//*[@data-client-reviews]//*[@role="tab"]')->length);
            $this->assertSame(6, $xpath->query('//*[@data-client-reviews]//*[@role="tabpanel"]')->length);
            $this->assertSame(1, $xpath->query('//*[@data-client-reviews]//*[@role="tabpanel" and not(@hidden)]')->length);
            $this->assertSame(1, $xpath->query('//*[@data-client-reviews and @data-cms-ignore and @data-cms-server-rendered]')->length);
            $this->assertSame(1, $xpath->query('//*[@data-client-highlight and @data-cms-ignore]')->length);
            foreach ($members as $member) {
                $response->assertSee($member->client_name)->assertSee($member->description)->assertSee($member->designation);
            }
        }
    }

    public function test_saved_client_details_and_image_changes_appear_without_using_the_visual_editor(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $first = CollectionItem::factory()->create(['collection' => 'testimonials', 'image' => '/storage/clients/first.jpg']);
        $second = CollectionItem::factory()->create(['collection' => 'testimonials', 'image' => '/storage/clients/second.jpg']);
        $this->put('/admin/collections/testimonials/'.$second->id, ['client_name' => 'Updated client', 'designation' => 'CEO', 'description' => 'Updated review', 'rating' => 4, 'status' => 'published', 'image_upload' => UploadedFile::fake()->image('updated-client.jpg')])->assertRedirect();
        $this->postJson('/admin/order/collections/testimonials', ['ids' => [$second->id, $first->id]])->assertOk();
        $response = $this->get('/')->assertOk()->assertSee('Updated client')->assertSee('Updated review')->assertSee('CEO');
        $xpath = $this->xpath($response->getContent());
        $this->assertNotSame('/storage/clients/second.jpg', $second->fresh()->image);
        $this->assertSame($second->fresh()->image, $xpath->query('//*[@data-client-highlight]//img')->item(0)->getAttribute('src'));
        $this->delete('/admin/collections/testimonials/'.$second->id)->assertRedirect();
        $response = $this->get('/')->assertOk()->assertDontSee('Updated client');
        $this->assertSame(1, $this->xpath($response->getContent())->query('//*[@data-client-reviews]//*[@role="tab"]')->length);
    }

    public function test_empty_and_legacy_reviews_never_show_demo_people_or_unsafe_markup(): void
    {
        $this->get('/')->assertOk()->assertDontSee('data-client-highlight', false)->assertDontSee('data-client-reviews', false)->assertDontSee('Emily Carter');
        $review = CollectionItem::factory()->create(['collection' => 'testimonials', 'client_name' => 'Actual client', 'designation' => '<script>alert(1)</script>', 'description' => '**Great work** <script>alert(2)</script>', 'image' => null, 'rating' => null]);
        $response = $this->get('/')->assertOk()->assertSee('Actual client')->assertSee('<strong>Great work</strong>', false)->assertDontSee('<script>alert(1)</script>', false)->assertDontSee('<script>alert(2)</script>', false);
        $xpath = $this->xpath($response->getContent());
        $this->assertSame(0, $xpath->query('//*[@data-client-highlight]//img')->length);
        $this->assertSame(1, $xpath->query('//*[@data-client-highlight]//*[local-name()="svg" and @aria-label="Actual client"]')->length);
        $this->assertSame(1, $xpath->query('//*[@role="tabpanel" and @id="client-review-panel-'.$review->id.'"]')->length);
    }

    private function xpath(string $html): \DOMXPath
    {
        $document = new \DOMDocument;
        $document->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);

        return new \DOMXPath($document);
    }
}
