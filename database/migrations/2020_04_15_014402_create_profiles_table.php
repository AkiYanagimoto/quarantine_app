<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->integer('country_id')->nullable();
            $table->string('prefecture')->nullable();
            $table->char('postal_code', 7)->nullable();
            $table->double('origin_lat', 10, 7)->nullable();
            $table->double('origin_lng', 11, 7)->nullable();
            $table->char('cohabitant', 3)->nullable();
            $table->char('contact_weekday', 3)->nullable();
            $table->char('contact_weekend', 3)->nullable();
            $table->boolean('delete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
