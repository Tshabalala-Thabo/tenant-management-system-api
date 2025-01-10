<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoomIdAndSiteIdToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->nullable()->after('status');
            $table->unsignedBigInteger('site_id')->after('room_id');

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['site_id']);
            $table->dropColumn(['room_id', 'site_id']);
        });
    }
}
