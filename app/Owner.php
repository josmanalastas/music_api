<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Owner extends Model
{
    protected $hidden = array('created_at', 'updated_at');

    public function cd()
    {
        return $this->hasOne('App\Cd');
    }

    public function getOwnerID($ownerName)
    {
        //check if the record exist, if not create a new one
        $data =  DB::table('owners')->where('name', $ownerName)->first();
        if ($data) {
            return $data->id;
        } else {
            $id = DB::table('owners')->insertGetId([
                'name' => $ownerName,
                'created_at' => Carbon::now()
            ]);
            return $id;
        }
    }
}
