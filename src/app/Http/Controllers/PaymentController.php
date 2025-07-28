<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

        $data = $validated->validated();
        $user = User::where('name', $data['userName'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'orderId' => '',
                'formUrl' =>'',
                'errorMessage' => 'Invalid username or password',
                'errorCode' => '0',
                ], 401);
        }
        try{
         
          $payment =  Payment::create(
                [
                    'orderNumber' => $data['orderNumber'],
                    'amount' => $data['amount'],
                    'currency' => $data['currency'],
                    'returnUrl' => $data['returnUrl'],
                    'isConfirmed' => false,
                    'isFailed' => false,
                    'user_id' => $user->id,
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
        $user = User::where('name', $data['userName'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)|| !$user->payments()->where('id', $data['orderId'])->exists()) {
            return response()->json([
              'orderStatus' => 2, 
              'errorCode' => 0,
              'errorMessage' => '',
              'orderNumber' => $payment->order_number ?? '',
              'actionCode' => 0,
              'actionCodeDescription' => 'Invalid username or password',
              'amount' => $payment->amount ?? 0,
              'currency' => 012
          ], 401);
        }

   $payment = Payment::findOrFail($data['orderId']);

   
  if($payment){
      if($payment->isConfirmed){
          return response()->json([
              'orderStatus' => 2, 
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
          'orderStatus' => 2, 
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
          'errorCode' => 5,
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

    public function generateCredentials(Request $request){
        $username = Str::uuid();
        $password = Str::random(16);
        try {
            $existingUser = User::where('name', $username)->first();
            if ($existingUser) {
                return response()->json(['error' => 'Username already exists'], 400);
            }
            User::create([
            'name' => $username,
            'password' => Hash::make($password)
             ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
   
        return response()->json([
            'username' => $username,
            'password' => $password,
        ]);
    }
}
