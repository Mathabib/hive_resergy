<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('broadcast_logs', function (Blueprint $table) {
        $table->dropColumn('email');
    });
}

public function down()
{
    Schema::table('broadcast_logs', function (Blueprint $table) {
        $table->string('email')->after('id');
    });
}

};
