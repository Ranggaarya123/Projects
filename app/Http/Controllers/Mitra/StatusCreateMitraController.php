<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\CreateMitraModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StatusCreateMitraController extends Controller
{
    public function index()
    {
        // Ambil semua data BrevetModel
        $query = CreateMitraModel::query();

        $createMitra = $query->get();

        $createMitra = $createMitra->sortByDesc('created_at');
        return view('pages/mitra/status_createmitra', ['createMitra' => $createMitra]);
    }

}
