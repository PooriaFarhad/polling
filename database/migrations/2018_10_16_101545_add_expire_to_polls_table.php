<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpireToPollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('image');
            $table->enum('status', ['running', 'suspended', 'expired'])->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->dropColumn('expires_at');
            $table->dropColumn('status');
        });
    }
}
