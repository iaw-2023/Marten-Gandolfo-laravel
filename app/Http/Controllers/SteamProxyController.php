<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SteamProxyController extends Controller
{
    public function indexApi($page){
        $games = Http::withoutVerifying()->get('https://api.steampowered.com/ISteamApps/GetAppList/v2/')->json()['applist']['apps'];
        return response()->json(array_slice($games, $page * 85000, 85000));
    }

    public function featuredApi(){
        $response = Http::withoutVerifying()->get('https://store.steampowered.com/api/featured');
        return $response->json();

    }

    public function showApi($id){
        $response = Http::withoutVerifying()->get('https://store.steampowered.com/api/appdetails?appids=' . $id);
        return $response->json();
    }


}
