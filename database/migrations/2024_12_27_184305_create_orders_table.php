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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('seller_id')->nullable()->default(1);
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->string('address');
            $table->string('phone');
            $table->string('status')->default('pending'); // pending, accepted, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
    public function seller()
{
    return $this->belongsTo(Seller::class);
}

};
