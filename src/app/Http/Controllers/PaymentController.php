<?php

namespace App\Http\Controllers;

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
            'orderNumber' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'returnUrl' => 'required|url',
            'failUrl' => 'required|url',
            'description' => 'required|string',
            'language' => 'required|string',
            'jsonParams' => 'required|string',
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
        $_SESSION['returnUrl'] = $data['returnUrl'];
        $_SESSION['failUrl'] = $data['failUrl'];
        // Return the payment webpage
return response()->json([
    'orderId' => $data['orderNumber'],
    'formUrl' => url('/paymentWebpage?orderId=' . $data['orderNumber']),
    'errorMessage' => '',
    'errorCode' => '',
]);
    }

    public function confirm(Request $request)
    {
        $rules = [
            'userName' => 'required|string',
            'password' => 'required|string',
            'orderNumber' => 'required|string',
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

        // Extract validated data
        $data = $validated->validated();
      return response()->json([
       'paymentStatus'=>'confirmed successfully'
      ]);
     
    
    }

    public function confirmPayment(Request $request)
    {
    
    }
}
