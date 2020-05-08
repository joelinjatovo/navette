<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Show the list of all notification
     *
     * @return Response
     */
    public function index()
    {
        $user = \Auth::user();
        
        return $user->notifications; //response()->json($user->notifications);
    }
    
    /**
     * Show the list of all unread notification
     *
     * @return Response
     */
    public function unread()
    {
        $user = \Auth::user();
        
        return $user->unreadNotifications;
    }
    
    /**
     * Mark as read all unread notification
     *
     * @return Response
     */
    public function markAsRead()
    {
        $user = \Auth::user();
        
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        
        return response()->json([
            'code' => 200,
            'status' => "success",
        ]);
    }
}
