<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard'); // area amministrativa
    }

    public function welcome()
    {
        return view('admin.welcome'); // reindirizzamento della pagina dopo logi, il redirect viene getsito nella sezione ROUTESERVICEPRVIDER, sotto la voce HOME =''
    }
}
