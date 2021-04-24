<?php

namespace App\Http\Controllers;

use App\Models\Bots;
use App\Models\Packs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Search extends Controller
{

    public function bots(Request $request, string $botName = null): object
    {
        DB::enableQueryLog();
        if (empty($botName)) {
            return view('bots', ['bots' => Bots::whereStatusId(1)->withCount('packs')->get()]);
        } else {

            $bot = Bots::whereName($botName)->withCount('packs')->first();

            if ($request->query('search')) {
                $packs = Packs::sortable(['number' => 'asc'])
                    ->whereBotId($bot->id)
                    ->where('name', 'like', '%' . $request->query('search') . '%')
                    ->paginate(50)
                    ->withQueryString();
            } else {
                $packs = Packs::sortable(['number' => 'asc'])
                    ->whereBotId($bot->id)
                    ->paginate(100)
                    ->withQueryString();
            }

            return view('bot', [
                'bot' => $bot,
                'packs' => $packs,
                'search' => $request->query('search')
            ]);
        }
    }

    public function search(Request $request): object
    {
        return view('search');
    }

}
