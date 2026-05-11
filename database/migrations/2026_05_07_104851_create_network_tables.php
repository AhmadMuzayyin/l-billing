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
        Schema::create('tbl_bandwidth', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_bw', 255);
            $table->unsignedInteger('rate_down');
            $table->enum('rate_down_unit', ['Kbps', 'Mbps']);
            $table->unsignedInteger('rate_up');
            $table->enum('rate_up_unit', ['Kbps', 'Mbps']);
            $table->string('burst', 128)->default('');
        });

        Schema::create('tbl_routers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32)->unique();
            $table->string('ip_address', 128);
            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('description', 256)->nullable();
            $table->string('coordinates', 50)->default('');
            $table->enum('status', ['Online', 'Offline'])->default('Online');
            $table->dateTime('last_seen')->nullable();
            $table->string('coverage', 8)->default('0');
            $table->boolean('enabled')->default(true);
            $table->index('enabled');
        });

        Schema::create('tbl_pool', function (Blueprint $table) {
            $table->id();
            $table->string('pool_name', 40);
            $table->string('local_ip', 40)->default('');
            $table->string('range_ip', 40);
            $table->string('routers', 40);
            $table->index('routers');
        });

        Schema::create('tbl_port_pool', function (Blueprint $table) {
            $table->id();
            $table->string('public_ip', 40);
            $table->string('port_name', 40);
            $table->string('range_port', 40);
            $table->string('routers', 40);
            $table->index('routers');
        });

        Schema::create('tbl_odps', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->integer('port_amount');
            $table->decimal('attenuation', 15, 2)->default(0);
            $table->mediumText('address');
            $table->string('coordinates', 50)->default('');
            $table->integer('coverage')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_odps');
        Schema::dropIfExists('tbl_port_pool');
        Schema::dropIfExists('tbl_pool');
        Schema::dropIfExists('tbl_routers');
        Schema::dropIfExists('tbl_bandwidth');
    }
};
