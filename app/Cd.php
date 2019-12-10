<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cd extends Model
{
    protected $hidden = array('created_at', 'updated_at');

    public function getCDRecords()
    {
        $cds = DB::select('SELECT
                    a.id, a.album_title, a.album_catalog_no, a.release_year,
                    b.name AS artist_name, e.name AS owner, d.title AS genre, c.name AS composer
                    FROM cds AS a
                    LEFT JOIN artists AS b ON a.artist_id = b.id
                    LEFT JOIN composers AS c ON a.composer_id = c.id
                    LEFT JOIN genres AS d ON a.genre_id = d.id
                    LEFT JOIN owners AS e ON a.owner_id = e.id
                    ORDER BY a.id'
                );
        return $cds;
    }

    public function composer()
    {
        return $this->hasOne('App\Composer', 'id', 'composer_id');
    }

    public function owner()
    {
        return $this->hasOne('App\Owner', 'id', 'owner_id');
    }

    public function artist()
    {
        return $this->hasOne('App\Artist', 'id', 'artist_id');
    }

    public function genre()
    {
        return $this->hasOne('App\Genre', 'id', 'genre_id');
    }

}
