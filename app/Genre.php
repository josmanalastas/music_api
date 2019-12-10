<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Genre extends Model
{
    protected $hidden = array('created_at', 'updated_at');

    public function cd()
    {
        return $this->hasOne('App\Cd');
    }

    public function getGenreID($genreName)
    {
        //check if the record exist, if not create a new one
        $data =  DB::table('genres')->where('title', $genreName)->first();
        if ($data) {
            return $data->id;
        } else {
            $id = DB::table('genres')->insertGetId([
                'title' => $genreName,
                'created_at' => Carbon::now()
            ]);
            return $id;
        }
    }
}
