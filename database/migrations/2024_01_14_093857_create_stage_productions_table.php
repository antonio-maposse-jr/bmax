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
            $table->unsignedBigInteger('process_id');
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->softDeletes();
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
