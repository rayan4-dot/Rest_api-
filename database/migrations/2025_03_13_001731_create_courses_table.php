<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->text('description'); 
            $table->integer('duration'); 
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced']); 
            $table->unsignedBigInteger('category_id')->references('id')->on('categories')->onDelete('cascade'); 
            $table->unsignedBigInteger('subcategory_id')->nullable()->references('id')->on('categories')->onDelete('cascade'); 
            $table->enum('status', ['open', 'in_progress', 'completed'])->default('open'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
