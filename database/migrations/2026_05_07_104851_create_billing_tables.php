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
        Schema::create('tbl_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name_plan', 40);
            $table->unsignedInteger('id_bw');
            $table->string('price', 40);
            $table->string('price_old', 40)->default('');
            $table->enum('type', ['Hotspot', 'PPPOE', 'Balance', 'VPN']);
            $table->enum('typebp', ['Unlimited', 'Limited'])->nullable();
            $table->enum('limit_type', ['Time_Limit', 'Data_Limit', 'Both_Limit'])->nullable();
            $table->unsignedInteger('time_limit')->nullable();
            $table->enum('time_unit', ['Mins', 'Hrs'])->nullable();
            $table->unsignedInteger('data_limit')->nullable();
            $table->enum('data_unit', ['MB', 'GB'])->nullable();
            $table->integer('validity');
            $table->enum('validity_unit', ['Mins', 'Hrs', 'Days', 'Months', 'Period']);
            $table->integer('shared_users')->nullable();
            $table->string('routers', 32)->default('');
            $table->boolean('is_radius')->default(false);
            $table->string('pool', 40)->nullable();
            $table->integer('plan_expired')->default(0);
            $table->unsignedTinyInteger('expired_date')->default(20);
            $table->boolean('enabled')->default(true);
            $table->enum('prepaid', ['yes', 'no'])->default('yes');
            $table->enum('plan_type', ['Business', 'Personal'])->default('Personal');
            $table->string('device', 32)->default('');
            $table->text('on_login')->nullable();
            $table->text('on_logout')->nullable();
            $table->index(['type', 'enabled', 'is_radius']);
            $table->index('routers');
        });

        Schema::create('tbl_user_recharges', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->string('username', 32);
            $table->unsignedInteger('plan_id');
            $table->string('namebp', 40);
            $table->date('recharged_on');
            $table->time('recharged_time')->default('00:00:00');
            $table->date('expiration');
            $table->time('time');
            $table->string('status', 20);
            $table->string('method', 128)->default('');
            $table->string('routers', 32);
            $table->string('type', 15);
            $table->integer('admin_id')->default(1);
            $table->index(['customer_id', 'status']);
            $table->index(['username', 'status']);
            $table->index(['plan_id', 'status']);
            $table->index('expiration');
        });

        Schema::create('tbl_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice', 25);
            $table->string('username', 32);
            $table->integer('user_id')->default(0);
            $table->string('plan_name', 40);
            $table->string('price', 40);
            $table->date('recharged_on');
            $table->time('recharged_time')->default('00:00:00');
            $table->date('expiration');
            $table->time('time');
            $table->string('method', 128);
            $table->string('routers', 32);
            $table->enum('type', ['Hotspot', 'PPPOE', 'Balance', 'VPN']);
            $table->string('note', 256)->default('');
            $table->integer('admin_id')->default(1);
            $table->index('invoice');
            $table->index('username');
            $table->index('recharged_on');
        });

        Schema::create('tbl_voucher', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Hotspot', 'PPPOE']);
            $table->string('routers', 32);
            $table->unsignedInteger('id_plan');
            $table->string('code', 55)->unique();
            $table->string('user', 45);
            $table->string('status', 25);
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('used_date')->nullable();
            $table->integer('generated_by')->default(0);
            $table->index(['id_plan', 'status']);
        });

        Schema::create('tbl_payment_gateway', function (Blueprint $table) {
            $table->id();
            $table->string('username', 32);
            $table->integer('user_id')->default(0);
            $table->string('gateway', 32);
            $table->string('gateway_trx_id', 512)->default('');
            $table->unsignedInteger('plan_id');
            $table->string('plan_name', 40);
            $table->integer('routers_id');
            $table->string('routers', 32);
            $table->string('price', 40);
            $table->string('pg_url_payment', 512)->default('');
            $table->string('payment_method', 32)->default('');
            $table->string('payment_channel', 32)->default('');
            $table->text('pg_request')->nullable();
            $table->text('pg_paid_response')->nullable();
            $table->dateTime('expired_date')->nullable();
            $table->dateTime('created_date');
            $table->dateTime('paid_date')->nullable();
            $table->string('trx_invoice', 25)->default('');
            $table->unsignedTinyInteger('status')->default(1);
            $table->index(['username', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('gateway_trx_id');
        });

        Schema::create('tbl_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->enum('type', ['fixed', 'percent']);
            $table->decimal('value', 10, 2);
            $table->text('description');
            $table->integer('max_usage')->default(1);
            $table->integer('usage_count')->default(0);
            $table->enum('status', ['active', 'inactive']);
            $table->decimal('min_order_amount', 10, 2);
            $table->decimal('max_discount_amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index(['status', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_coupons');
        Schema::dropIfExists('tbl_payment_gateway');
        Schema::dropIfExists('tbl_voucher');
        Schema::dropIfExists('tbl_transactions');
        Schema::dropIfExists('tbl_user_recharges');
        Schema::dropIfExists('tbl_plans');
    }
};
