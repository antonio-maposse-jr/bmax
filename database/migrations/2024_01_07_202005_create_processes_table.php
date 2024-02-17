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
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nr_sheets');
            $table->string('nr_panels');
            $table->double('order_value');
            $table->string('estimated_process_time');
            $table->date('date_required');
            $table->string('priority_level');
            $table->text('job_reference')->nullable();
            $table->string('order_confirmation');

            $table->string('status')->default('PENDING');
            $table->unsignedBigInteger('stage_id');
            $table->string('stage_name')->default('Cashier');

            $table->string('job_layout');
            $table->string('cutting_list');
            $table->string('quote');
            $table->string('confirmation_call_record')->nullable();
            $table->string('signed_confirmation')->nullable();
            $table->string('custom_cutting_list')->nullable();
            $table->string('other_document')->nullable();

            $table->boolean('cutting')->default(false);
            $table->boolean('edging')->default(false);
            $table->boolean('cnc_machining')->default(false);
            $table->boolean('grooving')->default(false);
            $table->boolean('hinge_boring')->default(false);
            $table->boolean('wrapping')->default(false);
            $table->boolean('sanding')->default(false);
            $table->boolean('hardware')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
