<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'terminated'])->default('pending');
            $table->boolean('previously_terminated')->default(false); // Indicates if terminated before
            $table->boolean('previously_rejected')->default(false); // Indicates if rejected before
            $table->text('termination_reason')->nullable(); // Stores reason for termination/rejection
            $table->text('rejection_reason')->nullable(); // Stores reason for termination/rejection
            $table->timestamp('termination_date')->nullable(); // Tracks when termination occurred
            $table->timestamp('rejection_date')->nullable(); // Tracks when termination occurred
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodation_applications');
    }
};

