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
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->string('photo');
        $table->text('description')->nullable();
        $table->boolean('status')->default(true);
        $table->timestamp('createdDate')->useCurrent();
        $table->unsignedBigInteger('product_category_id'); // Change this line
        $table->timestamps();
        
        // Remove the foreign key constraint from here
        // $table->foreign('product_category_id')->references('id')->on('product_categories');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
