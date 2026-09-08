<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FarfoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_render_successfully(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/portafolio')->assertStatus(200);
        $this->get('/sobre-mi')->assertStatus(200);
        $this->get('/contacto')->assertStatus(200);
        $this->get('/reserva')->assertStatus(200);
        $this->get('/reserva/confirmacion')->assertStatus(200);
    }

    public function test_api_calendar_reserved_days(): void
    {
        $response = $this->get('/api/calendar/reserved-days');
        $response->assertStatus(200)->assertJsonIsArray();
    }

    public function test_booking_request_submission(): void
    {
        $response = $this->post('/reserva', [
            'description' => 'Tatuaje personalizado blackwork en el antebrazo con flores y líneas finas.',
            'size' => 'M',
            'body_zone' => 'Antebrazo',
            'name' => 'Cliente de Prueba',
            'email' => 'test.cliente@example.com',
            'phone' => '+56 9 9988 7766',
            'preferred_date' => now()->addDays(5)->format('Y-m-d'),
            'preferred_time_slot' => 'Morning',
            'location' => 'INKNEFABLE',
        ]);

        $response->assertRedirect(route('booking.success'));

        $this->assertDatabaseHas('clients', [
            'email' => 'test.cliente@example.com',
            'name' => 'Cliente de Prueba',
        ]);

        $this->assertDatabaseHas('booking_requests', [
            'body_zone' => 'Antebrazo',
            'status' => 'PENDING',
        ]);
    }

    public function test_admin_authentication_and_dashboard(): void
    {
        $this->get('/admin/login')->assertStatus(200);

        // Try invalid password
        $this->post('/admin/login', [
            'email' => 'admin@farfos.com',
            'password' => 'wrong_password',
        ])->assertSessionHasErrors('email');

        // Valid login
        $this->post('/admin/login', [
            'email' => 'admin@farfos.com',
            'password' => 'admin_password_123',
        ])->assertRedirect(route('admin.dashboard'));

        $admin = AdminUser::where('email', 'admin@farfos.com')->first();
        $this->assertNotNull($admin);

        $this->actingAs($admin, 'admin')->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($admin, 'admin')->get('/admin/requests')->assertStatus(200);
        $agendaResponse = $this->actingAs($admin, 'admin')->get('/admin/agenda');
        $agendaResponse->assertStatus(200)
            ->assertSee('Lista')
            ->assertSee('Grilla / Mes')
            ->assertViewHas('agendaItems');
    }
}
