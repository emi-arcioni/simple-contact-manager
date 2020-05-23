<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class HomeController extends Controller
{
    public function index(Request $request) {
        $user_settings = Setting::where('user_id', auth()->user()->id)->first();
        if (!empty($user_settings)) {
            $api_key = $user_settings->content['klaviyo_api'];
        } else {
            $api_key = '';
        }

        $view_data = [
            'api_key' => $api_key
        ];
        return view('home', $view_data);
    }
}
