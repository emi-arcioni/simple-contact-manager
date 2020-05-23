<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class HomeController extends Controller
{
    public function index(Request $request) {
        $view_data = [
            'api_key' => Setting::privateApiKey()
        ];
        return view('home', $view_data);
    }
}
