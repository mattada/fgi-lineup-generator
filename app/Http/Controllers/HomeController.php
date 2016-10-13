<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experts = Content::article()->expertColumns()->notFeatured()->orderBy('created_at', 'DESC')->limit(6)->get();
        $strategies = Content::article()->strategyColumns()->notFeatured()->orderBy('id', 'DESC')->limit(3)->get();
        $preview = Content::article()->previewArticle()->orderBy('id', 'DESC')->first();
        $featured = Content::article()->featuredVideo()->orderBy('id', 'DESC')->first();
        $fantasy = Content::article()->fantasyFocus()->orderBy('id', 'DESC')->first();
        $featuredStrategy = Content::article()->strategyColumns()->featured()->orderBy('id', 'DESC')->first();
        $breakingNews = Content::breakingNews()->orderBy('updated_at', 'DESC')->limit(5)->get();

        return view('homepage')
            ->with('experts', $experts)
            ->with('strategies', $strategies)
            ->with('preview', $preview)
            ->with('featured', $featured)
            ->with('fantasy', $fantasy)
            ->with('featuredStrategy', $featuredStrategy)
            ->with('breakingNews', $breakingNews);
    }
}
