<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UpdateCDRequest;
use App\Http\Requests\CreateCDRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Cd;
use App\Artist;
use App\Composer;
use App\Owner;
use App\Genre;

/**
 * Class for Music Controller.
 *
 * @since 1.0
 *
 * @version 1.0.0
 */
class MusicController extends Controller
{
    private $headers;

    public function __construct()
    {
        $this->headers = ['Content-type'=>'application/json; charset=utf-8'];
    }
    /**
     * Get getCDs
     *
     * @since 1.0
     *
     * @version 1.0.0
     *
     * @return json string
     */
    public function getCDs(Request $request)
    {
        $response = [];
        //$cds = Cd::with('artist', 'composer', 'genre', 'owner')->get();
        //get cds
        $cds = new Cd;
        $data = $cds->getCDRecords();
        $dataCount = count($data);
        $response = ["status" => "ok", "count" => $dataCount, "records" => $data];
        return response()->json($response, Response::HTTP_OK, $this->headers);
    }

    /**
     * Get CD
     *
     * @since 1.0
     *
     * @version 1.0.0
     *
     * @return json string
     */
    public function getCD(Request $request, $id)
    {
        $request['id'] = $id;
        $this->validate($request , ['id' => 'numeric']);

        $responseStatus = 0;
        $data = Cd::find($id, ['id', 'album_title', 'album_catalog_no', 'release_year']);

        if ($data) {
            $artist = Cd::find($id)->artist->name;
            $owner = Cd::find($id)->owner->name;
            $genre = Cd::find($id)->genre->title;
            $composerDetails = Cd::find($id)->composer;
            $composer = (isset($composerDetails->name)) ? $composerDetails->name : "";

            $data->artist_name = $artist;
            $data->owner = $owner;
            $data->genre = $genre;
            $data->composer = $composer;

            $response = ["status" => "ok", "data" => $data];
            $responseStatus = Response::HTTP_OK;
        } else {
            $response = ["status" => "Invalid resource id"];
            $responseStatus = Response::HTTP_NOT_FOUND;
            $this->setErrorHeaders();
        }
        return response()->json($response, $responseStatus, $this->headers);

    }


    /**
     * Create new cd
     *
     * @since 1.0
     *
     * @version 1.0.0
     *
     * @param App\Http\Requests\CreateCDRequest $request A Request object
     *
     * @return json string
     */
    public function createCD(CreateCDRequest $request)
    {
        $responseStatus = 0;

        $artistName = $request->get('artist_name');
        $albumTitle = $request->get('album_title');
        $albumCatalogNo = $request->get('album_catalog_no');
        $releaseYear = $request->get('release_year');
        $genre = $request->get('genre');
        $composer = $request->get('composer');
        $owner = $request->get('owner');

        $artistClass = new Artist;
        $composerClass = new Composer;
        $genreClass = new Genre;
        $ownerClass = new Owner;
        $artistID = $artistClass->getArtistID($artistName);
        $composerID = (empty($composer)) ? 0 : $composerClass->getComposerID($composer);
        $genreID = $genreClass->getGenreID($genre);
        $ownerID = $ownerClass->getOwnerID($owner);


        $cd = new Cd;
        $cd->owner_id = $ownerID;
        $cd->composer_id = $composerID;
        $cd->artist_id = $artistID;
        $cd->genre_id = $genreID;
        $cd->album_title = $albumTitle;
        $cd->album_catalog_no = $albumCatalogNo;
        $cd->release_year = $releaseYear;
        $cd->created_at = Carbon::now();

        if ($cd->save()) {
            $url = $request->url() . "/" . $cd->id;
            $response = ["status" => "ok", "url" => $url];
            $responseStatus = Response::HTTP_CREATED;
        } else {
            $response = ["status" => "An error has occurred while trying to save the records,
                                     please try again later"];
            $responseStatus = Response::HTTP_BAD_REQUEST;
            $this->setErrorHeaders();
        }
        return response()->json($response, $responseStatus, $this->headers);
    }

    /**
     * Update CD details
     *
     * @since 1.0
     *
     * @version 1.0.0
     *
     * @param App\Http\Requests\UpdateCDRequest $request A Request object
     *
     * @return json string
     */
    public function updateCD(UpdateCDRequest $request, $id)
    {
        $request['id'] = $id;
        $this->validate($request , ['id' => 'numeric']);

        $responseStatus = 0;
        $artistName = $request->get('artist_name');
        $albumTitle = $request->get('album_title');
        $albumCatalogNo = $request->get('album_catalog_no');
        $releaseYear = $request->get('release_year');
        $genre = $request->get('genre');
        $composer = $request->get('composer');
        $owner = $request->get('owner');

        $artistClass = new Artist;
        $composerClass = new Composer;
        $genreClass = new Genre;
        $ownerClass = new Owner;
        $artistID = $artistClass->getArtistID($artistName);
        $composerID = (empty($composer)) ? 0 : $composerClass->getComposerID($composer);
        $genreID = $genreClass->getGenreID($genre);
        $ownerID = $ownerClass->getOwnerID($owner);

        $cd = Cd::find($id);
        if ($cd) {
            $cd->owner_id = $ownerID;
            $cd->composer_id = $composerID;
            $cd->artist_id = $artistID;
            $cd->genre_id = $genreID;
            $cd->album_title = $albumTitle;
            $cd->album_catalog_no = $albumCatalogNo;
            $cd->release_year = $releaseYear;

            if ($cd->save()) {
                $url = $request->url();
                $response = ["status" => "ok", "url" => $url];
                $responseStatus = Response::HTTP_OK;
            } else {
                $response = ["status" => "An error has occurred while trying to save the record,
                                     please try again later"];
                $responseStatus = Response::HTTP_BAD_REQUEST;
                $this->setErrorHeaders();
            }
        } else {
            $response = ["status" => "Invalid resource id"];
            $responseStatus = Response::HTTP_NOT_FOUND;
            $this->setErrorHeaders();
        }
        return response()->json($response, $responseStatus, $this->headers);
    }

    /**
     * Delete CD
     *
     * @since 1.0
     *
     * @version 1.0.0
     *
     * @return json string
     */
    public function deleteCd(Request $request, $id)
    {
        $request['id'] = $id;
        $this->validate($request , ['id' => 'numeric']);

        $responseStatus = 0;
        $cd = Cd::find($id);
        if ($cd) {
            if ($cd->delete()) {
                $response = ["status" => "ok"];
                $responseStatus = Response::HTTP_NO_CONTENT;
            } else {
                $response = ["status" => "An error has occurred while trying to delete the record,
                                     please try again later"];
                $responseStatus = Response::HTTP_BAD_REQUEST;
                $this->setErrorHeaders();
            }
        } else {
            $response = ["status" => "Invalid resource id"];
            $responseStatus = Response::HTTP_NOT_FOUND;
            $this->setErrorHeaders();

        }
        return response()->json($response, $responseStatus, $this->headers);
    }

    private function setErrorHeaders()
    {
        $this->headers = ['Content-type'=>'application/problem+json; charset=utf-8'];
    }
}
