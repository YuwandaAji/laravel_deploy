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
        Schema::create("presence", function (Blueprint $table) {
            $table->id("presence_id");
            $table->foreignId("employee_id")->constrained("employee", "employee_id",indexName:"presence_employee");
            $table->enum("status_presence", ["Present", "Absent", "Sick", "Permission"]);
            $table->date("presence_date");
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
