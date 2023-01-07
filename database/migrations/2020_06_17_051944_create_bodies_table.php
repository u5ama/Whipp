<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->unsignedBigInteger('body_order');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_type_id')
                ->references('id')
                ->on('vehicle_types')
                ->onDelete('cascade');

        });


        Schema::create('body_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('body_id');
            $table->string('name');
            $table->string('locale', 5)->index();
            $table->unique(['body_id', 'locale']);
            $table->timestamps();

            $table->foreign('body_id')
                ->references('id')
                ->on('bodies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bodies');
        Schema::dropIfExists('body_translations');
    }
}
