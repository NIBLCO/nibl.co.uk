<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Packs;
use Illuminate\Http\Request;

class Pages extends Controller
{
    public function index(Request $request)
    {
        $news = News::first();
        $packs = Packs::orderBy('last_modified', 'desc')->limit(20)->with('bot')->get();
        return view('index', ['news' => $news, 'packs' => $packs]);
    }

    public function about(Request $request)
    {
        return view('about');
    }

    public function faq(Request $request)
    {
        return view('faq');
    }

}
