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
        Schema::create('stage_productions', function (Blueprint $table) {
            $table->id();
            $table->boolean('cutting')->default(false);
            $table->boolean('edging')->default(false);
            $table->boolean('cnc_machining')->default(false);
            $table->boolean('grooving')->default(false);
            $table->boolean('hinge_boring')->default(false);
            $table->boolean('wrapping')->default(false);
            $table->boolean('sanding')->default(false);
            $table->boolean('hardware')->default(false);
            $table->string('other_documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage_productions');
    }
};
