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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 20)->unique();
            $table->foreignId('package_id')->constrained('travel_packages')->onDelete('cascade');
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->enum('booking_source', ['online', 'manual', 'phone', 'whatsapp'])->default('manual');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 20);
            $table->text('customer_address')->nullable();
            $table->string('customer_ktp_number', 20)->nullable();
            $table->integer('participants_adult')->default(1);
            $table->integer('participants_child')->default(0);
            $table->integer('participants_infant')->default(0);
            $table->date('travel_date');
            $table->date('return_date');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('commission_amount', 15, 2);
            $table->enum('booking_status', ['draft', 'pending', 'confirmed', 'paid', 'completed', 'cancelled'])->default('draft');
            $table->enum('payment_status', ['pending', 'down_payment', 'paid', 'refunded'])->default('pending');
            $table->enum('payment_method', ['cash', 'transfer', 'credit_card', 'debit_card', 'e_wallet'])->nullable();
            $table->string('payment_proof_path')->nullable();
            $table->decimal('down_payment_amount', 15, 2)->default(0);
            $table->date('down_payment_date')->nullable();
            $table->date('full_payment_date')->nullable();
            $table->text('special_requests')->nullable();
            $table->text('affiliate_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['booking_code', 'booking_status']);
            $table->index(['affiliate_id', 'booking_status']);
            $table->index(['package_id', 'travel_date']);
            $table->index(['customer_email', 'booking_status']);
            $table->index(['created_at', 'booking_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
