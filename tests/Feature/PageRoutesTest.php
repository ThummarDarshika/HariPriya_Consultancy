<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test all converted pages load with HTTP status 200.
     */
    public function test_all_pages_load_successfully(): void
    {
        $routes = [
            '/',
            '/about',
            '/services',
            '/products',
            '/case-studies',
            '/blog',
            '/blog-detail',
            '/contact',
            '/faqs',
            '/privacy-policy',
            '/error-404',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * Test fallback 404 route returns HTTP 404 with custom 404 template.
     */
    public function test_non_existent_route_returns_404(): void
    {
        $response = $this->get('/non-existent-page-url');
        $response->assertStatus(404);
        $response->assertSee('404');
    }
}
