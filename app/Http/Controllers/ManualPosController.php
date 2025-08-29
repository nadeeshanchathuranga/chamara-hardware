<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CompanyInfo;

class ManualPosController extends Controller
{
    public function index()
{
    $companyInfo = CompanyInfo::first();
    $loggedInUser = auth()->user();

    return Inertia::render('ManualPos/Index', [
        'companyInfo' => $companyInfo,
        'loggedInUser' => $loggedInUser
    ]);
}
}
