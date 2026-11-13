<?php

namespace Tests\Feature;

use App\Models\AnalyticsEvent;
use App\Models\AnalyticsPageView;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SiteAnalyticsTest extends TestCase
{
    use DatabaseTransactions;

    private const PHONE_UA = 'Mozilla/5.0 (Linux; Android 14; SM-A546E) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0 Mobile Safari/537.36';

    public function test_storefront_page_view_is_recorded_with_visit_details(): void
    {
        $before = AnalyticsPageView::max('id') ?? 0;

        $response = $this->withHeaders(['User-Agent' => self::PHONE_UA, 'Referer' => 'https://www.google.com/'])
            ->get('/pricing?search=iPhone%2017&brand=apple&utm_source=Instagram&utm_campaign=promo');

        $response->assertOk()->assertCookie('dd_vid')->assertCookie('dd_sid');

        $view = AnalyticsPageView::where('id', '>', $before)->sole();
        $this->assertSame('/pricing', $view->path);
        $this->assertSame('iphone 17', $view->search_term);
        $this->assertSame('brand=apple&search=iPhone+17', $view->query);
        $this->assertSame('campaign', $view->source);
        $this->assertSame('instagram', $view->utm_source);
        $this->assertSame('promo', $view->utm_campaign);
        $this->assertSame('www.google.com', $view->referrer_host);
        $this->assertSame('mobile', $view->device);
        $this->assertSame('Chrome', $view->browser);
        $this->assertSame('Android', $view->os);
        $this->assertTrue($view->is_entry);
        $this->assertTrue($view->is_new_visitor);
    }

    public function test_second_page_in_same_visit_is_internal_and_whatsapp_click_is_attributed(): void
    {
        $before = AnalyticsPageView::max('id') ?? 0;
        $phone = ProductVariant::query()->published()->firstOrFail();

        $first = $this->withHeaders(['User-Agent' => self::PHONE_UA])->get('/');
        $cookies = [
            'dd_vid' => $first->getCookie('dd_vid')->getValue(),
            'dd_sid' => $first->getCookie('dd_sid')->getValue(),
        ];

        $this->withHeaders(['User-Agent' => self::PHONE_UA])->withCookies($cookies)
            ->get(route('phones.show', $phone))->assertOk();

        $views = AnalyticsPageView::where('id', '>', $before)->orderBy('id')->get();
        $this->assertCount(2, $views);
        $this->assertSame('direct', $views[0]->source);
        $this->assertSame('internal', $views[1]->source);
        $this->assertFalse($views[1]->is_entry);
        $this->assertFalse($views[1]->is_new_visitor);
        $this->assertSame($views[0]->session_id, $views[1]->session_id);
        $this->assertSame($phone->getKey(), $views[1]->product_variant_id);

        $this->withHeaders(['User-Agent' => self::PHONE_UA])->withCookies($cookies)
            ->post(route('analytics.event'), ['name' => 'whatsapp_click', 'path' => $views[1]->path, 'label' => 'Ask about this product'])
            ->assertNoContent();

        $event = AnalyticsEvent::where('session_id', $views[0]->session_id)->sole();
        $this->assertSame('whatsapp_click', $event->name);
        $this->assertSame($phone->getKey(), $event->product_variant_id);
    }

    public function test_bots_prefetches_and_signed_in_staff_are_not_counted(): void
    {
        $before = AnalyticsPageView::max('id') ?? 0;

        $this->withHeaders(['User-Agent' => 'WhatsApp/2.23.20.0 A'])->get('/')->assertOk();
        $this->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1)'])->get('/')->assertOk();
        $this->withHeaders(['User-Agent' => self::PHONE_UA, 'Sec-Purpose' => 'prefetch'])->get('/')->assertOk();
        $this->actingAs(User::where('role', 'admin')->firstOrFail())
            ->withHeaders(['User-Agent' => self::PHONE_UA])->get('/')->assertOk();

        $this->assertSame(0, AnalyticsPageView::where('id', '>', $before)->count());
    }

    public function test_beacons_without_a_tracked_visit_or_with_unknown_names_are_dropped(): void
    {
        $before = AnalyticsEvent::max('id') ?? 0;

        $this->withHeaders(['User-Agent' => self::PHONE_UA])
            ->post(route('analytics.event'), ['name' => 'whatsapp_click', 'path' => '/'])->assertNoContent();
        $this->withHeaders(['User-Agent' => self::PHONE_UA])
            ->withCookies(['dd_vid' => '0b6b5f0e-3a1e-4f3e-9f55-6a2f4c1d2e3f', 'dd_sid' => '1b6b5f0e-3a1e-4f3e-9f55-6a2f4c1d2e3f'])
            ->post(route('analytics.event'), ['name' => 'purchase', 'path' => '/'])->assertSessionHasErrors('name');

        $this->assertSame(0, AnalyticsEvent::where('id', '>', $before)->count());
    }

    public function test_admin_can_open_analytics_for_every_range(): void
    {
        $this->withHeaders(['User-Agent' => self::PHONE_UA])->get('/');
        $admin = User::where('role', 'admin')->firstOrFail();

        foreach (['today', '7d', '30d', '90d', '365d'] as $range) {
            $this->actingAs($admin)->get(route('staff.analytics.index', ['range' => $range]))
                ->assertOk()->assertSee('How customers use the website');
        }

        $today = now(config('analytics.timezone'));
        $this->actingAs($admin)
            ->get(route('staff.analytics.index', ['from' => $today->copy()->subDays(3)->toDateString(), 'to' => $today->toDateString()]))
            ->assertOk();
    }

    public function test_analytics_requires_a_signed_in_admin(): void
    {
        $this->get(route('staff.analytics.index'))->assertRedirect('/staff/login');

        $staff = User::where('role', '!=', 'admin')->first();
        if ($staff) {
            $this->actingAs($staff)->get(route('staff.analytics.index'))->assertForbidden();
        }
    }

    public function test_footer_shows_developer_credit(): void
    {
        $this->get('/')
            ->assertSee('https://x.com/levis_lance', false)
            ->assertSee('mailto:lancelevis19@gmail.com', false);
    }
}
