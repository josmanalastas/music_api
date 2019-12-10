<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Artist extends Model
{
    protected $hidden = array('created_at', 'updated_at');

    public function cd()
    {
        return $this->belongsTo('App\Cd');
    }

    public function getArtistID($artistName)
    {
        //check if the record exist, if not create a new one
        $data =  DB::table('artists')->where('name', $artistName)->first();
        if ($data) {
            return $data->id;
        } else {
            $id = DB::table('artists')->insertGetId([
                'name' => $artistName,
                'created_at' => Carbon::now()
            ]);
            return $id;
        }
    }
}
