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
        Schema::create("sales", function (Blueprint $table) {
            $table->id("sales_id");
            $table->foreignId("customer_id")->constrained("customer", "customer_id",indexName:"sales_customer");
            $table->foreignId("payment_id")->constrained("payment","payment_id",indexName:"slaes_payment");
            $table->enum("sales_status", ["New", "Prepared", "Delivery", "Done"]);
            $table->boolean("pay_status");
            $table->boolean("order_method");
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
