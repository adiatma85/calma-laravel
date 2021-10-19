<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\MusicItem;
use App\Http\Controllers\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;


class MusicController
{

    use ResponseTrait;


    // GET
    public function getIndexFromPlaylistId($playlistId)
    {
        $musics = MusicItem::where('playlist_id', $playlistId);
        if (!$musics->exists()) {
            return $this->notFoundFailResponse();
        }
        return $this->response(true, Response::HTTP_OK, "Success fetching particular resource", ["musics" => $musics->get()]);
    }

    // GET
    public function show($musicId)
    {
        $music = MusicItem::with(['playlist'])->firstWhere('id', $musicId);
        if (!$music) {
            return $this->notFoundFailResponse();
        }
        return $this->response(true, Response::HTTP_OK, "Success fetching particular resource", ["music" => $music->get()]);
    }

    // GET from searchBar
    public function getFromSearchBar($searchString)
    {
        $musics = MusicItem::where('name', 'like', "%$searchString%")->get();

        return $this->response(true, Response::HTTP_OK, 'Success fetching resources', compact('musics'));
    }
}
