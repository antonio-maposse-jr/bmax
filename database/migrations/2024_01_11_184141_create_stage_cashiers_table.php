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
        Schema::create('stage_cashiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('process_id');
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('invoice_reference');
            $table->double('invoice_amount');
            $table->text('variance_explanation')->nullable();
            $table->string('reciept_reference')->nullable();
            $table->double('total_amount_paid')->nullable();
            $table->string('invoice_status');
            $table->string('balance_to_be_paid')->nullable();
            $table->text('special_instructions')->nullable();
            $table->boolean('special_authorization')->default(false);
        

            $table->string('invoice');
            $table->string('receipt')->nullable();
            $table->string('other')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage_cashiers');
    }
};
