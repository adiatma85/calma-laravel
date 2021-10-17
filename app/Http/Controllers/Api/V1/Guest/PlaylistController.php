<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\Playlist;
use App\Http\Controllers\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;


class PlaylistController
{

    use ResponseTrait;

    private $userRoles = [2];

    // GET
    public function index()
    {
        $playlists = Playlist::with(['topic', 'playlistMusicItems'])->get();
        $playlists->makeHidden('description');
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", compact('playlists'));
    }

    // GET
    public function indexWithRandom()
    {
        $playlists = Playlist::with(['topic', 'playlistMusicItems'])->limit(10)->inRandomOrder();
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", compact('playlists'));
    }

    // GET
    public function show($playListId)
    {
        $playlist = Playlist::with(['topic', 'playlistMusicItems'])->firstWhere('id', $playListId);
        if (!$playlist) {
            return $this->notFoundFailResponse();
        }
        $playlist->makeHidden('description');
        return $this->response(true, Response::HTTP_OK, "Success fetching particular resource", compact('playlist'));
    }
}
