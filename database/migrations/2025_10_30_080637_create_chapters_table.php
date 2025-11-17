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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->text('content')->nullable();
            $table->integer('order')->default(0);
            $table->string('status')->default('active');
            $table->dateTime('published_at')->nullable();
            $table->string('thumbnail')->nullable();
            $table->float('duration')->nullable(); // duration in minutes
            $table->timestamp('available_from')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapters');
    }
};
