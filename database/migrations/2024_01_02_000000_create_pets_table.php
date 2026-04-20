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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('species');
            $table->string('breed');
            $table->string('age')->nullable();
            $table->string('weight')->nullable();
            $table->string('color')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('microchip')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('species');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
};
