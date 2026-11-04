<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

class RobuxController extends Controller
{
    public function index()
    {
        $robux = require resource_path('/data/robux.php');

        return view('page/home', compact('robux'));
    }
}
