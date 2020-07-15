<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    /**
     * Show the list of all payments
     *
     * @return Response
     */
    public function index(Request $request)
    {
		$models = Payment::orderBy('created_at', 'desc')
					->paginate();
        
        return view('admin.payment.index', ['models' => $models]);
    }

    /**
     * Show the payment info.
     *
     * @param Payment $payment
     * @return Response
     */
    public function show(Request $request, Payment $payment)
    {
        return view('payment.item.show', ['model' => $payment]);
    }

    /**
     * Handle specified action
     *
     * @param Request  $request
	 *
     * @return Response
     */
    public function action(Request $request)
    {
        $payment = Payment::findOrFail($request->input('id'));
		switch($request->input('action')){
			case 'cancel':
				$item->cancel();

				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.payment.canceled'),
					'view' => view('admin.payment.table-row', ['model' => $payment])->render(),
				]);
			break;
		}
		
        return response()->json([
            'status' => "error",
            'message' => trans('messages.controller.error.unknown'),
        ]);
    }

    /**
     * Delete the specified item.
     *
     * @param Request  $request
     * 
     * @return Response
     */
    public function delete(Request $request)
    {
        $model = Payment::findOrFail($request->input('id'));
        $model->delete();
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.payment.deleted'),
        ]);
    }
}
