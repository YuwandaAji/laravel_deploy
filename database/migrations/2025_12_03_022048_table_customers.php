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
        Schema::create("customer", function (Blueprint $table) {
            $table->id("customer_id");
            $table->string("customer_name");
            $table->string("customer_email")->unique();
            $table->string("password");
            $table->string("customer_address")->nullable();
            $table->string("customer_number")->nullable();
            $table->date("customer_dateborn")->nullable();
            $table->string("customer_img")->nullable();
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
