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
            $table->enum('superuser', ['N', 'Y'])->default('N');
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert:
        DB::table('admins')->insert([
            'email'      => 'admin@localhost',
            'password'   => Hash::make('test'), // $2y$10$JhK7HP96YDXBQ3Twcr5EBe4ePGtPcA3OZbd5Ef9LTpmOfWSpy9H..
            'superuser'  => 'Y',
            'active'     => 'Y',
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
        Schema::dropIfExists('admins');
    }
}
