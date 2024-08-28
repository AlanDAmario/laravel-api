<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {

        //$project = Project::all();

        //PER IMPAGINAZIONE
        $project = Project::with('user', 'type', 'technologies')->paginate(3);
        return response()->json([
            'status' => 'success',
            'results' => $project]);
    }
}
