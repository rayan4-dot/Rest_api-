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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');

            $table->decimal('price', 8, 2)->nullable();
            $table->boolean('is_subscription')->default(false); 

            $table->enum('status', ['open', 'in_progress', 'completed'])->default('open');
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('cascade')->unsigned(); 
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
