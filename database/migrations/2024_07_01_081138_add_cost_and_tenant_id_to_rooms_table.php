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
        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('cost');

            // Assuming you have a users table
            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};
