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
    public function index(Request $request)
    {
        $user = \Auth::user();
        
        if(!$request->ajax()){
			$models = $user->notifications()->orderBy('created_at', 'desc')->paginate();
			if($user->isAdmin()){
				return view('admin.notifications', ['models' => $models]);
			}
			return view('customer.notifications', ['models' => $models]);
        }
		
        return $user->notifications()->orderBy('created_at', 'desc')->take(5)->get();
    }
	
    /**
     * Show notification
     *
     * @return Response
     */
    public function show($id)
    {
        $user = \Auth::user();
		
		$notification = $user->notifications()->where('id', $id)->first();
		$route = route('admin.dashboard');
		if($notification){
			$notification->markAsRead();
			switch($notification->type){
				case 'App\\Notifications\\OrderStatus':
					if($user->isAdmin()){
						return redirect()->route('admin.order.show', $notification->data['order_id']);
					}
					return redirect()->route('customer.order.show', $notification->data['order_id']);
				break;
				case 'App\\Notifications\\DriverArrived':
				case 'App\\Notifications\\ItemStatus':
					if($user->isAdmin()){
						return redirect()->route('admin.item.show', $notification->data['item_id']);
					}
					return redirect()->route('customer.item.show', $notification->data['item_id']);
				break;
				case 'App\\Notifications\\RideStatus':
					if($user->isAdmin()){
						return redirect()->route('admin.ride.show', $notification->data['ride_id']);
					}
					if($user->isDriver()){
						return redirect()->route('driver.ride.show', $notification->data['ride_id']);
					}
					return redirect()->route('customer.ride.show', $notification->data['ride_id']);
				break;
			}
		}
		
		if($user->isAdmin()){
			return redirect()->route('admin.dashboard');
		}
		return redirect()->route('customer.dashboard');
    }
    
    /**
     * Show the list of all unread notification
     *
     * @return Response
     */
    public function unread(Request $request)
    {
        $user = \Auth::user();
        
        if(!$request->ajax()){
			$models = $user->unreadNotifications()->orderBy('created_at', 'desc')->paginate();
			if($user->isAdmin()){
				return view('admin.notifications', ['models' => $models]);
			}
			return view('customer.notifications', ['models' => $models]);
        }
        
        return $user->unreadNotifications()->orderBy('created_at', 'desc')->take(5)->get(); 
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
