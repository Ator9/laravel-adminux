<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 100)->default('')->unique();
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->enum('deleted', ['N', 'Y'])->default('N');
            $table->softDeletes();
            $table->timestamps();
        });

        // Insert:
        DB::table('partners')->insert([
            'name'       => 'General',
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
        Schema::dropIfExists('partners');
    }
}
