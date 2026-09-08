<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\Appointment;
use App\Models\AvailabilityRule;
use App\Models\BookingRequest;
use App\Models\Client;
use App\Models\PortfolioItem;
use App\Models\TattooStyle;
use App\Models\TimeBlock;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tattoo Styles
        $styles = [
            ['name' => 'Blackwork', 'slug' => 'blackwork'],
            ['name' => 'Fine Line', 'slug' => 'fine-line'],
            ['name' => 'Traditional', 'slug' => 'traditional'],
            ['name' => 'Neo-Traditional', 'slug' => 'neo-traditional'],
            ['name' => 'Micro-Realism', 'slug' => 'micro-realism'],
            ['name' => 'Geometric', 'slug' => 'geometric'],
            ['name' => 'Cover Up', 'slug' => 'cover-up'],
            ['name' => 'Anime', 'slug' => 'anime'],
            ['name' => 'Realismo', 'slug' => 'realismo'],
            ['name' => 'Black & Grey', 'slug' => 'black-grey'],
            ['name' => 'Acuarela', 'slug' => 'acuarela'],
        ];

        foreach ($styles as $style) {
            TattooStyle::firstOrCreate(['name' => $style['name']], $style);
        }

        // 2. Default Availability Rules (Mon - Fri: 10:00 to 19:00)
        foreach ([1, 2, 3, 4, 5] as $day) {
            AvailabilityRule::firstOrCreate(
                ['day_of_week' => $day],
                ['start_time' => '10:00', 'end_time' => '19:00']
            );
        }

        // 3. Admin User
        AdminUser::updateOrCreate(
            ['email' => 'admin@farfos.com'],
            [
                'name' => 'Farfos Admin',
                'password' => Hash::make('admin_password_123'),
            ]
        );

        // 4. Portfolio Items (Matching original site)
        $portfolioData = [
            [
                'category' => 'Cover Up',
                'image_url' => 'https://images.unsplash.com/photo-1590201774843-021110a2663c?q=80&w=800',
                'title' => 'Guerrero y León',
                'description' => 'Un cover up de 3 sesiones que reinterpreta la piel desde un nuevo relato visual: estrategia y poder.',
                'is_featured' => true,
            ],
            [
                'category' => 'Anime',
                'image_url' => 'https://images.unsplash.com/photo-1611501275019-9b5cda994e8d?q=80&w=800',
                'title' => 'Killua Zoldyck',
                'description' => '2 sesiones: definición de estructura eléctrica y atmósfera de color para el personaje de HxH.',
                'is_featured' => true,
            ],
            [
                'category' => 'Black & Grey',
                'image_url' => 'https://images.unsplash.com/photo-1550537687-c91072c4792d?q=80&w=800',
                'title' => 'Zorro Ornamental',
                'description' => 'Líneas que fluyen y sombras suaves para un espacio personal llevado a la piel en @inknefable_estudio.',
                'is_featured' => false,
            ],
            [
                'category' => 'Cover Up',
                'image_url' => 'https://images.unsplash.com/photo-1560707854-fb9a10eb18ef?q=80&w=800',
                'title' => 'Mewtwo',
                'description' => '14 horas de trabajo para transformar un símbolo antiguo en una composición de Pokémon estratégica.',
                'is_featured' => false,
            ],
            [
                'category' => 'Acuarela',
                'image_url' => 'https://images.unsplash.com/photo-1562967914-01eba72aa17e?q=80&w=800',
                'title' => 'Saturno',
                'description' => 'Transformando el pasado en ciclos y madurez con técnica fluida y orgánica de acuarela.',
                'is_featured' => false,
            ],
            [
                'category' => 'Realismo',
                'image_url' => 'https://images.unsplash.com/photo-1598371839696-5c5bb00bdc28?q=80&w=800',
                'title' => 'Elefante',
                'description' => 'Cierre de ½ manga que habla de fuerza y memoria, integrándose con piezas preexistentes.',
                'is_featured' => true,
            ],
        ];

        foreach ($portfolioData as $item) {
            $style = TattooStyle::where('name', $item['category'])->first();
            PortfolioItem::updateOrCreate(
                ['title' => $item['title']],
                [
                    'image_url' => $item['image_url'],
                    'description' => $item['description'],
                    'style_id' => $style ? $style->id : null,
                    'is_featured' => $item['is_featured'],
                ]
            );
        }

        // 5. Sample Clients & Requests & Appointments for realistic Dashboard & Agenda
        $clientLucas = Client::firstOrCreate(
            ['email' => 'lucas.rivas@example.com'],
            ['name' => 'Lucas Rivas', 'phone' => '+56 9 8765 4321']
        );

        $clientMaria = Client::firstOrCreate(
            ['email' => 'maria.jose@example.com'],
            ['name' => 'María José', 'phone' => '+56 9 1234 5678']
        );

        $reqLucas = BookingRequest::firstOrCreate(
            ['client_id' => $clientLucas->id],
            [
                'description' => 'Blackwork en antebrazo de serpiente y flores.',
                'size' => 'M',
                'body_zone' => 'Antebrazo',
                'preferred_date' => Carbon::tomorrow()->setHour(10)->setMinute(0),
                'preferred_time_slot' => 'Morning',
                'location' => 'INKNEFABLE',
                'status' => 'APPROVED',
            ]
        );

        $reqMaria = BookingRequest::firstOrCreate(
            ['client_id' => $clientMaria->id],
            [
                'description' => 'Diseño Fine line de flores silvestres en costillas.',
                'size' => 'S',
                'body_zone' => 'Costillas',
                'preferred_date' => Carbon::tomorrow()->setHour(15)->setMinute(0),
                'preferred_time_slot' => 'Afternoon',
                'location' => 'INKNEFABLE',
                'status' => 'PENDING',
            ]
        );

        // Sample Appointment
        Appointment::updateOrCreate(
            ['booking_request_id' => $reqLucas->id],
            [
                'client_id' => $clientLucas->id,
                'title' => 'Tatuaje: Lucas Rivas',
                'description' => 'Blackwork Antebrazo',
                'start_time' => Carbon::tomorrow()->setHour(10)->setMinute(0),
                'end_time' => Carbon::tomorrow()->setHour(14)->setMinute(0),
                'status' => 'CONFIRMED',
                'payment_status' => 'UNPAID',
                'deposit_amount' => 30000.00,
                'location' => 'INKNEFABLE',
                'price' => 150000.00,
            ]
        );

        // Sample TimeBlock for lunch
        TimeBlock::firstOrCreate(
            ['start_time' => Carbon::tomorrow()->setHour(14)->setMinute(0)],
            [
                'end_time' => Carbon::tomorrow()->setHour(15)->setMinute(0),
                'type' => 'LUNCH',
                'description' => 'Almuerzo y esterilización',
            ]
        );
    }
}
