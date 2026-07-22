<?php

namespace Tests\Feature;

use App\Models\ProductVariant;
use App\Models\User;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_staff_login_is_available_but_dashboard_is_protected(): void
    {
        $this->get('/staff/login')->assertOk();
        $this->get('/staff')->assertRedirect('/staff/login');
    }

    public function test_main_website_navigation_destinations_are_available(): void
    {
        $this->get(route('home'))->assertOk()
            ->assertSee(route('home').'#categories', false)
            ->assertSee(route('pricing'), false)
            ->assertSee(route('policies.index'), false)
            ->assertSee(route('home').'#contact', false);

        $this->get(route('pricing'))->assertOk();
        $this->get(route('policies.index'))->assertOk();

        $phone = ProductVariant::query()->published()->firstOrFail();
        $this->get(route('phones.show', $phone))->assertOk()
            ->assertSee('Images/faviconapple.png?v=2', false)
            ->assertSee(route('home').'#categories', false)
            ->assertSee(route('pricing'), false)
            ->assertSee(route('policies.index'), false)
            ->assertSee(route('home').'#contact', false);
    }

    public function test_active_administrator_can_open_the_operations_dashboard(): void
    {
        $administrator = User::where('email', 'info@phoneexpresskenya.co.ke')->firstOrFail();

        $this->actingAs($administrator)->get('/staff')->assertOk();
        $this->actingAs($administrator)->get('/staff/team')->assertOk();
        $this->actingAs($administrator)->get('/staff/catalogue')->assertOk();
    }
}
