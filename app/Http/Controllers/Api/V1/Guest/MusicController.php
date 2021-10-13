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
        $musics = MusicItem::with(['playlist'])->where('playlist_id', $playlistId);
        if (!$musics->exists()) {
            return $this->response(false, Response::HTTP_NOT_FOUND, "Particular resource does not exists", null);
        }
        return $this->response(true, Response::HTTP_OK, "Success fetching particular resource", compact('musics'));
    }

    // GET
    public function show($musicId)
    {
        $music = MusicItem::with(['playlist'])->firstWhere('id', $musicId);
        if (!$music) {
            return $this->response(false, Response::HTTP_NOT_FOUND, "Particular resource does not exists", null);
        }
        return $this->response(true, Response::HTTP_OK, "Success fetching particular resource", compact('music'));
    }
}
