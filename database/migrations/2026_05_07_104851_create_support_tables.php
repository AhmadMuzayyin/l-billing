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
        Schema::create('tbl_logs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->string('type', 50);
            $table->mediumText('description');
            $table->integer('userid');
            $table->mediumText('ip');
            $table->index('date');
            $table->index('userid');
        });

        Schema::create('tbl_customers_inbox', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->dateTime('date_created');
            $table->dateTime('date_read')->nullable();
            $table->string('subject', 64);
            $table->text('body')->nullable();
            $table->string('from', 8)->default('System');
            $table->integer('admin_id')->default(0);
            $table->index(['customer_id', 'date_read']);
        });

        Schema::create('tbl_meta', function (Blueprint $table) {
            $table->id();
            $table->string('tbl', 32);
            $table->integer('tbl_id');
            $table->string('name', 32);
            $table->mediumText('value')->nullable();
            $table->index(['tbl', 'tbl_id']);
        });

        Schema::create('tbl_widgets', function (Blueprint $table) {
            $table->id();
            $table->integer('orders')->default(99);
            $table->tinyInteger('position')->default(1);
            $table->enum('user', ['Admin', 'Agent', 'Sales', 'Customer'])->default('Admin');
            $table->boolean('enabled')->default(true);
            $table->string('title', 64);
            $table->string('widget', 64)->default('');
            $table->text('content');
            $table->index(['user', 'enabled', 'orders']);
        });

        Schema::create('tbl_message_logs', function (Blueprint $table) {
            $table->id();
            $table->string('message_type', 50)->nullable();
            $table->string('recipient', 255)->nullable();
            $table->text('message_content')->nullable();
            $table->string('status', 50)->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->useCurrent();
            $table->index('sent_at');
        });

        Schema::create('tbl_message', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id')->nullable();
            $table->string('title', 255);
            $table->longText('message');
            $table->unsignedInteger('send_by');
            $table->timestamp('created_at')->useCurrent();
            $table->index('customer_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_message');
        Schema::dropIfExists('tbl_message_logs');
        Schema::dropIfExists('tbl_widgets');
        Schema::dropIfExists('tbl_meta');
        Schema::dropIfExists('tbl_customers_inbox');
        Schema::dropIfExists('tbl_logs');
    }
};
