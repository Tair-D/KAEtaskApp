<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(){
        try
        {
           // $user_id=Auth::user()->id;
            $task = Task::where('user_id', Auth::user()->id)->get();
            return response()->json($task);
        }
        catch (\Excertion $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

//    public function getDescription($taskId){
//        try{
//           // $user_id=Auth::user()->id;
//
//            $task=Task::where('id',$taskId)->first();
//
//            if (!$task) {
//                return response()->json(['message' => 'Задача не найдена'], 404);
//            }
//
//            return response()->json(['description'=>$task->description]);
//        }
//        catch (\Exception $exception){
//            return response()->json(['message' => $exception->getMessage()], 500);
//
//        }
//    }

    public function sortedTaskByStatus($statusId){
        try{
            //$userId=Auth::user()->id;
            $task=Task::where('user_id', Auth::user()->id,'status_id',$statusId)->get();
            if($task=!null){
                return response()->json([
                    'task' => $task
                ], 200);
            }
            else
            {
                return response()->json(['message' => 'no task'], 500);
            }
        }
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function getTaskByDate($date){
        try{
           // $userId=Auth::user()->id;
            $task=Task::whereDate('user_id', Auth::user()->id,'created_at',$date)->get();//
            if($task=! null){
                return response()->json([
                    'task' => $task
                ], 200);
            }else
            {
                return response()->json(['message' => 'no task'], 500);
            }
        }
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function getAllTaskForOneEmployee($task_id)
    {
        try{
            $userId=Auth::user()->id;
        $task=Task::where([
            'user_id'=>Auth::user()->id,
            'id'=>$task_id
        ])->first();

        if($task){
            return response()->json(['task'=>$task]);
        }}
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);

        }
    }

    public function insert(Request $request){
        //return response()->json(['message' => 123], 500);
        try{

        $task=new Task();
        $task->title=$request['title'];
        $task->description=$request['description'];
        $task->deadline=$request['deadline'];//$
         $task->project_id=$request['project_id'];//$
        $task->user_id=$request['user_id'];

        if($task->save()){
            $message='Задача добавлена';
        }
        else
        {
            $message='Ошибка... задача не добавлена';
        }

        return response()->json([
            'message'=>$message
        ],200);}
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function updateTask(Request $request,$task_id){
        try{

            $task=Task::where(['id'=>$task_id],['user_id'=>Auth::user()->id])->first();
            //$task=Task::where(['id'=>$task_id])->first();
            if(!$task){
                return response()->json(['message' => 'заявка не найдена'], 404);
            }
            $task->title=$request['title'];
            $task->description=$request['description'];
            $task->deadline=$request['deadline'];
            $task->project_id=$request['project_id'];
            $task->user_id=$request['user_id'];

        if($task->save()){
            $message='Задача обновлена';
        }
        else
        {
            $message='Ошибка... задача не обновлена';
        }

        return response()->json([
            'message'=>$message
        ],200);}
        catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    public function deleteTask($id){
        try
        {
            $task=Task::where('id',$id)->get();
            $task->status_id=0;

            if($task->save()){
                $message='статус задачи 0';
            }
            else
            {
                $message='Ошибка... задача не удалена';
            }
            return response()->json([
                'message'=>$message
            ],200);
        }
        catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }


    }

    public function doTask(){
        try{
          //  $task=Task::where('id',$id)->first();
            $task = Task::where('user_id', Auth::user()->id)->get();
            $task->status_id=3;

            if($task->save()){
                $message='статус задачи выполнен';
            }
            else
            {
                $message='Ошибка... ';
            }
            return response()->json([
                'message'=>$message
            ],200);
        }
        catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);

        }
    }


}
