<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {

        $project = Project::all();
        return response()->json([
            'status' => 'success',
            'results' => $project]);
    }
}
