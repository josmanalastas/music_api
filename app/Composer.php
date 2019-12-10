<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Composer extends Model
{
    protected $hidden = array('created_at', 'updated_at');

    public function cd()
    {
        return $this->hasOne('App\Cd');
    }

    public function getComposerID($composerName)
    {
        //check if the record exist, if not create a new one
        $data =  DB::table('composers')->where('name', $composerName)->first();
        if ($data) {
            return $data->id;
        } else {
            $id = DB::table('composers')->insertGetId([
                'name' => $composerName,
                'created_at' => Carbon::now()
            ]);
            return $id;
        }
    }
}
