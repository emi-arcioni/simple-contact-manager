<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\TrackServiceInterface;

class TrackController extends Controller
{
    protected $trackService;

    public function __construct(TrackServiceInterface $trackService)
    {
        $this->trackService = $trackService;
    }

    public function index() 
    {
        if ($this->trackService->track()) {
            $view_data = [
                'message' => 'Information tracked succesfully',
                'type' => 'success'
            ];
        } else {
            $view_data = [
                'message' => 'There was a problem tracking information',
                'type' => 'danger'
            ];
        }

        return view('track', $view_data);
    }
}
