<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('username', 50)->default('')->unique();
            $table->string('password', 64)->default('');
            $table->string('email', 75)->default('');
            $table->string('firstname', 75)->default('');
            $table->string('lastname', 75)->default('');
            $table->enum('superuser', ['N', 'Y'])->default('N');
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->enum('deleted', ['N', 'Y'])->default('N');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        // Insert admin:
        DB::table('admins')->insert([
            'username'  => 'admin',
            'password'  => 'test',
            'superuser' => 'Y',
            'active'    => 'Y',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
