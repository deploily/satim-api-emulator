<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function register(Request $request)
    {
        // Define validation rules
        $rules = [
            'userName' => 'required|string',
            'password' => 'required|string',
            'orderNumber' => 'required|numeric',
            'amount' => 'required|numeric',
            'currency' => 'required|numeric',
            'returnUrl' => 'required|string',
            'failUrl' => 'url',
            'description' => 'string',
            'language' => 'required|string',
            'jsonParams' => 'string',
        ];

        // Validate the request
        $validated = Validator::make($request->query(), $rules);
        
        if ($validated->fails()) {
            return response()->json([
                'error' => 'Missing or invalid parameters',
                'errors' => $validated->errors()
            ], 400);
        }

        // Extract validated data
        $data = $validated->validated();
        try{
         
          $payment =  Payment::create(
                [
                    'userName' => $data['userName'],
                    'password' => $data['password'],
                    'orderNumber' => $data['orderNumber'],
                    'amount' => $data['amount'],
                    'currency' => $data['currency'],
                    'returnUrl' => $data['returnUrl'],
                    'isConfirmed' => false,
                    'isFailed' => false,
                ]
            );
          
            // Return the payment webpage
            return response()->json([
        'orderId' => $payment->latest('id')->first()->id,
        'formUrl' => url('/paymentWebpage?orderId=' .$payment->latest('id')->first()->id),
        'errorMessage' => '',
        'errorCode' => '',
              ]);
        }catch(\Exception $e){
            return response()->json([
                'orderId' => '',
                'formUrl' =>'',
                'errorMessage' => $e->getMessage(),
                'errorCode' => '7',
                      ]);
        }

    }

    public function confirm(Request $request)
    {
        $rules = [
            'userName' => 'required|string',
            'password' => 'required|string',
            'orderId' => 'required|numeric',
            'language' => 'required|string',
        ];

        // Validate the request
        $validated = Validator::make($request->query(), $rules);
        
        if ($validated->fails()) {
            return response()->json([
                'error' => 'Missing or invalid parameters',
                'errors' => $validated->errors()
            ], 400);
        }
        $data = $validated->validated();
   $payment = Payment::findOrFail($data['orderId']);

   
  if($payment){
      if($payment->isConfirmed){
          return response()->json([
              'orderStatus' => 2, // Already processed
              'errorCode' => 0,
              'errorMessage' => '',
              'orderNumber' => $payment->order_number ?? '',
              'actionCode' => 0,
              'actionCodeDescription' => 'Payment already confirmed',
              'amount' => $payment->amount ?? 0,
              'currency' => 012
          ]);
      }
      
      $payment->isConfirmed = true;
      $payment->save();
      
      return response()->json([
          'orderStatus' => 2, // Successfully processed
          'errorCode' => 0,
          'errorMessage' => '',
          'orderNumber' => $payment->order_number ?? '',
          'actionCode' => 0,
          'actionCodeDescription' => 'Payment confirmed successfully',
          'amount' => $payment->amount ?? 0,
          'currency' => 012,
          'pan' => $payment->masked_pan ?? '',
          'expiration' => $payment->card_expiry ?? '',
          'cardholderName' => $payment->card_holder_name ?? '',
          'approvalCode' => $payment->approval_code ?? '',
          'authCode' => '2',
          'ip' => request()->ip()
      ]);
  } else {
      return response()->json([
          'errorCode' => 5, // Order not found
          'errorMessage' => 'Payment not found',
          'actionCode' => 5,
          'actionCodeDescription' => 'Order not found in the system'
      ], 404);
  }
    
     
    
    }


    public function paymentWebpage(Request $request){
        
        $payment = Payment::findOrFail($request->query('orderId'));
        if($payment){
       
            return view('paymentWebpage',['data'=>$payment->getAttributes()]);
        }
    
   
    }
}
