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
        Schema::create("schedule", function (Blueprint $table) {
            $table->id("schedule_id");
            $table->boolean("shift");
            $table->enum("schedule_day", ["Monday","Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]);
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
