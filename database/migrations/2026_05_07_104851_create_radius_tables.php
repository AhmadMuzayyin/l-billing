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
        Schema::create('rad_acct', function (Blueprint $table) {
            $table->id();
            $table->string('acctsessionid', 64)->default('');
            $table->string('username', 64)->default('');
            $table->string('realm', 128)->default('');
            $table->string('nasid', 32)->default('');
            $table->string('nasipaddress', 15)->default('');
            $table->string('nasportid', 32)->nullable();
            $table->string('nasporttype', 32)->nullable();
            $table->string('framedipaddress', 15)->default('');
            $table->unsignedBigInteger('acctsessiontime')->default(0);
            $table->unsignedBigInteger('acctinputoctets')->default(0);
            $table->unsignedBigInteger('acctoutputoctets')->default(0);
            $table->string('acctstatustype', 32)->nullable();
            $table->string('macaddr', 50);
            $table->timestamp('dateAdded')->useCurrent();
            $table->index('username');
            $table->index('framedipaddress');
            $table->index('acctsessionid');
            $table->index('nasipaddress');
        });

        Schema::create('nas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nasname', 128);
            $table->string('shortname', 32)->nullable();
            $table->string('type', 30)->default('other');
            $table->integer('ports')->nullable();
            $table->string('secret', 60)->default('secret');
            $table->string('server', 64)->nullable();
            $table->string('community', 50)->nullable();
            $table->string('description', 200)->default('RADIUS Client');
            $table->string('routers', 32)->default('');
            $table->index('nasname');
        });

        Schema::create('radacct', function (Blueprint $table) {
            $table->bigIncrements('radacctid');
            $table->string('acctsessionid', 64)->default('');
            $table->string('acctuniqueid', 32)->default('')->unique();
            $table->string('username', 64)->default('');
            $table->string('realm', 64)->default('')->nullable();
            $table->string('nasipaddress', 15)->default('');
            $table->string('nasportid', 32)->nullable();
            $table->string('nasporttype', 32)->nullable();
            $table->dateTime('acctstarttime')->nullable();
            $table->dateTime('acctupdatetime')->nullable();
            $table->dateTime('acctstoptime')->nullable();
            $table->integer('acctinterval')->nullable();
            $table->unsignedInteger('acctsessiontime')->nullable();
            $table->string('acctauthentic', 32)->nullable();
            $table->string('connectinfo_start', 128)->nullable();
            $table->string('connectinfo_stop', 128)->nullable();
            $table->bigInteger('acctinputoctets')->nullable();
            $table->bigInteger('acctoutputoctets')->nullable();
            $table->string('calledstationid', 50)->default('');
            $table->string('callingstationid', 50)->default('');
            $table->string('acctterminatecause', 32)->default('');
            $table->string('servicetype', 32)->nullable();
            $table->string('framedprotocol', 32)->nullable();
            $table->string('framedipaddress', 15)->default('');
            $table->string('framedipv6address', 45)->default('');
            $table->string('framedipv6prefix', 45)->default('');
            $table->string('framedinterfaceid', 44)->default('');
            $table->string('delegatedipv6prefix', 45)->default('');
            $table->string('class', 64)->nullable();
            $table->index('username');
            $table->index('framedipaddress');
            $table->index('acctsessionid');
            $table->index('nasipaddress');
            $table->index('class');
        });

        Schema::create('radcheck', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 64)->default('');
            $table->string('attribute', 64)->default('');
            $table->char('op', 2)->default('==');
            $table->string('value', 253)->default('');
            $table->index('username');
        });

        Schema::create('radgroupcheck', function (Blueprint $table) {
            $table->increments('id');
            $table->string('groupname', 64)->default('');
            $table->string('attribute', 64)->default('');
            $table->char('op', 2)->default('==');
            $table->string('value', 253)->default('');
            $table->index('groupname');
        });

        Schema::create('radgroupreply', function (Blueprint $table) {
            $table->increments('id');
            $table->string('groupname', 64)->default('');
            $table->string('attribute', 64)->default('');
            $table->char('op', 2)->default('=');
            $table->string('value', 253)->default('');
            $table->integer('plan_id')->default(0);
            $table->index('groupname');
        });

        Schema::create('radpostauth', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 64)->default('');
            $table->string('pass', 64)->default('');
            $table->string('reply', 32)->default('');
            $table->timestamp('authdate')->useCurrent()->useCurrentOnUpdate();
            $table->string('class', 64)->nullable();
            $table->index('username');
            $table->index('class');
        });

        Schema::create('radreply', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 64)->default('');
            $table->string('attribute', 64)->default('');
            $table->char('op', 2)->default('=');
            $table->string('value', 253)->default('');
            $table->index('username');
        });

        Schema::create('radusergroup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 64)->default('');
            $table->string('groupname', 64)->default('');
            $table->integer('priority')->default(1);
            $table->index('username');
        });

        Schema::create('nasreload', function (Blueprint $table) {
            $table->string('nasipaddress', 15)->primary();
            $table->dateTime('reloadtime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasreload');
        Schema::dropIfExists('radusergroup');
        Schema::dropIfExists('radreply');
        Schema::dropIfExists('radpostauth');
        Schema::dropIfExists('radgroupreply');
        Schema::dropIfExists('radgroupcheck');
        Schema::dropIfExists('radcheck');
        Schema::dropIfExists('radacct');
        Schema::dropIfExists('nas');
        Schema::dropIfExists('rad_acct');
    }
};
