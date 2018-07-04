<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller
{
    public function getAllProjects($project_id=false){
        try{
            $project=$project_id?Project::where([])
                ->where('id',$project_id)->get() : Project::where([])

                ->get();
            if(!$project){
                return response()->json(['anyone user']);
            }
            return response()->json($project);
        }catch(\Exception $exception){
            return response()->json(['exception message'=>$exception->getMessage()],500);
        }
    }
}
