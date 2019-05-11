<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateAdminux extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_roles', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('role', 100)->default('')->unique();
            $table->timestamps();
        });
        DB::table('admins_roles')->insert([
            'role'       => 'Administrator',
            'created_at' => Carbon::now()
        ]);


        Schema::create('admins', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->smallInteger('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('admins_roles');
            $table->string('email', 75)->default('')->unique();
            $table->string('password')->default('');
            $table->string('firstname', 75)->default('');
            $table->string('lastname', 75)->default('');
            $table->enum('superuser', ['N', 'Y'])->default('N');
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->rememberToken();
            $table->string('last_login_ip', 75)->default('');
            $table->timestamp('last_login_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('admins')->insert([
            'email'      => 'admin@localhost',
            'password'   => '$2y$10$JhK7HP96YDXBQ3Twcr5EBe4ePGtPcA3OZbd5Ef9LTpmOfWSpy9H..', // test
            'role_id'    => 1,
            'superuser'  => 'Y',
            'active'     => 'Y',
            'created_at' => Carbon::now() // DB::raw('now()')
        ]);


        Schema::create('partners', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 100)->default('')->unique();
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('partners')->insert([
            'name'       => 'General',
            'active'     => 'Y',
            'created_at' => Carbon::now()
        ]);


        Schema::create('admin_partner', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->mediumInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('partners')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('created_at')->nullable();
            $table->unique(['admin_id', 'partner_id'], 'admin_partner');
        });
        DB::table('admin_partner')->insert([
            'admin_id'   => 1,
            'partner_id' => 1,
            'created_at' => Carbon::now()
        ]);


        Schema::create('products', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('product', 100)->default('')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
        Schema::dropIfExists('admins_roles');
        Schema::dropIfExists('admin_partner');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('products');
    }
}
