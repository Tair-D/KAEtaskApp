<?php

namespace App\Http\Controllers;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Musonza\Chat\Facades\ChatFacade;
use App\Task;
use App\Comment;
use App\Version;
use App;
class ChatController extends Controller
{
    public function sendMessageToNew(Request $request,$user_id_receiver){
        try {
            $chat = App::make('chat');
            $user_id = 6;

            //$user_id=Auth::user()->id;
            $participants = [$user_id, $user_id_receiver];
            $conversation = ChatFacade::createConversation($participants);



            $message = ChatFacade::message($request->text)
                ->from($user_id)
                ->to($conversation)
                ->send();
            if($message->save()){

                $text='Задача добавлена';
            }
            else
            {
                $text='Ошибка... задача не добавлена';
            }

            return response()->json([$text], 200);
        }
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }



    public function sendMessageToExist(Request $request,$id)
    {
        try{
        $user_id = Auth::user()->id;

        $conversation = ChatFacade::conversations()->getById($id);

        $message = ChatFacade::message($request->text)
            ->from($user_id)
            ->to($conversation)
            ->send();}
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function removeUser($conversation_id,$user_id){
        try{
        $conversation = ChatFacade::conversations()->getById($conversation_id);
        Chat::conversation($conversation)->removeParticipants($user_id);}
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }


    public function removeUsers($conversation_id,$user_id){
        try{
        $conversation = ChatFacade::conversations()->getById($conversation_id);
        Chat::conversation($conversation)->removeParticipants($user_id);
        }
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function getMessaeById($conversation_id,$message_id){
        try{
            $conversation = ChatFacade::conversations()->getById($conversation_id);


        }
        catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }






}
