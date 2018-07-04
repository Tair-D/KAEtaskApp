<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Version;
class VersionController extends Controller
{
    public function getAllVersions($project_id){
        try{
            $version=Version::where('project_id',$project_id)
                ->with('status')
                ->with('tasks')
                ->orderBy('id','desc')
                ->get();

            if(!$version){
                return response()->json(['anyone user']);
            }
            return response()->json($version);
        }catch(\Exception $exception){
            return response()->json(['exception message'=>$exception->getMessage()],500);
        }
    }

    public function getTask($version_id){
        try{
            $version=Version::select('id','version_name')
            ->where('id',$version_id)

                ->orderBy('id','desc')
                ->get();

            if(!$version){
                return response()->json(['anyone user']);
            }
            return response()->json($version);
        }catch (\Exception $exception){
            return response()->json(['exception message'=>$exception->getMessage()],500);
        }
    }
}
