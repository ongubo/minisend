<?php

use Illuminate\Database\Seeder;
use App\models\Mail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert(
            [
                ['name' => 'Posted'],
                ['name' => 'Sent'],
                ['name' => 'Failed'],
            ]
        );

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Mail::create([
                'to' => $faker->unique()->safeEmail,
                'from' => $faker->unique()->safeEmail,
                'subject' => $faker->text($maxNbChars = 90),
                'text_content' => $faker->text($maxNbChars = 400),
                'html_content' => $faker->randomHtml(2,3) ,
                'status_id' => $faker->numberBetween($min = 1, $max = 3),
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
            ]);
        }
    }
}
