<?php

use App\Enum\PaymentMethodEnum;
use App\Enum\StatusOrderEnum;
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
            $table->string('order_no');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('table_id')->constrained('tables')->cascadeOnDelete();

            $table->enum('payment_method', [
                PaymentMethodEnum::CASH->value,
                PaymentMethodEnum::QRIS->value,
                PaymentMethodEnum::BANKTRANSFER->value,
            ])->default(PaymentMethodEnum::CASH->value);

            $table->enum('status', [
                StatusOrderEnum::PENDING->value,
                StatusOrderEnum::PAID->value,
                StatusOrderEnum::READY->value,
                StatusOrderEnum::FAILED->value,
            ])->default(StatusOrderEnum::PENDING->value);

            $table->double('total_price');
            $table->double('discount')->nullable();
            $table->string('voucher')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unique(['order_no', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
