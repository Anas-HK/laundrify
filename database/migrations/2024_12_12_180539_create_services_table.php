<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // id column
            $table->unsignedBigInteger('seller_id'); // Foreign key for seller
            $table->string('service_name'); // Name of the service
            $table->text('service_description')->nullable(); // Description
            $table->string('seller_city'); // Seller's city
            $table->string('seller_area'); // Seller's area
            $table->string('availability'); // Service availability
            $table->string('service_delivery_time'); // Delivery time
            $table->string('seller_contact_no'); // Seller contact number
            $table->decimal('service_price', 10, 2); // Service price
            $table->string('image')->nullable(); // Path to image file
            $table->boolean('is_approved')->default(false); // Approval status
            $table->timestamps(); // created_at and updated_at

            // Define the foreign key constraint
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
