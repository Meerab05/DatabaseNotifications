<?php

namespace App\Http\Controllers;

use App\Notifications\TaskCompleted;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str; 

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $users=User::all();
       // dd("users : ".$users);
        $letter= collect(['title'=>'Notification updates', 'body'=>'It is the body of nothing :D']);
        //dd("letters : ".$letter);
        Notification::send($users, new TaskCompleted($letter));
        echo "Notifications sent to all users !";

        $unreadedNotifications =\ Auth::user()->unreadNotifications();
        $readedNotifications = \Auth::user()->readNotifications()->get();

        return view('layouts.app',compact('unreadedNotifications','readedNotifications'));

    }
     public function MarkAsRead($id)
     {
        $users=\Auth::user();
        //$notifications = Notification::all();

        $notification = auth()->user()->notifications()->where('id', $id)->first()->markAsRead();
        // $read=$notification->read_at;
        // dd("read : ".$read);
        $unreadedNotifications = \Auth::user()->unreadNotifications();
        $readedNotifications = \Auth::user()->readNotifications()->get();
        
        
        // $users->unreadNotifications()->where('notifications.id', $id)->markAsRead();
        // \Auth::user()->notifications->markAsRead();
        //return view('home')->with('readNotif',$readedNotifications);
        return view('home');
     }
}
