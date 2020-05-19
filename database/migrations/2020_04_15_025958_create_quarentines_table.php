<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuarentinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quarentines', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->double('dis_0to3', 5, 3)->nullable();
            $table->double('dis_4to6', 5, 3)->nullable();
            $table->double('dis_7to9', 5, 3)->nullable();
            $table->double('dis_10to12', 5, 3)->nullable();
            $table->double('dis_13to15', 5, 3)->nullable();
            $table->double('dis_16to18', 5, 3)->nullable();
            $table->double('dis_19to21', 5, 3)->nullable();
            $table->double('dis_22to24', 5, 3)->nullable();
            $table->char('total_contact', 3);
            $table->boolean('quarentine')->default(0); // failed=0, success=1
            $table->text('obs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quarentines');
    }
}
