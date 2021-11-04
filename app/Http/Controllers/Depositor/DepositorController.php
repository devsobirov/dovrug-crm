<?php

namespace App\Http\Controllers\Depositor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositorController extends Controller
{
    public function index()
    {
        return view('crm.director.dashboard');
    }
}
