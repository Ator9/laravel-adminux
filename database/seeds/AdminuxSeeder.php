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

        DB::table('software')->insert([
            [ 'software' => 'Custom' ],
            [ 'software' => 'Website' ],
            [ 'software' => 'Mailer' ],
        ]);

        DB::table('accounts')->insert([
            'partner_id' => 1,
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'account' => $faker->name,
        ]);
    }
}
