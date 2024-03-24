<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    public function index()
    {
        $criterias = Criteria::get();
        $criterias2 = Criteria::get();


        return view('pembobotan.index', compact('criterias', 'criterias2'));
    }
}
