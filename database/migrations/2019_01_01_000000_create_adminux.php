<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminux extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminux_admins', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('email', 75)->default('')->unique();
            $table->string('password')->default('');
            $table->string('firstname', 75)->default('');
            $table->string('lastname', 75)->default('');
            $table->enum('superuser', ['N', 'Y'])->default('N');
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->rememberToken();
            $table->string('last_login_ip',75)->default('');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
        DB::table('adminux_admins')->insert([
            'email'      => 'admin@localhost',
            'password'   => Hash::make('test'), // $2y$10$JhK7HP96YDXBQ3Twcr5EBe4ePGtPcA3OZbd5Ef9LTpmOfWSpy9H..
            'superuser'  => 'Y',
            'active'     => 'Y',
            'created_at' => DB::raw('now()'),
        ]);


        Schema::create('adminux_partners', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 100)->default('')->unique();
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('adminux_partners')->insert([
            'name'       => 'General',
            'active'     => 'Y',
            'created_at' => DB::raw('now()'),
        ]);


        Schema::create('adminux_roles', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 100)->default('')->unique();
            $table->timestamps();
        });
        DB::table('adminux_roles')->insert([
            'name'       => 'General',
            'created_at' => DB::raw('now()'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adminux_admins');
        Schema::dropIfExists('adminux_partners');
        Schema::dropIfExists('adminux_roles');
    }
}
