<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('phone')->default('');
            $table->string('postal_code')->default('');
            $table->string('address')->default('');
            $table->string('profile')->default('');
            $table->string('image')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('postal_code');
            $table->dropColumn('address');
            $table->dropColumn('profile');
            $table->dropColumn('image');
        });
    }
}
