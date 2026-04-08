<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
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
            // 'orderNumber' => 'required|numeric',   
            'orderNumber' => 'required|string', 
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
        $user = User::where('satim_username', $data['userName'])->first();
        if (!$user || $user->satim_password !== $data['password']) {
            return response()->json([
                'orderId' => '',
                'formUrl' => '',
                'errorMessage' => 'Invalid SATIM username or password',
                'errorCode' => '0',
            ], 401);
        }

        try {

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
                'formUrl' => url('/paymentWebpage?orderId=' . $payment->latest('id')->first()->id),
                'errorMessage' => '',
                'errorCode' => 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'orderId' => '',
                'formUrl' => '',
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
        $user = User::where('satim_username', $data['userName'])->first();
        if (!$user || $user->satim_password !== $data['password'] || !$user->payments()->where('id', $data['orderId'])->exists()) {
            return response()->json([
                'orderStatus' => 2,
                'errorCode' => 0,
                'errorMessage' => '',
                'orderNumber' => $data['orderId'], // ou ''
                'actionCode' => 0,
                'actionCodeDescription' => 'Invalid username or password',
                'amount' => 0,
                'currency' => 012
            ], 401);
        }

        $payment = Payment::findOrFail($data['orderId']);


        if ($payment) {
            if ($payment->isConfirmed) {
                return response()->json([
                    'orderStatus' => 2,
                    'OrderStatus' => 2,
                    'errorCode' => '0',
                    'ErrorCode' => '0',
                    'errorMessage' => '',
                    'ErrorMessage' => '',
                    'orderNumber' => $payment->order_number ?? '',
                    'OrderNumber' => $payment->orderNumber ?? '',
                        'orderId' => $payment->id,
                    'OrderId' => $payment->id,
                    'actionCode' => 0,
                    'ActionCode' => 0,
                    'actionCodeDescription' => 'Payment already confirmed',
                    'ActionCodeDescription' => 'Payment already confirmed',
                    'depositAmount' => 0,
                    'DepositAmount' => 0,

                    'amount' => $payment->amount ?? 0,
                        'Amount' => $payment->amount ?? 0,
                    'currency' => 012,
                    'Currency' => 012,
                    'respCode' => '00',
                    'RespCode' => '00',
                    'respCode_desc' => '',
                    'RespCodeDesc' => '',
                     'params' => [
        'respCode' => '00',
        'respCode_desc' => '',
        'udf1' => '',
        'udf2' => '',
        'udf3' => '',
        'udf4' => '',
        'udf5' => '',
    ],
                ]);
            }

            $payment->isConfirmed = true;
            $payment->save();

            return response()->json([
                'orderStatus' => 2,
                 'OrderStatus' => 2,     
                'errorCode' => '0',
                    'ErrorCode' => '0',
                'errorMessage' => '',
                  'ErrorMessage' => '', 
                'orderNumber' => $payment->order_number ?? '',
                  'OrderNumber' => $payment->orderNumber ?? '',
                'orderId' => $payment->id,  // ← add this
                'OrderId' => $payment->id,  // ← add this
                'actionCode' => 0,
                 'depositAmount' => 0,
                'actionCodeDescription' => 'Payment confirmed successfully',
                'amount' => $payment->amount ?? 0,
                    'Amount' => $payment->amount ?? 0, 
                'currency' => 012,
                'pan' => $payment->masked_pan ?? '',
                    'Pan' => '', 
                'expiration' => $payment->card_expiry ?? '',
                'cardholderName' => $payment->card_holder_name ?? '',
                'approvalCode' => $payment->approval_code ?? '',
                'authCode' => '2',
                'respCode' => '00',
                'respCode_desc' => '',
                'ip' => request()->ip(),
                   'Ip' => request()->ip(), 
                    'params' => [
        'respCode' => '00',
        'respCode_desc' => '',
        'udf1' => '',
        'udf2' => '',
        'udf3' => '',
        'udf4' => '',
        'udf5' => '',
    ],
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


    public function paymentWebpage(Request $request)
    {

        $payment = Payment::findOrFail($request->query('orderId'));
        if ($payment) {

            return view('paymentWebpage', ['data' => $payment->getAttributes()]);
        }
    }

    public function generateCredentials(Request $request)
    {
        $username = Str::uuid();
        $password = Str::random(16);

        $satimUsername = 'satim_' . Str::random(8);
        $satimPassword = Str::random(16);

        try {
            if (User::where('name', $username)->exists()) {
                return response()->json(['error' => 'Username already exists'], 400);
            }

            User::create([
                'name'           => $username,
                'password'       => Hash::make($password),
                'satim_username' => $satimUsername,
                'satim_password' => Hash::make($satimPassword),
            ]);

            return response()->json([
                'username'        => $username,
                'password'        => $password,
                'satim_username'  => $satimUsername,
                'satim_password'  => $satimPassword,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Erreur lors de la génération des credentials',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
