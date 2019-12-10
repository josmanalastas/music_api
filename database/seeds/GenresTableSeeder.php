<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ["Rock", "RNB", "Classical", "Love Song", "Pop"];
        foreach ($genres as $genre) {
            DB::table('genres')->insert([
                'title' => $genre,
                'created_at' => Carbon::now()
            ]);
        }
    }
}

