<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    $user = factory(App\User::class)->make();

    return [
        'user_id' => $user->id,
        'external_id' => $faker->asciify('******'),
        'first_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber
    ];
});
