<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lease_agreements', function (Blueprint $table) {
            $table->timestamp('termination_date')->nullable()->after('is_terminated');
        });
    }

    public function down()
    {
        Schema::table('lease_agreements', function (Blueprint $table) {
            $table->dropColumn('termination_date');
        });
    }
}; 