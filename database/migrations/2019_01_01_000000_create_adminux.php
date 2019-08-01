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
            ['role' => 'Administrator', 'created_at' => Carbon::now()],
            ['role' => 'Account Manager', 'created_at' => Carbon::now()]
        ]);


        Schema::create('admins_languages', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->char('language', 5)->default('')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('admins_languages')->insert([
            ['language' => 'en', 'created_at' => Carbon::now()],
            ['language' => 'es', 'created_at' => Carbon::now()],
        ]);


        Schema::create('admins', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->smallInteger('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('admins_roles');
            $table->string('email', 75)->default('')->unique();
            $table->string('password')->default('');
            $table->string('firstname', 75)->default('');
            $table->string('lastname', 75)->default('');
            $table->smallInteger('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('admins_languages');
            $table->enum('superuser', ['N', 'Y'])->default('N');
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->rememberToken();
            $table->string('last_login_ip', 75)->default('');
            $table->timestamp('last_login_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('admins')->insert([
            'email'       => 'admin@localhost',
            'password'    => '$2y$10$JhK7HP96YDXBQ3Twcr5EBe4ePGtPcA3OZbd5Ef9LTpmOfWSpy9H..', // test
            'role_id'     => 1,
            'language_id' => 1,
            'superuser'   => 'Y',
            'active'      => 'Y',
            'created_at'  => Carbon::now() // DB::raw('now()')
        ]);


        Schema::create('partners', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('partner', 100)->default('')->unique();
            $table->smallInteger('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('admins_languages');
            $table->text('default_config')->nullable()->comment('json config/properties');
            $table->enum('active', ['N', 'Y'])->default('N');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('partners')->insert([
            'partner'    => 'Adminux',
            'language_id' => 1,
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


        Schema::create('admins_currencies', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->char('currency', 3)->default('')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('admins_currencies')->insert([
            ['currency' => 'USD', 'created_at' => Carbon::now()]
        ]);


        Schema::create('services', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('service', 100)->default('')->unique();
            $table->string('service_class', 255)->nullable()->comment('App\Adminux\Service\Controllers ...');
            $table->smallInteger('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('admins_currencies');
            $table->decimal('price', 9, 2)->default(0)->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('services_features', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
            $table->string('feature', 100)->default('');
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('products', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->mediumInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
            $table->string('product', 100)->default('');
            $table->string('domain', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('products_plans', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('plan', 100)->default('');
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('accounts', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->string('email', 75)->default('')->index();
            $table->string('password')->default('');
            $table->string('account', 75)->nullable();
            // $table->text('default_config')->nullable()->comment('json config/properties');
            $table->enum('active', ['N', 'Y'])->default('Y');
            $table->rememberToken();
            $table->string('last_login_ip', 75)->default('');
            $table->timestamp('last_login_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['partner_id', 'email'], 'partner_email');
            $table->unique(['partner_id', 'account'], 'partner_account');
        });


        Schema::create('accounts_plans', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->mediumInteger('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('products_plans');
            // $table->text('default_config')->nullable()->comment('json config/properties');
            $table->text('service_config')->nullable()->comment('json config/properties');
            $table->enum('active', ['N', 'Y'])->default('N');
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
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('accounts_plans');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('admins_roles');
        Schema::dropIfExists('admin_partner');

        Schema::dropIfExists('configs_currencies');
        Schema::dropIfExists('configs_languages');

        Schema::dropIfExists('partners');
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_plans');
        Schema::dropIfExists('services');
    }
}
