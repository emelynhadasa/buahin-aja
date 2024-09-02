<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //

    public function index()
    {
        $news = News::orderBy('publish_date')->get();
        return view('user.news.index', compact('news'));
    }

    public function show(News $news)
    {
        return view('user.news.show', compact('news'));
    }
}
