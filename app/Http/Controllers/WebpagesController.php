<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebpagesController extends Controller
{
    public function HomePage() {
        return view('webpages/contents/HomePage');
    }

    public function AboutPage() {
        return view('webpages/contents/AboutPage');
    }
    
}
