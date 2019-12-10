<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owners = DB::table('owners')->pluck('id');
        $composers = DB::table('composers')->pluck('id');
        $artists = DB::table('artists')->pluck('id');
        $genres = DB::table('genres')->pluck('id');

        $faker = Faker::create();
        foreach(range(1, 30) as $index) {
            DB::table('cds')->insert([
                'owner_id' => $faker->randomElement($owners),
                'composer_id' => $faker->randomElement($composers),
                'artist_id' => $faker->randomElement($artists),
                'genre_id' => $faker->randomElement($genres),
                'album_title' => $faker->word,
                'album_catalog_no' => $faker->unique()->randomNumber(8),
                'release_year' => rand(1901, 2019),
                'created_at' => Carbon::now()
            ]);
        }
    }
}
