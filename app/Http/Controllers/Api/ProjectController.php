<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Tecnology;
use App\Models\Type;
use Database\Seeders\TecnologiesTableSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

            // per far si che funzionasse ho dovuto cambiare nel file.env la voce APP_URL=http://localhost:8000 aggiungendo :8000
            if($project->image){
                $project->image = Storage::url($project->image);
            }else{
                // qui c'è bisogno di inserire anche uploads/
                $project->image = Storage::url('uploads/noimg.jpg');
                $project->image_original_name = 'no img';

            }

        }else{
            $success = false;
        }

        return response()->json(compact('success', 'project'));

    }

    public function getProjectByType($slug){
        $type = Type::where('slug', $slug)->with('projects')->first();
        return response()->json($type);
    }

    public function getProjectByTecnologies($slug){
        $tecnologies = Tecnology::where('slug', $slug)->with('projects')->first();
        return response()->json($tecnologies);

    }
}
