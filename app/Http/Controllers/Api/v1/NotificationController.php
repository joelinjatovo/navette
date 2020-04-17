<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
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
        
        return new NotificationCollection($user->notifications()->orderBy('created_at', 'desc')->paginate());
    }
    
    /**
     * Show the list of all unread notification
     *
     * @return Response
     */
    public function unread()
    {
        $user = \Auth::user();
        
        return new NotificationCollection($user->unreadNotifications()->paginate());
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
