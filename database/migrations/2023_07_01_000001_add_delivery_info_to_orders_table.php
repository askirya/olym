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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('recipient_name')->nullable()->after('delivery_address');
            $table->string('recipient_phone')->nullable()->after('recipient_name');
            $table->string('recipient_email')->nullable()->after('recipient_phone');
            $table->text('delivery_comment')->nullable()->after('recipient_email');
            $table->string('payment_method')->default('cash')->after('delivery_comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'recipient_name',
                'recipient_phone',
                'recipient_email',
                'delivery_comment',
                'payment_method',
            ]);
        });
    }
}; 