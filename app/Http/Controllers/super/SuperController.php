<?php

namespace App\Http\Controllers\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperController extends Controller
{
    public function index()
    {
        return view('super.index');
    }
}
