<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Task;
use App\Comment;
use App\Version;
use App\User;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Database\Eloquent\Collection;
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
            $task = Task::where('user_id', Auth::user()->id)
                ->with('project')
                ->with('status')
                ->with('version')
                ->where('status_id','!=','6')
                ->orderby('deadline','desc')
                ->get();//6 - remote task

            //$task = Task::where([])->get();

            //$task = Task::where(['status_id','!=',6],['user_id', Auth::user()->id])->get();

            return response()->json($task);
        }
        catch (\Excertion $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function getAllMyTask(){//
        try
        {
           // $user_id=Auth::user()->id;
            $task = Task::where('creator_id', Auth::user()->id)
                ->with('project')
                ->with('status')
                ->with('version')
                ->where('status_id','!=','6')
                ->orderby('deadline','desc')
                ->get();//6 - remote task
            //$task = Task::where([])->get();

            //$task = Task::where(['status_id','!=',6],['user_id', Auth::user()->id])->get();

            return response()->json($task);
        }
        catch (\Excertion $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function getTaskByVersion($version_id=false){
        try{
//            $task=Task::where('version_id',$version_id)
//            ->with('status')
//            ->get();

            $task=$version_id?
                Task::select('id','title','status_id','version_id')
                    ->with('status')
                    ->with('version')

                    ->where('version_id',$version_id)
                    ->get():
                Task::select('id','title','status_id','version_id')
                ->with('status')
                    ->with('version')
                ->get();



            if($task){
                return response()->json($task);
            }
            else{
                return response()->json('no task');
            }
        return response()->json($task);
        }
        catch (\Exception $exception){
            return response()->json(['exception message'=>$exception->getMessage()],500);
        }

    }

    public function getTaskByProject($project_id){
        try{
//            $task=Task::where('project_id',$project_id)
//                ->with('project')
//                ->with('status')
//                ->with('version')
//                ->orderBy('version_id', 'desc')
//                ->get();
            $task=Task::select('title','status_id')
                ->where('project_id',$project_id)->get();
//            $task=Version::where('project_id',$project_id)
//                ->with('project')
//                ->with('status')
//                ->with('tasks')
//
//                ->get();

            if($task){
            return response()->json($task);
            }
            else{
                return response()->json('no task');
            }

        }
        catch (\Exception $exception){
            return response()->json(['exception message'=>$exception->getMessage()],500);
        }
    }

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
          //  $task=Task::where('user_id', Auth::user()->id)->whereDate('created_at',$date)->get();//
            $task=Task::whereDate('created_at',$date)->get();//check
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
            return response()->json(['message exception' => $exception->getMessage()], 500);
        }
    }

    public function getAllTaskForOneEmployee($task_id)
    {
        try{

        $task=Task::where([

            'id'=>$task_id
        ])->where('status_id','!=','6')->with('project')->with('status')->with('version')->with('creatorUser')->with('executedUser')->first();
//$userId=Auth::user()->id;
//        $task=Task::where('id',$task_id)->first();

        if($task){
            return response()->json(['task'=>$task]);
        }
        else{
            return response()->json(['message' =>'запись не найдена'], 500);

        }
        }
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);

        }
    }

    public function insert(Request $request){
        //return response()->json(['message' => 123], 500);
        try{
        $creator_id=Auth::user()->id;
        $task=new Task();
        $task->title=$request['title'];
        $task->description=$request['description'];
        $task->deadline=$request['deadline'];//$
        $task->project_id=$request['project_id'];//$
        $task->version_id=$request['version_id'];//$
        $task->user_id=$request['user_id'];
        $task->creator_id=$creator_id;

        if($task->save()){

            $message='Задача добавлена';
            $user=User::where('id',$request['user_id'])->first();

//            Mail::raw($user->description,function ($mail)use ($user,$request){
//
//                $mail->to($user->email,$user->name)->subject($request['title']);
//                $mail->from('tair.dospayev@gmail.com',$request['description']);
//            });
//
            Mail::send(['html' =>'email'],
                  ['title' => $request['title'],
                      'description' => $request['description'],
                      'deadline' => $request['deadline'],
                      'project'=>$request['project_id']
                  ],

                function ($mail)use ($user,$request) {
                $mail->to($user->email,$user->name);
                $mail->from('tair.dospayev@gmail.com','CRM KazAeroSpace');
            });
        }
        else
        {
            $message='Ошибка... задача не добавлена';
        }

        return response()->json([
            $message
        ],200);}
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }



    public function updateTask(Request $request,$task_id){
        try{

            $task=Task::where(['id'=>$task_id],['user_id'=>Auth::user()->id])->with('project')->with('status')->with('version')->first();
//            $task=Task::where(['id'=>$task_id])->first();
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
            //$task=Task::where('user_id', Auth::user()->id)->where('task_id',$id)->first();
            //$task = Task::where('user_id', Auth::user()->id)->where('id',$id)->first();//6 - remote task
            $task = Task::where('id',$id)->first();//6 - remote task


            $task->status_id=6;

            if($task->save()){
                $message='статус задачи 0,задача удалена';
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
            return response()->json(['message exception' => $exception->getMessage()], 500);
        }


    }

    public function doTask(Request $request,$id){
        try{
          //  $task=Task::where('id',$id)->first();
           // $task = Task::where(['id'=>$id],['user_id'=> Auth::user()->id])->get();
           // $task = Task::where('user_id', Auth::user()->id)->where('id',$id)->first();//3-
            $task=Task::where('id',$id)->with('project')->with('status')->with('version')->first();
            $task->status_id=3;

            $comment=new Comment();
            $comment->comment_text=$request['comment_text'];
            $comment->user_id=Auth::user()->id;
            $comment->task_id=$id;
            if($task->save()&& $comment->save()){
                $message='коммент добавлен';
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
            return response()->json(['message exception' => $exception->getMessage()], 500);

        }
    }


}
