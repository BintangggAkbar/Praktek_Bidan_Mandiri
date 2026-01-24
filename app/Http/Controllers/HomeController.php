<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Service;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index()
    {
        $schedules = Schedule::where('status', true)->get();
        $services = Service::where('status', true)->get();
        return view('welcome', compact('schedules', 'services'));
    }
}
