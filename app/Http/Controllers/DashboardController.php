<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Respondent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAlternatives = Alternative::get()->count();
        $totalCriterias = Criteria::get()->count();
        $totalRespondens = Respondent::get()->count();
        return view('dashboard', compact('totalAlternatives', 'totalCriterias', 'totalRespondens'));
    }
}
