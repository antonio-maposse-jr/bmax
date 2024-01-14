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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
   
            $table->string('id_type');
            $table->string('id_number')->unique();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('address');
            $table->string('tax_number');
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('id_document')->nullable();
            $table->string('company_reg_document')->nullable();

            $table->unsignedBigInteger('customer_category_id');
            $table->foreign('customer_category_id')->references('id')->on('customer_categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
