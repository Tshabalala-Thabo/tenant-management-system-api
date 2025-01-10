<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProviderSiteTable extends Migration
{
    public function up()
    {
        Schema::create('service_provider_site', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_provider_site');
    }
}
