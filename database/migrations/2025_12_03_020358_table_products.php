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
        Schema::create("product", function (Blueprint $table) {
            $table->id("product_id");
            $table->string("product_name");
            $table->foreignId("discount_id")->nullable()->constrained("discount","discount_id" ,indexName:"product_discount");
            $table->integer("product_price");
            $table->enum("product_category", ["Coffe","Snack", "Signature"]);
            $table->string("product_size");
            $table->integer("product_stock");
            $table->text("product_description");
            $table->string("product_img")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
