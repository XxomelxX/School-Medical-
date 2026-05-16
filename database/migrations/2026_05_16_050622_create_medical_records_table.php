<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('medical_records', function (Blueprint $table) {

        $table->id();

        $table->foreignId('student_id')
              ->constrained()
              ->onDelete('cascade');

        $table->date('checkup_date');

        $table->string('height');
        $table->string('weight');
        $table->string('blood_pressure');

        $table->text('allergies')->nullable();
        $table->text('medical_condition')->nullable();

        $table->text('diagnosis');
        $table->text('treatment');

        $table->text('prescribed_medicine')->nullable();
        $table->text('notes')->nullable();

        $table->enum('medical_status', [
            'Healthy',
            'Under Observation',
            'Needs Attention',
            'Critical'
        ]);

        $table->string('file_attachment')->nullable();

        $table->timestamps();
    });
}
};
