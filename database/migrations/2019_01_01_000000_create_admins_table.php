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
            $table->string('email', 75)->default('')->unique();
            $table->string('password')->default('');
            $table->string('firstname', 75)->default('');
            $table->string('lastname', 75)->default('');
            $table->string('remember_token', 100)->nullable();
            $table->enum('superuser', ['N', 'Y'])->default('N');
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->enum('deleted', ['N', 'Y'])->default('N');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        // Insert admins:
        DB::table('admins')->insert([
            'email'     => 'admin@localhost',
            'password'  => Hash::make('test'),
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
