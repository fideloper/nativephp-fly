<?php

namespace App\Http\Controllers;

use App\Fly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('apps');
    }
}
