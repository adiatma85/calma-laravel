<?php

namespace App\Http\Controllers\Api\V1\Guest;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Http\Controllers\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class PlaylistController
{

    use ResponseTrait;

    private $userRoles = [2];

    // GET
    public function index()
    {
        $playlists = Playlist::with(['topic'])->get();
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", compact('playlists'));
    }

    // GET
    public function indexWithRandom()
    {
        $playlists = Playlist::with(['topic'])->inRandomOrder()->limit(10)->get();
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", compact('playlists'));
    }

    // GET
    public function show($playListId)
    {
        $playlist = Playlist::with(['topic'])->firstWhere('id', $playListId);
        if (!$playlist) {
            return $this->response(false, Response::HTTP_NOT_FOUND, "Particular resource does not exists", null);
        }
        return $this->response(true, Response::HTTP_OK, "Success fetching particular resource", compact('playlist'));
    }
}