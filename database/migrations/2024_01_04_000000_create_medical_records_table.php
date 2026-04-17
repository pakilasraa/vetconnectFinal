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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['checkup', 'vaccination', 'surgery', 'lab-results', 'prescription', 'dental']);
            $table->string('title');
            $table->text('description');
            $table->date('record_date');
            $table->string('doctor');
            $table->integer('attachments_count')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('pet_id');
            $table->index('type');
            $table->index('record_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
};
