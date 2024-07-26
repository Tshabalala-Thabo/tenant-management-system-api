<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade'); // Foreign key to tenants table
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null'); // Foreign key to rooms table (optional)
            $table->foreignId('site_id')->nullable()->constrained('sites')->onDelete('set null'); // Foreign key to sites table (optional)
            $table->date('issue_date'); // Date when the invoice was issued
            $table->date('due_date'); // Date when the payment is due
            $table->decimal('amount', 10, 2); // Total amount of the invoice
            $table->decimal('paid_amount', 10, 2)->default(0.00); // Amount that has been paid
            $table->enum('status', ['pending', 'paid', 'overdue', 'canceled'])->default('pending'); // Status of the invoice
            $table->decimal('water_charge', 10, 2)->default(0.00); // Water charge
            $table->decimal('electricity_charge', 10, 2)->default(0.00); // Electricity charge
            $table->decimal('other_charges', 10, 2)->default(0.00); // Other charges
            $table->text('description')->nullable(); // Optional description or notes
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
