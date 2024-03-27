<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Alternative;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::get();
        return view('perangkingan.index', compact('alternatives'));
    }

    public function perhitungan()
    {
        $alternatives = Alternative::get();
        $criterias = Criteria::all();
        return view('perangkingan.perhitungan', compact('criterias', 'alternatives'));
    }
}
