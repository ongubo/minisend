<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\models\Mail;

class APITest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_availability()
    {
        $response = $this->get('/api/emails');
        $response->assertStatus(200);
    }
    public function test_email_created_succesfully()
    {
        $faker = \Faker\Factory::create();
        $data=[
            'to' => $faker->unique()->safeEmail,
            'from' => $faker->unique()->safeEmail,
            'subject' => $faker->text($maxNbChars = 90),
            'text_content' => $faker->text($maxNbChars = 400),
            'html_content' => $faker->randomHtml(2,3) ,
            'status_id' => $faker->numberBetween($min = 1, $max = 3),
            'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        ];

        $this->json('POST', 'api/emails/store', $data, ['Accept' => 'application/json'])
            ->assertStatus(201);
    }
    public function test_can_show_email() {

        $faker = \Faker\Factory::create();
        $mail=new Mail();
        $mail->to=$faker->unique()->safeEmail;
        $mail->from=$faker->unique()->safeEmail;
        $mail->subject=$faker->text($maxNbChars = 90);
        $mail->text_content=$faker->text($maxNbChars = 400);
        $mail->html_content=$faker->randomHtml(2,3) ;
        $mail->status_id=$faker->numberBetween($min = 1, $max = 3);
        $mail->created_at=$faker->dateTime($max = 'now', $timezone = null);
        $mail->save()
        
;
        $this->get('api/emails/'. $mail->id)
            ->assertStatus(200);
    }

}
