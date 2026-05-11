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
        Schema::create('tbl_appconfig', function (Blueprint $table) {
            $table->id();
            $table->mediumText('setting');
            $table->mediumText('value')->nullable();
        });

        Schema::create('tbl_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('root')->default(0);
            $table->string('photo', 128)->default('/admin.default.png');
            $table->string('username', 45)->default('')->unique();
            $table->string('fullname', 45)->default('');
            $table->string('password', 255);
            $table->string('phone', 32)->default('');
            $table->string('email', 128)->default('');
            $table->string('city', 64)->default('');
            $table->string('subdistrict', 64)->default('');
            $table->string('ward', 64)->default('');
            $table->enum('user_type', ['SuperAdmin', 'Admin', 'Report', 'Agent', 'Sales']);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->text('data')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('login_token', 40)->nullable();
            $table->dateTime('creationdate');
        });

        Schema::create('tbl_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 45)->unique();
            $table->string('password', 255);
            $table->string('photo', 128)->default('/user.default.jpg');
            $table->string('pppoe_username', 32)->default('');
            $table->string('pppoe_password', 255)->default('');
            $table->string('pppoe_ip', 32)->default('');
            $table->string('fullname', 45);
            $table->mediumText('address')->nullable();
            $table->string('city', 255)->nullable();
            $table->string('district', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('phonenumber', 20)->default('0');
            $table->string('email', 128)->default('1');
            $table->string('coordinates', 50)->default('');
            $table->enum('account_type', ['Business', 'Personal'])->default('Personal');
            $table->decimal('balance', 15, 2)->default(0);
            $table->enum('service_type', ['Hotspot', 'PPPoE', 'Others'])->default('Others');
            $table->boolean('auto_renewal')->default(true);
            $table->enum('status', ['Active', 'Banned', 'Disabled', 'Inactive', 'Limited', 'Suspended'])->default('Active');
            $table->integer('created_by')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('last_login')->nullable();
            $table->index(['status', 'service_type']);
            $table->index('created_by');
        });

        Schema::create('tbl_customers_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->string('field_name', 255);
            $table->string('field_value', 255);
            $table->index('customer_id');
            $table->index(['customer_id', 'field_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_customers_fields');
        Schema::dropIfExists('tbl_customers');
        Schema::dropIfExists('tbl_users');
        Schema::dropIfExists('tbl_appconfig');
    }
};
