<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Tecnology;
use App\Models\Type;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::with('type','tecnologies')->paginate(10);
        return response()->json($projects);
    }

    public function getType(){
        // predisposto per esercizio domani
        $types = Type::all();
        return response()->json($types);
    }

    public function getTecn(){
        // predisposto per esercizio domani
        $tecnologies = Tecnology::all();
        return response()->json($tecnologies);
    }

    public function getProjectBySlug($slug){
        $project = Project::where('slug', $slug)->with('type','tecnologies','user')->first();
        if($project){
            $success = true;

            if($project->image){
                $project->image = asset('storage/' . $project->image);
            }else{
                $project->image = asset('storage.uploads/noimg.jpg');
                $project->image_original_name = 'no img';

            }

        }else{
            $success = false;
        }

        return response()->json(compact('success', 'project'));

    }
}
