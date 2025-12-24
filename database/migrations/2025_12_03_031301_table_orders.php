<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Constraint\Constraint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("order", function (Blueprint $table) {
            $table->id("order_id");
            $table->foreignId("sales_id")->constrained("sales", "sales_id",indexName:"order_sales");
            $table->foreignId("product_id")->constrained("product", "product_id",indexName:"order_product");
            $table->integer("order_quantity");
            $table->unique(["sales_id", "product_id"],);
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
