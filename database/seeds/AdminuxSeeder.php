<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

// php artisan db:seed --class=AdminuxSeeder
class AdminuxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('software')->insertOrIgnore([
            [ 'id' => 1, 'software' => 'Custom' ],
            [ 'id' => 2, 'software' => 'Website' ],
            [ 'id' => 3, 'software' => 'Mailer' ],
        ]);

        DB::table('services')->insertOrIgnore([
            [ 'id' => 1, 'partner_id' => 1, 'software_id' => 1, 'service' => 'Custom', 'currency_id' => 1, 'price' => 0, 'interval' => 'onetime' ],
            [ 'id' => 2, 'partner_id' => 1, 'software_id' => 2, 'service' => 'Website', 'currency_id' => 1, 'price' => 3, 'interval' => 'monthly' ],
            [ 'id' => 3, 'partner_id' => 1, 'software_id' => 3, 'service' => 'Mailer', 'currency_id' => 1, 'price' => 0.005, 'interval' => 'perunit' ],
        ]);

        DB::table('services_plans')->insertOrIgnore([
            [ 'id' => 1, 'service_id' => 1, 'plan' => 'Support Basic', 'currency_id' => 1, 'price' => 1, 'interval' => 'onetime' ],
            [ 'id' => 2, 'service_id' => 2, 'plan' => 'Website Basic', 'currency_id' => 1, 'price' => 5, 'interval' => 'monthly' ],
            [ 'id' => 3, 'service_id' => 3, 'plan' => 'Mailer Basic', 'currency_id' => 1, 'price' => 5, 'interval' => 'monthly' ],
        ]);

        $account = DB::table('accounts')->insertGetId([
            'partner_id' => 1,
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'account' => $faker->name,
        ]);

        $product = DB::table('accounts_products')->insertGetId([ 'account_id' => $account, 'plan_id' => 2, 'active' => 'Y' ]);
        DB::table('billing_usage')->insertGetId([ 'product_id' => $product, 'date_start' => $faker->dateTimeBetween('-12 months', 'now'), 'date_end' => now() ]);

        $product = DB::table('accounts_products')->insertGetId([ 'account_id' => $account, 'plan_id' => 3, 'active' => 'Y' ]);
        DB::table('billing_units')->insertGetId([ 'product_id' => $product, 'units' => mt_rand(1, 10000), 'date' => date('Y-m-01', strtotime('-'.mt_rand(0, 12).' months')) ]);
    }
}
