<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Admin Users
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Clients
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. Tattoo Styles
        Schema::create('tattoo_styles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 4. Booking Requests
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->text('description');
            $table->string('size')->nullable();
            $table->string('body_zone')->nullable();
            $table->dateTime('preferred_date');
            $table->string('preferred_time_slot')->nullable(); // Morning, Afternoon
            $table->string('budget')->nullable();
            $table->string('location')->nullable(); // INKNEFABLE, IL CAPO STUDIO
            $table->json('references')->nullable();
            $table->string('status')->default('PENDING'); // PENDING, APPROVED, REJECTED, CANCELLED
            $table->timestamps();
        });

        // 5. Appointments
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('booking_request_id')->nullable()->unique()->constrained('booking_requests')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('status')->default('CONFIRMED'); // CONFIRMED, COMPLETED, CANCELLED, REPROGRAMMED
            $table->string('payment_status')->default('UNPAID'); // UNPAID, PAID, REFUNDED
            $table->decimal('deposit_amount', 10, 2)->default(30000.00);
            $table->dateTime('paid_at')->nullable();
            $table->string('location')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['start_time', 'end_time']);
        });

        // 6. Availability Rules
        Schema::create('availability_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day_of_week'); // 0 (Sunday) to 6 (Saturday)
            $table->string('start_time'); // "HH:mm"
            $table->string('end_time');   // "HH:mm"
            $table->timestamps();
        });

        // 7. Time Blocks
        Schema::create('time_blocks', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('type')->default('OTHER'); // LUNCH, VACATION, CLOSED, PERSONAL, OTHER
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index(['start_time', 'end_time']);
        });

        // 8. Portfolio Items
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('style_id')->nullable()->constrained('tattoo_styles')->onDelete('set null');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // 9. Site Settings
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('portfolio_items');
        Schema::dropIfExists('time_blocks');
        Schema::dropIfExists('availability_rules');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('booking_requests');
        Schema::dropIfExists('tattoo_styles');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('admin_users');
    }
};
