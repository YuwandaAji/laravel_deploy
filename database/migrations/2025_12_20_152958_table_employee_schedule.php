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
        Schema::create("employee_schedule", function (Blueprint $table) {
            $table->bigIncrements("es_id");
            $table->foreignId("employee_id")->constrained("employee","employee_id" ,indexName:"employee_employee_schedule");
            $table->foreignId("schedule_id")->constrained("schedule", "schedule_id",indexName:"schedule_employee_schedule");
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
