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
        Schema::create("employee", function (Blueprint $table) {
            $table->id("employee_id");
            $table->string("employee_name");
            $table->string("employee_address");
            $table->string("employee_number");
            $table->boolean("employee_gender");
            $table->string("employee_email")->unique();
            $table->string("password");
            $table->date("employee_date_born");
            $table->enum("employee_role", ["Waiter", "Barista", "Manager", "Courier", "Cashier"]);
            $table->integer("employee_salary");
            $table->date("employee_date_join");
            $table->string("employee_img");
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
